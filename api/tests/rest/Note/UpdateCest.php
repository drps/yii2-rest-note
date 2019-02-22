<?php

namespace api\tests\rest\Note;

use api\tests\RestTester;
use common\fixtures\NoteFixture;

class UpdateCest
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
        $I->sendPATCH('/notes/1000');
        $I->seeResponseCodeIs(401);
        $I->seeResponseIsJson();
    }

    public function authAccess(RestTester $I)
    {
        $I->amBearerAuthenticated('secrettoken1');
        $I->sendPATCH('/notes/1002', [
            'title' => $title = 'title_edited' . random_int(1,100),
            'content' => $content = 'content',
            'created_at' => $time = date('Y-m-d H:i')
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'title' => $title,
            'content' => $content,
        ]);
    }

    public function editNotMineNote(RestTester $I)
    {
        $I->amBearerAuthenticated('secrettoken1');
        $I->sendPATCH('/notes/1005', [
            'title' => $title = 'title_edited' . random_int(1,100),
            'content' => $content = 'content',
            'created_at' => $time = date('Y-m-d H:i')
        ]);
        $I->seeResponseCodeIs(403);
    }

    public function editTooOldNote(RestTester $I)
    {
        $I->amBearerAuthenticated('secrettoken1');
        $I->sendPATCH('/notes/1000', [
            'title' => $title = 'title_edited' . random_int(1,100),
            'content' => $content = 'content',
            'created_at' => $time = date('Y-m-d H:i')
        ]);
        $I->seeResponseCodeIs(403);
    }
}
