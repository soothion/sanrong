<?php

class AdminController extends Controller {

    public function init() {
        $this->layout = '//layouts/column2';
        if(!$this->checkAccess(3)){
            $this->showError('没有操作权限！','/admin');
        }
        parent::init();
        $this->subnavtabs = array(
            'admin_index' => array('title' => '管理员列表', 'url' => $this->createUrl('index')),
            'admin_role_list' => array('title' => '角色列表', 'url' => $this->createUrl('role_list')),
            'admin_create' => array('title' => '添加管理员', 'url' => $this->createUrl('create')),
        );
    }

    public function actionIndex() {
        $this->breadcrumbs[] = '管理员列表';
        $criteria = new CDbCriteria();
        $criteria -> order = 't.id DESC';
        $criteria->with = array(
            'role',
        );
        $dataProvider = new CActiveDataProvider('AdminModel', array(
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
        $this->breadcrumbs[] = '添加管理员';
        $model = new AdminModel('login');
        $this->render('_form', array('model' => $model));
    }

    public function actionUpdate($id = 0) {
        $this->breadcrumbs[] = '编辑管理员';
        $model = AdminModel::model()->find('id=:id', array(':id' => $id));
        $this->checkEmpty($model);
        $model->password = "";
        $this->render('_form', array('model' => $model));
    }

    public function actionsave() {
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = AdminModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            if (empty($_POST['AdminModel']['password'])) {
                $_POST['AdminModel']['password'] = $model->password;
            }
        } else {
            $model = new AdminModel();
            if(AdminModel::model()->find('username=:username',array(':username' => $_POST['AdminModel']['username']))){
                $this->showError('用户名已存在');
            }
            $_POST['AdminModel']['password'] = password($_POST['AdminModel']['password']);
            $model->created = time();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['AdminModel'])) {
            $model->attributes = $_POST['AdminModel'];
            if ($model->save()) {
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
    }

    public function actionDelete() {
        $model = new AdminModel();
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

    public function actionRole_list() {
        $this->breadcrumbs[] = '角色列表';
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $dataProvider = new CActiveDataProvider('AdminRoleModel', array(
            'id' => '',
            'pagination' => array('pageSize' => 15),
            'criteria' => $criteria,
                )
        );
        $this->render('role_list', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionRole_create() {
        $this->breadcrumbs[] = '添加角色';
        $model = new AdminRoleModel();
        $this->render('_role_form', array('model' => $model));
    }

    public function actionRole_update($id = 0) {
        $this->breadcrumbs[] = '编辑角色';
        $model = AdminRoleModel::model()->find('id=:id', array(':id' => $id));
        $model->access = explode(',', $model->access);
        $this->checkEmpty($model);
        $this->render('_role_form', array('model' => $model));
    }

    public function actionRole_save() {
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = AdminRoleModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
        } else {
            $model = new AdminRoleModel();
            $model->created = time();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['AdminRoleModel'])) {
            $model->attributes = $_POST['AdminRoleModel'];
            $model->access = implode(',', $_POST['AdminRoleModel']['access']);
            if ($model->save()) {
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
    }

    public function actionRole_delete() {
        $model = new AdminRoleModel();
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

    /**
     * 管理员密码修改 
     */
    public function actionMy() {
        $this->subnavtabs['manager_my'] = array('title' => '修改密码', 'url' => $this->createUrl('my'));
        $this->breadcrumbs[] = '修改密码';
        $model = AdminModel::model()->find('id=:id', array(':id' => Yii::app()->user->getId()));
        $this->checkEmpty($model);
        $model->password = "";
        $this->render('my', array('model' => $model));
    }

    public function actionMy_save() {
        $model = new AdminModel('modify_pw');
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        $data = AdminModel::model()->find('id=:id', array(':id' => Yii::app()->user->getId()));
        if (password($_POST['AdminModel']['oldpassword']) != $data->password) {
            $this->showError('旧密码错误');
        }
        $data->password = password($_POST['AdminModel']['password']);
        if ($data->save()) {
            $this->showSuccess('保存成功！');
        } else {
            $this->showError('保存失败！');
        }
    }

}
