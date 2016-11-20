<?
namespace api\modules\v1\actions;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\Action;
use yii\rest\IndexAction;

class RatingIndex extends Action
{
    /** @inheritdoc */
    public function run($bookId)
    {
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;

        return new ActiveDataProvider([
            'query' => $modelClass::find()->where(['Book-ID' => $bookId])
        ]);
    }
}