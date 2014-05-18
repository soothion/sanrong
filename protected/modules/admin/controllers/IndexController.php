<?php
    Class IndexController extends Controller{
        public function actionIndex(){
            //$last_time = Yii::app()->user->getState('last_login');
            //echo date('Y-m-d H:i:s',$last_time);
            $this->render('index');
        }
    }
