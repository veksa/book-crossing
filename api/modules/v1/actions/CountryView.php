<?
namespace api\modules\v1\actions;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ViewAction;

class CountryView extends ViewAction
{
    /** @inheritdoc */
    public function run($id)
    {
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;

        return new ActiveDataProvider([
            'query' => $modelClass::find()->where(['Book-ID' => $id])
        ]);
    }
}