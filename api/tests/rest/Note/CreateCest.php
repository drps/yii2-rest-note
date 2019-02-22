<?php

namespace api\tests\rest\Note;

use api\tests\RestTester;
use common\fixtures\NoteFixture;

class CreateCest
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
        $I->sendPOST('/notes');
        $I->seeResponseCodeIs(401);
        $I->seeResponseIsJson();
    }

    public function authAccess(RestTester $I)
    {
        $I->amBearerAuthenticated('secrettoken1');
        $I->sendPOST('/notes', [
            'title' => $title = 'title',
            'content' => $content = 'content',
            'created_at' => $time = date('Y-m-d H:i')
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'title' => $title,
            'content' => $content,
        ]);
    }

    public function noDate(RestTester $I)
    {
        $I->amBearerAuthenticated('secrettoken1');
        $I->sendPOST('/notes', [
            'title' => 'title',
            'content' => $content = 'content'
        ]);
        $I->seeResponseCodeIs(422);
    }

    public function noTitle(RestTester $I)
    {
        $I->amBearerAuthenticated('secrettoken1');
        $I->sendPOST('/notes', [
            'content' => $content = 'content',
            'created_at' => $time = date('Y-m-d H:i')
        ]);
        $I->seeResponseCodeIs(422);
    }

    public function noContent(RestTester $I)
    {
        $I->amBearerAuthenticated('secrettoken1');
        $I->sendPOST('/notes', [
            'title' => 'title',
            'created_at' => $time = date('Y-m-d H:i')
        ]);
        $I->seeResponseCodeIs(422);
    }
}
