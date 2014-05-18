<style type="text/css">
    .tab a{margin:0 10px;padding:2px 10px;text-decoration: none}
    .tab a.on{background:blue;color:white}
    .resume_list{border:1px dotted #CCCCCC;margin-top:20px;padding:10px;}
    .red{color:red}
    .green{color:green}
    tr td:first-child{text-align: right}
    select, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input{margin:0px}

    .uploader-btn{
        border: 1px solid #D3D3D3;
        text-align: center;
        margin-bottom: 10px;
        background: #EEE;
        cursor: pointer;
        color:black;
    }
    .uploadify{float:left;padding-top:30px;}
</style>
<div class="tab">
    <a href="javascript:;" class="on">我的资料</a>
    <a href="<?php echo $this->createUrl('/admin/resume/contact',array('id'=>$model->id)); ?>">联系方式</a>
    <a href="<?php echo $this->createUrl('/admin/resume/description',array('id'=>$model->id)); ?>">个人描述</a>
    <a href="<?php echo $this->createUrl('/admin/resume/purpose',array('id'=>$model->id)); ?>">求职意向</a>
    <a href="<?php echo $this->createUrl('/admin/resume/education',array('id'=>$model->id)); ?>">教育背景</a>
    <a href="<?php echo $this->createUrl('/admin/resume/train',array('id'=>$model->id)); ?>">培训经历</a>
    <a href="<?php echo $this->createUrl('/admin/resume/experience',array('id'=>$model->id)); ?>">工作经验</a>
    <a href="<?php echo $this->createUrl('/admin/resume/extracurricular',array('id'=>$model->id)); ?>">课外经历</a>
</div>
<div class="resume_list">
    <?php
    $isEdit = !empty($model->id);
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'id-form',
        'action' => $this->createUrl('account_save'),
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:afterValidate',
        ),
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
        ),
    ));
    ?>
    <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?php echo $model->id; ?>" />
    <?php endif; ?>
    <table>
        <tr <?php if (array_key_exists('username', $resume_log_content)): ?> class="<?php echo $resume_log_content['username']['color'] ?>" <?php endif ?>>
            <td>姓名：</td>
            <td>
                <?php echo $form->textField($model, 'username') ?>
            </td>
        </tr>
        <tr <?php if (array_key_exists('gender', $resume_log_content)): ?> class="<?php echo $resume_log_content['gender']['color'] ?>" <?php endif ?>>
            <td>性别：</td><td><?php echo $form->dropDownList($model, 'gender', UserResumeModel::model()->gender_arr(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('marry_status', $resume_log_content)): ?> class="<?php echo $resume_log_content['marry_status']['color'] ?>" <?php endif ?>>
            <td>婚姻状况：</td><td><?php echo $form->dropDownList($model, 'marry_status', UserResumeModel::model()->marry_arr(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('political_status', $resume_log_content)): ?> class="<?php echo $resume_log_content['political_status']['color'] ?>" <?php endif ?>>
            <td>政治面貌：</td><td><?php echo $form->dropDownList($model, 'political_status', UserResumeModel::model()->political_status_arr(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('birthday', $resume_log_content)): ?> class="<?php echo $resume_log_content['birthday']['color'] ?>" <?php endif ?>>
            <td>出生年月：</td><td><?php echo $form->textField($model, 'birthday', array('class' => 'birthday_date')) ?></td>
        </tr>
        <tr <?php if (array_key_exists('height', $resume_log_content)): ?> class="<?php echo $resume_log_content['height']['color'] ?>" <?php endif ?>>
            <td>身高：</td><td><?php echo $form->textField($model, 'height') ?></td>
        </tr>
        <tr <?php if (array_key_exists('weight', $resume_log_content)): ?> class="<?php echo $resume_log_content['weight']['color'] ?>" <?php endif ?>>
            <td>体重：</td><td><?php echo $form->textField($model, 'weight') ?></td>
        </tr>
        <tr <?php if (array_key_exists('graduate_school', $resume_log_content)): ?> class="<?php echo $resume_log_content['graduate_school']['color'] ?>" <?php endif ?>>
            <td>毕业院校：</td><td><?php echo $form->textField($model, 'graduate_school') ?></td>
        </tr>
        <tr <?php if (array_key_exists('graduate_time', $resume_log_content)): ?> class="<?php echo $resume_log_content['graduate_time']['color'] ?>" <?php endif ?>>
            <td>毕业时间：</td><td><?php echo $form->textField($model, 'graduate_time', array('class' => 'datepicker')) ?></td>
        </tr>
        <tr <?php if (array_key_exists('education', $resume_log_content)): ?> class="<?php echo $resume_log_content['education']['color'] ?>" <?php endif ?>>
            <td>学历：</td><td><?php echo $form->dropDownList($model, 'education', UserResumeModel::model()->education_arr(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('major_first_id', $resume_log_content)): ?> class="<?php echo $resume_log_content['major_first_id']['color'] ?>" <?php endif ?>>
            <td>第一专业：</td><td><?php echo $form->dropDownList($model, 'major_first_id', UserResumeModel::model()->get_major(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('major_second_id', $resume_log_content)): ?> class="<?php echo $resume_log_content['major_second_id']['color'] ?>" <?php endif ?>>
            <td>第二专业：</td><td><?php echo $form->dropDownList($model, 'major_second_id', UserResumeModel::model()->get_major(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('grade', $resume_log_content)): ?> class="<?php echo $resume_log_content['grade']['color'] ?>" <?php endif ?>>
            <td>年级：</td><td><?php echo $form->dropDownList($model, 'grade', UserResumeModel::model()->get_grade_arr(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('resume_speciality_id', $resume_log_content)): ?> class="<?php echo $resume_log_content['resume_speciality_id']['color'] ?>" <?php endif ?>>
            <td>技能特长：</td><td><?php echo $form->dropDownList($model, 'resume_speciality_id', UserResumeModel::model()->get_speciality(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('eyesight', $resume_log_content)): ?> class="<?php echo $resume_log_content['eyesight']['color'] ?>" <?php endif ?>>
            <td>视力状况：</td><td><?php echo $form->dropDownList($model, 'eyesight', UserResumeModel::model()->eyesight_arr(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('foreign_lang_first', $resume_log_content)): ?> class="<?php echo $resume_log_content['foreign_lang_first']['color'] ?>" <?php endif ?>>
            <td>第一外语：</td><td><?php echo $form->textField($model, 'foreign_lang_first') ?></td>
        </tr>
        <tr <?php if (array_key_exists('foreign_lang_second', $resume_log_content)): ?> class="<?php echo $resume_log_content['foreign_lang_second']['color'] ?>" <?php endif ?>>
            <td>第二外语：</td><td><?php echo $form->textField($model, 'foreign_lang_second') ?></td>
        </tr>
        <tr <?php if (array_key_exists('computer_level', $resume_log_content)): ?> class="<?php echo $resume_log_content['computer_level']['color'] ?>" <?php endif ?>>
            <td>电脑水平：</td><td><?php echo $form->dropDownList($model, 'computer_level', UserResumeModel::model()->computer_level_arr(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('work_year', $resume_log_content)): ?> class="<?php echo $resume_log_content['work_year']['color'] ?>" <?php endif ?>>
            <td>工作年限：</td><td><?php echo $form->dropDownList($model, 'work_year', UserResumeModel::model()->work_year_arr(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('resume_technical_titles_id', $resume_log_content)): ?> class="<?php echo $resume_log_content['resume_technical_titles_id']['color'] ?>" <?php endif ?>>
            <td>第一职称：</td><td><?php echo $form->dropDownList($model, 'resume_technical_titles_id', UserResumeModel::model()->get_technical_titles(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('resume_technical_titles_second_id', $resume_log_content)): ?> class="<?php echo $resume_log_content['resume_technical_titles_second_id']['color'] ?>" <?php endif ?>>
            <td>第二职称：</td><td><?php echo $form->dropDownList($model, 'resume_technical_titles_second_id', UserResumeModel::model()->get_technical_titles(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('healthy', $resume_log_content)): ?> class="<?php echo $resume_log_content['healthy']['color'] ?>" <?php endif ?>>
            <td>健康情况：</td><td><?php echo $form->dropDownList($model, 'healthy', UserResumeModel::model()->healthy_arr(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('account_where_id', $resume_log_content)): ?> class="<?php echo $resume_log_content['account_where_id']['color'] ?>" <?php endif ?>>
            <td>户口所在地：</td><td><?php echo $form->dropDownList($model, 'account_where_id', UserResumeModel::model()->get_area(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('birthplace_id', $resume_log_content)): ?> class="<?php echo $resume_log_content['birthplace_id']['color'] ?>" <?php endif ?>>
            <td>籍贯：</td><td><?php echo $form->dropDownList($model, 'birthplace_id', UserResumeModel::model()->get_area(), array('prompt' => '请选择')); ?></td>
        </tr>
        <tr <?php if (array_key_exists('one_size_photo', $resume_log_content)): ?> class="<?php echo $resume_log_content['one_size_photo']['color'] ?>" <?php endif ?>>
            <td>一寸照片：</td>
            <td><input  type="file" id="one_size_photo" /><input type="hidden" name="UserResumeModel[one_size_photo]" value="" id="one_size_photo_submit" />
                <img src="<?php if (isset($model->one_size_photo) && !empty($model->one_size_photo)) echo $model->one_size_photo ?>" width="100" alt="" id="one_size_pic" />
                <div class="clearfix"></div></td>
        </tr>
        <tr>
            <td><label class="control-label" for="GrouponGoodsModel_m_price">审核状态：</label></td>
            <td>
                <div class="controls">
                    <label class="radio inline">
                        <input id="GrouponGoodsModel_is_top_0" value="1" type="radio" checked="checked" name="status">
                        <label for="GrouponGoodsModel_is_top_0">通过</label>                            
                    </label>
                    <label class="radio inline">
                        <input id="GrouponGoodsModel_is_top_1" value="0"  type="radio" name="status">
                        <label for="GrouponGoodsModel_is_top_1">未通过</label>                            
                    </label>
                </div>
        </tr>
        <tr><td>审核原因：</td><td><input type="text" name="reason" /></td></tr>
    </table>
    <div class="form-actions">
        <button class="btn" type="submit" name="yt0"> 保 存 </button></div>
        <?php $this->endWidget(); ?>
</div>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<script type="text/javascript" src="/static/jquery/jqueryui/js/jquery-ui-1.8.14.custom.min.js"></script> 
<script type="text/javascript" src="/static/jquery/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript">
    $(function() {
        $("#one_size_photo").uploadify({
            height: 30,
            swf: '/static/jquery/uploadify/uploadify.swf',
            uploader: '<?php echo $this->createUrl("/admin/upload/uploadify_image"); ?>',
            width: 120,
            buttonText: '请上传一寸照片',
            buttonClass: 'uploader-btn',
            'onUploadSuccess': function(file, data, response) {
                var data = eval("(" + data + ")");
                $('#one_size_photo_submit').val(data.file);
                $('#one_size_pic').attr('src', data.file);
            }
        });
    });
    $('.birthday_date').datetimepicker({
        language: 'zh-CN',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 3,
        forceParse: 0,
        format: 'yyyy-mm-dd'
    });
    $('.datepicker').datetimepicker({
        language: 'zh-CN',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 3,
        minView: 3,
        forceParse: 0,
        format: 'yyyy-mm'
    });
    function afterValidate(form, data, hasError) {
        if (hasError == false) {
            ajaxFormSubmit("#id-form", 'successfun');
        }
        return false;
    }
    ;
    function successfun(data) {
        setTimeout("history.go(-1);", 1000);
    }
</script>
