<?
namespace backend\tests\functional;

use api\tests\FunctionalTester;
use common\fixtures\Book as BookFixture;
use common\fixtures\User as UserFixture;
use common\fixtures\BookRating as RatingFixture;

class RatingCest
{
    private $login;
    private $user;
    private $book;

    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'books' => [
                'class' => BookFixture::className(),
                'dataFile' => codecept_data_dir() . 'books.php'
            ],
            'users' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'users.php'
            ],
            'ratings' => [
                'class' => RatingFixture::className(),
                'dataFile' => codecept_data_dir() . 'ratings.php'
            ]
        ]);

        $this->login = $I->grabRecord('common\models\Login', ['name' => 'demo']);
        $this->user = $I->grabRecord('common\models\User', ['User-ID' => 1]);
        $this->book = $I->grabRecord('common\models\Book', ['Book-ID' => 1]);
    }

    public function indexTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that rating list work');
        $I->sendGET('v1/rating/' . $this->book->{'Book-ID'});
        $I->seeResponseCodeIs(200);
    }

    public function createAccessTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that rating create protected');
        $I->sendPOST('v1/rating');
        $I->seeResponseCodeIs(401);
    }

    public function createTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that rating create work');
        $I->sendPOST('v1/rating?access-token=' . $this->login->auth_key);
        $I->seeResponseCodeIs(201);
    }

    public function deleteAccessTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that rating delete protected');
        $I->sendDELETE('v1/rating/' . $this->book->{'Book-ID'} . '/' . $this->user->{'User-ID'});
        $I->seeResponseCodeIs(401);
    }

    public function deleteTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that rating delete work');
        $I->sendDELETE('v1/rating/' . $this->book->{'Book-ID'} . '/' . $this->user->{'User-ID'} . '?access-token=' . $this->login->auth_key);
        $I->seeResponseCodeIs(204);
    }
}