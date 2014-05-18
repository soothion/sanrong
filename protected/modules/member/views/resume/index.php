<!--<script type="text/javascript" src="/static/js/datepicker/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/static/js/datepicker/js/jquery.datePicker-min.js"></script>
<link type="text/css" href="/static/js/datepicker/css/datepicker.css" rel="stylesheet" />-->
<link href="/static/js/bootstrap-datetimepicker/v2/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="/static/js/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<style type="text/css">
    .reg_type{text-align: center}
    .uploader-btn{
        border: 1px solid #D3D3D3;
        text-align: center;
        margin-bottom: 10px;
        background: #EEE;
        cursor: pointer;
    }
    .jl_xq li b,.jl_xq li .uploadify{float:left}
</style>
<div class='main'>
    <div class='wrap'>
        <div class="u_main fl">

            <!--左栏 团购列表开始-->   
            <?php $this->renderPartial('../common/member_header') ?>
            <?php
            $isEdit = !empty($model->id);
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'id-form',
                'action' => $this->createUrl('index_save'),
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
            <ul class="jl_xq">
                <div class="log_res">
                    <?php
                    if (isset($log_res)) {
                        echo $log_res['status'];
                        if (!empty($log['info'])) {
                            echo $log['info'];
                        }
                    }
                    ?>
                </div>
                <li><b>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</b><?php echo $form->textField($model, 'username') ?></li>
                <li><b>性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别</b><?php echo $form->dropDownList($model, 'gender', UserResumeModel::model()->gender_arr(), array('prompt' => '请选择')); ?></li>
                <li><b>身&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高</b><?php echo $form->textField($model, 'height') ?></li>
                <li><b>体&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;重</b><?php echo $form->textField($model, 'weight') ?></li>                
                <li><b>出生年月</b><?php echo $form->textField($model, 'birthday', array('class' => 'birthday_date')) ?>&nbsp;<span style="font-size:12px">  筛选器提示：点击年份可快速筛选年份,格式：1990-1-1</span></li>
                <li><b>视力状况</b><?php echo $form->dropDownList($model, 'eyesight', UserResumeModel::model()->eyesight_arr(), array('prompt' => '请选择')); ?></li>                
                <li><b>健康情况</b><?php echo $form->dropDownList($model, 'healthy', UserResumeModel::model()->healthy_arr(), array('prompt' => '请选择')); ?></li>               
                <!--<li><b>年龄</b><?php echo $form->dropDownList($model, 'age', UserResumeModel::model()->age_arr(), array('prompt' => '请选择')); ?></li>-->
                <li><b>政治面貌</b><?php echo $form->dropDownList($model, 'political_status', UserResumeModel::model()->political_status_arr(), array('prompt' => '请选择')); ?></li>
                <li><b>婚姻状况</b><?php echo $form->dropDownList($model, 'marry_status', UserResumeModel::model()->marry_arr(), array('prompt' => '请选择')); ?></li>
                <li><b>学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;历</b><?php echo $form->dropDownList($model, 'education', UserResumeModel::model()->education_arr(), array('prompt' => '请选择')); ?></li>
                <li><b>年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;级</b><?php echo $form->dropDownList($model, 'grade', UserResumeModel::model()->get_grade_arr(), array('prompt' => '请选择')); ?>  毕业生可选题</li>
                <li><b>毕业院校</b><?php echo $form->textField($model, 'graduate_school') ?></li>
                <li><b>毕业时间</b><?php echo $form->textField($model, 'graduate_time', array('class' => 'datepicker')) ?>  在校生可选择预计毕业时间</li>

                <li><b>第一专业</b><?php echo $form->dropDownList($model, 'major_first_id', UserResumeModel::model()->get_major(), array('prompt' => '请选择')); ?></li>
                <li><b>第二专业</b><?php echo $form->dropDownList($model, 'major_second_id', UserResumeModel::model()->get_major(), array('prompt' => '请选择')); ?></li>
                <li><b>第一外语</b><?php echo $form->textField($model, 'foreign_lang_first') ?></li>
                <li><b>第二外语</b><?php echo $form->textField($model, 'foreign_lang_second') ?></li>
                <li><b>第一职称</b><?php echo $form->dropDownList($model, 'resume_technical_titles_id', UserResumeModel::model()->get_technical_titles(), array('prompt' => '请选择')); ?>  请选择同一行业的最高职称</li>
                <li><b>第二职称</b><?php echo $form->dropDownList($model, 'resume_technical_titles_second_id', UserResumeModel::model()->get_technical_titles(), array('prompt' => '请选择')); ?>  请选择同一行业的最高职称</li>
                <li><b>电脑水平</b><?php echo $form->dropDownList($model, 'computer_level', UserResumeModel::model()->computer_level_arr(), array('prompt' => '请选择')); ?></li>
                <li><b>技能特长</b><?php echo $form->dropDownList($model, 'resume_speciality_id', UserResumeModel::model()->get_speciality(), array('prompt' => '请选择')); ?></li>


                <li><b>工作年限</b><?php echo $form->dropDownList($model, 'work_year', UserResumeModel::model()->work_year_arr(), array('prompt' => '请选择')); ?></li>
                <li><b>籍&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;贯</b><?php echo $form->dropDownList($model, 'birthplace_id', UserResumeModel::model()->get_area(), array('prompt' => '请选择')); ?></li>

                <li><b>户口所在地</b><?php echo $form->dropDownList($model, 'account_where_id', UserResumeModel::model()->get_area(), array('prompt' => '请选择')); ?></li>

                <li><b>一寸照片</b><input  type="file" id="one_size_photo" />
                    <?php //if ($model->one_size_photo != ''):  ?>
                    <!--                        <div style="padding-left:110px;padding-top:10px">
                                                <img src="<?php //echo getImageUrl($model->one_size_photo);       ?>" width="100" /> <br />
                                                <input type="checkbox" name="delete_one_size_photo" value="1" />
                                                删除照片
                                            </div>-->
                    <?php //endif;  ?>
                    <input type="hidden" name="UserResumeModel[one_size_photo]" value="" id="one_size_photo_submit" />
                    <img src="<?php if (isset($model->one_size_photo) && !empty($model->one_size_photo)) echo $model->one_size_photo ?>" width="100" alt="" id="one_size_pic" />
                    <div class="clearfix"></div>
                </li>
<!--    <input type="hidden" name="ajax" value="1" />-->
                <div class="lbtn"><input name="" type="submit" value="提交"  class="submit_btn" /></div>
            </ul>
            <?php $this->endWidget(); ?>
        </div>
        <?php echo $this->renderPartial('../common/fr') ?>
        <div class="clear"></div>
    </div>
</div>


<script type="text/javascript" src="/static/js/bootstrap-datetimepicker/v3/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="/static/js/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript" src="/static/jquery/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript">
    $(function() {
        $("#one_size_photo").uploadify({
            height: 30,
            swf: '/static/jquery/uploadify/uploadify.swf',
            uploader: '<?php echo $this->createUrl("/upload/uploadify_image"); ?>',
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
        setTimeout("location.href='" + data.goUrl + "';", 1000);
    }
</script>

<!--左栏 团购列表结束--> 