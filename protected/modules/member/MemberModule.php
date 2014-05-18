<?php

class MemberModule extends CWebModule {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->defaultController = 'orders';
        $this->layout = 'main';
        $this->setImport(array(
            'member.models.*',
            'member.components.*',
        ));
        Yii::app()->setComponents(array(
            'bootstrap' => array(
                'class' => 'bootstrap.components.Bootstrap',
            ),
            'user' => array(
                // enable cookie-based authentication
                'class' => 'application.components.MCAuthUser',
                'allowAutoLogin' => true,
                'stateKeyPrefix' => 'member',
            )
        ));        
    }

    public function beforeControllerAction($controller, $action) {
        $controller->layout = '//layouts/main';
        $controller->seo = array(
            'title' => '会员中心'
        );
        if ($controller->getId() != 'login' && $controller->getId() != 'register' && Yii::app()->user->getId() == '' && $controller->getId() != 'register_enterprise' ) {
            $controller->redirect($controller->createUrl('/member/login'));
        }
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }

}
