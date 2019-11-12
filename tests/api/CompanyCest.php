<?php

class CompanyCest
{
    public function _before(ApiTester $I)
    {
        $user = factory(\App\User::class)->create();
        $I->amAuthenticatedAs($user);
    }


    public function testCantCreateCompanyWithInvalidData(ApiTester $I)
    {
        $I->sendPOST('/companies', []);
        $I->seeResponseCodeIs(422);
    }

    public function testCantCreateCompanyWithSameCNPJ(ApiTester $I)
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

        factory(\App\Company::class)->create($data);

        $I->sendPOST('/companies', $data);
        $I->seeResponseCodeIs(422);
    }

    public function testCantCreateCompanyWithSameCode(ApiTester $I)
    {
        factory(\App\Company::class)->create([
            'code' => 'guaja.cc'
        ]);

        $data = factory(\App\Company::class)->make([
            'code' => 'guaja.cc'
        ]);

        $I->sendPOST('/companies', $data);
        $I->seeResponseCodeIs(422);
    }

    public function testCanCreateCompany(ApiTester $I)
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

        $I->sendPOST('/companies', $data);

        $I->seeResponseCodeIs(201);
        $I->seeResponseContainsJson($data);
        //$I->seeInDatabase('companies', $data);

    }

    public function testCanListCompanies(ApiTester $I)
    {
        $company = factory(\App\Company::class)->create();

        $I->sendGET('/companies');

        $I->seeResponseCodeIs(200);
        $I->canSeeResponseIsJson();
        $I->seeResponseContainsJson(json_decode(json_encode($company->toArray()), true));
    }

    public function testCanSeeCompanyById(ApiTester $I)
    {
        $company = factory(\App\Company::class)->create();

        $I->sendGET('/companies/'.$company->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(json_decode(json_encode($company->toArray()), true));
    }

    public function testCanSeeCompanyByCode(ApiTester $I)
    {
        $company = factory(\App\Company::class)->create();

        $I->sendGET('/companies/'.$company->code);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(json_decode(json_encode($company->toArray()), true));
    }
}
