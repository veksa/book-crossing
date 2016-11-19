<?
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class BookRating extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%BX-Book-Ratings}}';
    }

    public function rules()
    {
        return [
            [
                ['User-ID', 'Book-Rating'],
                'integer'
            ],
            [
                ['ISBN'],
                'string',
                'max' => 13
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'User-ID' => 'ID пользователя',
            'ISBN' => 'ISBN книги',
            'Book-Rating' => 'Рейтинг'
        ];
    }
}
