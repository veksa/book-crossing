<?
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class CountryRating extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%BX-Rating-Countries}}';
    }

    public function rules()
    {
        return [
            [
                ['Book-ID'],
                'integer'
            ],
            [
                ['Country'],
                'string',
                'max' => 15
            ],
            [
                ['Book-Rating'],
                'number'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'Book-ID' => 'ID книги',
            'Country' => 'Страна',
            'Book-Rating' => 'Рейтинг'
        ];
    }
}
