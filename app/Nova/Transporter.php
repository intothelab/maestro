<?php

namespace App\Nova;

use Illuminate\Mail\Markdown;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Outhebox\NovaHiddenField\HiddenField;
use Wemersonrv\InputMask\InputMask;
use Whitecube\NovaFlexibleContent\Flexible;

class Transporter extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Transporter';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'code', 'cnpj'
    ];

    public static function icon()
    {
        return self::getIcon('truck'); // TODO: Change the autogenerated stub
    }

    public static function label()
    {
        return 'Transportadoras'; // TODO: Change the autogenerated stub
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->onlyOnForms(),
            Text::make('Nome', 'name')
                ->sortable()
                ->size('w-2/5')
                ->rules('required'),
            Text::make('Código', 'code')
                ->size('w-1/5'),
            InputMask::make('CNPJ', 'cnpj')
                ->mask('##.###.###/####-##')
                ->size('w-2/5')
                ->rules('required'),
            Text::make('E-mail', 'email')
                ->sortable()
                ->rules('required', 'email')
                ->size('w-1/3'),
            InputMask::make('Telefone', 'phone')
                ->size('w-1/3'),
            Place::make('Endereço','address')
                ->size('w-2/3')
                ->countries(['BR']),
            Text::make('Número', 'number')
                ->size('w-1/3'),
            Text::make('CEP', 'postal_code')
                ->size('w-1/3'),
            Text::make('Estado', 'state')
                ->size('w-1/3'),
            Text::make('Cidade', 'city')
                ->size('w-1/3'),
            HiddenField::make('latitude')->withMeta(['type' => 'hidden'])->onlyOnForms(),
            HiddenField::make('longitude')->withMeta(['type' => 'hidden'])->onlyOnForms(),
            HasMany::make('Veículos', 'vehicle', Vehicle::class)
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
