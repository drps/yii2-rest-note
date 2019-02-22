<?php

namespace api\tests\rest\Note;

use api\tests\RestTester;
use common\fixtures\NoteFixture;

class IndexCest
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
        $I->sendGET('/notes');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function userAccess(RestTester $I)
    {
        $I->amBearerAuthenticated('secrettoken1');
        $I->sendGET('/notes');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function checkSortByTime(RestTester $I)
    {
        $I->sendGET('/notes');
        $responseData = $I->grabResponse();
        $data = json_decode($responseData, true);
        $time = null;
        $isOk = true;
        foreach ($data['records'] as $row) {
            $dt = strtotime($row['created_at']);
            $time = $time ?: $dt;
            if ($time > $dt) {
                $isOk = false;
                break;
            }

            $time = strtotime($dt);
        }
        assert($isOk, 'Check sort order by time' . $dt);
    }

    public function checkPagination(RestTester $I)
    {
        $I->sendGET('/notes');
        $I->seeResponseMatchesJsonType([
            'count' => 'integer',
            'pageCount' => 'integer',
            'currentPage' => 'integer'
        ]);
    }
}
