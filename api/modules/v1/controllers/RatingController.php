<?
namespace api\modules\v1\controllers;

use api\modules\v1\actions\RatingIndex;
use api\modules\v1\actions\RatingDelete;

class RatingController extends RestController
{
    public $modelClass = 'common\models\BookRating';

    public function actions()
    {
        return [
            'index' => [
                'class' => RatingIndex::className(),
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess']
            ],
            'create' => [
                'class' => 'yii\rest\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario
            ],
            'delete' => [
                'class' => RatingDelete::className(),
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess']
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction'
            ]
        ];
    }
}
