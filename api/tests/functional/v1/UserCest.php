<?
namespace backend\tests\functional;

use api\tests\FunctionalTester;
use common\fixtures\User as UserFixture;

class UserCest
{
    private $login;
    private $user;

    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'users' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'users.php'
            ]
        ]);

        $this->login = $I->grabRecord('common\models\Login', ['name' => 'demo']);
        $this->user = $I->grabRecord('common\models\User', ['User-ID' => 1]);
    }

    public function indexTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that user list work');
        $I->sendGET('v1/users');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContains($this->user->Location);
    }

    public function viewTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that user view work');
        $I->sendGET('v1/user/' . $this->user->{'User-ID'});
        $I->seeResponseCodeIs(200);
        $I->seeResponseContains($this->user->Location);
    }

    public function createAccessTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that user create protected');
        $I->sendPOST('v1/user');
        $I->seeResponseCodeIs(401);
    }

    public function createTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that user create work');
        $I->sendPOST('v1/user?access-token=' . $this->login->auth_key);
        $I->seeResponseCodeIs(201);
    }

    public function updateAccessTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that user update protected');
        $I->sendPUT('v1/user/' . $this->user->{'User-ID'});
        $I->seeResponseCodeIs(401);
    }

    public function updateTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that user update work');
        $I->sendPUT('v1/user/' . $this->user->{'User-ID'} . '?access-token=' . $this->login->auth_key);
        $I->seeResponseCodeIs(200);
    }

    public function deleteAccessTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that user delete protected');
        $I->sendDELETE('v1/user/' . $this->user->{'User-ID'});
        $I->seeResponseCodeIs(401);
    }

    public function deleteTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that user delete work');
        $I->sendDELETE('v1/user/' . $this->user->{'User-ID'} . '?access-token=' . $this->login->auth_key);
        $I->seeResponseCodeIs(204);
    }
}