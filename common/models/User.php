<?
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%BX-Users}}';
    }

    public function rules()
    {
        return [
            [
                ['User-ID'],
                'integer'
            ],
            [
                ['Location'],
                'string',
                'max' => 255
            ],
            [
                ['Age'],
                'integer'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'User-ID' => 'ID',
            'Location' => 'Местоположение',
            'Age' => 'Возраст'
        ];
    }
}
