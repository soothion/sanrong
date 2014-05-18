<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    public $_id;
    public $email;
    public $password;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function getName() {
        return $this->email;
    }

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $model = UserModel::model()->find('email=:email', array(':email' => $this->email));
        if (!isset($model->email)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        } elseif ($model->password !== password($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            return false;
        } else {
//            if ($model->status == 2 && $model->user_type == 2) {
//                $this->errorCode = 'checking';
//                return false;
//            }
            //完善数据库的信息
                $this->errorCode = self::ERROR_NONE;
            $this->_id = $model->id;
            $this->setState('last_login', $model->last_login);
            $this->setState('user_type', $model->user_type);
            $model->last_ip = Yii::app()->request->userHostAddress;
            $model->logins += 1;
            $model->last_login = time();
            $model->save();
            return true;
        }
    }

    public function getId() {
        return $this->_id;
    }

}
