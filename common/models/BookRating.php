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
                ['User-ID', 'Book-ID', 'Book-Rating'],
                'integer'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'User-ID' => 'ID пользователя',
            'Book-ID' => 'ID книги',
            'Book-Rating' => 'Рейтинг'
        ];
    }
}
