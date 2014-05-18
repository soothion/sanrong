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
    public function init() {
        if (numeric(Yii::app()->user->id) <= 0) {
            $this->showError('您还未登录', $this->createUrl('/member/login'));
        }
        if (Yii::app()->user->getState('user_type') == 2) {
            $this->showError('您的企业身份还在审核中...', $this->createUrl('/member'));
        }
        if (Yii::app()->user->getState('user_type') == 3) {
            $this->showError('您的企业身份审核未通过...', $this->createUrl('/member'));
        }
    }

    public function actionIndex() {
        if (numeric(Yii::app()->user->getState('user_type')) == 0) {
            $this->actionShow();
            exit;
        }
        $model = new UserResumeModel();
        $criteria = new CDbCriteria();
        if (isset($_GET['apply_job_type']) && numeric($_GET['apply_job_type']) > 0) {
            $apply_job_type = $_GET['apply_job_type'];
        } else {
            $apply_job_type = 2;
        }
//        if(isset($_GET['is_elite'])){
//            $criteria->compare('is_elite', $_GET['is_elite']);
//        }
        if (isset($_GET) && !empty($_GET)) {
            foreach ($_GET as $k => $v) {
                if (isset($v) && !empty($v)) {
                    if ($k != 'page') {
                        $model->$k = $v;
                        if ($k == 'age') {
                            switch (numeric($v)) {
                                case 1:$criteria->addBetweenCondition($k, 15, 20);
                                    break;
                                case 2:$criteria->addBetweenCondition($k, 21, 25);
                                    break;
                                case 3:$criteria->addBetweenCondition($k, 26, 30);
                                    break;
                                case 4:$criteria->addBetweenCondition($k, 31, 40);
                                    break;
                                case 5:$criteria->addBetweenCondition($k, 40, 100);
                                    break;
                            }
                        } elseif ($k == 'major') {
                            $criteria->addCondition('major_first_id = ' . $v);
                            $criteria->addCondition('major_second_id = ' . $v, 'OR');
                        } elseif ($k == 'technical_titles') {
                            $criteria->addCondition('resume_technical_titles_id = ' . $v);
                            $criteria->addCondition('resume_technical_titles_second_id = ' . $v, 'OR');
                        } elseif ($k == 'description') {
                            $criteria->addSearchCondition($k, $v);
                        } elseif ($k == 'apply_job_type') {
                            $purpose_model = Yii::app()->db->createCommand()->select('id,user_id')->from('user_purpose')->where("apply_job_type_id = $apply_job_type")->queryAll();
                            $user_id_arr = CHtml::listData($purpose_model, 'id', 'user_id');
                            $criteria->addInCondition('user_id', $user_id_arr);
                        } elseif ($k == 'wish_treatment_id') {
                            $purpose_model = Yii::app()->db->createCommand()->select('id,user_id')->from('user_purpose')->where("wish_treatment_id = $v and apply_job_type_id = $apply_job_type")->queryAll();
                            $user_id_arr = CHtml::listData($purpose_model, 'id', 'user_id');
                            $criteria->addInCondition('user_id', $user_id_arr);
                        } elseif ($k == 'wish_part_time_treatment_id') {
                            $purpose_model = Yii::app()->db->createCommand()->select('id,user_id')->from('user_purpose')->where("wish_part_time_treatment_id = $v and apply_job_type_id = $apply_job_type")->queryAll();
                            $user_id_arr = CHtml::listData($purpose_model, 'id', 'user_id');
                            $criteria->addInCondition('user_id', $user_id_arr);
                        } elseif ($k == 'wish_job_place_id') {
                            $purpose_model = Yii::app()->db->createCommand()->select('id,user_id')->from('user_purpose')->where("wish_job_place_id = $v and apply_job_type_id = $apply_job_type")->queryAll();
                            $user_id_arr = CHtml::listData($purpose_model, 'id', 'user_id');
                            $criteria->addInCondition('user_id', $user_id_arr);
                        } elseif ($k == 'resume_position_id') {
                            $purpose_model = Yii::app()->db->createCommand()->select('id,user_id')->from('user_purpose')->where("resume_position_id = $v and apply_job_type_id = $apply_job_type")->queryAll();
                            $user_id_arr = CHtml::listData($purpose_model, 'id', 'user_id');
                            $criteria->addInCondition('user_id', $user_id_arr);
                        } else {
                            $criteria->compare($k, $v);
                        }
                    }
                }
            }
        }
        $criteria->with = array(
            //'resume_position', //这里会出现关联，原来的技术职称已经不在resume表里了，所以会出现问题，可添加一个审核通过的字段可解决此问题
            'major_first',
        );
        $criteria->compare('status', 1);
        $count = UserResumeModel::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 1;
        $pager->applyLimit($criteria);
        $resumeListModel = UserResumeModel::model()->findAll($criteria);
        //$this->checkEmpty($resumeListModel);
        $this->render('index', array(
            'model' => $model,
            'search_param' => $_GET,
            'resumeListModel' => $resumeListModel,
            'pages' => $pager,
        ));
    }

    public function actionShow() {
        $criteria = new CDbCriteria();
        if (Yii::app()->user->getState('user_type') == 0) {
            $user_id = numeric(Yii::app()->user->id);
            if (!UserResumeModel::model()->find('user_id = :user_id', array(':user_id' => $user_id))) {
                $this->showError('您还未创建简历，请前往创建...', $this->createUrl('/member/resume'));
                exit;
            } else {
                $criteria->compare('user_id', $user_id);
            }
            $view = "show";
        } else {
            if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] > 0) {
                $criteria->compare('user_id', $_REQUEST['user_id']);
            } elseif (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
                $criteria->compare('t.id', $_REQUEST['id']);
            }
            $view = 'view';
        }
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

    public function actionFavorite() {
        $user_id = numeric(Yii::app()->user->id);
        $resume_id = numeric($_POST['resume_id']);
        $user_type = numeric(Yii::app()->user->getState('user_type'));
        if (!$user_id) {
            echo json_encode(array('status' => 0, 'messages' => '未登录'));
            exit;
        }
        if ($user_type == 0) {
            echo json_encode(array('status' => 0, 'messages' => '个人身份无法收藏'));
            exit;
        } else {
            if (ResumeFavoriteModel::model()->find('user_id = :user_id and resume_id = :resume_id', array(':user_id' => $user_id, ':resume_id' => $resume_id))) {
                echo json_encode(array('status' => 0, 'messages' => '您已经收藏过了！'));
                exit;
            } else {
                $model = new ResumeFavoriteModel();
                $model->user_id = $user_id;
                $model->resume_id = $resume_id;
                $model->created = time();
                if ($model->save()) {
                    echo json_encode(array('status' => 1, 'messages' => '收藏成功！'));
                    exit;
                }
            }
        }
    }

}
