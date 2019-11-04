<?php

class OrderCest
{
    public function _before(ApiTester $I)
    {
        $user = factory(\App\User::class)->create();
        $I->amAuthenticatedAs($user);
    }


    public function testCantCreateOrderWithInvalidData(ApiTester $I)
    {
        $I->sendPOST('/orders', []);
        $I->seeResponseCodeIs(422);
    }

    public function testCreateOrderForANotExistingCompany(ApiTester $I)
    {

        $customer = factory(\App\Customer::class)->create();

        $I->sendPOST('/orders', [
            'company_cnpj' => 12345,
            'customer_cnpj' => $customer->cnpj,
            'code' => '1234',
            'value' => 100,
            'weight' => 5000
        ]);

        $I->seeResponseCodeIs(422);
    }

    public function testCreateOrderForANotExistingCustomer(ApiTester $I)
    {

        $company = factory(\App\Company::class)->create();

        $I->sendPOST('/orders', [
            'company_cnpj' => $company->cnpj,
            'customer_cnpj' => 1234,
            'code' => '1234',
            'value' => 100,
            'weight' => 5000
        ]);

        $I->seeResponseCodeIs(422);
    }

    public function testCanCreateOrder(ApiTester $I)
    {
        $company = factory(\App\Company::class)->create();
        $customer = factory(\App\Customer::class)->create();


        $data = [
            'company_cnpj' => $company->cnpj,
            'customer_cnpj' => $customer->cnpj,
            'code' => '1234',
            'value' => 100,
            'weight' => 5000
        ];

        $I->sendPOST('/orders', $data);

        $I->seeResponseCodeIs(201);
        $I->seeResponseContainsJson($data);
    }

    public function testCanListOrders(ApiTester $I)
    {
        $order = factory(\App\Order::class)->create();

        $I->sendGET('/orders');
        $I->seeResponseCodeIs(200);
        $I->canSeeResponseIsJson();
        $I->seeResponseContainsJson(json_decode(json_encode($order->toArray()), true));
    }

    public function testCanSeeOrderById(ApiTester $I)
    {
        $order = factory(\App\Order::class)->create();

        $I->sendGET('/orders/'.$order->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(json_decode(json_encode($order->toArray()), true));
    }

    public function tryToLoadUnexistentOrder(ApiTester $I)
    {
        $I->sendGET('/orders/12312');
        $I->seeResponseCodeIs(404);
    }
}
