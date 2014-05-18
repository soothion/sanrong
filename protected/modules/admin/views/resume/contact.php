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
    <a href="<?php echo $this->createUrl('/admin/resume/account',array('id'=>$model->id)); ?>" >我的资料</a>
    <a  class="on" href="javascript:;">联系方式</a>
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
        'action' => $this->createUrl('contact_save'),
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
        <tr <?php if (array_key_exists('mobile', $resume_log_content)): ?> class="<?php echo $resume_log_content['mobile']['color'] ?>" <?php endif ?>>
            <td>手机：</td>
            <td>
                <?php echo $form->textField($model, 'mobile') ?>
            </td>
        </tr>
        <tr <?php if (array_key_exists('phone', $resume_log_content)): ?> class="<?php echo $resume_log_content['phone']['color'] ?>" <?php endif ?>>
            <td>电话：</td>
            <td>
                <?php echo $form->textField($model, 'phone') ?>
            </td>
        </tr>
        <tr <?php if (array_key_exists('qq', $resume_log_content)): ?> class="<?php echo $resume_log_content['qq']['color'] ?>" <?php endif ?>>
            <td>QQ：</td>
            <td>
                <?php echo $form->textField($model, 'qq') ?>
            </td>
        </tr>
        <tr <?php if (array_key_exists('contact_address', $resume_log_content)): ?> class="<?php echo $resume_log_content['contact_address']['color'] ?>" <?php endif ?>>
            <td>通讯地址：</td>
            <td>
                <?php echo $form->textField($model, 'contact_address') ?>
            </td>
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
<script type="text/javascript" src="/static/jquery/jquery.js"></script><link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-datetimepicker.zh-CN.js"></script>
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
