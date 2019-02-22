<?php

namespace api\tests\rest;

use api\tests\RestTester;

class HomeCest
{
    public function mainPage(RestTester $I)
    {
        $I->sendGET('/');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
