<?
namespace api\modules\v1\actions;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveRecordInterface;
use yii\rest\Action;
use yii\web\ServerErrorHttpException;

class RatingDelete extends Action
{
    /** @inheritdoc */
    public function run($bookId, $userId)
    {
        /* @var $modelClass ActiveRecordInterface */
        $modelClass = $this->modelClass;
        /* @var $model ActiveRecord */
        $model = $modelClass::find()->where(['Book-ID' => $bookId, 'User-ID' => $userId])->one();
        if (!$model) {
            Yii::$app->getResponse()->setStatusCode(204);
        }

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if ($model->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        Yii::$app->getResponse()->setStatusCode(204);
    }
}