<?php

class SupplierCest
{
    public function _before(ApiTester $I)
    {
        $user = factory(\App\User::class)->create();
        $I->amAuthenticatedAs($user);
    }


    public function testCantCreateSupplierWithInvalidData(ApiTester $I)
    {
        $I->sendPOST('/suppliers', []);
        $I->seeResponseCodeIs(422);
    }

    public function testCantCreateSupplierWithSameCNPJ(ApiTester $I)
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

        factory(\App\Supplier::class)->create($data);

        $I->sendPOST('/suppliers', $data);
        $I->seeResponseCodeIs(422);
    }

    public function testCanCreateSupplier(ApiTester $I)
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

        $I->sendPOST('/suppliers', $data);

        $I->seeResponseCodeIs(201);
        $I->seeResponseContainsJson($data);
        //$I->seeInDatabase('suppliers', $data);

    }
    
    public function testCanListSuppliers(ApiTester $I)
    {
        $supplier = factory(\App\Supplier::class)->create();

        $I->sendGET('/suppliers');

        $I->seeResponseCodeIs(200);
        $I->canSeeResponseIsJson();
        $I->seeResponseContainsJson(json_decode(json_encode($supplier->toArray()), true));
    }

    public function testCanSeeSupplier(ApiTester $I)
    {
        $supplier = factory(\App\Supplier::class)->create();

        $I->sendGET('/suppliers/'.$supplier->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(json_decode(json_encode($supplier->toArray()), true));
    }
}
