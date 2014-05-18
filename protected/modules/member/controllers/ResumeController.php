<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResumeController
 *
 * @author liuzihui
 */
class ResumeController extends Controller {

    //put your code here
    /**
     * 个人资料
     */
    public function init() {
        $this->layout = '//layouts/column2';
        if (Yii::app()->user->getState('user_type') == 2) {
            $this->showError('您的企业身份还在审核中...', $this->createUrl('/member'));
        }
        if (Yii::app()->user->getState('user_type') == 3) {
            $this->showError('您的企业身份审核未通过...', $this->createUrl('/member'));
        }
    }

    public function actionIndex() {
        $user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $model = UserResumeModel::model()->find($criteria);
        if (!$model) {
            $model = new UserResumeModel();
            $model->birthday = strtotime('1989-01-01');
            $model->graduate_time = "";
        }
        $model->birthday = numeric($model->birthday) == 0 ? "1989-01-01" : date('Y-m-d', $model->birthday);
        $model->graduate_time = numeric($model->graduate_time) == 0 ? "" : date('Y-m-d', $model->graduate_time);
        $render_arr['model'] = $model;
        //审核情况
        $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
        if ($resumeLogModel) {
            $content = json_decode($resumeLogModel->content, TRUE);
            if (isset($content['user_resume'][$model->id]['username'])) {
                $log_first = $content['user_resume'][$model->id]['username'];
                $log_res = array(
                    'status' => ResumeLogModel::model()->get_log_status($log_first['status']),
                    'info' => $log_first['reason'],
                );
                $render_arr['log_res'] = $log_res;
            }
        }
        $this->render('index', $render_arr);
    }

