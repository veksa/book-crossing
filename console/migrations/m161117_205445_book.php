<?
use yii\db\Migration;

class m161117_205445_book extends Migration
{
    public function safeUp()
    {
        $tableOptions = NULL;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%BX-Books}}', [
            'Book-ID' => $this->primaryKey(),
            'ISBN' => $this->string(13),
            'Year-Of-Publication' => $this->integer(),
            'Book-Title' => $this->string(),
            'Book-Author' => $this->string(),
            'Publisher' => $this->string(),
            'Image-URL-S' => $this->string(),
            'Image-URL-M' => $this->string(),
            'Image-URL-L' => $this->string()
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%BX-Books}}');
    }
}
