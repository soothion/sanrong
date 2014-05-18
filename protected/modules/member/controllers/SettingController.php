<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingController
 *
 * @author liuzihui
 */
//账户设置
class SettingController extends Controller{
    //put your code here
    public function actionIndex(){
        $user_id = numeric(Yii::app()->user->id);
        $userCriteria = new CDbCriteria();
        $userCriteria->select = 'id,email,mobile';
        $userCriteria->compare('id', $user_id);
        $userModel = UserModel::model()->find($userCriteria);
        //用户信息，只需要昵称
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $criteria->select = 'id,nickname';
        $model = UserInfoModel::model()->find($criteria);
        if(!$model){
            $model = new UserInfoModel();
        }
        $this->render('index',array(
            'userModel' => $userModel,
            'model' => $model,
        ));
    }
    public function actionInfo_save(){
        $user_id = numeric(Yii::app()->user->id);
        $userModel = UserModel::model()->findByPk($user_id);
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserInfoModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
            if ($model->user_id != $user_id) {
                $this->showError('操作失败！');
            }
        } else {
            $model = new UserInfoModel();
            $model->created = time();
            $model->user_id = $user_id;
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['UserInfoModel'])) {            
            $model->nickname = $_POST['UserInfoModel']['nickname'] ? $_POST['UserInfoModel']['nickname'] : $_POST['UserModel']['mobile'];
            if ($model->save()) {
                $userModel->mobile = $_POST['UserModel']['mobile'];
                $userModel->save();
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->render('index',array(
            'userModel' => $userModel,
            'model' => $model,
        ));
    }
    public function actionAddress(){
        $user_id = numeric(Yii::app()->user->id);
        $userCriteria = new CDbCriteria();
        $userCriteria->select = 'id,mobile';
        $userCriteria->compare('id', $user_id);
        $userModel = UserModel::model()->find($userCriteria);    
        //用户信息，只需要昵称
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $criteria->select = 'id,address,address_name';
        $model = UserInfoModel::model()->find($criteria);
        
        if(!$model){
            $model = new UserInfoModel();
        }
        $this->render('address',array(
            'userModel' => $userModel,
            'model' => $model,
        ));
    }
    public function actionAddress_save(){
        $user_id = numeric(Yii::app()->user->id);
        $userModel = UserModel::model()->findByPk($user_id);
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserInfoModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
            if ($model->user_id != $user_id) {
                $this->showError('操作失败！');
            }
        } else {
            $model = new UserInfoModel();
            $model->created = time();
            $model->user_id = $user_id;
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['UserInfoModel'])) {            
            $model->address = $_POST['UserInfoModel']['address'];
            $model->address_name = $_POST['UserInfoModel']['address_name'];
            if ($model->save()) {
                $userModel->mobile = $_POST['UserModel']['mobile'];
                $userModel->save();
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->render('address',array(
            'userModel' => $userModel,
            'model' => $model,
        ));
    }
    public function actionChange_password(){
        $this->render('change_password');
    }
    public function actionChange_password_save(){
        $user_id = numeric(Yii::app()->user->id);
        $userModel = UserModel::model()->findByPk($user_id);
        if(password($_POST['current_password']) != $userModel->password){
            $this->showError('当前密码错误！');
            exit;
        }        
        if($_POST['new_password'] != $_POST['new_password2']){
            $this->showError('两次密码不一致！');
            exit;
        }
        if(empty($_POST['new_password'])){
            $this->showError('密码不能为空！');
            exit;
        }
        $userModel->password = password($_POST['new_password']);
        if($userModel->save()){
            $this->showSuccess('修改成功！');
        }
    }
}
