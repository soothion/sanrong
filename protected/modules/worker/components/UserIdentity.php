<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    protected $_id;
    public $mobile;
    public $password;

    public function __construct($mobile, $password) {
        $this->mobile = $mobile;
        $this->password = $password;
    }

    public function getName() {
        return $this->mobile;
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
        $criteria = new CDbCriteria();
        $criteria->addCondition('mobile=' . $this->mobile, 'OR');
        $criteria->addCondition('id=' . numeric($this->mobile), 'OR');
        $model = WorkerModel::model()->find($criteria);
        if(!$model){
            $this->errorCode = '用户名不存在！';
            return false;
        }elseif ($model->status == 0) {
            $this->errorCode = '该账号正在审核中...';
            return false;
        } elseif (!isset($model->mobile)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        } elseif ($model->password !== password($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            return false;
        } else {
            //完善数据库的信息
            $this->errorCode = self::ERROR_NONE;
            $this->_id = get_worker_id($model->id);
            $this->setState('last_login', $model->last_login);
            $this->setState('username', $model->username);
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
