<?
namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use api\modules\v1\actions\BookIndex;

class BookController extends RestController
{
    public $modelClass = 'common\models\Book';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'index' => [
                'class' => BookIndex::className()
            ]
        ]);
    }
}
