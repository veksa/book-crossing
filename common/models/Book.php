<?
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%BX-Books}}';
    }

    public function rules()
    {
        return [
            [
                ['ISBN'],
                'string',
                'max' => 13
            ],
            [
                ['Year-Of-Publication'],
                'integer'
            ],
            [
                ['Book-Title', 'Book-Author', 'Publisher', 'Image-URL-S', 'Image-URL-M', 'Image-URL-L'],
                'string',
                'max' => 255
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'ISBN' => 'ID',
            'Year-Of-Publication' => 'Год публикации',
            'Book-Title' => 'Название',
            'Book-Author' => 'Автор',
            'Publisher' => 'Редакция',
            'Image-URL-S' => 'Изображение S',
            'Image-URL-M' => 'Изображение M',
            'Image-URL-L' => 'Изображение L'
        ];
    }
}
