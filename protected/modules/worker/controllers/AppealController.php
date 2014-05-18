<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppealController
 *
 * @author liuzihui
 */
class AppealController extends Controller {

    //put your code here
    public function actionIndex($worker_info_id) {
        //申诉详情
        $worker_info_id = numeric($worker_info_id);
        $creiteria = new CDbCriteria();
        $creiteria->compare('worker_info_id', $worker_info_id);
        $info = WorkerAppealModel::model()->findAll($creiteria);
        //日志信息
        $workerInfoModel = WorkerInfoModel::model()->findByPk($worker_info_id);
        //添加的model
        $model = new WorkerAppealModel();
        $this->render('index', array(
            'model' => $model,
            'workerInfoModel' => $workerInfoModel,
            'info' => $info,
        ));
    }

    public function actionAppeal() {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['WorkerAppealModel'])) {
            $model = new WorkerAppealModel();
            $model->created = time();
            $model->worker_id = numeric(Yii::app()->user->id);
            $model->worker_info_id = $_POST['worker_info_id'];
            $model->content = $_POST['WorkerAppealModel']['content'];
            if ($model->save()) {
                if(WorkerInfoModel::model()->updateStatus($model->worker_info_id, 1)){
                    $this->showSuccess('申诉中，请等待回复！');
                }
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->showError('操作失败！');
    }

}
