<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegisterController
 *
 * @author liuzihui
 */
class RegisterController extends Controller{
    //put your code here
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'system.web.widgets.captcha.CCaptchaAction',
                'width' => 70,
                'height' => 30,
                'padding' => 0,
                'minLength' => 4,
                'maxLength' => 4,
                'testLimit' => 999,
            ),
        );
    }
     public function actionIndex() {
        $model = new WorkerModel();
        $model->read = 1;
        $this->render('index', array('model' => $model));
    }
    public function actionRegister() {
        $model = new WorkerModel();
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['WorkerModel'])) {
            $model->mobile = $_POST['WorkerModel']['mobile'];
            $model->password = password(($_POST['WorkerModel']['password']));
            $model->last_login = time();
            $model->last_ip = Yii::app()->request->userHostAddress;
            $model->logins = 1;
            $model->created = time();
            if ($model->save()) {
                $return = Yii::app()->user->doUserLogin($model->email,$model->password);
                if ($return == 'success') {
                    Yii::app()->user->setState('user_status',0); //0表示个人用户
                    $this->showSuccess('注册成功！', $this->createUrl('/worker'));
                }
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->render('index', array('model' => $model));
    }
}
