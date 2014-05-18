<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author lzh
 */
class UserController extends Controller {

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

    public function actionForget_pwd() {
        $model = new UserModel();
        $this->render('forget_pwd', array('model' => $model));
    }

    public function actionForget_pwd_handle() {
        if (strtolower($_POST['UserModel']['verifyCode']) !== strtolower($this->createAction('captcha')->getVerifyCode())) {
            $this->showError('验证码错误！');
        }
        if (isset($_POST['UserModel']['email'])) {
            $model = UserModel::model()->find('email=:email', array(':email' => $_POST['UserModel']['email']));
            if ($model) {
                $model->codes = uniqid();
                $model->password2 = $model->password;
                if ($model->save()) {
                    $url = $this->createAbsoluteUrl('/user/reset_pwd', array('email' => $model->email, 'codes' => $model->codes));
                    $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                    $message = <<<str
你好！{$model->email}
	<h2>请点击以下链接进行重置密码</h2>
        <a href="{$url}" target="_blank">"{$url}"</a>
	<br/><br/>
str;
                    //$message = '企业申请在线审核中!';
                    $mailer->Host = 'smtp.163.com';
                    $mailer->IsSMTP();
                    $mailer->SMTPAuth = true;
                    $mailer->IsHTML(true);
                    $mailer->From = Yii::app()->mailer->from;
                    $mailer->FromName = Yii::app()->mailer->fromname;
                    $mailer->Username = Yii::app()->mailer->username;
                    $mailer->Password = Yii::app()->mailer->password;
                    $mailer->AddAddress($model->email);

                    $mailer->CharSet = 'UTF-8';
                    $mailer->Subject = Yii::t('demo', '密码重置!');
                    $mailer->Body = $message;
                    $mailer->Send();
                    $this->showSuccess('请前往邮箱进行重置密码！');
                } else {
                    print_r(CHtml::errorSummary($model));
                }
            } else {
                $this->showError('页面错误');
            }
        } else {
            $this->showError('页面错误');
        }
    }

    public function actionReset_pwd() {
        $email = $_REQUEST['email'];
        $codes = $_REQUEST['codes'];
        $criteria = new CDbCriteria();
        $criteria->compare('email', $email);
        $criteria->compare('codes', $codes);
        $model = UserModel::model()->find($criteria);
        if (!$model) {
            $this->showError('页面错误');
        } else {
            $this->render('reset_pwd', array('model' => $model));
        }
    }

    public function actionReset_pwd_handle() {
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $id = $_POST['id'];
        $codes = $_POST['codes'];
        if (empty($password) || empty($password2)) {
            $this->showError('密码不能为空！');
        }
        if ($password !== $password2) {
            $this->showError('两次密码不一致！');
        }
        $model = UserModel::model()->find('id=:id and codes = :codes',array(':id'=>$id,':codes'=>$codes));
        if(!$model){
             $this->showError('页面错误！');
        }else{
            $model->password = password($password);
            $model->password2 = password($password);
            if($model->save()){
                $this->showSuccess('重置密码成功，请重新登录',$this->createUrl('/member/login'));
            }else{
                print_r(CHtml::errorSummary($model));
            }
        }
    }

}
