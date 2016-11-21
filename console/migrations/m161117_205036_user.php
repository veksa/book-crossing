<?
use yii\db\Migration;

class m161117_205036_user extends Migration
{
    public function safeUp()
    {
        $tableOptions = NULL;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%BX-Users}}', [
            'User-ID' => $this->primaryKey(),
            'Location' => $this->string(),
            'Country' => $this->string(15),
            'Age' => $this->integer()
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%BX-Users}}');
    }
}
