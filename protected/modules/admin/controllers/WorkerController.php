<?php

class WorkerController extends Controller {

    public function init() {
        $this->layout = '//layouts/column2';
        if (!$this->checkAccess(2)) {
            $this->showError('没有操作权限！', '/admin');
        }
        $this->subnavtabs = array(
            'worker_index' => array('title' => '业务员列表', 'url' => $this->createUrl('index')),
            //'worker_worker_info' => array('title' => '业务员记录信息列表', 'url' => $this->createUrl('worker_info', array('worker_id' => 0))),
        );
        parent::init();
    }

    public function actionIndex() {
        $this->breadcrumbs[] = '业务员列表';
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        if(isset($_GET['id']) && numeric($_GET['id']) > 0){
            $criteria->compare('id', numeric($_GET['id']));
        }
        if(isset($_GET['status']) && $_GET['status'] >= 0){ 
            $criteria->compare('status', $_GET['status']);
        }
        if(isset($_GET['username']) && !empty($_GET['username'])){
            $criteria->addSearchCondition('username', $_GET['username']);
        }
        $dataProvider = new CActiveDataProvider('WorkerModel', array(
            'id' => '',
            'pagination' => array('pageSize' => 15),
            'criteria' => $criteria,
                )
        );
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $this->subnavtabs['worker_create'] = array(
            'title' => '添加业务员', 'url' => $this->createUrl('create')
        );
        $this->breadcrumbs[] = '添加业务员';
        $model = new WorkerModel('login');
        $model->status = 1;
        $this->render('_form', array('model' => $model));
    }

    public function actionUpdate($id = 0) {
        $this->subnavtabs['worker_update'] = array(
            'title' => '更新业务员信息', 'url' => $this->createUrl('update')
        );
        $this->breadcrumbs[] = '编辑业务员';
        $model = WorkerModel::model()->find('id=:id', array(':id' => $id));
        $this->checkEmpty($model);
        $model->password = "";
        $this->render('_form', array('model' => $model));
    }

