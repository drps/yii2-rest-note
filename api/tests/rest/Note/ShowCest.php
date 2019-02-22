<?php

namespace api\tests\rest\Note;

use api\tests\RestTester;
use common\fixtures\NoteFixture;

class ShowCest
{
    public function _before(RestTester $I)
    {
        $I->haveFixtures([
            'note' => [
                'class' => NoteFixture::class,
                'dataFile' => codecept_data_dir() . 'note.php',
            ],
        ]);
    }

    public function guestAccess(RestTester $I)
    {
        $I->sendGET('/notes/1000');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function userAccess(RestTester $I)
    {
        $I->amBearerAuthenticated('secrettoken1');
        $I->sendGET('/notes/1000');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function myFutureNote(RestTester $I)
    {
        $I->amBearerAuthenticated('secrettoken1');
        $I->sendGET('/notes/1000');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function notMineFutureNote(RestTester $I)
    {
        $I->amBearerAuthenticated('secrettoken1');
        $I->sendGET('/notes/1007');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
    }

    public function noteFromFuture(RestTester $I)
    {
        $I->sendGET('/notes/1007');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
    }
}
