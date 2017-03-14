<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * 初始表单
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $username;
    public $password;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            [['username'],'string','max'=>32,'encoding'=>'utf-8'],
            [[ 'password'],'string','max'=>30],
        ];
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function save()
    {
        if(!$this->validate()) {
            return false;
        }
        $user = new User([
            'username'=>$this->username,
        ]);
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save(false);
        return $user;
    }
    
        
    public function attributeLabels() {
        return [
            'username'=>'用户名',
            'password'=>'密码',
        ];
    }
}