    public function actionSave() {
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = WorkerModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            if (isset($_POST['WorkerModel']['password']) && !empty($_POST['WorkerModel']['password'])) {
                $model->password = password($_POST['WorkerModel']['password']);
            }
        } else {
            $model = new WorkerModel();
            $model->password = password($_POST['WorkerModel']['password']);
            $model->created = time();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['WorkerModel'])) {
            $model->mobile = $_POST['WorkerModel']['mobile'];
            $model->status = $_POST['WorkerModel']['status'];
            $model->username = $_POST['WorkerModel']['username'];
            $model->admin_id = Yii::app()->user->id;
            if ($model->save()) {
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
    }

    public function actionDelete() {
        $model = new WorkerModel();
        if (isset($_GET['id'])) {
            $model->deleteByPk(numeric($_GET['id']));
            $this->showSuccess('删除成功！');
        } elseif (isset($_POST['selected']) && is_array($_POST['selected'])) {
            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $_POST['selected']);
            $model->deleteAll($criteria);
            $this->showSuccess('删除成功！');
        }
        $this->showSuccess('操作失败！');
    }

    public function actionWorker_info() {
        $this->subnavtabs['worker_worker_info'] = array(
            'title' => '业务员记录信息管理', 'url' => $this->createUrl('worker_info')
        );      
        $this->breadcrumbs[] = '业务员记录信息管理';
        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $render_array = array();
        if (isset($_GET['worker_id']) && numeric($_GET['worker_id']) > 0) {
            $criteria->compare('t.worker_id', $_GET['worker_id']);
            $render_array['worker_id'] = $_GET['worker_id'];
        }
        $criteria->with = array('worker');
        $dataProvider = new CActiveDataProvider('WorkerInfoModel', array(
            'id' => '',
            'pagination' => array('pageSize' => 15),
            'criteria' => $criteria,
                )
        );
        $render_array['dataProvider'] = $dataProvider;
        $this->render('worker_info', $render_array);
    }

    public function actionWorker_info_create($worker_id) {
        $this->subnavtabs['worker_worker_info_create'] = array(
            'title' => '添加业务员记录信息', 'url' => $this->createUrl('worker_info_create')
        );
        $this->breadcrumbs[] = '添加业务员记录信息';
        $WorkerModel = WorkerModel::model()->find('id=:worker_id', array(':worker_id' => $worker_id));
        $this->checkEmpty($WorkerModel);
        $model = new WorkerInfoModel('login');
        $model->operated = "";
        $this->render('_worker_info_form', array('model' => $model, 'WorkerModel' => $WorkerModel));
    }

    public function actionWorker_info_update($id) {
        $this->subnavtabs['worker_worker_info_update'] = array(
            'title' => '编辑业务员记录信息', 'url' => $this->createUrl('worker_info_update')
        );
        $this->breadcrumbs[] = '编辑业务员记录信息';
        $model = WorkerInfoModel::model()->find('id=:id', array(':id' => $id));
        $this->checkEmpty($model);
        $WorkerModel = WorkerModel::model()->find('id=:worker_id', array(':worker_id' => $model->worker_id));
        $model->operated = date('Y-m-d', $model->operated);
        $this->render('_worker_info_form', array('model' => $model, 'WorkerModel' => $WorkerModel));
    }

    public function actionWorker_info_save() {
        $isEdit = isset($_POST['id']);
        $worker_id = $_POST['worker_id'];
        if ($isEdit) {
            $model = WorkerInfoModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $model->updated = time();
        } else {
            $model = new WorkerInfoModel();
            $model->admin_id = Yii::app()->user->id;
            $model->updated = time();
            $model->created = time();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['WorkerInfoModel'])) {
            $model->attributes = $_POST['WorkerInfoModel'];
            $model->operated = strtotime($model->operated);
            $model->worker_id = $worker_id;
            if ($model->save()) {
                $this->showSuccess('保存成功！', $this->createUrl('worker_info', array('worker_id' => $worker_id)));
            } else {
                $this->showError($model->getErrors());
            }
        }
    }

    public function actionWorker_info_delete() {
        $model = new WorkerInfoModel();
        if (isset($_GET['id'])) {
            $model->deleteByPk(numeric($_GET['id']));
            $this->showSuccess('删除成功！');
        } elseif (isset($_POST['selected']) && is_array($_POST['selected'])) {
            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $_POST['selected']);
            $model->deleteAll($criteria);
            $this->showSuccess('删除成功！');
        }
        $this->showSuccess('操作失败！');
    }

    //申诉
    public function actionWorker_appeal($id) {
        $this->subnavtabs['worker_worker_appeal'] = array(
            'title' => '申诉列表', 'url' => $this->createUrl('worker_appeal')
        );
        $this->breadcrumbs[] = '申诉列表';
        $criteria = new CDbCriteria();
        $criteria->addCondition('worker_info_id=' . $id, 'OR');
        $criteria->addCondition('pid=' . $id, 'OR');
        $model = WorkerAppealModel::model()->findAll($criteria);

        $replyModel = new WorkerAppealModel();

        $workerInfoModel = WorkerInfoModel::model()->with('worker')->findByPk($id);
        $this->render('worker_appeal', array(
            'model' => $model,
            'workerInfoModel' => $workerInfoModel,
            'replyModel' => $replyModel,
        ));
    }

    public function actionWorker_appeal_save() {
        $model = new WorkerAppealModel();
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['WorkerAppealModel'])) {
            $model->content = $_POST['WorkerAppealModel']['content'];
            $model->admin_id = Yii::app()->user->id;
            $model->admin_name = Yii::app()->user->name;
            $model->worker_id = $_POST['worker_id'];
            $model->worker_info_id = $_POST['worker_info_id'];
            $model->created = time();
            if ($model->save()) {
                WorkerInfoModel::model()->updateStatus($model->worker_info_id, 2);
                $this->showSuccess('保存成功！',$this->createUrl('worker_appeal',array('id'=>$model->worker_id)));
            } else {
                $this->showError($model->getErrors());
            }
        }
    }

}
