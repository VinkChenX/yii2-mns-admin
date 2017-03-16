<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username 用户名称
 * @property string $password_hash 密码hash
 * @property string $auth_key auth key
 * @property integer $status 状态
 * @property integer $created_at 创建时间
 * @property integer $updated_at 更新时间
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * 密码
     * @var string 
     */
    public $password;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
    
    public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className()
        ];
    }
    

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne((int)$id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username'=>$username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    public function rules() {
        return [
            [['username','password'],'required'],
            [['username'],'string','max'=>64,'encoding'=>'utf-8'],
            [['password'],'string','max'=>64],
        ];
    }
    
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    
    public function attributeLabels() {
        return [
            'username'=>'用户名',
            'password'=>'密码',
        ];
    }
}