    public function actionIndex_save() {
        $user_id = Yii::app()->user->id;
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserResumeModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
            if ($model->user_id != $user_id) {
                $this->showError('操作失败！');
            }
        } else {
            $model = new UserResumeModel();
            $model->created = time();
            $model->user_id = $user_id;
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['delete_one_size_photo'])) {
            $model->one_size_photo = '';
        }
        if (isset($_FILES['one_size_photo']['tmp_name']) && !empty($_FILES['one_size_photo']['tmp_name'])) {
            $Uploader = new Uploader();
            $Uploader->useImage();
            if ($Uploader->upload('one_size_photo')) {
                $model->one_size_photo = $Uploader->file;
            }
        }
        if (isset($_POST['UserResumeModel'])) {
            if (isset($_POST['UserResumeModel']['birthday']) && !empty($_POST['UserResumeModel']['birthday'])) {
                $_POST['UserResumeModel']['birthday'] = strtotime($_POST['UserResumeModel']['birthday']);
                $model->age = numeric(date('Y', time())) - numeric(date('Y', $_POST['UserResumeModel']['birthday']));
            }
            if (isset($_POST['UserResumeModel']['graduate_time']) && !empty($_POST['UserResumeModel']['graduate_time'])) {
                $_POST['UserResumeModel']['graduate_time'] = strtotime($_POST['UserResumeModel']['graduate_time']);
            }
            $model->attributes = $_POST['UserResumeModel'];
            $model->updated = time();
            if ($model->save()) {
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    if (isset($content['user_resume'][$model->id])) {
                        foreach ($_POST['UserResumeModel'] as $field => $value) {
                            if (array_key_exists($field, $content['user_resume'][$model->id])) {
                                if ($value != $content['user_resume'][$model->id][$field]['value']) {
                                    $content['user_resume'][$model->id][$field] = array(
                                        'field' => $field,
                                        'value' => $value,
                                        'status' => 0,
                                        'reason' => '',
                                        'color' => 'red',
                                        'updated' => time(),
                                    );
                                }
                            } else {
                                $content['user_resume'][$model->id][$field] = array(
                                    'field' => $field,
                                    'value' => $value,
                                    'status' => 0,
                                    'reason' => '',
                                    'color' => 'red',
                                    'updated' => time(),
                                );
                            }
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    } else {
                        foreach ($model->attributes as $field => $value) {
                            if (array_key_exists($field, $_POST['UserResumeModel'])) {
                                $content['user_resume'][$model->id][$field] = array(
                                    'field' => $field,
                                    'value' => $value,
                                    'status' => 0,
                                    'reason' => '',
                                    'color' => 'red',
                                    'updated' => time(),
                                );
                            }
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    }
                } else {
                    $resumeLogModel = new ResumeLogModel();
                    $resumeLogModel->user_id = $user_id;
                    $resumeLogModel->resume_id = $model->id;
                    $resumeLogModel->updated = time();
                    $resumeLogModel->created = time();
                    $content = array();
                    foreach ($model->attributes as $field => $value) {
                        if (array_key_exists($field, $_POST['UserResumeModel'])) {
                            $content['user_resume'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 0,
                                'reason' => '',
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                    }
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                }
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->render('index', array(
            'model' => $model,
            'userModel' => $userModel,
        ));
    }

    /*
     * 联系方式 
     */

    public function actionContact() {
        $user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $criteria->select = "id,user_id,phone,qq,zipcode,contact_address,blog";
        $model = UserResumeModel::model()->find($criteria);
        $userModel = UserModel::model()->find('id=:user_id', array(':user_id' => $user_id));
        if (!$model) {
            $model = new UserResumeModel();
        }

        $render_arr['model'] = $model;
        $render_arr['userModel'] = $userModel;
        //审核情况
        $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
        if ($resumeLogModel) {
            $content = json_decode($resumeLogModel->content, TRUE);
            if (isset($content['user_resume'][$model->id]['phone'])) {
                $log_first = $content['user_resume'][$model->id]['phone'];
                $log_res = array(
                    'status' => ResumeLogModel::model()->get_log_status($log_first['status']),
                    'info' => $log_first['reason'],
                );
                $render_arr['log_res'] = $log_res;
            }
        }

        $this->render('contact', $render_arr);
    }

    public function actionContact_save() {
        $user_id = Yii::app()->user->id;
        $userModel = UserModel::model()->find('id=:user_id', array(':user_id' => $user_id));
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserResumeModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
            if ($model->user_id != $user_id) {
                $this->showError('操作失败！');
            }
        } else {
            $model = new UserResumeModel();
            $model->created = time();
            $model->user_id = $user_id;
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['UserResumeModel'])) {
            $model->attributes = $_POST['UserResumeModel'];
            $model->updated = time();
            if ($model->save()) {
                $userModel->mobile = $_POST['UserModel']['mobile'];
                $userModel->save();
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
                $data = $_POST['UserResumeModel'];
                $data['mobile'] = $_POST['UserModel']['mobile'];
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    if (isset($content['user_resume'][$model->id])) {
                        foreach ($data as $field => $value) {
                            if (array_key_exists($field, $content['user_resume'][$model->id])) {
                                if ($value != $content['user_resume'][$model->id][$field]['value']) {
                                    $content['user_resume'][$model->id][$field] = array(
                                        'field' => $field,
                                        'value' => $value,
                                        'status' => 0,
                                        'reason' => '',
                                        'color' => 'red',
                                        'updated' => time(),
                                    );
                                }
                            } else {
                                $content['user_resume'][$model->id][$field] = array(
                                    'field' => $field,
                                    'value' => $value,
                                    'status' => 0,
                                    'reason' => '',
                                    'color' => 'red',
                                    'updated' => time(),
                                );
                            }
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_resume'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 0,
                                'reason' => '',
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    }
                } else {
                    $resumeLogModel = new ResumeLogModel();
                    $resumeLogModel->user_id = $user_id;
                    $resumeLogModel->resume_id = $model->id;
                    $resumeLogModel->updated = time();
                    $resumeLogModel->created = time();
                    $content = array();
                    foreach ($data as $field => $value) {
                        $content['user_resume'][$model->id][$field] = array(
                            'field' => $field,
                            'value' => $value,
                            'status' => 0,
                            'reason' => '',
                            'color' => 'red',
                            'updated' => time(),
                        );
                    }
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                }
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->render('contact', array(
            'model' => $model,
            'userModel' => $userModel,
        ));
    }

    /**
     * 个人描述
     */
    public function actionDescription() {
        $user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $criteria->select = "id,user_id,description";
        $model = UserResumeModel::model()->find($criteria);
        if (!$model) {
            $model = new UserResumeModel();
        }

        //审核情况
        $render_arr['model'] = $model;
        $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
        if ($resumeLogModel) {
            $content = json_decode($resumeLogModel->content, TRUE);
            if (isset($content['user_resume'][$model->id]['description'])) {
                $log_first = $content['user_resume'][$model->id]['description'];
                $log_res = array(
                    'status' => ResumeLogModel::model()->get_log_status($log_first['status']),
                    'info' => $log_first['reason'],
                );

                $render_arr['log_res'] = $log_res;
            }
        }
        $this->render('description', $render_arr);
    }

    public function actionDescription_save() {
        $user_id = Yii::app()->user->id;
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserResumeModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
            if ($model->user_id != $user_id) {
                $this->showError('操作失败！');
            }
        } else {
            $model = new UserResumeModel();
            $model->created = time();
            $model->user_id = $user_id;
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['UserResumeModel'])) {
            $_POST['UserResumeModel']['description'] = str_replace(chr(13), '<br/>', $_POST['UserResumeModel']['description']);
            $_POST['UserResumeModel']['description'] = str_replace(chr(32), '&nbsp;&nbsp;', $_POST['UserResumeModel']['description']);
            $model->attributes = $_POST['UserResumeModel'];
            $model->updated = time();
            if ($model->save()) {
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
                $data = $_POST['UserResumeModel'];
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    if (isset($content['user_resume'][$model->id])) {
                        foreach ($data as $field => $value) {
                            if (array_key_exists($field, $content['user_resume'][$model->id])) {
                                if ($value != $content['user_resume'][$model->id][$field]['value']) {
                                    $content['user_resume'][$model->id][$field] = array(
                                        'field' => $field,
                                        'value' => $value,
                                        'status' => 0,
                                        'reason' => '',
                                        'color' => 'red',
                                        'updated' => time(),
                                    );
                                }
                            } else {
                                $content['user_resume'][$model->id][$field] = array(
                                    'field' => $field,
                                    'value' => $value,
                                    'status' => 0,
                                    'reason' => '',
                                    'color' => 'red',
                                    'updated' => time(),
                                );
                            }
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_resume'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 0,
                                'reason' => '',
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    }
                } else {
                    $resumeLogModel = new ResumeLogModel();
                    $resumeLogModel->user_id = $user_id;
                    $resumeLogModel->resume_id = $model->id;
                    $resumeLogModel->updated = time();
                    $resumeLogModel->created = time();
                    $content = array();
                    foreach ($data as $field => $value) {
                        $content['user_resume'][$model->id][$field] = array(
                            'field' => $field,
                            'value' => $value,
                            'status' => 0,
                            'reason' => '',
                            'color' => 'red',
                            'updated' => time(),
                        );
                    }
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                }
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->render('description', array(
            'model' => $model,
        ));
    }

    //求职意向
//    public function actionPurpose() {
//        $user_id = Yii::app()->user->id;
//        $criteria = new CDbCriteria();
//        $criteria->compare('user_id', $user_id);
//        $criteria->select = "id,user_id,apply_job_type,wish_job_place_id,wish_treatment,resume_position_id,apply_job_status,other_weal";
//        $model = UserResumeModel::model()->find($criteria);
//        if (!$model) {
//            $model = new UserResumeModel();
//        }
//        $this->render('purpose', array(
//            'model' => $model,
//        ));
//    }
    public function actionPurpose() {
        $user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $All_model = UserPurposeModel::model()->findAll($criteria);
        $model = new UserPurposeModel();

        //审核情况
        $render_arr['model'] = $model;
        $render_arr['All_model'] = $All_model;
        $this->render('purpose', $render_arr);
    }

    public function actionPurpose_update() {
        $user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $All_model = UserPurposeModel::model()->findAll($criteria);
        $id = numeric($_REQUEST['id']);
        $model = UserPurposeModel::model()->findByPk($id);
        $model->other_weal = explode(',', $model->other_weal);
        $model->part_time_type = explode(',', $model->part_time_type);

        //审核情况
        $render_arr['model'] = $model;
        $render_arr['All_model'] = $All_model;
        $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
        if ($resumeLogModel) {
            $content = json_decode($resumeLogModel->content, TRUE);
            if (isset($content['user_purpose'][$model->id]['apply_job_type_id'])) {
                $log_first = $content['user_purpose'][$model->id]['apply_job_type_id'];
                $log_res = array(
                    'status' => ResumeLogModel::model()->get_log_status($log_first['status']),
                    'info' => $log_first['reason'],
                );
                $render_arr['log_res'] = $log_res;
            }
        }
        $this->render('purpose', $render_arr);
    }

    public function actionPurpose_save() {
        $user_id = Yii::app()->user->id;
        $isEdit = isset($_POST['id']);
        if (!isset($_POST['UserPurposeModel']['apply_job_type_id'])) {
            $this->showError('请选择求职类型');
        }
        $resumeModel = UserResumeModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
        if (!$resumeModel) {

            $resumeModel = new UserResumeModel();
            $resumeModel->user_id = $user_id;
            $resumeModel->save();
        }
        if ($isEdit) {
            $model = UserPurposeModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
            $otherModel = UserPurposeModel::model()->find('id<>:id and user_id=:user_id and apply_job_type_id=:apply_job_type_id', array(':id' => numeric($_POST['id']), ':user_id' => $user_id, ':apply_job_type_id' => $_POST['UserPurposeModel']['apply_job_type_id']));
            if ($otherModel) {
                $temp = "已提交过" . UserPurposeModel::model()->apply_job_type_arr($_POST['UserPurposeModel']['apply_job_type_id']) . '类型！';
                $this->showError($temp);
            }
        } else {
            $model = new UserPurposeModel();
            $otherModel = UserPurposeModel::model()->find('user_id=:user_id and apply_job_type_id=:apply_job_type_id', array(':user_id' => $user_id, ':apply_job_type_id' => $_POST['UserPurposeModel']['apply_job_type_id']));
            if ($otherModel) {
                $temp = "已提交过" . UserPurposeModel::model()->apply_job_type_arr($_POST['UserPurposeModel']['apply_job_type_id']) . '类型！';
                $this->showError($temp);
            }
            $model->created = time();
            $model->user_id = $user_id;
            $model->resume_id = $resumeModel->id;
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['UserPurposeModel'])) {
            $post = $_POST['UserPurposeModel'];
            $model->apply_job_type_id = isset($post['apply_job_type_id']) ? $post['apply_job_type_id'] : "";
            $model->wish_job_place_id = isset($post['wish_job_place_id']) ? $post['wish_job_place_id'] : "";
            $model->wish_treatment_id = isset($post['wish_treatment_id']) ? $post['wish_treatment_id'] : "";
            $model->wish_part_time_treatment_id = isset($post['wish_part_time_treatment_id']) ? $post['wish_part_time_treatment_id'] : "";

            $model->resume_position_id = isset($post['resume_position_id']) ? $post['resume_position_id'] : "";
            $model->apply_job_status = isset($post['apply_job_status']) ? $post['apply_job_status'] : "";
            if (isset($post['part_time_type']) && !empty($post['part_time_type'])) {
                $model->part_time_type = implode(',', $post['part_time_type']);
            }
            if (isset($post['other_weal']) && !empty($post['other_weal'])) {
                $model->other_weal = implode(',', $post['other_weal']);
            }
            if ($model->save()) {
                $resumeModel->updated = time();
                $resumeModel->save();
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
                $data = $_POST['UserPurposeModel'];
                $data['part_time_type'] = $model->part_time_type;
                $data['other_weal'] = $model->other_weal;
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    if (isset($content['user_purpose'][0])) {
                        unset($content['user_purpose'][0]);
                    }
                    if (isset($content['user_purpose'][$model->id])) {
                        foreach ($data as $field => $value) {
                            if (array_key_exists($field, $content['user_purpose'][$model->id])) {
                                if ($value != $content['user_purpose'][$model->id][$field]['value']) {
                                    $content['user_purpose'][$model->id][$field] = array(
                                        'field' => $field,
                                        'value' => $value,
                                        'status' => 0,
                                        'reason' => '',
                                        'color' => 'red',
                                        'updated' => time(),
                                    );
                                }
                            } else {
                                $content['user_purpose'][$model->id][$field] = array(
                                    'field' => $field,
                                    'value' => $value,
                                    'status' => 0,
                                    'reason' => '',
                                    'color' => 'red',
                                    'updated' => time(),
                                );
                            }
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_purpose'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 0,
                                'reason' => '',
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    }
                } else {
                    $resumeLogModel = new ResumeLogModel();
                    $resumeLogModel->user_id = $user_id;
                    $resumeLogModel->resume_id = $resumeModel->id;
                    $resumeLogModel->updated = time();
                    $resumeLogModel->created = time();
                    $content = array();
                    foreach ($data as $field => $value) {
                        $content['user_purpose'][$model->id][$field] = array(
                            'field' => $field,
                            'value' => $value,
                            'status' => 0,
                            'reason' => '',
                            'color' => 'red',
                            'updated' => time(),
                        );
                    }
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                }
                $this->showSuccess('保存成功！', $this->createUrl('purpose'));
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->render('purpose', array(
            'model' => $model,
        ));
    }

//    public function actionPurpose_save() {
//        $user_id = Yii::app()->user->id;
//        $isEdit = isset($_POST['id']);
//        if ($isEdit) {
//            $model = UserResumeModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
//            $this->checkEmpty($model);
//            if ($model->user_id != $user_id) {
//                $this->showError('操作失败！');
//            }
//        } else {
//            $model = new UserResumeModel();
//            $model->created = time();
//            $model->user_id = $user_id;
//        }
//        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
//            echo CActiveForm::validate($model);
//            Yii::app()->end();
//        }
//        if (isset($_POST['UserResumeModel'])) {
//            $model->attributes = $_POST['UserResumeModel'];
//            $model->updated = time();
//            if ($model->save()) {
//                $this->showSuccess('保存成功！');
//            } else {
//                $this->showError($model->getErrors());
//            }
//        }
//        $this->render('purpose', array(
//            'model' => $model,
//        ));
//    }
    //课外经历
    public function actionExtracurricular() {
        $user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $criteria->select = "id,user_id,extracurricular";
        $model = UserResumeModel::model()->find($criteria);
        if (!$model) {
            $model = new UserResumeModel();
        }
        //审核情况
        $render_arr['model'] = $model;
        $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
        if ($resumeLogModel) {
            $content = json_decode($resumeLogModel->content, TRUE);
            if (isset($content['user_resume'][$model->id]['extracurricular'])) {

                $log_first = $content['user_resume'][$model->id]['extracurricular'];
                $log_res = array(
                    'status' => ResumeLogModel::model()->get_log_status($log_first['status']),
                    'info' => $log_first['reason'],
                );
                $render_arr['log_res'] = $log_res;
            }
        }
        $this->render('extracurricular', $render_arr);
    }

    public function actionExtracurricular_save() {
        $user_id = Yii::app()->user->id;
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserResumeModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
            if ($model->user_id != $user_id) {
                $this->showError('操作失败！');
            }
        } else {
            $model = new UserResumeModel();
            $model->created = time();
            $model->user_id = $user_id;
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['UserResumeModel'])) {
            $_POST['UserResumeModel']['extracurricular'] = str_replace(chr(13), '<br/>', $_POST['UserResumeModel']['extracurricular']);
            $_POST['UserResumeModel']['extracurricular'] = str_replace(chr(32), '&nbsp;&nbsp;', $_POST['UserResumeModel']['extracurricular']);
            $model->attributes = $_POST['UserResumeModel'];
            $model->updated = time();
            if ($model->save()) {
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
                $data = $_POST['UserResumeModel'];
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    if (isset($content['user_resume'][$model->id])) {
                        foreach ($data as $field => $value) {
                            if (array_key_exists($field, $content['user_resume'][$model->id])) {
                                if ($value != $content['user_resume'][$model->id][$field]['value']) {
                                    $content['user_resume'][$model->id][$field] = array(
                                        'field' => $field,
                                        'value' => $value,
                                        'status' => 0,
                                        'reason' => '',
                                        'color' => 'red',
                                        'updated' => time(),
                                    );
                                }
                            } else {
                                $content['user_resume'][$model->id][$field] = array(
                                    'field' => $field,
                                    'value' => $value,
                                    'status' => 0,
                                    'reason' => '',
                                    'color' => 'red',
                                    'updated' => time(),
                                );
                            }
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_resume'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 0,
                                'reason' => '',
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    }
                } else {
                    $resumeLogModel = new ResumeLogModel();
                    $resumeLogModel->user_id = $user_id;
                    $resumeLogModel->resume_id = $model->id;
                    $resumeLogModel->updated = time();
                    $resumeLogModel->created = time();
                    $content = array();
                    foreach ($data as $field => $value) {
                        $content['user_resume'][$model->id][$field] = array(
                            'field' => $field,
                            'value' => $value,
                            'status' => 0,
                            'reason' => '',
                            'color' => 'red',
                            'updated' => time(),
                        );
                    }
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                }
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->render('extracurricular', array(
            'model' => $model,
        ));
    }

    /**
     * 教育背景
     */
    public function actionEducation() {
        $user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $All_model = UserEducationModel::model()->findAll($criteria);
        $model = new UserEducationModel();
        $model->from_time = "";
        $model->to_time = "";
        $this->render('education', array(
            'model' => $model,
            'All_model' => $All_model,
        ));
    }

    public function actionEducation_update() {
        $user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $All_model = UserEducationModel::model()->findAll($criteria);
        $id = numeric($_REQUEST['id']);
        $model = UserEducationModel::model()->findByPk($id);
        $model->from_time = date('Y-m-d', $model->from_time);
        $model->to_time = date('Y-m-d', $model->to_time);

        //审核情况
        $render_arr['model'] = $model;
        $render_arr['All_model'] = $All_model;
        $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
        if ($resumeLogModel) {
            $content = json_decode($resumeLogModel->content, TRUE);
            if (isset($content['user_education'][$model->id]['school'])) {
                $log_first = $content['user_education'][$model->id]['school'];
                $log_res = array(
                    'status' => ResumeLogModel::model()->get_log_status($log_first['status']),
                    'info' => $log_first['reason'],
                );
                $render_arr['log_res'] = $log_res;
            }
        }
        $this->render('education', $render_arr);
    }

    public function actionEducation_save() {
        $user_id = Yii::app()->user->id;
        $isEdit = isset($_POST['id']);
        $resumeModel = UserResumeModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
        if (!$resumeModel) {
            $resumeModel = new UserResumeModel();
            $resumeModel->user_id = $user_id;
            $resumeModel->save();
        }
        if ($isEdit) {
            $model = UserEducationModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
        } else {
            $model = new UserEducationModel();
            $model->created = time();
            $model->user_id = $user_id;
            //$userArr = Yii::app()->db->createCommand()->select('id')->from('user_resume')->where('user_id=:user_id',array(':user_id'=>$user_id))->queryRow();
            //$model->resume_id = $userArr['id'];
            $model->resume_id = $resumeModel->id;
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_FILES['certificate']['tmp_name']) && !empty($_FILES['certificate']['tmp_name'])) {
            $Uploader = new Uploader();
            $Uploader->useFile();
            if ($Uploader->upload('certificate')) {
                $model->certificate = $Uploader->file;
                //$_POST['UserEducationModel']['certificate'] = $Uploader->file;
            } else {
                $this->showError('上传失败！');
            }
        }
        if (isset($_POST['UserEducationModel'])) {
            if (!empty($_POST['UserEducationModel']['from_time'])) {
                $_POST['UserEducationModel']['from_time'] = strtotime($_POST['UserEducationModel']['from_time']);
            }
            if (!empty($_POST['UserEducationModel']['to_time'])) {
                $_POST['UserEducationModel']['to_time'] = strtotime($_POST['UserEducationModel']['to_time']);
            }
            $model->attributes = $_POST['UserEducationModel'];
            if ($model->save()) {
                $resumeModel->updated = time();
                $resumeModel->save();
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
                $data = $_POST['UserEducationModel'];
                $data['certificate'] = $model->certificate;
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    if (isset($content['user_education'][0])) {
                        unset($content['user_education'][0]);
                    }
                    if (isset($content['user_education'][$model->id])) {
                        foreach ($data as $field => $value) {
                            if (array_key_exists($field, $content['user_education'][$model->id])) {
                                if ($value != $content['user_education'][$model->id][$field]['value']) {
                                    $content['user_education'][$model->id][$field] = array(
                                        'field' => $field,
                                        'value' => $value,
                                        'status' => 0,
                                        'reason' => '',
                                        'color' => 'red',
                                        'updated' => time(),
                                    );
                                }
                            } else {
                                $content['user_education'][$model->id][$field] = array(
                                    'field' => $field,
                                    'value' => $value,
                                    'status' => 0,
                                    'reason' => '',
                                    'color' => 'red',
                                    'updated' => time(),
                                );
                            }
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_education'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 0,
                                'reason' => '',
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    }
                } else {
                    $resumeLogModel = new ResumeLogModel();
                    $resumeLogModel->user_id = $user_id;
                    $resumeLogModel->resume_id = $resumeModel->id;
                    $resumeLogModel->updated = time();
                    $resumeLogModel->created = time();
                    $content = array();
                    foreach ($data as $field => $value) {
                        $content['user_education'][$model->id][$field] = array(
                            'field' => $field,
                            'value' => $value,
                            'status' => 0,
                            'reason' => '',
                            'color' => 'red',
                            'updated' => time(),
                        );
                    }
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                }
                $this->showSuccess('保存成功！', $this->createUrl('education'));
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->render('education', array(
            'model' => $model,
        ));
    }

    /**
     * 培训经历
     */
    public function actionTrain() {
        $user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $All_model = UserTrainModel::model()->findAll($criteria);
        $model = new UserTrainModel();
        $model->from_time = "";
        $model->to_time = "";
        $this->render('train', array(
            'model' => $model,
            'All_model' => $All_model,
        ));
    }

    public function actionTrain_update() {
        $user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $All_model = UserTrainModel::model()->findAll($criteria);
        $id = numeric($_REQUEST['id']);
        $model = UserTrainModel::model()->findByPk($id);
        $model->from_time = date('Y-m-d', $model->from_time);
        $model->to_time = date('Y-m-d', $model->to_time);

        //审核情况
        $render_arr['model'] = $model;
        $render_arr['All_model'] = $All_model;
        $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
        if ($resumeLogModel) {
            $content = json_decode($resumeLogModel->content, TRUE);
            if (isset($content['user_train'][$model->id]['organization_name'])) {
                $log_first = $content['user_train'][$model->id]['organization_name'];
                $log_res = array(
                    'status' => ResumeLogModel::model()->get_log_status($log_first['status']),
                    'info' => $log_first['reason'],
                );
                $render_arr['log_res'] = $log_res;
            }
        }
        $this->render('train', $render_arr);
    }

    public function actionTrain_save() {
        $user_id = Yii::app()->user->id;
        $isEdit = isset($_POST['id']);
        $resumeModel = UserResumeModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
        if (!$resumeModel) {
            $resumeModel = new UserResumeModel();
            $resumeModel->user_id = $user_id;
            $resumeModel->save();
        }
        if ($isEdit) {
            $model = UserTrainModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
        } else {
            $model = new UserTrainModel();
            $model->created = time();
            $model->user_id = $user_id;
            //$userArr = Yii::app()->db->createCommand()->select('id')->from('user_resume')->where('user_id=:user_id',array(':user_id'=>$user_id))->queryRow();
            //$model->resume_id = $userArr['id'];
            $model->resume_id = $resumeModel->id;
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_FILES['certificate']['tmp_name']) && !empty($_FILES['certificate']['tmp_name'])) {
            $Uploader = new Uploader();
            $Uploader->useFile();
            if ($Uploader->upload('certificate')) {
                $model->certificate = $Uploader->file;
            } else {
                $this->showError('上传失败！');
            }
        }
        if (isset($_POST['UserTrainModel'])) {
            if (!empty($_POST['UserTrainModel']['from_time'])) {
                $_POST['UserTrainModel']['from_time'] = strtotime($_POST['UserTrainModel']['from_time']);
            }
            if (!empty($_POST['UserTrainModel']['to_time'])) {
                $_POST['UserTrainModel']['to_time'] = strtotime($_POST['UserTrainModel']['to_time']);
            }
            $model->attributes = $_POST['UserTrainModel'];
            if ($model->save()) {
                $resumeModel->updated = time();
                $resumeModel->save();
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
                $data = $_POST['UserTrainModel'];
                $data['certificate'] = $model->certificate;
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    if (isset($content['user_train'][0])) {
                        unset($content['user_train'][0]);
                    }
                    if (isset($content['user_train'][$model->id])) {
                        foreach ($data as $field => $value) {
                            if (array_key_exists($field, $content['user_train'][$model->id])) {
                                if ($value != $content['user_train'][$model->id][$field]['value']) {
                                    $content['user_train'][$model->id][$field] = array(
                                        'field' => $field,
                                        'value' => $value,
                                        'status' => 0,
                                        'reason' => '',
                                        'color' => 'red',
                                        'updated' => time(),
                                    );
                                }
                            } else {
                                $content['user_train'][$model->id][$field] = array(
                                    'field' => $field,
                                    'value' => $value,
                                    'status' => 0,
                                    'reason' => '',
                                    'color' => 'red',
                                    'updated' => time(),
                                );
                            }
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_train'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 0,
                                'reason' => '',
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    }
                } else {
                    $resumeLogModel = new ResumeLogModel();
                    $resumeLogModel->user_id = $user_id;
                    $resumeLogModel->resume_id = $resumeModel->id;
                    $resumeLogModel->updated = time();
                    $resumeLogModel->created = time();
                    $content = array();
                    foreach ($data as $field => $value) {
                        $content['user_train'][$model->id][$field] = array(
                            'field' => $field,
                            'value' => $value,
                            'status' => 0,
                            'reason' => '',
                            'color' => 'red',
                            'updated' => time(),
                        );
                    }
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                }
                $this->showSuccess('保存成功！', $this->createUrl('train'));
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->render('train', array(
            'model' => $model,
        ));
    }

    /**
     * 工作经验
     */
    public function actionExperience() {
        $user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $All_model = UserExperienceModel::model()->findAll($criteria);
        $model = new UserExperienceModel();
        $model->from_time = "";
        $model->to_time = "";
        $this->render('experience', array(
            'model' => $model,
            'All_model' => $All_model,
        ));
    }

    public function actionExperience_update() {
        $user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $All_model = UserExperienceModel::model()->findAll($criteria);
        $id = numeric($_REQUEST['id']);
        $model = UserExperienceModel::model()->findByPk($id);
        $model->from_time = date('Y-m-d', $model->from_time);
        $model->to_time = date('Y-m-d', $model->to_time);

        //审核情况
        $render_arr['model'] = $model;
        $render_arr['All_model'] = $All_model;
        $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
        if ($resumeLogModel) {
            $content = json_decode($resumeLogModel->content, TRUE);
            if (isset($content['user_experience'][$model->id]['company_name'])) {
                $log_first = $content['user_experience'][$model->id]['company_name'];
                $log_res = array(
                    'status' => ResumeLogModel::model()->get_log_status($log_first['status']),
                    'info' => $log_first['reason'],
                );

                $render_arr['log_res'] = $log_res;
            }
        }
        $this->render('experience', $render_arr);
    }

    public function actionExperience_save() {
        $user_id = Yii::app()->user->id;
        $isEdit = isset($_POST['id']);
        $resumeModel = UserResumeModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
        if (!$resumeModel) {
            $resumeModel = new UserResumeModel();
            $resumeModel->user_id = $user_id;
            $resumeModel->save();
        }
        if ($isEdit) {
            $model = UserExperienceModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
        } else {
            $model = new UserExperienceModel();
            $model->created = time();
            $model->user_id = $user_id;
            //$userArr = Yii::app()->db->createCommand()->select('id')->from('user_resume')->where('user_id=:user_id',array(':user_id'=>$user_id))->queryRow();
            //$model->resume_id = $userArr['id'];
            $model->resume_id = $resumeModel->id;
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_FILES['business_card']['tmp_name']) && !empty($_FILES['business_card']['tmp_name'])) {
            $Uploader = new Uploader();
            $Uploader->useFile();
            if ($Uploader->upload('business_card')) {
                $model->business_card = $Uploader->file;
            } else {
                $this->showError('上传失败！');
            }
        }
        if (isset($_POST['UserExperienceModel'])) {
            if (!empty($_POST['UserExperienceModel']['from_time'])) {
                $_POST['UserExperienceModel']['from_time'] = strtotime($_POST['UserExperienceModel']['from_time']);
            }
            if (!empty($_POST['UserExperienceModel']['to_time'])) {
                $_POST['UserExperienceModel']['to_time'] = strtotime($_POST['UserExperienceModel']['to_time']);
            }
            $model->attributes = $_POST['UserExperienceModel'];
            if ($model->save()) {
                $resumeModel->updated = time();
                $resumeModel->save();
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
                $data = $_POST['UserExperienceModel'];
                $data['business_card'] = $model->business_card;
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    if (isset($content['user_experience'][0])) {
                        unset($content['user_experience'][0]);
                    }
                    if (isset($content['user_experience'][$model->id])) {
                        foreach ($data as $field => $value) {
                            if (array_key_exists($field, $content['user_experience'][$model->id])) {
                                if ($value != $content['user_experience'][$model->id][$field]['value']) {
                                    $content['user_experience'][$model->id][$field] = array(
                                        'field' => $field,
                                        'value' => $value,
                                        'status' => 0,
                                        'reason' => '',
                                        'color' => 'red',
                                        'updated' => time(),
                                    );
                                }
                            } else {
                                $content['user_experience'][$model->id][$field] = array(
                                    'field' => $field,
                                    'value' => $value,
                                    'status' => 0,
                                    'reason' => '',
                                    'color' => 'red',
                                    'updated' => time(),
                                );
                            }
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_experience'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 0,
                                'reason' => '',
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                        $resumeLogModel->content = json_encode($content);
                        $resumeLogModel->save();
                    }
                } else {
                    $resumeLogModel = new ResumeLogModel();
                    $resumeLogModel->user_id = $user_id;
                    $resumeLogModel->resume_id = $resumeModel->id;
                    $resumeLogModel->updated = time();
                    $resumeLogModel->created = time();
                    $content = array();
                    foreach ($data as $field => $value) {
                        $content['user_experience'][$model->id][$field] = array(
                            'field' => $field,
                            'value' => $value,
                            'status' => 0,
                            'reason' => '',
                            'color' => 'red',
                            'updated' => time(),
                        );
                    }
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                }
                $this->showSuccess('保存成功！', $this->createUrl('experience'));
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->render('experience', array(
            'model' => $model,
        ));
    }

    //简历收藏
    public function actionFavorite() {
        if (Yii::app()->user->getState('user_type') == 1) {
            $user_id = Yii::app()->user->id;
            $criteria = new CDbCriteria();
            $criteria->with = array('resume');
            $criteria->compare('t.user_id', $user_id);
            $model = ResumeFavoriteModel::model()->findAll($criteria);
            $this->render('favorite', array('model' => $model));
        } else {
            $this->showError('您没有权限查看');
        }
    }

    public function actionCancel_favorite() {
        $user_id = $_POST['user_id'];
        $resume_id = $_POST['resume_id'];
        if ($user_id != Yii::app()->user->id) {
            echo json_encode(array('status' => 0, 'messages' => '操作失败！'));
            exit;
        } else {
            $model = ResumeFavoriteModel::model()->find('user_id = :user_id and resume_id = :resume_id', array(':user_id' => $user_id, 'resume_id' => $resume_id));
            if ($model->delete()) {
                echo json_encode(array('status' => 1, 'messages' => '取消成功！'));
                exit;
            } else {
                echo json_encode(array('status' => 0, 'messages' => '取消失败！'));
                exit;
            }
        }
    }

}
