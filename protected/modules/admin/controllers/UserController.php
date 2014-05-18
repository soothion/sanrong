<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author liuzihui
 */
class UserController extends Controller {

    public function init() {
        $this->layout = '//layouts/column2';
        if (!$this->checkAccess(3)) {
            $this->showError('没有操作权限！', '/admin');
        }
        $this->subnavtabs = array(
            'user_index' => array('title' => '用户列表', 'url' => $this->createUrl('index')),
            'user_user_info' => array('title' => '企业信息', 'url' => $this->createUrl('/admin/enterprise')),
        );
        parent::init();
    }

    //put your code here
    public function actionIndex() {
        $this->breadcrumbs[] = '用户列表';
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->compare('user_type', 0);
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
        $this->subnavtabs['user_create'] = array(
            'title' => '添加用户', 'url' => $this->createUrl('create')
        );
        $this->breadcrumbs[] = '添加用户';
        $model = new UserModel();
        $model->status = 1;
        $this->render('_form', array('model' => $model));
    }

    public function actionUpdate($id = 0) {
        $this->subnavtabs['user_update'] = array(
            'title' => '更新用户/企业信息', 'url' => $this->createUrl('update')
        );
        $this->breadcrumbs[] = '编辑用户/企业';
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
            $this->showSuccess('删除成功！');
        } elseif (isset($_POST['selected']) && is_array($_POST['selected'])) {
            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $_POST['selected']);
            $model->deleteAll($criteria);
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
        $this->subnavtabs['user_user_info'] = array(
            'title' => '用户信息', 'url' => $this->createUrl('user_info')
        );
        $this->breadcrumbs[] = '用户信息';
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
        $this->subnavtabs['user_user_info'] = array(
            'title' => '企业信息', 'url' => $this->createUrl('user_info')
        );
        $this->breadcrumbs[] = '企业信息';
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $dataProvider = new CActiveDataProvider('UserCompanyModel', array(
            'id' => '',
            'pagination' => array('pageSize' => 15),
            'criteria' => $criteria,
                )
        );
        $this->render('company_info', array(
            'dataProvider' => $dataProvider,
        ));
    }

}
