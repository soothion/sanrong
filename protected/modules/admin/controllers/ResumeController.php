<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResumeController
 *
 * @author lzh
 */
class ResumeController extends Controller {

    public function init() {
        $this->layout = '//layouts/column2';
        if(!$this->checkAccess(1)){
            $this->showError('没有操作权限！','/admin');
        }
        $this->subnavtabs = array(
            'resume_index' => array('title' => '简历列表', 'url' => $this->createUrl('index')),
                //'user_user_info' => array('title' => '用户/企业信息', 'url' => $this->createUrl('user_info', array('user_id' => 0))),
        );
        parent::init();
    }

    public function actionIndex() {
        if (isset($_GET['id']) && isset($_GET['elite'])) {
            $resumeModel = UserResumeModel::model()->find('id=:id', array(':id' => $_GET['id']));
            $resumeModel->is_elite = numeric($_GET['elite']);
            $resumeModel->updated = time();
            $resumeModel->save();
        }
        $this->breadcrumbs[] = '简历列表';
        $criteria = new CDbCriteria();
        $criteria->order = 'updated DESC';
        if (isset($_GET['id']) && numeric($_GET['id']) > 0) {
            $criteria->compare('id', numeric($_GET['id']));
        }
        if (isset($_GET['is_elite']) && $_GET['is_elite'] >= 0) {
            $criteria->compare('is_elite', $_GET['is_elite']);
        }
        if (isset($_GET['username']) && !empty($_GET['username'])) {
            $criteria->addSearchCondition('username', $_GET['username']);
        }
        $count = UserResumeModel::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 15;
        $pager->applyLimit($criteria);
        $model = UserResumeModel::model()->findAll($criteria);
        $this->render('index', array(
            'model' => $model,
            'pager' => $pager,
        ));
    }

    public function actionAccount() {
        if (isset($_REQUEST['id']) && numeric($_REQUEST['id']) > 0) {
            $id = $_REQUEST['id'];
            $this->subnavtabs['resume_account'] = array(
                'title' => '更新简历', 'url' => $this->createUrl('account')
            );
            $this->breadcrumbs[] = '更新简历';

            $model = UserResumeModel::model()->find('id=:id', array(':id' => $id));
            $render_arr = array('model' => $model);
            $resume_log_model = ResumeLogModel::model()->find('resume_id = :id', array(':id' => $id));
            $resume_log = json_decode($resume_log_model->content, true);
            if (isset($resume_log['user_resume'])) {
                $resume_log_content = $resume_log['user_resume'][$id];
                $render_arr['resume_log_content'] = $resume_log_content;
            } else {
                $render_arr['resume_log_content'] = array();
            }

            $this->checkEmpty($model);
            $model->birthday = $model->birthday ? date('Y-m-d', $model->birthday) : "";
            $model->graduate_time = $model->graduate_time ? date('Y-m-d', $model->graduate_time) : "";
            $this->render('account', $render_arr);
        }
    }

