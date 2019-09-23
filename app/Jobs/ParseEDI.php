<?php

namespace App\Jobs;

use App\Document;
use App\Event;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class ParseEDI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $edi;
    private $unprocessedCodes;

    private const DELIVERY_CODES = ['001', '002'];

    private $mapping = [
        '000' => [
            'name' => 'header',
            'map' => [
                'sender' => [3, 35],
                'receiver' => [38, 35],
                'date' => [73, 6],
                'time' => [79, 4],
                'file' => [83, 12],
            ],
        ],

        '540' => [
            'name' => 'registry',
            'map' => [
                'number' => [3, 14]
            ]
        ],

        '541' => [
            'name' => 'transporter',
            'map' => [
                'cnpj' => [3,14],
                'name' => [17,50]
            ]
        ],

        '549' => [
            'name' => 'footer',
            'map' => [
                'events_count' => [4,3],
            ]
        ],

        '542' => [
            'name' => 'events',
            'map' => [
                'company_cnpj' => [3, 14],
                'document_series' => [17, 3],
                'document_number' => [20, 9],
                'code' => [29, 3],
                'date' => [32, 8],
                'time' => [40, 4],
                'cte_number' => [141, 12],
                'cte_series' => [137, 5]
            ],
            'multiple' => true
        ],

        '543' => [
            'name' => 'event_extra',
            'map' => [
                'text_1' => [3,70],
                'text_2' => [73,70],
                'text_3' => [143,70]
            ],
            'multiple' => true,
            'parent' => '542'
        ]
    ];

    private function getEventKey($code)
    {
        if (isset($this->mapping[$code])) {
            return $this->mapping[$code]['name'];
        }


        $this->unprocessedCodes[] = $code;

        return false;
    }

    private function getEventParent($code){
        if (isset($this->mapping[$code]['parent'])) {
            return $this->mapping[$this->mapping[$code]['parent']]['name'] ;
        }

        return false;
    }

    private function isMultiple($code)
    {
        return isset($this->mapping[$code]['multiple']) && $this->mapping[$code]['multiple'] ;
    }

    private function processLine($code, $line)
    {

        if (isset($this->mapping[$code])) {

            $blockSettings = $this->mapping[$code];
            return $this->extract($line, $blockSettings);
        }

        return false;
    }

    /**
     * Extrai em um array as diversas posições de uma linha
     * */
    private function extract($line, $blockSettings)
    {
        $data = [];

        foreach($blockSettings['map'] as $key => $positions){
            $data[$key] = trim(substr($line, $positions[0], $positions[1]));
        }

        return $data;
    }


    public function processEDI()
    {
        $results = [];

        if($this->edi) {
            foreach (preg_split("/((\r?\n)|(\r\n?))/", $this->edi) as $line) {
                $code = substr($line, 0, 3);
                $key = $this->getEventKey($code);
                $parent = $this->getEventParent($code);

                if($key !== false){
                    if($this->isMultiple($code)){
                        if($parent !== false) {
                            $results[$parent][count($results[$parent]) -1] = array_merge(
                                $results[$parent][count($results[$parent]) -1],
                                $this->processLine($code, $line)
                            );
                        } else {
                            $results[$key][] = $this->processLine($code, $line);
                        }
                    } else {
                        if($parent !== false){
                            $results[$key] = array_merge($results[$key], $this->processLine($code, $line));
                        } else {
                            $results[$key] = $this->processLine($code, $line);
                        }
                    }
                }
            }
        }

        return $results;
    }


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rawEDI)
    {
        $this->edi = $rawEDI;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $processedEDI = $this->processEDI();

        $data = [];
        foreach($processedEDI['events'] as $event){

            $documentData = [
                'number' =>  $event['document_number'],
                'series' => $event['document_series'],
                'company_cnpj' => $event['company_cnpj'],
                'transporter_cnpj' => $processedEDI['transporter']['cnpj']
            ];

            $eventDate = Carbon::createFromFormat('dmYHi', $event['date'].$event['time']);

            if(in_array($event['code'], self::DELIVERY_CODES)){
                $documentData['delivered_at'] = $eventDate;
            }

            Document::unguard(true);
            $document = Document::firstOrCreate([
                'number' =>  $event['document_number'],
                'series' => $event['document_series']
            ], $documentData);

//            if($document->collected_at === null || (
//                $document->collected_at !== null && $eventDate->isBefore($document->collected_at)
//            )){
//                $document->collected_at = $eventDate;
//                $document->save();
//            }

            $data[] = [
                'document_id' => $document->id,
                'code' => $event['code'],
                'executed_at' =>  $eventDate,
                'received_at' => Carbon::now()
            ];

        }

        Event::insert($data);
    }
}
