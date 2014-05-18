<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class MailController extends Controller {

    public function actionIndex() {
        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
        $message = '恭喜您成功注册三容人力会员!';
        $mailer->Host = 'smtp.163.com';
        $mailer->IsSMTP();
        $mailer->SMTPAuth = true;
        $mailer->From = Yii::app()->mailer->from;
        $mailer->FromName = Yii::app()->mailer->fromname;
        $mailer->Username = Yii::app()->mailer->username;
        $mailer->Password = Yii::app()->mailer->password;
        $mailer->AddAddress('359403011@qq.com');
        
        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = Yii::t('demo', '恭喜您成功注册三容人力会员!');
        $mailer->Body = $message;
        
        if ($mailer->Send()) {
            echo "success";
            exit;
        } else {
            echo 'fail';
        }
    }

}
