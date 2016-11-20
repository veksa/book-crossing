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
                ['country'],
                'string',
                'max' => 15
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
            'country' => 'Страна',
            'Age' => 'Возраст'
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->Location) {
                $location = explode(',', $this->Location);
                if (count($location) == 3) {
                    $this->country = $location[2];
                }
            }

            return true;
        }

        return false;
    }
}
