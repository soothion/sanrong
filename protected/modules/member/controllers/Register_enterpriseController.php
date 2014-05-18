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
class Register_enterpriseController extends Controller {

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
//        $user_id = Yii::app()->user->id;
//        if (!isset($user_id) || numeric($user_id) <= 0) {
//            $this->showError('请先登录', $this->createUrl('/member/login'));
//        } elseif (UserCompanyModel::model()->find('user_id=:user_id', array(':user_id' => $user_id))) {
//            $this->showError('您已经申请过企业，正在进入企业中心...', $this->createUrl('/member'));
//        }
//        $model = UserModel::model()->find('id = :user_id', array(':user_id' => Yii::app()->user->id));
//        $userCompanyModel = new UserCompanyModel();
//        $userCompanyModel->read = 1;
//        $this->render('index', array(
//            'model' => $model,
//            'userCompanyModel' => $userCompanyModel,
//        ));
        //$model = new UserModel();
        $model = new UserCompanyModel();
        $model->read = 1;
        $this->render('index', array(
            'model' => $model
        ));
    }

//    public function actionRegister_enterprise() {
//        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
//            echo CActiveForm::validate($model);
//            Yii::app()->end();
//        }
//        $model = new UserCompanyModel();
//        $model->attributes = $_POST['UserCompanyModel'];
//        if($model->save()){
//            $this->showSuccess('success');
//        }
//    }

    public function actionRegister_enterprise() {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (strtolower($_POST['UserCompanyModel']['verifyCode']) !== strtolower($this->createAction('captcha')->getVerifyCode())) {
            $this->showError('验证码错误！');
        }
        $user_model = new UserModel();
        if (isset($_POST['UserCompanyModel'])) {
            $userpost = $_POST['UserCompanyModel'];
            if (UserModel::model()->find('email=:email', array(':email' => $userpost['email']))) {
                $this->showError('用户名已存在！');
            }
            if ($userpost['password'] !== $userpost['password2']) {
                $this->showError('两次密码不一致！');
            }
            if (!preg_match('/^1\d{10}$/', $userpost['mobile'])) {
                $this->showError('手机号码格式不正确！');
            }
            $user_model->mobile = $userpost['mobile'];
            $user_model->user_type = 2;
            $user_model->email = $userpost['email'];
            $user_model->password = password(($userpost['password']));
            $user_model->password2 = password(($userpost['password2']));
            $user_model->codes = uniqid();
            $user_model->created = time();
            //$user_model->status = 2; //2表示企业用户审核中 
            $user_model->isNewRecord = true;
            if ($user_model->save()) {
                //$return = Yii::app()->user->doUserLogin($user_model->email, $userpost['password']);
                //Yii::app()->user->setState('user_type',$user_model->user_type);

                $userCompanyModel = new UserCompanyModel();
                $userCompanyModel->user_id = $user_model->id;
                $userCompanyModel->real_name = $userpost['real_name'];
                $userCompanyModel->company_name = $userpost['company_name'];
                $userCompanyModel->position = $userpost['position'];
                $userCompanyModel->company_address = $userpost['company_address'];
                $userCompanyModel->company_phone = $userpost['company_phone'];
                $userCompanyModel->trading_certificate = $userpost['trading_certificate'];
                $userCompanyModel->created = time();

                if ($userCompanyModel->save()) {
                    $url = $this->createAbsoluteUrl('/member/register_enterprise/check', array('email' => $user_model->email, 'codes' => $user_model->codes));
                    $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                    $message = <<<str
你好！{$user_model->email}
	<h2>感谢您注册三容人力企业,请点击以下链接进行激活账号</h2>
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
                    $mailer->AddAddress($user_model->email);

                    $mailer->CharSet = 'UTF-8';
                    $mailer->Subject = Yii::t('demo', '激活企业在线申请!');
                    $mailer->Body = $message;
                    $mailer->Send();
                    $this->showSuccess('申请成功,请前往邮箱进行激活账号！');
                }
            }
        }
    }

    public function actionCheck() {
        $email = $_REQUEST['email'];
        $codes = $_REQUEST['codes'];
        $criteria = new CDbCriteria();
        $criteria->compare('email', $email);
        $criteria->compare('codes', $codes);
        $criteria->compare('status', 0);
        $model = UserModel::model()->find($criteria);
        if (!$model) {
            $this->showError('页面错误');
        } else {
            $model->status = 1;
            $model->password2 = $model->password;
            if ($model->save()) {
                Yii::app()->user->setState('user_type', 2);
                Yii::app()->user->doUserLogin($model->email, "", true);
                $this->showSuccess('恭喜您，账号激活成功，请等待审核！', $this->createUrl('/member'));
            } else {
               print_r( CHtml::errorSummary($model));
               // print_r($model->getError($model->attributes));
            }
        }
    }

//    public function actionRegister_enterprise() {
//        $model = new UserCompanyModel();
//        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
//            echo CActiveForm::validate($model);
//            Yii::app()->end();
//        }
//        if (isset($_POST['UserCompanyModel'])) {
//            $model->attributes = $_POST['UserCompanyModel'];
//            $model->user_id = Yii::app()->user->id;
//            $model->created = time();
//            if ($model->save()) {
////                Yii::app()->user->setState('user_type', 2); //2表示企业用户审核中
////                $userModel = UserModel::model()->find('id = :user_id', array(':user_id' => Yii::app()->user->id));
//                $userModel = new UserModel();
//                $userModel->mobile = $_POST['UserModel']['mobile'];
//                $userModel->user_type = 2;
//                $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
//                $message = '企业申请在线审核中!';
//                $mailer->Host = 'smtp.163.com';
//                $mailer->IsSMTP();
//                $mailer->SMTPAuth = true;
//                $mailer->From = Yii::app()->mailer->from;
//                $mailer->FromName = Yii::app()->mailer->fromname;
//                $mailer->Username = Yii::app()->mailer->username;
//                $mailer->Password = Yii::app()->mailer->password;
//                $mailer->AddAddress($userModel->email);
//
//                $mailer->CharSet = 'UTF-8';
//                $mailer->Subject = Yii::t('demo', '企业申请在线审核中!');
//                $mailer->Body = $message;
//                $mailer->Send();
//                $userModel->save();
//                $this->showSuccess('申请成功,请等待审核！', $this->createUrl('/member'));
//            } else {
//                $this->showError($model->getErrors());
//            }
//        }
//        $this->render('index', array('model' => $model));
//    }
}
