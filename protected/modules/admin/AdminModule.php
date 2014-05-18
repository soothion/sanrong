<?php

class AdminModule extends CWebModule {

    public function init() {
        $this->defaultController = 'index';
        $this->layout = '//layouts/column2';
        $this->setImport(array(
            'admin.models.*',
            'admin.components.*',
        ));
        Yii::app()->setComponents(array(
            'bootstrap' => array(
                'class' => 'bootstrap.components.Bootstrap',
            ),
            'user' => array(
                // enable cookie-based authentication
                'class' => 'application.components.MCAuthUser',
                'allowAutoLogin' => true,
                'stateKeyPrefix' => 'admin',
            )
        ));
        Yii::app()->theme = 'bootstrap';
    }

    public function beforeControllerAction($controller, $action) {
        $controller->layout = '//layouts/column2';
        if ($controller->getId() != 'login' && Yii::app()->user->getId() == '') {
            $controller->redirect($controller->createUrl('/admin/login'));
        }
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }

}
