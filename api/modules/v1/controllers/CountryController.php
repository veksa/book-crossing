<?
namespace api\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use api\modules\v1\actions\CountryView;

class CountryController extends RestController
{
    public $modelClass = 'common\models\CountryRating';

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
            ],
            'view' => [
                'class' => CountryView::className()
            ]
        ]);
    }
}
