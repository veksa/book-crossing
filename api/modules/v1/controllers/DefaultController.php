<?
namespace api\modules\v1\controllers;

use common\models\Login;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }

    /**
     * Авторизация
     *
     * @return mixed|null
     *
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionLogin()
    {
        /** @var Login $model */
        $model = null;

        $post = Yii::$app->getRequest()->getBodyParams();
        if (!$post) {
            throw new BadRequestHttpException('Invalid params');
        }

        if (isset($post['name'])) {
            $model = Login::findIdentityByName($post['name']);
        }

        if (!$model) {
            throw new NotFoundHttpException('User not found');
        }

        if (!isset($post['password']) || !$post['password'] || !$model->validatePassword($post['password'])) {
            throw new ForbiddenHttpException;
        }

        $model->generateAuthKey();
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(200);
            return $model->auth_key;
        }

        return null;
    }
}
