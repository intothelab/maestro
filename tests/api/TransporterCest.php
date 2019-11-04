<?php

class TransporterCest
{
    public function _before(ApiTester $I)
    {
        $user = factory(\App\User::class)->create();
        $I->amAuthenticatedAs($user);
    }


    public function testCantCreateTransporterWithInvalidData(ApiTester $I)
    {
        $I->sendPOST('/transporters', []);
        $I->seeResponseCodeIs(422);
    }

    public function testCantCreateTransporterWithSameCNPJ(ApiTester $I)
    {
        $data = [
            "name" =>  "Soprano",
            "email" =>  "outbound@soprano.com.br",
            "phone" =>  "(51) 3214-4321",
            "cnpj" =>  "04256826000177",
            "address" =>  "Avenida Plínio Kroeff",
            "number" =>  "1715, Loja B",
            "postal_code" =>  "91150170",
        ];

        factory(\App\Transporter::class)->create($data);

        $I->sendPOST('/transporters', $data);
        $I->seeResponseCodeIs(422);
    }

    public function testCanCreateTransporter(ApiTester $I)
    {
        $data = [
            "name" =>  "Soprano",
            "email" =>  "outbound@soprano.com.br",
            "phone" =>  "(51) 3214-4321",
            "cnpj" =>  "04256826000177",
            "address" =>  "Avenida Plínio Kroeff",
            "number" =>  "1715, Loja B",
            "postal_code" =>  "91150170",
        ];

        $I->sendPOST('/transporters', $data);

        $I->seeResponseCodeIs(201);
        $I->seeResponseContainsJson($data);
        //$I->seeInDatabase('transporters', $data);

    }

    public function testCanListTransporters(ApiTester $I)
    {
        $transporter = factory(\App\Transporter::class)->create();

        $I->sendGET('/transporters');

        $I->seeResponseCodeIs(200);
        $I->canSeeResponseIsJson();
        $I->seeResponseContainsJson(json_decode(json_encode($transporter->toArray()), true));
    }

    public function testCanSeeTransporter(ApiTester $I)
    {
        $transporter = factory(\App\Transporter::class)->create();

        $I->sendGET('/transporters/'.$transporter->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(json_decode(json_encode($transporter->toArray()), true));
    }
}
