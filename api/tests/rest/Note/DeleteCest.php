<?php

namespace api\tests\rest\Note;

use api\tests\RestTester;
use common\fixtures\NoteFixture;

class DeleteCest
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
        $I->sendDELETE('/notes/1000');
        $I->seeResponseCodeIs(401);
        $I->seeResponseIsJson();
    }

    public function userAccess(RestTester $I)
    {
        $I->amBearerAuthenticated('secrettoken1');
        $I->sendDELETE('/notes/1001');
        $I->seeResponseCodeIs(204);
    }

    public function notMineNote(RestTester $I)
    {
        $I->amBearerAuthenticated('secrettoken1');
        $I->sendDELETE('/notes/1004');
        $I->seeResponseCodeIs(403);
    }

    public function myOldNote(RestTester $I)
    {
        $I->amBearerAuthenticated('secrettoken1');
        $I->sendDELETE('/notes/1000');
        $I->seeResponseCodeIs(403);
    }
}
