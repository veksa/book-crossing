<?
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Login extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return '{{%logins}}';
    }

    public function rules()
    {
        return [
            [
                ['name'],
                'string',
                'max' => 255
            ],
            [
                ['password'],
                'safe'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Логин',
            'password' => 'Пароль',
            'updated_at' => 'Дата изменения',
            'created_at' => 'Дата создания'
        ];
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function findIdentityByAccessToken($token, $type = NULL)
    {
        if (!$token) {
            return null;
        }

        return static::findOne(['access_token' => $token]);
    }

    public static function findIdentityByName($name)
    {
        if (!$name) {
            return null;
        }

        return static::findOne(['name' => $name]);
    }

    public static function findIdentityByAuthKey($key)
    {
        return static::findOne(['auth_key' => $key]);
    }

    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id
        ]);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @param \yii\web\User $user
     * @param $key
     * @return null|static
     */
    public function loginByAuthKey($user, $key)
    {
        /** @var Login $identity */
        $identity = Login::findIdentityByAuthKey($key);
        if ($identity && $user->login($identity)) {
            return $identity;
        }

        return null;
    }

    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }

    public function validatePassword($password)
    {
        Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->generateAuthKey();
        }

        return parent::beforeSave($insert);
    }
}
