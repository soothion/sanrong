<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Groupon_area
 *
 * @author liuzihui
 */
class News_categoryController extends Controller{
    public function actionIndex(){
        $this->breadcrumbs[] = '分类管理';
        $criteria = new CDbCriteria();
        $criteria->order = "id desc";
        $model = new NewsCategoryModel();
        $model = $model->findAll($criteria);
        $model = object2array($model);
        $model = NewsCategoryModel::getCategory($model);
        $this->render('index', array('model' => $model));
    }
    public function actionCreate() {
        $this->breadcrumbs[] = '添加分类';
        $model = new NewsCategoryModel();
        $pid = isset($_GET['pid']) && $_GET['pid'] > 0 ? $_GET['pid'] : 0;
        $model->pid_text = NewsCategoryModel::model()->get_pid_text($pid);
        $model->pid = $pid;
        $this->render('_form', array('model' => $model));
    }
    public function actionUpdate($id = 0) {
        $this->breadcrumbs[] = '编辑分类';
        $model = NewsCategoryModel::model()->find('id=:id', array(':id' => $id));
        $model->pid_text = NewsCategoryModel::model()->get_pid_text($model->pid);
        $this->checkEmpty($model);
        $this->render('_form', array('model' => $model));
    }

    public function actionSave() {
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = NewsCategoryModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
        } else {
            $model = new NewsCategoryModel();
            $model->created = time();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['NewsCategoryModel'])) {
            $model->attributes = $_POST['NewsCategoryModel'];
            if ($model->save()) {
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->showError('操作失败！');
    }

    public function actionDelete() {
        $model = new NewsCategoryModel();
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

    public function actionUpdate_sort() {
        if (isset($_POST['sorting'])) {
            foreach($_POST['sorting'] as $k=>$v){
                $model = CategoryModel::model()->find("id=:id",array(':id'=>$k));
                $model->sorting = $v;
                $model->save($model);
            }
        }
        $this->redirect("/mp/category/list");
    }
}
