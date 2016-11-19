<?
namespace api\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use api\modules\v1\auth\UserAuth;

abstract class RestController extends ActiveController
{
    public $modelClass = '';

    public function behaviors()
    {
        $behaviors = ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'except' => ['options', 'index', 'view'],
                'authMethods' => [
                    UserAuth::className()
                ]
            ]
        ]);

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON
            ]
        ];

        return $behaviors;
    }

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'index' => [
                'prepareDataProvider' => function ($action) {
                    /* @var $modelClass \yii\db\BaseActiveRecord */
                    $modelClass = $this->modelClass;

                    return new ActiveDataProvider([
                        'query' => $modelClass::find()
                    ]);
                }
            ]
        ]);
    }
}