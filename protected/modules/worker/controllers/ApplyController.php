<?php

Class ApplyController extends Controller {

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
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionApply() {
        $model = new WorkerModel();
        $model->created = time();
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['WorkerModel'])) {
            $model->attributes = $_POST['WorkerModel'];
            if ($model->save()) {
                $this->showSuccess('申请成功，请等待管理员审核！',$this->createUrl('/worker/login'));
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

}