    public function actionAccount_save() {
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserResumeModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
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
            if (isset($_POST['UserResumeModel']['birthday']) && !empty($_POST['UserResumeModel']['birthday'])) {
                $_POST['UserResumeModel']['birthday'] = strtotime($_POST['UserResumeModel']['birthday']);
                $model->age = numeric(date('Y', time())) - numeric(date('Y', $_POST['UserResumeModel']['birthday']));
            }
            if (isset($_POST['UserResumeModel']['graduate_time']) && !empty($_POST['UserResumeModel']['graduate_time'])) {
                $_POST['UserResumeModel']['graduate_time'] = strtotime($_POST['UserResumeModel']['graduate_time']);
            }
            if (isset($_FILES['one_size_photo']['tmp_name']) && !empty($_FILES['one_size_photo']['tmp_name'])) {
                $Uploader = new Uploader();
                $Uploader->useImage();
                if ($Uploader->upload('one_size_photo')) {
                    $model->one_size_photo = $Uploader->file;
                }
            }
            $model->attributes = $_POST['UserResumeModel'];

            if ($model->save()) {
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $model->user_id));
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    $data = $_POST['UserResumeModel'];
                    $data['one_size_photo'] = $model->one_size_photo;
                    if ($_POST['status'] == 1) {
                        foreach ($data as $field => $value) {
                            $content['user_resume'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 1,
                                'reason' => '',
                                'color' => 'green',
                                'updated' => time(),
                            );
                        }
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_resume'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 2,
                                'reason' => $_POST['reason'],
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                    }
                    foreach ($content as $key => $val) {
                        $status = 1;
                        if (isset($content['user_resume']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience'])) {
                            foreach ($content['user_resume'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_purpose'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_education'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_train'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_experience'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                        } else {
                            $status = 2;
                        }
                    }
                    $model->status = $status;
                    $model->save();
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                } else {
                    $this->showError('用户未添加信息！');
                }
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
    }

    public function actionContact() {
        if (isset($_REQUEST['id']) && numeric($_REQUEST['id']) > 0) {
            $id = $_REQUEST['id'];
            $this->subnavtabs['resume_contact'] = array(
                'title' => '更新简历', 'url' => $this->createUrl('contact')
            );
            $this->breadcrumbs[] = '更新简历';

            $model = UserResumeModel::model()->find('id=:id', array(':id' => $id));
            $model->mobile = UserModel::model()->find('id = ' . $model->user_id)->mobile;
            $render_arr = array('model' => $model);
            $resume_log_model = ResumeLogModel::model()->find('resume_id = :id', array(':id' => $id));
            $resume_log = json_decode($resume_log_model->content, true);
            if (isset($resume_log['user_resume'])) {
                $resume_log_content = $resume_log['user_resume'][$id];
                $render_arr['resume_log_content'] = $resume_log_content;
            } else {
                $render_arr['resume_log_content'] = array();
            }
            $this->checkEmpty($model);
            $this->render('contact', $render_arr);
        }
    }

    public function actionContact_save() {
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserResumeModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
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
            $temp_data = $_POST['UserResumeModel'];
            unset($temp_data['mobile']);
            $model->attributes = $temp_data;
            $userModel = UserModel::model()->find('id =' . $model->user_id);
            $userModel->mobile = $_POST['UserResumeModel']['mobile'];
            $userModel->save();
            if ($model->save()) {
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $model->user_id));
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    $data = $_POST['UserResumeModel'];
                    if ($_POST['status'] == 1) {
                        foreach ($data as $field => $value) {
                            $content['user_resume'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 1,
                                'reason' => '',
                                'color' => 'green',
                                'updated' => time(),
                            );
                        }
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_resume'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 2,
                                'reason' => $_POST['reason'],
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                    }
                    foreach ($content as $key => $val) {
                        $status = 1;
                        if (isset($content['user_resume']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience'])) {
                            foreach ($content['user_resume'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_purpose'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_education'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_train'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_experience'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                        } else {
                            $status = 2;
                        }
                    }
                    $model->status = $status;
                    $model->save();
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                } else {
                    $this->showError('用户未添加信息！');
                }
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
    }

    public function actionDescription() {
        if (isset($_REQUEST['id']) && numeric($_REQUEST['id']) > 0) {
            $id = $_REQUEST['id'];
            $this->subnavtabs['resume_description'] = array(
                'title' => '更新简历', 'url' => $this->createUrl('description')
            );
            $this->breadcrumbs[] = '更新简历';

            $model = UserResumeModel::model()->find('id=:id', array(':id' => $id));
            $render_arr = array('model' => $model);
            $resume_log_model = ResumeLogModel::model()->find('resume_id = :id', array(':id' => $id));
            $resume_log = json_decode($resume_log_model->content, true);
            if (isset($resume_log['user_resume'])) {
                $resume_log_content = $resume_log['user_resume'][$id];
                $render_arr['resume_log_content'] = $resume_log_content;
            } else {
                $render_arr['resume_log_content'] = array();
            }
            $this->checkEmpty($model);
            $this->render('description', $render_arr);
        }
    }

    public function actionDescription_save() {
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserResumeModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
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
            if ($model->save()) {
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $model->user_id));
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    $data = $_POST['UserResumeModel'];
                    if ($_POST['status'] == 1) {
                        foreach ($data as $field => $value) {
                            $content['user_resume'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 1,
                                'reason' => '',
                                'color' => 'green',
                                'updated' => time(),
                            );
                        }
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_resume'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 2,
                                'reason' => $_POST['reason'],
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                    }
                    foreach ($content as $key => $val) {
                        $status = 1;
                        if (isset($content['user_resume']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience'])) {
                            foreach ($content['user_resume'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_purpose'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_education'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_train'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_experience'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                        } else {
                            $status = 2;
                        }
                    }
                    $model->status = $status;
                    $model->save();
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                } else {
                    $this->showError('用户未添加信息！');
                }
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
    }

    public function actionExtracurricular() {
        if (isset($_REQUEST['id']) && numeric($_REQUEST['id']) > 0) {
            $id = $_REQUEST['id'];
            $this->subnavtabs['resume_extracurricular'] = array(
                'title' => '更新简历', 'url' => $this->createUrl('extracurricular')
            );
            $this->breadcrumbs[] = '更新简历';

            $model = UserResumeModel::model()->find('id=:id', array(':id' => $id));
            $render_arr = array('model' => $model);
            $resume_log_model = ResumeLogModel::model()->find('resume_id = :id', array(':id' => $id));
            $resume_log = json_decode($resume_log_model->content, true);
            if (isset($resume_log['user_resume'])) {
                $resume_log_content = $resume_log['user_resume'][$id];
                $render_arr['resume_log_content'] = $resume_log_content;
            } else {
                $render_arr['resume_log_content'] = array();
            }
            $this->checkEmpty($model);
            $this->render('extracurricular', $render_arr);
        }
    }

    public function actionExtracurricular_save() {
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserResumeModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
        } else {
            $model = new UserResumeModel();
            $model->created = time();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['UserResumeModel'])) {
            $model->attributes = $_POST['UserResumeModel'];
            if ($model->save()) {
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $model->user_id));
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    $data = $_POST['UserResumeModel'];
                    if ($_POST['status'] == 1) {
                        foreach ($data as $field => $value) {
                            $content['user_resume'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 1,
                                'reason' => '',
                                'color' => 'green',
                                'updated' => time(),
                            );
                        }
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_resume'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 2,
                                'reason' => $_POST['reason'],
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                    }
                    foreach ($content as $key => $val) {
                        $status = 1;
                        if (isset($content['user_resume']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience'])) {
                            foreach ($content['user_resume'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_purpose'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_education'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_train'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_experience'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                        } else {
                            $status = 2;
                        }
                    }
                    $model->status = $status;
                    $model->save();
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                } else {
                    $this->showError('用户未添加信息！');
                }
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
    }

    public function actionPurpose() {
        if (isset($_REQUEST['id']) && numeric($_REQUEST['id']) > 0) {
            $id = $_REQUEST['id'];
            $this->subnavtabs['resume_purpose'] = array(
                'title' => '更新简历', 'url' => $this->createUrl('purpose')
            );
            $this->breadcrumbs[] = '更新简历';

            $allModel = UserPurposeModel::model()->findAll('resume_id=:id', array(':id' => $id));
            $render_arr = array('allModel' => $allModel, 'id' => $id);
            if (isset($_REQUEST['purpose_id']) && numeric($_REQUEST['purpose_id']) > 0) {
                $model = UserPurposeModel::model()->find('id = :id', array(':id' => $_REQUEST['purpose_id']));
                $model->other_weal = explode(',', $model->other_weal);
                $this->checkEmpty($model);
                $render_arr['model'] = $model;
                $resume_log_model = ResumeLogModel::model()->find('resume_id = :id', array(':id' => $id));

                $resume_log = json_decode($resume_log_model->content, true);
                if (isset($resume_log['user_purpose'])) {
                    $resume_log_content = $resume_log['user_purpose'][$_REQUEST['purpose_id']];
                    $render_arr['resume_log_content'] = $resume_log_content;
                } else {
                    $render_arr['resume_log_content'] = array();
                }
            }

            $this->render('purpose', $render_arr);
        }
    }

    public function actionPurpose_save() {
        if (!isset($_POST['UserPurposeModel'])) {
            $model = new UserPurposeModel();
            $resume_id = $_POST['resume_id'];
            $resumeLogModel = ResumeLogModel::model()->find('resume_id = :resume_id', array(':resume_id' => $resume_id));
            if ($resumeLogModel) {
                $content = json_decode($resumeLogModel->content, TRUE);
                if ($_POST['status'] == 1) {
                    foreach ($model->attributes as $field => $value) {
                        $content['user_purpose'][0][$field] = array(
                            'field' => $field,
                            'value' => '',
                            'status' => 1,
                            'reason' => '',
                            'color' => 'green',
                            'updated' => time(),
                        );
                    }
                } else {
                    foreach ($model->attributes as $field => $value) {
                        $content['user_purpose'][0][$field] = array(
                            'field' => $field,
                            'value' => '',
                            'status' => 2,
                            'reason' => $_POST['reason'],
                            'color' => 'red',
                            'updated' => time(),
                        );
                    }
                }
                foreach ($content as $key => $val) {
                    $status = 1;
                    if (isset($content['user_resume']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience'])) {
                        foreach ($content['user_resume'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_purpose'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_education'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_train'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_experience'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                    } else {
                        $status = 2;
                    }
                }
                $resumeModel = UserResumeModel::model()->find('id = :id', array(':id' => $resume_id));
                $resumeModel->status = $status;
                $resumeModel->save();
                $resumeLogModel->content = json_encode($content);
                $resumeLogModel->save();
                $this->showSuccess('保存成功！');
            }
            exit;
        }
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserPurposeModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
        } else {
            $model = new UserPurposeModel();
            $model->created = time();
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
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $model->user_id));
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    $data = $_POST['UserPurposeModel'];
                    if ($_POST['status'] == 1) {
                        foreach ($model->attributes as $field => $value) {
                            $content['user_purpose'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 1,
                                'reason' => '',
                                'color' => 'green',
                                'updated' => time(),
                            );
                        }
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_purpose'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 2,
                                'reason' => $_POST['reason'],
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                    }
                    foreach ($content as $key => $val) {
                        $status = 1;
                        if (isset($content['user_resume']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience'])) {
                            foreach ($content['user_resume'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_purpose'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_education'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_train'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_experience'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                        } else {
                            $status = 2;
                        }
                    }
                    $resumeModel = UserResumeModel::model()->find('id = :id', array(':id' => $model->resume_id));
                    $resumeModel->status = $status;
                    $resumeModel->save();
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                } else {
                    $this->showError('用户未添加信息！');
                }
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
    }

    public function actionEducation() {
        if (isset($_REQUEST['id']) && numeric($_REQUEST['id']) > 0) {
            $id = $_REQUEST['id'];
            $this->subnavtabs['resume_education'] = array(
                'title' => '更新简历', 'url' => $this->createUrl('education')
            );
            $this->breadcrumbs[] = '更新简历';

            $allModel = UserEducationModel::model()->findAll('resume_id=:id', array(':id' => $id));

            $render_arr = array('allModel' => $allModel, 'id' => $id);
            if (isset($_REQUEST['education_id']) && numeric($_REQUEST['education_id']) > 0) {
                $model = UserEducationModel::model()->find('id = :id', array(':id' => $_REQUEST['education_id']));
                $model->from_time = date('Y-m', $model->from_time);
                $model->to_time = date('Y-m', $model->to_time);
                $this->checkEmpty($model);
                $render_arr['model'] = $model;
                $resume_log_model = ResumeLogModel::model()->find('resume_id = :id', array(':id' => $id));

                $resume_log = json_decode($resume_log_model->content, true);
                if (isset($resume_log['user_education'])) {
                    $resume_log_content = $resume_log['user_education'][$_REQUEST['education_id']];
                    $render_arr['resume_log_content'] = $resume_log_content;
                } else {
                    $render_arr['resume_log_content'] = array();
                }
            }

            $this->render('education', $render_arr);
        }
    }

    public function actionEducation_save() {
        if (!isset($_POST['UserEducationModel'])) {
            $model = new UserEducationModel();
            $resume_id = $_POST['resume_id'];
            $resumeLogModel = ResumeLogModel::model()->find('resume_id = :resume_id', array(':resume_id' => $resume_id));
            if ($resumeLogModel) {
                $content = json_decode($resumeLogModel->content, TRUE);
                if ($_POST['status'] == 1) {
                    foreach ($model->attributes as $field => $value) {
                        $content['user_education'][0][$field] = array(
                            'field' => $field,
                            'value' => '',
                            'status' => 1,
                            'reason' => '',
                            'color' => 'green',
                            'updated' => time(),
                        );
                    }
                } else {
                    foreach ($model->attributes as $field => $value) {
                        $content['user_education'][0][$field] = array(
                            'field' => $field,
                            'value' => '',
                            'status' => 2,
                            'reason' => $_POST['reason'],
                            'color' => 'red',
                            'updated' => time(),
                        );
                    }
                }
                foreach ($content as $key => $val) {
                    $status = 1;
                    if (isset($content['user_resume']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience'])) {
                        foreach ($content['user_resume'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_purpose'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_education'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_train'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_experience'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                    } else {
                        $status = 2;
                    }
                }
                $resumeModel = UserResumeModel::model()->find('id = :id', array(':id' => $resume_id));
                $resumeModel->status = $status;
                $resumeModel->save();
                $resumeLogModel->content = json_encode($content);
                $resumeLogModel->save();
                $this->showSuccess('保存成功！');
            }
            exit;
        }
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserEducationModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
        } else {
            $model = new UserEducationModel();
            $model->created = time();
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
            $post = $_POST['UserEducationModel'];
            if (!empty($post['from_time'])) {
                $post['from_time'] = strtotime($post['from_time']);
            }
            if (!empty($post['to_time'])) {
                $post['to_time'] = strtotime($post['to_time']);
            }
            $model->attributes = $post;
            if ($model->save()) {
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $model->user_id));
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    $data = $post;
                    $data['certificate'] = $model->certificate;
                    if ($_POST['status'] == 1) {
                        foreach ($data as $field => $value) {
                            $content['user_education'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 1,
                                'reason' => '',
                                'color' => 'green',
                                'updated' => time(),
                            );
                        }
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_education'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 2,
                                'reason' => $_POST['reason'],
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                    }
                    foreach ($content as $key => $val) {
                        $status = 1;
                        if (isset($content['user_resume']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience'])) {
                            foreach ($content['user_resume'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_purpose'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_education'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_train'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_experience'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                        } else {
                            $status = 2;
                        }
                    }
                    $resumeModel = UserResumeModel::model()->find('id = :id', array(':id' => $model->resume_id));
                    $resumeModel->status = $status;
                    $resumeModel->save();
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                } else {
                    $this->showError('用户未添加信息！');
                }
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
    }

    public function actionTrain() {
        if (isset($_REQUEST['id']) && numeric($_REQUEST['id']) > 0) {
            $id = $_REQUEST['id'];
            $this->subnavtabs['resume_train'] = array(
                'title' => '更新简历', 'url' => $this->createUrl('train')
            );
            $this->breadcrumbs[] = '更新简历';

            $allModel = UserTrainModel::model()->findAll('resume_id=:id', array(':id' => $id));
            $render_arr = array('allModel' => $allModel, 'id' => $id);
            if (isset($_REQUEST['train_id']) && numeric($_REQUEST['train_id']) > 0) {
                $model = UserTrainModel::model()->find('id = :id', array(':id' => $_REQUEST['train_id']));
                $model->from_time = date('Y-m', $model->from_time);
                $model->to_time = date('Y-m', $model->to_time);
                $this->checkEmpty($model);
                $render_arr['model'] = $model;
                $resume_log_model = ResumeLogModel::model()->find('resume_id = :id', array(':id' => $id));

                $resume_log = json_decode($resume_log_model->content, true);
                if (isset($resume_log['user_train'])) {
                    $resume_log_content = $resume_log['user_train'][$_REQUEST['train_id']];
                    $render_arr['resume_log_content'] = $resume_log_content;
                } else {
                    $render_arr['resume_log_content'] = array();
                }
            }

            $this->render('train', $render_arr);
        }
    }

    public function actionTrain_save() {
        if (!isset($_POST['UserTrainModel'])) {
            $model = new UserTrainModel();
            $resume_id = $_POST['resume_id'];
            $resumeLogModel = ResumeLogModel::model()->find('resume_id = :resume_id', array(':resume_id' => $resume_id));
            if ($resumeLogModel) {
                $content = json_decode($resumeLogModel->content, TRUE);
                if ($_POST['status'] == 1) {
                    foreach ($model->attributes as $field => $value) {
                        $content['user_train'][0][$field] = array(
                            'field' => $field,
                            'value' => '',
                            'status' => 1,
                            'reason' => '',
                            'color' => 'green',
                            'updated' => time(),
                        );
                    }
                } else {
                    foreach ($model->attributes as $field => $value) {
                        $content['user_train'][0][$field] = array(
                            'field' => $field,
                            'value' => '',
                            'status' => 2,
                            'reason' => $_POST['reason'],
                            'color' => 'red',
                            'updated' => time(),
                        );
                    }
                }
                foreach ($content as $key => $val) {
                    $status = 1;
                    if (isset($content['user_resume']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience'])) {
                        foreach ($content['user_resume'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_purpose'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_education'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_train'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_experience'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                    } else {
                        $status = 2;
                    }
                }
                $resumeModel = UserResumeModel::model()->find('id = :id', array(':id' => $resume_id));
                $resumeModel->status = $status;
                $resumeModel->save();
                $resumeLogModel->content = json_encode($content);
                $resumeLogModel->save();
                $this->showSuccess('保存成功！');
            }
            exit;
        }
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserTrainModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
        } else {
            $model = new UserTrainModel();
            $model->created = time();
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
        if (isset($_POST['UserTrainModel'])) {
            $post = $_POST['UserTrainModel'];
            if (!empty($post['from_time'])) {
                $post['from_time'] = strtotime($post['from_time']);
            }
            if (!empty($post['to_time'])) {
                $post['to_time'] = strtotime($post['to_time']);
            }
            $model->attributes = $post;
            if ($model->save()) {
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $model->user_id));
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    $data = $post;
                    $data['certificate'] = $model->certificate;
                    if ($_POST['status'] == 1) {
                        foreach ($data as $field => $value) {
                            $content['user_train'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 1,
                                'reason' => '',
                                'color' => 'green',
                                'updated' => time(),
                            );
                        }
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_train'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 2,
                                'reason' => $_POST['reason'],
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                    }
                    foreach ($content as $key => $val) {
                        $status = 1;
                        if (isset($content['user_resume']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience'])) {
                            foreach ($content['user_resume'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_purpose'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_education'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_train'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                        } else {
                            $status = 2;
                        }
                    }
                    $resumeModel = UserResumeModel::model()->find('id = :id', array(':id' => $model->resume_id));
                    $resumeModel->status = $status;
                    $resumeModel->save();
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                } else {
                    $this->showError('用户未添加信息！');
                }
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
    }

    public function actionExperience() {
        if (isset($_REQUEST['id']) && numeric($_REQUEST['id']) > 0) {
            $id = $_REQUEST['id'];
            $this->subnavtabs['resume_experience'] = array(
                'title' => '更新简历', 'url' => $this->createUrl('experience')
            );
            $this->breadcrumbs[] = '更新简历';

            $allModel = UserExperienceModel::model()->findAll('resume_id=:id', array(':id' => $id));
            $render_arr = array('allModel' => $allModel, 'id' => $id);
            if (isset($_REQUEST['experience_id']) && numeric($_REQUEST['experience_id']) > 0) {
                $model = UserExperienceModel::model()->find('id = :id', array(':id' => $_REQUEST['experience_id']));
                $model->from_time = date('Y-m', $model->from_time);
                $model->to_time = date('Y-m', $model->to_time);
                $this->checkEmpty($model);
                $render_arr['model'] = $model;
                $resume_log_model = ResumeLogModel::model()->find('resume_id = :id', array(':id' => $id));

                $resume_log = json_decode($resume_log_model->content, true);
                if (isset($resume_log['user_experience'])) {
                    $resume_log_content = $resume_log['user_experience'][$_REQUEST['experience_id']];
                    $render_arr['resume_log_content'] = $resume_log_content;
                } else {
                    $render_arr['resume_log_content'] = array();
                }
            }

            $this->render('experience', $render_arr);
        }
    }

    public function actionExperience_save() {
        if (!isset($_POST['UserExperienceModel'])) {
            $model = new UserExperienceModel();
            $resume_id = $_POST['resume_id'];
            $resumeLogModel = ResumeLogModel::model()->find('resume_id = :resume_id', array(':resume_id' => $resume_id));
            if ($resumeLogModel) {
                $content = json_decode($resumeLogModel->content, TRUE);
                if ($_POST['status'] == 1) {
                    foreach ($model->attributes as $field => $value) {
                        $content['user_experience'][0][$field] = array(
                            'field' => $field,
                            'value' => '',
                            'status' => 1,
                            'reason' => '',
                            'color' => 'green',
                            'updated' => time(),
                        );
                    }
                } else {
                    foreach ($model->attributes as $field => $value) {
                        $content['user_experience'][0][$field] = array(
                            'field' => $field,
                            'value' => '',
                            'status' => 2,
                            'reason' => $_POST['reason'],
                            'color' => 'red',
                            'updated' => time(),
                        );
                    }
                }
                foreach ($content as $key => $val) {
                    $status = 1;
                    if (isset($content['user_resume']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience'])) {
                        foreach ($content['user_resume'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_purpose'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_education'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_train'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                        foreach ($content['user_experience'] as $k => $v) {
                            foreach ($v as $field => $value) {
                                $status = $status * $value['status'];
                            }
                        }
                    } else {
                        $status = 2;
                    }
                }
                $resumeModel = UserResumeModel::model()->find('id = :id', array(':id' => $resume_id));
                $resumeModel->status = $status;
                $resumeModel->save();
                $resumeLogModel->content = json_encode($content);
                $resumeLogModel->save();
                $this->showSuccess('保存成功！');
            }
            exit;
        }
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = UserExperienceModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
        } else {
            $model = new UserExperienceModel();
            $model->created = time();
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
                //$_POST['UserEducationModel']['certificate'] = $Uploader->file;
            } else {
                $this->showError('上传失败！');
            }
        }
        if (isset($_POST['UserExperienceModel'])) {
            $post = $_POST['UserExperienceModel'];
            if (!empty($post['from_time'])) {
                $post['from_time'] = strtotime($post['from_time']);
            }
            if (!empty($post['to_time'])) {
                $post['to_time'] = strtotime($post['to_time']);
            }
            $model->attributes = $post;
            if ($model->save()) {
                $resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $model->user_id));
                if ($resumeLogModel) {
                    $content = json_decode($resumeLogModel->content, TRUE);
                    $data = $post;
                    $data['business_card'] = $model->business_card;
                    if ($_POST['status'] == 1) {
                        foreach ($data as $field => $value) {
                            $content['user_experience'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 1,
                                'reason' => '',
                                'color' => 'green',
                                'updated' => time(),
                            );
                        }
                    } else {
                        foreach ($data as $field => $value) {
                            $content['user_experience'][$model->id][$field] = array(
                                'field' => $field,
                                'value' => $value,
                                'status' => 2,
                                'reason' => $_POST['reason'],
                                'color' => 'red',
                                'updated' => time(),
                            );
                        }
                    }
                    foreach ($content as $key => $val) {
                        $status = 1;
                        if (isset($content['user_resume']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience']) && isset($content['user_purpose']) && isset($content['user_education']) && isset($content['user_train']) && isset($content['user_experience'])) {
                            foreach ($content['user_resume'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_purpose'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_education'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_train'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                            foreach ($content['user_experience'] as $k => $v) {
                                foreach ($v as $field => $value) {
                                    $status = $status * $value['status'];
                                }
                            }
                        } else {
                            $status = 2;
                        }
                    }
                    $resumeModel = UserResumeModel::model()->find('id = :id', array(':id' => $model->resume_id));
                    $resumeModel->status = $status;
                    $resumeModel->save();
                    $resumeLogModel->content = json_encode($content);
                    $resumeLogModel->save();
                } else {
                    $this->showError('用户未添加信息！');
                }
                $this->showSuccess('保存成功！');
            } else {
                $this->showError($model->getErrors());
            }
        }
    }

    public function actionShow() {
        $this->layout = 'application.views.layouts.main';
        $criteria = new CDbCriteria();

        if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] > 0) {
            $criteria->compare('user_id', $_REQUEST['user_id']);
        } elseif (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
            $criteria->compare('t.id', $_REQUEST['id']);
        }
        $view = 'admin_show';
        $criteria->with = array('major_first', 'major_second', 'technical_titles_first', 'technical_titles_second', 'resume_speciality', 'account_where', 'birthplace', 'user');
        $model = UserResumeModel::model()->find($criteria);
        $user_id = $model->user_id;
        $educationModel = UserEducationModel::model()->findAll('user_id = :user_id', array(':user_id' => $user_id));
        $trainModel = UserTrainModel::model()->findAll('user_id = :user_id', array(':user_id' => $user_id));
        $experienceModel = UserExperienceModel::model()->findAll('user_id = :user_id', array(':user_id' => $user_id));
        $this->render($view, array(
            'model' => $model,
            'educationModel' => $educationModel,
            'trainModel' => $trainModel,
            'experienceModel' => $experienceModel,
        ));
    }

    public function actionDelete() {
        $model = new UserResumeModel();
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
