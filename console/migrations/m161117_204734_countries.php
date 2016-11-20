<?
use yii\db\Migration;

class m161117_204734_countries extends Migration
{
    public function safeUp()
    {
        $tableOptions = NULL;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%BX-Rating-Countries}}', [
            'Book-ID' => $this->integer(),
            'Country' => $this->string(15),
            'Book-Rating' => $this->float(),
            'PRIMARY KEY (`Book-ID`, `Country`)'
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%BX-Rating-Countries}}');
    }
}
