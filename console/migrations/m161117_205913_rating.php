<?
use yii\db\Migration;

class m161117_205913_rating extends Migration
{
    public function safeUp()
    {
        $tableOptions = NULL;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%BX-Book-Ratings}}', [
            'User-ID' => $this->integer(),
            'ISBN' => $this->string(),
            'Book-Rating' => $this->integer(),
            'PRIMARY KEY (`User-ID`, `ISBN`)'
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%BX-Book-Ratings}}');
    }
}
