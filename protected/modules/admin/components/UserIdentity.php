<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $model = AdminModel::model()->find('username=:username', array(':username' => $this->username));
        if (!isset($model->username)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        } elseif ($model->password !== password($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            return false;
        } else {
            //完善数据库的信息
            $this->errorCode = self::ERROR_NONE;
            $this->_id = $model->id;
            $this->setState('last_login', $model->last_login);
            $this->setState('last_ip', $model->last_ip);
            $model->last_ip = Yii::app()->request->userHostAddress;
            $model->logins += 1;
            $model->last_login = time();
            $model->save();
            //找出管理员权限
            $access = "";
            if (!empty($model->role_id)) {
                $roleData = AdminRoleModel::model()->find('id=:id', array(':id' => $model->role_id));
                $access = $roleData->access;
            }
            $this->setState('access', $access);
            return true;
        }
    }

    public function getId() {
        return $this->_id;
    }

}
