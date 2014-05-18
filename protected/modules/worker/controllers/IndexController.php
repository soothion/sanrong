<?php

Class IndexController extends Controller {

    public function actionIndex() {
        $creteria = new CDbCriteria();
        $creteria->compare('worker_id', numeric(Yii::app()->user->id));
        $model = WorkerInfoModel::model()->findAll($creteria);
        $this->render('index',array(
            'model' => $model,
        ));
    }

}
