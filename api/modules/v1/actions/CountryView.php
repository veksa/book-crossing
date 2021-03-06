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

        $query = $modelClass::find()->where(['Book-ID' => $id]);
        $queryCount = clone $query;

        $totalCount = $queryCount->count();
        $pageSize = 20;

        $get = Yii::$app->request->get();
        $start = 0;
        if (isset($get['start'])){
            $start = (int)$get['start'];
        }

        $models = $query->asArray()->limit($pageSize)->offset($start)->all();

        return [
            'draw' => isset($get['draw']) ? (int)$get['draw'] : 1,
            'recordsTotal' => (int)$totalCount,
            'recordsFiltered' => (int)$totalCount,
            'data' => $models
        ];
    }
}