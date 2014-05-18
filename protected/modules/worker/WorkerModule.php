<?php

class WorkerModule extends CWebModule {

    public function init() {
        $this->defaultController = 'index';
        $this->layout = 'main';
        $this->setImport(array(
            'worker.models.*',
            'worker.components.*',
        ));
        Yii::app()->setComponents(array(
            'user' => array(
                // enable cookie-based authentication
                'class' => 'application.components.MCAuthUser',
                'allowAutoLogin' => true,
                'stateKeyPrefix' => 'worker',
            )
        ));
    }

    public function beforeControllerAction($controller, $action) {
        $controller->layout = '//layouts/main';
        $controller->seo = array(
            'title' => '业务员中心',
        );
        if ($controller->getId() != 'login' && $controller->getId() != 'apply' && Yii::app()->user->getId() == '') {
            $controller->redirect($controller->createUrl('/worker/login'));
        }
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }

}
