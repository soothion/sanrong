<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Groupon_goods
 *
 * @author liuzihui
 */
class SinglepageController extends Controller {

    public function actionIndex() {
        $this->breadcrumbs[] = '单页管理';
        $criteria = new CDbCriteria();
        $criteria->order = "id desc";
        $dataProvider = new CActiveDataProvider('SinglepageModel', array(
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
        $this->breadcrumbs[] = '添加单页';
        $model = new SinglepageModel();
        $this->render('_form', array('model' => $model));
    }

    public function actionUpdate($id = 0) {
        $this->breadcrumbs[] = '编辑单页';
        $id = numeric($id);
        $model = SinglepageModel::model()->find('id=:id', array(':id' => $id));
        $this->checkEmpty($model);
        $this->render('_form', array('model' => $model));
    }

    public function actionSave() {
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = SinglepageModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
        } else {
            $model = new SinglepageModel();
            $model->created = time();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['SinglepageModel'])) {
            $model->attributes = $_POST['SinglepageModel'];
            if ($model->save()) {
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->showError('操作失败！');
    }

    public function actionDelete() {
        $model = new SinglepageModel();
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
