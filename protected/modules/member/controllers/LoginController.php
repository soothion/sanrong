<?php

Class LoginController extends Controller {

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
        $model = new LoginForm();
        $this->render('index', array('model' => $model));
    }

    public function actionLogin() {
        $model = new LoginForm();
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                $referer = Yii::app()->session['http_referer'];
                if(isset($referer) && !empty($referer)){
                    Yii::app()->session['http_referer'] = '';
                }else{
                    $referer = $this->createUrl('/member');
                }
                $this->showSuccess('登录成功！', $referer);
            }
        }
        $this->render('index', array('model' => $model));
    }

    public function actionLogout() {
        Yii::app()->user->logout(true);
        $this->redirect('login');
    }

}
