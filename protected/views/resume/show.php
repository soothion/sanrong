<style type="text/css">
    .red{color:red}
    .green{color:green}
</style>
<?php
$user_id = Yii::app()->user->id;
$resumeLogModel = ResumeLogModel::model()->find('user_id = :user_id', array(':user_id' => $user_id));
$account_arr = array(
    'username', 'gender', 'marry_status', 'birthday', 'height', 'weight', 'graduate_school', 'graduate_time', 'education', 'major_first_id', 'major_second_id',
    'grade', 'resume_speciality_id', 'eyesight', 'foreign_lang_first', 'foreign_lang_second', 'computer_level', 'work_year', 'resume_technical_titles_id',
    'healthy', 'account_where_id', 'birthplace_id', 'one_size_photo', 'one_size_photo', 'resume_technical_titles_second_id', 'political_status',
);
$contact_arr = array(
    'mobile', 'phone', 'qq', 'contact_address',
);
$description_arr = array('description');
$extracurricular_arr = array('extracurricular');

$purpose_arr = array(
    'apply_job_type_id', 'wish_job_place_id', 'wish_treatment_id', 'other_weal', 'resume_position_id', 'apply_job_status',
    'wish_part_time_treatment_id', 'part_time_type'
);

$education_arr = array(
    'from_time', 'to_time', 'school', 'major', 'certificate', 'gain'
);
$train_arr = array(
    'from_time', 'to_time', 'organization_name', 'major', 'certificate', 'gain'
);
$experience_arr = array(
    'from_time', 'to_time', 'company_name', 'position', 'business_card', 'work_highlight'
);
$log = array(
    'account' => array('class' => '', 'value' => ''),
    'contact' => array('class' => '', 'value' => ''),
    'description' => array('class' => '', 'value' => ''),
    'extracurricular' => array('class' => '', 'value' => ''),
    'purpose' => array('class' => '', 'value' => ''),
    'education' => array('class' => '', 'value' => ''),
    'train' => array('class' => '', 'value' => ''),
    'experience' => array('class' => '', 'value' => ''),
);
if (isset($resumeLogModel)) {
    $log_content = json_decode($resumeLogModel->content, TRUE);
    if (isset($log_content['user_resume'])) {
        $account_status = 1;
        $contact_status = 1;
        $description_status = 1;
        $extracurricular_status = 1;
        foreach ($log_content['user_resume'] as $v) {
            foreach ($account_arr as $val) {
                if (isset($v[$val])) {
                    $account_status = $account_status * $v[$val]['status'];
                } else {
                    $account_status = 0;
                }
            }
            foreach ($contact_arr as $val) {
                if (isset($v[$val])) {
                    $contact_status = $contact_status * $v[$val]['status'];
                } else {
                    $contact_status = 0;
                }
            }
            foreach ($description_arr as $val) {
                if (isset($v[$val])) {
                    $description_status = $description_status * $v[$val]['status'];
                } else {
                    $description_status = 0;
                }
            }
            foreach ($extracurricular_arr as $val) {
                if (isset($v[$val])) {
                    $extracurricular_status = $extracurricular_status * $v[$val]['status'];
                } else {
                    $extracurricular_status = 0;
                }
            }
        }
        if ($account_status > 1) {
            $account_status = 2;
        }
        if ($contact_status > 1) {
            $contact_status = 2;
        }
        if ($description_status > 1) {
            $description_status = 2;
        }
        if ($extracurricular_status > 1) {
            $extracurricular_status = 2;
        }
        if ($account_status == 1) {
            $account_class = "green";
        } else {
            $account_class = "red";
        }
        if ($contact_status == 1) {
            $contact_class = "green";
        } else {
            $contact_class = "red";
        }
        if ($description_status == 1) {
            $description_class = "green";
        } else {
            $description_class = "red";
        }
        if ($extracurricular_status == 1) {
            $extracurricular_class = "green";
        } else {
            $extracurricular_class = "red";
        }
        $log['account'] = array('class' => $account_class, 'value' => ResumeLogModel::model()->get_log_status($account_status));
        $log['contact'] = array('class' => $contact_class, 'value' => ResumeLogModel::model()->get_log_status($contact_status));
        $log['description'] = array('class' => $description_class, 'value' => ResumeLogModel::model()->get_log_status($description_status));
        $log['extracurricular'] = array('class' => $extracurricular_class, 'value' => ResumeLogModel::model()->get_log_status($extracurricular_status));
    }

    if (isset($log_content['user_education'])) {
        $education_status = 1;
        foreach ($log_content['user_education'] as $v) {
            foreach ($education_arr as $val) {
                if (isset($v[$val])) {
                    $education_status = $education_status * $v[$val]['status'];
                }
            }
        }
        if ($education_status > 1) {
            $education_status = 2;
        }
        if ($education_status == 1) {
            $education_class = 'green';
        } else {
            $education_class = 'red';
        }
        $log['education'] = array('class' => $education_class, 'value' => ResumeLogModel::model()->get_log_status($education_status));
    }
    if (isset($log_content['user_experience'])) {
        $experience_status = 1;
        foreach ($log_content['user_experience'] as $v) {
            foreach ($experience_arr as $val) {
                if (isset($v[$val])) {
                    $experience_status = $experience_status * $v[$val]['status'];
                }
            }
        }
        if ($experience_status > 1) {
            $experience_status = 2;
        }
        if ($experience_status == 1) {
            $experience_class = 'green';
        } else {
            $experience_class = 'red';
        }
        $log['experience'] = array('class' => $experience_class, 'value' => ResumeLogModel::model()->get_log_status($experience_status));
    }
    if (isset($log_content['user_purpose'])) {
        $purpose_status = 1;
        foreach ($log_content['user_purpose'] as $v) {
            foreach ($purpose_arr as $val) {
                if (isset($v[$val])) {
                    $purpose_status = $purpose_status * $v[$val]['status'];
                }
            }
        }
        if ($purpose_status > 1) {
            $purpose_status = 2;
        }
        if ($purpose_status == 1) {
            $purpose_class = 'green';
        } else {
            $purpose_class = 'red';
        }

        $log['purpose'] = array('class' => $purpose_class, 'value' => ResumeLogModel::model()->get_log_status($purpose_status));
    }
    if (isset($log_content['user_train'])) {
        $train_status = 1;
        foreach ($log_content['user_train'] as $v) {
            foreach ($train_arr as $val) {
                if (isset($v[$val])) {
                    $train_status = $train_status * $v[$val]['status'];
                }
            }
        }
        if ($train_status > 1) {
            $train_status = 2;
        }
        if ($train_status == 1) {
            $train_class = 'green';
        } else {
            $train_class = 'red';
        }
        $log['train'] = array('class' => $train_class, 'value' => ResumeLogModel::model()->get_log_status($train_status));
    }
}
?>
<!--主体开始-->
<div class="wrap">
    <!--筛选器开始-->
    <div class="rc_s">
        <div class="rc_s_tit">
            <h1>个人简历</h1>
            <p>简历编号：<?php echo get_resume_id($model->id) ?>  更新日期：<?php echo date('Y-m-d H:i:s', $model->updated) ?></p>
        </div>
        <div class="rc_s_con">
            <h2>基本资料<span style="margin-left:100px" class="<?php echo $log['account']['class'] ?>"><?php echo $log['account']['value'] ?></span></h2>
            <ul class="xx">
                <div class="xxcon">
                    <li><b>姓　　名：</b><?php echo $model->username; ?></li>
                    <li><b>性　　别：</b><?php echo UserResumeModel::model()->gender_arr($model->gender); ?></li>
                    <li><b>身　　高：</b><?php echo $model->height ?></li>
                    <li><b>体　　重：</b><?php echo $model->weight; ?></li>
                    <li><b>出生年月：</b><?php echo date('Y-m', $model->birthday) ?></li>
                    <li><b>视力状况：</b><?php echo UserResumeModel::model()->eyesight_arr($model->eyesight) ?></li>
                    <li><b>健康情况：</b><?php echo UserResumeModel::model()->healthy_arr($model->healthy) ?></li>
                    <li><b>政治面貌：</b><?php echo UserResumeModel::model()->political_status_arr($model->political_status) ?></li>
                    <li><b>婚姻状况：</b><?php echo UserResumeModel::model()->marry_arr($model->marry_status) ?></li>
                    <li><b>学　　历：</b><?php echo UserResumeModel::model()->education_arr($model->education) ?></li>
                    <li><b>年　　级：</b><?php echo UserResumeModel::model()->get_grade_arr($model->grade) ?></li>
                    <li><b>毕业院校：</b><?php echo $model->graduate_school ?></li>
                    <li><b>毕业时间：</b><?php echo date('Y-m-d', $model->graduate_time) ?></li>
                    <li><b>第一专业：</b><?php echo $model->major_first ? $model->major_first->name : "" ?></li>
                    <li><b>第二专业：</b><?php echo $model->major_second ? $model->major_second->name : "" ?></li>
                    <li><b>第一外语：</b><?php echo $model->foreign_lang_first ?></li>
                    <li><b>第二外语：</b><?php echo $model->foreign_lang_second ?></li>
                    <li><b>第一职称：</b><?php echo $model->technical_titles_first ? $model->technical_titles_first->name : '' ?></li>
                    <li><b>第二职称：</b><?php echo $model->technical_titles_second ? $model->technical_titles_second->name : '' ?></li>
                    <li><b>电脑水平：</b><?php echo UserResumeModel::model()->computer_level_arr($model->computer_level) ?></li>
                    <li><b>技能特长：</b><?php echo $model->resume_speciality ? $model->resume_speciality->name : "" ?></li>
                    <li><b>工作年限：</b><?php echo UserResumeModel::model()->work_year_arr($model->work_year) ?></li>
                    <li><b>籍　　贯：</b><?php echo $model->birthplace ? $model->birthplace->name : "" ?></li>
                    <li><b>户口所在地：</b><?php echo $model->account_where ? $model->account_where->name : "" ?></li>
                </div>
                <div class="xxpic"><img src="<?php echo $model->one_size_photo ?>" width="150" height="210" /></div>
                <div class="clear"></div>
            </ul>
            <h2>联系方式<span style="margin-left:100px" class="<?php echo $log['contact']['class'] ?>"><?php echo $log['contact']['value'] ?></span></h2>
            <ul>
                <li><b>手机：</b><?php echo $model->user ? $model->user->mobile : "" ?></li>
                <li><b>QQ：</b><?php echo $model->qq; ?></li>
                <li><b>E-mail：</b><?php echo $model->user ? $model->user->email : "" ?></li>
                <li class="w900"><b>通讯地址：</b><?php echo $model->contact_address ?></li>
                <div class="clear"></div>
            </ul>

            <h2>个人描述<span style="margin-left:100px" class="<?php echo $log['description']['class'] ?>" ><?php echo $log['description']['value'] ?></span></h2>
            <?php if (empty($model->description)): ?>

                <?php if (!isset($log_content['user_resume'][$model->id]['description']) || $log_content['user_resume'][$model->id]['description']['status'] != 1): ?>
                    <div style="font-size:14px; margin:20px 0 40px 0;">您还没有填写，请<a href="<?php echo $this->createUrl('/member/resume/description'); ?>">点击这里</a>去完善简历。</div>
                <?php endif; ?>
            <?php else: ?>
                <div class="xxdes">
                    <?php echo $model->description ?>
                </div>
            <?php endif ?>
            <h2>求职意向<span style="margin-left:100px" class="<?php echo $log['purpose']['class'] ?>"><?php echo $log['purpose']['value'] ?></span></h2>
            <?php $purposeModel = UserPurposeModel::model()->findAll('user_id=:user_id', array(':user_id' => Yii::app()->user->id)); ?>
            <?php if (!$purposeModel): ?>
                <?php if (!isset($log_content['user_purpose'][0]['apply_job_type_id']) || $log_content['user_purpose'][0]['apply_job_type_id']['status'] != 1): ?>
                    <div style="font-size:14px; margin:20px 0 40px 0;">您还没有填写，请<a href="<?php echo $this->createUrl('/member/resume/purpose'); ?>">点击这里</a>去完善简历。</div>
                <?php endif; ?>

            <?php else: ?>
                <?php foreach ($purposeModel as $k => $v): ?>
                    <?php if ($v->apply_job_type_id == 1): ?>
                        <ul class="yx">   
                            <li><b>求职类型：</b><?php echo UserPurposeModel::model()->apply_job_type_arr($v->apply_job_type_id); ?></li>                    
                            <li><b>期望待遇：</b><?php echo UserPurposeModel::model()->wish_part_time_treatment_arr($v->wish_part_time_treatment_id); ?></li>
                            <li><b>期望类型：</b><?php
                                $part_time_type = explode(',', $v->part_time_type);
                                foreach ($part_time_type as $val) {
                                    echo UserPurposeModel::model()->get_part_time_type($val) . "  ";
                                }
                                ?></li>
                        </ul>
                    <?php else: ?>

                        <ul class="yx">            
                            <li><b>求职类型：</b><?php echo UserPurposeModel::model()->apply_job_type_arr($v->apply_job_type_id); ?></li>
                            <li><b>期望工作地点：</b><?php echo UserResumeModel::model()->get_area($v->wish_job_place_id) ?></li>
                            <li><b>期望待遇：</b><?php echo UserPurposeModel::model()->wish_treatment_arr($v->wish_treatment_id); ?></li>
                            <li><b>其他福利：</b><?php
                                $other_weal = explode(',', $v->other_weal);
                                foreach ($other_weal as $val) {
                                    echo UserPurposeModel::model()->get_other_weal($val) . "  ";
                                }
                                ?></li>
                            <li><b>应聘职位：</b><?php echo UserPurposeModel::model()->get_position($v->resume_position_id) ?></li>
                            <li><b>求职状态：</b><?php echo UserPurposeModel::model()->apply_job_status_arr($v->apply_job_status); ?></li>
                            <div class="clear"></div>
                        </ul>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <h2>教育背景<span style="margin-left:100px" class="<?php echo $log['education']['class'] ?>"><?php echo $log['education']['value'] ?></span></h2>
            <?php if (!$educationModel): ?>
                <?php if (!isset($log_content['user_education'][0]['from_time']) || $log_content['user_education'][0]['from_time']['status'] != 1): ?>
                    <div style="font-size:14px; margin:20px 0 40px 0;">您还没有填写，请<a href="<?php echo $this->createUrl('/member/resume/education'); ?>">点击这里</a>去完善简历。</div>
                <?php endif; ?>


            <?php else: ?>
                <ul class="jy">  
                    <?php foreach ($educationModel as $k => $v): ?>
                        <li><span><?php echo date('Y年m月', $v->from_time) ?>-<?php echo date('Y年m月', $v->to_time) ?></span><i>|</i><span><?php echo $v->school ?></span><i>|</i><span><?php echo $v->major ?></span><br /><p><b>学习收获：</b><?php echo $v->gain ?></p></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <h2>培训经历<span style="margin-left:100px" class="<?php echo $log['train']['class'] ?>" ><?php echo $log['train']['value'] ?></span></h2>

            <?php if (!$trainModel): ?>
                <?php if (!isset($log_content['user_train'][0]['from_time']) || $log_content['user_train'][0]['from_time']['status'] != 1): ?>
                    <div style="font-size:14px; margin:20px 0 40px 0;">您还没有填写，请<a href="<?php echo $this->createUrl('/member/resume/train'); ?>">点击这里</a>去完善简历。</div>
                <?php endif; ?>

            <?php else: ?>
                <ul class="jy">
                    <?php foreach ($trainModel as $k => $v): ?>
                        <li><span><?php echo date('Y年m月', $v->from_time) ?>-<?php echo date('Y年m月', $v->to_time) ?></span><i>|</i><span><?php echo $v->organization_name ?></span><i>|</i><span><?php echo $v->major ?></span><br /><p><b>学习收获：</b><?php echo $v->gain ?></p></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <h2>工作经历<span style="margin-left:100px" class="<?php echo $log['experience']['class'] ?>"><?php echo $log['experience']['value'] ?></span></h2>
            <?php if (!$experienceModel): ?>
                <?php if (!isset($log_content['user_experience'][0]['from_time']) || $log_content['user_experience'][0]['from_time']['status'] != 1): ?>
                    <div style="font-size:14px; margin:20px 0 40px 0;">您还没有填写，请<a href="<?php echo $this->createUrl('/member/resume/experience'); ?>">点击这里</a>去完善简历。</div>
                <?php endif; ?>

            <?php else: ?>
                <ul class="jy">
                    <?php foreach ($experienceModel as $k => $v): ?>
                        <li><span><?php echo date('Y年m月', $v->from_time) ?>-<?php echo date('Y年m月', $v->to_time) ?></span><i>|</i><span><?php echo $v->company_name ?></span><i>|</i><span><?php echo $v->position ?></span><br /><p><b>工作收获：</b><?php echo $v->work_highlight ?></p></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <h2>课外经历<span style="margin-left:100px" class="<?php echo $log['extracurricular']['class'] ?>"><?php echo $log['extracurricular']['value'] ?></span></h2>
            <?php if (empty($model->extracurricular)): ?>
                <?php if (!isset($log_content['user_resume'][$model->id]['extracurricular']) || $log_content['user_resume'][$model->id]['extracurricular']['status'] -= 1): ?>
                    <div style="font-size:14px; margin:20px 0 40px 0;">您还没有填写，请<a href="<?php echo $this->createUrl('/member/resume/extracurricular'); ?>">点击这里</a>去完善简历。</div>
                <?php endif; ?>
            <?php else: ?>
                <div class="xxdes">
                    <?php echo $model->extracurricular ?>
                </div>
            <?php endif; ?>
            <div class="rc_tool">
                <button onClick="javascript:window.print();" >打印简历</button>
                <?php if (Yii::app()->user->getState('user_type') == 1) : ?><button onClick="favorite(<?php echo $model->id ?>)">加入收藏</button><?php endif; ?>
                <button onClick="window.close()">关闭本页</button>
                <?php if (Yii::app()->user->getState('user_type') == 1) : ?><button onClick="window.location.href = '<?php echo $this->createUrl('/resume') ?>'">返回列表</button><?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function favorite(id) {
        var url = '<?php echo $this->createUrl('/resume/favorite') ?>';
        $.post(url, {resume_id: id}, function(data) {
            alert(data.messages);
        }, 'json');
    }
</script>
<!--主体结束-->