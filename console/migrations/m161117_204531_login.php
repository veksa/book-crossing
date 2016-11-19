<?
use yii\db\Migration;

class m161117_204531_login extends Migration
{
    public function safeUp()
    {
        $tableOptions = NULL;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%logins}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string(),
            'updated_at' => $this->timestamp(),
            'created_at' => $this->timestamp()
        ], $tableOptions);

        $this->insert('{{%logins}}', [
            'name' => 'demo',
            'password' => Yii::$app->security->generatePasswordHash('demo123')
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%logins}}');
    }
}
