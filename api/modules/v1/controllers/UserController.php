<?
namespace api\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class UserController extends RestController
{
    public $modelClass = 'common\models\User';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'index' => [
                'prepareDataProvider' => function ($action) {
                    /* @var $modelClass \yii\db\BaseActiveRecord */
                    $modelClass = $this->modelClass;

                    return new ActiveDataProvider([
                        'query' => $modelClass::find()->select(['User-ID', 'Location', 'Age'])
                    ]);
                }
            ]
        ]);
    }
}
