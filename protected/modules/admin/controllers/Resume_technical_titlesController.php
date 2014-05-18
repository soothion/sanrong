<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 技术职称控制器
 */
Class Resume_technical_titlesController extends Controller{
    public function init() {
        $this->layout = '//layouts/column2';
        if(!$this->checkAccess(1)){
            $this->showError('没有操作权限！','/admin');
        }
        parent::init();
    }
    public function actionIndex(){
        $this->breadcrumbs[] = '技术职称管理';
        $criteria = new CDbCriteria();
        $criteria->order = "id desc";
        $dataProvider = new CActiveDataProvider('ResumeTechnicalTitlesModel', array(
            'id' => '',
            'pagination' => array('pageSize' => 15),
            'criteria' => $criteria,
                )
        );
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }
    public function actionCreate($cate_id = 0) {
        $this->breadcrumbs[] = '添加技术职称';
        $model = new ResumeTechnicalTitlesModel();
        $this->render('_form', array('model' => $model));
    }

    public function actionUpdate($id = 0) {
        $this->breadcrumbs[] = '编辑技术职称';
        $id = numeric($id);
        $model = ResumeTechnicalTitlesModel::model()->find('id=:id', array(':id' => $id));
        $this->checkEmpty($model);
        $this->render('_form', array('model' => $model));
    }
    public function actionSave() {
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = ResumeTechnicalTitlesModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
        } else {
            $model = new ResumeTechnicalTitlesModel();
            $model->created = time();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['ResumeTechnicalTitlesModel'])) {
            $model->attributes = $_POST['ResumeTechnicalTitlesModel'];
            if ($model->save()) {
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->showError('操作失败！');
    }

    public function actionDelete() {
        $model = new ResumeTechnicalTitlesModel();
        $criteria = new CDbCriteria();
        if (isset($_GET['id'])) {
            $model->deleteByPk(numeric($_GET['id']), $criteria);
            $this->showSuccess('删除成功！');
        } elseif (isset($_POST['selected']) && is_array($_POST['selected'])) {
            $criteria->addInCondition('id', $_POST['selected']);
            $model->deleteAll($criteria);
            $this->showSuccess('删除成功！');
        }
        $this->showError('操作失败！');
    }
}
