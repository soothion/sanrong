<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author waiting
 */
class MCAuthUser extends CWebUser {

    public function doManagerLogin($username, $password, $ignorePassword = false) {
        $manager = ManagerModel::model()->find('username=:username', array(':username' => $username));
        if (empty($manager)) {
            return 'user_no_exists';
        }
        if (!$ignorePassword) {
            if (password($password) != $manager->password) {
                return 'password_error';
            }
        }
        $access = array('m');
        if (!empty($manager->role_id)) {
            $roleData = RoleModel::model()->find('id=:id', array(':id' => $manager->role_id));
            if (!empty($roleData->access)) {
                $access = (array) unserialize($roleData->access);
            }
            foreach ($access as $value) {
                if (!strstr($value, '_')) {
                    continue;
                }
                $parentAccess = substr($value, 0, strpos($value, '_'));
                if (!in_array($parentAccess, $access)) {
                    $access[] = $parentAccess;
                }
            }
        }
        $UserIdentity = new UserIdentity($username, '');
        $UserIdentity->_id = $manager->id;
        $UserIdentity->setState('access', $access);
        $this->login($UserIdentity);
        $manager->last_login_time = time();
        $manager->save();
        return 'success';
    }

    public function doUserLogin($email, $password, $ignorePassword = false) {
        
        $UserModel = new UserModel();
        $User = $UserModel->find('email=:email', array(':email' => $email));
        if (empty($User)) {
            return 'user_no_exists';
        }
        if (!$ignorePassword) {
            if (password($password) != $User->password) {
                return 'password_error';
            }
        }
        
        $UserIdentity = new UserIdentity($email, $password);
        
        $UserIdentity->_id = $User->id;
        $this->login($UserIdentity);
        $User->save();
        return 'success';
    }
    public function doWorkerLogin($mobile, $password, $ignorePassword = false) {
        $WokerModel = new WorkerModel();
        $Worker = $WokerModel->find('mobile=:mobile', array(':mobile' => $mobile));
        if (empty($User)) {
            return 'worker_no_exists';
        }
        if (!$ignorePassword) {
            if ($password != $Worker->password) {
                return 'password_error';
            }
        }
        $UserIdentity = new UserIdentity($mobile, '');
        $UserIdentity->_id = $Worker->id;
        $this->login($UserIdentity);
        $Worker->save();
        return 'success';
    }

    public function doPropertyServiceLogin($username, $password, $ignorePassword = false) {
        $model = new PropertyServicerModel();
        $model = PropertyServicerModel::model()->find('username=:username', array(':username' => $username));
        if (empty($model)) {
            return 'user_no_exists';
        }
        if (!$ignorePassword) {
            if (password($password) != $model->password) {
                return 'password_error';
            }
        }
        $access = array();
        $UserIdentity = new UserIdentity($username, '');
        $UserIdentity->_id = $model->id;
        $UserIdentity->setState('access', $access);
        $this->login($UserIdentity);
        return 'success';
    }

    public function getAccess() {
        //return (array) $this->getState('access');
        return explode(',', $this->getState('access'));
    }

    public function cAccess($operation) {
        static $access = null;
        if ($access === null) {
            $access = $this->getAccess();
        }
        return in_array($operation, $access);
    }

    public function getNick() {
        if ($nick = $this->getState('__nick') !== null)
            return $nick;
        else
            return $this->getName();
    }
    
//    public function get_user_type(){
//        if (Yii::app()->user->getState('user_type') == 0){
//            return 0;//个人用户
//        }elseif (Yii::app()->user->getState('user_type') == 1 && Yii::app()->user->getState('user_status') == 1){
//            return 1;//企业用户
//        }elseif (Yii::app()->user->getState('user_type') == 1 && Yii::app()->user->getState('user_status') == 0){
//            return 2;//企业审核中用户
//        }
//    }

}

?>
