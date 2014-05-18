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
class RegisterController extends Controller {

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
        $model = new UserModel();
        $model->read = 1;
        $this->render('index', array('model' => $model));
    }

    public function actionRegister() {
        //echo 11;exit;
        $model = new UserModel();
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['UserModel'])) {
            $model->email = $_POST['UserModel']['email'];
            $model->mobile = $_POST['UserModel']['mobile'];
            $model->password = password(($_POST['UserModel']['password']));
            $model->password2 = password(($_POST['UserModel']['password2']));
            $model->last_login = time();
            $model->last_ip = Yii::app()->request->userHostAddress;
            $model->logins = 1;
            $model->user_type = 0;
            $model->codes = uniqid();
            $model->created = time();
            if ($model->save()) {
                //$return = Yii::app()->user->doUserLogin($model->email, $_POST['UserModel']['password']);
                $url = $this->createAbsoluteUrl('/member/register/check', array('email' => $model->email, 'codes' => $model->codes));
             $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                $message = <<<str
你好！{$model->email}
	<h2>恭喜您成功注册三容人力会员,请点击以下链接进行激活账号</h2>
        <a href="{$url}" target="_blank">"{$url}"</a>
	<br/><br/>
str;
                //$message = '恭喜您成功注册三容人力会员,请点击以下链接进行激活账号：<br/><a href="'.$this->createUrl('/register/check',array('email'=>$model->email,'codes'=>$model->codes)).'" target="_blank"></a>';
                $mailer->Host = 'smtp.163.com';
                $mailer->IsSMTP();
                $mailer->SMTPAuth = true;
                $mailer->From = Yii::app()->mailer->from;
                $mailer->FromName = Yii::app()->mailer->fromname;
                $mailer->Username = Yii::app()->mailer->username;
                $mailer->Password = Yii::app()->mailer->password;
                $mailer->AddAddress($model->email);
                $mailer->IsHTML(true);
                $mailer->CharSet = 'UTF-8';
                $mailer->Subject = Yii::t('demo', '恭喜您成功注册三容人力会员!');
                $mailer->Body = $message;
                $mailer->Send();
                Yii::app()->user->setState('user_type', 0); //0表示个人用户
                $this->showSuccess('注册成功,请前往邮箱进行激活账号！');
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->render('index', array('model' => $model));
    }

    public function actionCheck() {
        $email = $_REQUEST['email'];
        $codes = $_REQUEST['codes'];
        $criteria = new CDbCriteria();
        $criteria->compare('email', $email);
        $criteria->compare('codes', $codes);
        $model = UserModel::model()->find($criteria);
        if (!$model) {
            $this->showError('页面错误');
        } else {
            $model->status = 1;
            $model->password2 = $model->password;
            $model->save();
            Yii::app()->user->setState('user_type',0);
            Yii::app()->user->doUserLogin($model->email,"",true);
            $this->showSuccess('恭喜您，注册成功！', $this->createAbsoluteUrl('/member'));
        }
    }

}
