<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WorkerController
 *
 * @author lzh
 */
class WorkerController extends Controller {

    //put your code here
    public function actionChange_password() {
        $creteria = new CDbCriteria();
        $creteria->compare('worker_id', numeric(Yii::app()->user->id));
        $model = WorkerInfoModel::model()->findAll($creteria);
        $this->render('change_password', array(
            'model' => $model,
        ));
    }

    public function actionChange_password_save() {
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $password_old = $_POST['password_old'];
        if (empty($password) || empty($password2)){
            $this->showError('密码不能为空！');
        }
        if ($password !== $password2){
            $this->showError('两次密码不一致！');
        }
        $id = numeric(Yii::app()->user->id);
        $criteria = new CDbCriteria();
        $criteria->compare('id', $id);
        $criteria->compare('password', password($password_old));
        $workerModel = WorkerModel::model()->find($criteria);
        if(!$workerModel){
            $this->showError('原密码错误！');
        }
        $workerModel->password = password($password);
        $workerModel->save();
        Yii::app()->user->logout(true);
        $this->showError('密码修改成功！，请重新登录',$this->createUrl('/worker'));
    }

}
