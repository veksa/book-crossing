<?
namespace backend\tests\functional;

use api\tests\FunctionalTester;
use common\fixtures\Book as BookFixture;

class BookCest
{
    private $login;
    private $book;

    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'books' => [
                'class' => BookFixture::className(),
                'dataFile' => codecept_data_dir() . 'books.php'
            ]
        ]);

        $this->login = $I->grabRecord('common\models\Login', ['name' => 'demo']);
        $this->book = $I->grabRecord('common\models\Book', ['Book-ID' => 1]);
    }

    public function indexTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that book list work');
        $I->sendGET('v1/books');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContains($this->book->{'Book-Title'});
    }

    public function viewTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that book view work');
        $I->sendGET('v1/book/' . $this->book->{'Book-ID'});
        $I->seeResponseCodeIs(200);
        $I->seeResponseContains($this->book->{'Book-Title'});
    }

    public function createAccessTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that book create protected');
        $I->sendPOST('v1/book');
        $I->seeResponseCodeIs(401);
    }

    public function createTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that book create work');
        $I->sendPOST('v1/book?access-token=' . $this->login->auth_key);
        $I->seeResponseCodeIs(201);
    }

    public function updateAccessTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that book update protected');
        $I->sendPUT('v1/book/' . $this->book->{'Book-ID'});
        $I->seeResponseCodeIs(401);
    }

    public function updateTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that book update work');
        $I->sendPUT('v1/book/' . $this->book->{'Book-ID'} . '?access-token=' . $this->login->auth_key);
        $I->seeResponseCodeIs(200);
    }

    public function deleteAccessTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that book delete protected');
        $I->sendDELETE('v1/book/' . $this->book->{'Book-ID'});
        $I->seeResponseCodeIs(401);
    }

    public function deleteTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that book delete work');
        $I->sendDELETE('v1/book/' . $this->book->{'Book-ID'} . '?access-token=' . $this->login->auth_key);
        $I->seeResponseCodeIs(204);
    }
}