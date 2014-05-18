<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EnterpriseController
 *
 * @author lzh
 */
class EnterpriseController extends Controller {

    //put your code here
    public function init() {
        $this->subnavtabs = array(
            'enterprise_user' => array('title' => '用户列表', 'url' => $this->createUrl('/admin/user')),
            'enterprise_index' => array('title' => '企业列表', 'url' => $this->createUrl('index')),
            'enterprise_virtual_enterprise' => array('title' => '虚拟企业', 'url' => $this->createUrl('virtual_enterprise')),
        );
        parent::init();
    }

    public function actionIndex() {
        $this->breadcrumbs[] = '企业列表';
        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $criteria->addCondition('t.user_type > 0');
        $criteria->with = array('company');
        $dataProvider = new CActiveDataProvider('UserModel', array(
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
        $this->subnavtabs['enterprise_create'] = array(
            'title' => '添加企业', 'url' => $this->createUrl('create')
        );
        $this->breadcrumbs[] = '添加企业';
        $model = new UserModel();
        $model->status = 1;
        $this->render('_form', array('model' => $model));
    }

    public function actionUpdate($id = 0) {
        $this->subnavtabs['enterprise_update'] = array(
            'title' => '更新企业信息', 'url' => $this->createUrl('update')
        );
        $this->breadcrumbs[] = '编辑企业';
        $model = UserModel::model()->find('id=:id', array(':id' => $id));
        $this->checkEmpty($model);
        $model->password = "";
        $this->render('_form', array('model' => $model));
    }

    public function actionSave() {
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            if (isset($_POST['UserModel']['password']) && !empty($_POST['UserModel']['password'])) {
                $model->password = password($_POST['UserModel']['password']);
            }
        } else {
            $model = new UserModel();
            $model->password = password($_POST['UserModel']['password']);
            $model->created = time();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['UserModel'])) {
            $model->mobile = $_POST['UserModel']['mobile'];
            $model->email = $_POST['UserModel']['email'];
            $model->user_type = $_POST['UserModel']['user_type'];
            $model->password2 = $model->password;
            if ($model->save()) {
                if (numeric($model->user_type) == 1 || numeric($model->user_type) == 3) {
                    $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                    if (numeric($model->user_type) == 1) {
                        $message = '企业申请成功通过审核';
                    } elseif (numeric($model->user_type) == 3) {
                        $message = '企业申请未通过审核';
                    }
                    $mailer->Host = 'smtp.163.com';
                    $mailer->IsSMTP();
                    $mailer->SMTPAuth = true;
                    $mailer->From = Yii::app()->mailer->from;
                    $mailer->FromName = Yii::app()->mailer->fromname;
                    $mailer->Username = Yii::app()->mailer->username;
                    $mailer->Password = Yii::app()->mailer->password;
                    $mailer->AddAddress($model->email);

                    $mailer->CharSet = 'UTF-8';
                    $mailer->Subject = Yii::t('demo', '企业申请审核结果!');
                    $mailer->Body = $message;
                    $mailer->Send();
                }
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
    }

    public function actionDelete() {
        $model = new UserModel();
        if (isset($_GET['id'])) {
            $model->deleteByPk(numeric($_GET['id']));
            $criteria2 = new CDbCriteria();
            $criteria2->compare('user_id', $_GET['id']);
            UserCompanyModel::model()->find($criteria2)->delete();
            UserInfoModel::model()->find($criteria2)->delete();
            $this->showSuccess('删除成功！');
        } elseif (isset($_POST['selected']) && is_array($_POST['selected'])) {
            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $_POST['selected']);
            $model->deleteAll($criteria);
            $criteria2 = new CDbCriteria();
            $criteria->addInCondition('user_id', $_POST['selected']);
            UserCompanyModel::model()->deleteAll($criteria);
            UserInfoModel::model()->deleteAll($criteria);
            $this->showSuccess('删除成功！');
        }
        $this->showSuccess('操作失败！');
    }

    public function actionUser_info() {

        $user_id = numeric($_REQUEST['user_id']);
        $userModel = UserModel::model()->findByPk($user_id);
        if ($userModel->user_type > 0) {
            $this->actionCompany_info($user_id);
            exit;
        }
        $this->subnavtabs['enterprise_user_info'] = array(
            'title' => '企业信息', 'url' => $this->createUrl('user_info')
        );
        $this->breadcrumbs[] = '企业信息';
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $dataProvider = new CActiveDataProvider('UserInfoModel', array(
            'id' => '',
            'pagination' => array('pageSize' => 15),
            'criteria' => $criteria,
                )
        );
        $this->render('user_info', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCompany_info($user_id) {
        $this->subnavtabs['enterprise_user_info'] = array(
            'title' => '企业信息', 'url' => $this->createUrl('user_info')
        );
        $this->breadcrumbs[] = '企业信息';
        $criteria = new CDbCriteria();
        $criteria->compare('t.id', $user_id);
        $criteria->with = array('company');
        $dataProvider = new CActiveDataProvider('UserModel', array(
            'id' => '',
            'pagination' => array('pageSize' => 15),
            'criteria' => $criteria,
                )
        );
        $this->render('company_info', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionVirtual_enterprise() {
        $this->breadcrumbs[] = '虚拟企业';
        $this->subnavtabs['enterprise_virtual_enterprise'] = array(
            'title' => '虚拟企业', 'url' => $this->createUrl('virtual_enterprise')
        );
        $criteria = new CDbCriteria();
        $criteria->order = "id desc";
        $dataProvider = new CActiveDataProvider('VirtualEnterpriseModel', array(
            'id' => '',
            'pagination' => array('pageSize' => 15),
            'criteria' => $criteria,
                )
        );
        $this->render('virtual_enterprise', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionVirtual_enterprise_create($cate_id = 0) {
        $this->breadcrumbs[] = '添加虚拟企业';
        $this->subnavtabs['enterprise_virtual_enterprise_create'] = array(
            'title' => '添加虚拟企业', 'url' => $this->createUrl('virtual_enterprise_create')
        );
        $model = new VirtualEnterpriseModel();
        $this->render('virtual_enterprise_form', array('model' => $model));
    }

    public function actionVirtual_enterprise_update($id = 0) {
        $this->breadcrumbs[] = '编辑虚拟企业';
        $this->subnavtabs['enterprise_virtual_enterprise_update'] = array(
            'title' => '编辑虚拟企业', 'url' => $this->createUrl('virtual_enterprise_update')
        );
        $id = numeric($id);
        $model = VirtualEnterpriseModel::model()->find('id=:id', array(':id' => $id));
        $this->checkEmpty($model);
        $this->render('virtual_enterprise_form', array('model' => $model));
    }

    public function actionVirtual_enterprise_save() {
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = VirtualEnterpriseModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
        } else {
            $model = new VirtualEnterpriseModel();
            $model->created = time();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['VirtualEnterpriseModel'])) {
            $model->attributes = $_POST['VirtualEnterpriseModel'];
            if ($model->save()) {
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->showError('操作失败！');
    }

    public function actionVirtual_enterprise_delete() {
        $model = new VirtualEnterpriseModel();
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

    public function actionCompany_info_update($id) {
        $this->subnavtabs['enterprise_company_info_update'] = array(
            'title' => '编辑虚拟企业', 'url' => $this->createUrl('company_info_update')
        );
        $this->breadcrumbs[] = '编辑公司信息';
        $id = numeric($id);
        $model = UserCompanyModel::model()->find('id=:id', array(':id' => $id));
        $this->checkEmpty($model);
        $this->render('company_info_update', array('model' => $model));
    }

    public function actionCompany_info_save() {
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserCompanyModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
        } else {
            $model = new UserCompanyModel();
            $model->created = time();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['UserCompanyModel'])) {
            $model->attributes = $_POST['UserCompanyModel'];
            if ($model->save()) {
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->showError('操作失败！');
    }

}
