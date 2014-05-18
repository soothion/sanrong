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
    .other_weal input,.other_weal label{display: inline}
</style>
<div class="tab">
    <a href="<?php echo $this->createUrl('/admin/resume/account', array('id' => $id)); ?>">我的资料</a>
    <a href="<?php echo $this->createUrl('/admin/resume/contact', array('id' => $id)); ?>">联系方式</a>
    <a href="<?php echo $this->createUrl('/admin/resume/description', array('id' => $id)); ?>">个人描述</a>
    <a href="<?php echo $this->createUrl('/admin/resume/education', array('id' => $id)); ?>">求职意向</a>
    <a  class="on" href="javascript:;">教育背景</a>
    <a href="<?php echo $this->createUrl('/admin/resume/train', array('id' => $id)); ?>">培训经历</a>
    <a href="<?php echo $this->createUrl('/admin/resume/experience', array('id' => $id)); ?>">工作经验</a>
    <a href="<?php echo $this->createUrl('/admin/resume/extracurricular', array('id' => $id)); ?>">课外经历</a>
</div>

<div class="resume_list">
    <?php foreach ($allModel as $v): ?>
        <table class="items table table-bordered">
            <thead>
                <tr>
                    <th>内容</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo date('Y-m',$v->from_time) ?>---<?php echo date('Y-m',$v->to_time) ?></td><td><a href="<?php echo $this->createUrl('education', array('id' => $id, 'education_id' => $v->id)) ?>">修改</a></td>
                </tr>
            </tbody>
        </table>
    <?php endforeach ?>
   
        <?php
        $isEdit = !empty($model->id);
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'id-form',
            'action' => $this->createUrl('education_save'),
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
             <?php if (isset($model)): ?>
            <tbody class="full-time">
                <tr <?php if (array_key_exists('from_time', $resume_log_content)): ?> class="<?php echo $resume_log_content['from_time']['color'] ?>" <?php endif ?>>
                    <td>起始时间：</td>
                    <td>
                        <?php echo $form->textField($model, 'from_time', array('class' => 'datepicker')) ?>
                    </td>
                </tr>
                <tr <?php if (array_key_exists('to_time', $resume_log_content)): ?> class="<?php echo $resume_log_content['to_time']['color'] ?>" <?php endif ?>>
                    <td>结束时间：</td>
                    <td>
                        <?php echo $form->textField($model, 'to_time', array('class' => 'datepicker')) ?>
                    </td>
                </tr>
                <tr <?php if (array_key_exists('school', $resume_log_content)): ?> class="<?php echo $resume_log_content['school']['color'] ?>" <?php endif ?>>
                    <td>所在院校：</td>
                    <td class="other_weal">
                        <?php echo $form->textField($model, 'school') ?>
                    </td>
                </tr>
                <tr <?php if (array_key_exists('major', $resume_log_content)): ?> class="<?php echo $resume_log_content['major']['color'] ?>" <?php endif ?>>
                    <td>所学专业：</td>
                    <td>
                        <?php echo $form->textField($model, 'major') ?>
                    </td>
                </tr>
                <tr <?php if (array_key_exists('certificate', $resume_log_content)): ?> class="<?php echo $resume_log_content['certificate']['color'] ?>" <?php endif ?>>
                    <td>上传证书：</td>
                    <td>
                        <input type="file" name="certificate" id="" />（zip包）<?php if(isset($model->certificate) && !empty($model->certificate)): ?><a href="<?php echo $model->certificate ?>">下载</a><?php endif; ?>
                    </td>
                </tr>
                <tr <?php if (array_key_exists('gain', $resume_log_content)): ?> class="<?php echo $resume_log_content['gain']['color'] ?>" <?php endif ?>>
                    <td>学习收获：</td>
                    <td>
                        <?php echo $form->textArea($model, 'gain') ?>
                    </td>
                </tr>
            </tbody>
             <?php else: ?>
            用户未添加信息
            <?php endif; ?>
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
            <input type="hidden" name="resume_id" value="<?php echo $id ?>" />
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
    UE.getEditor('UserResumeModel_description', {
        imagePath: "",
        imageUrl: "<?php echo $this->createUrl('upload/ue_upload_image'); ?>",
        //关闭字数统计
        wordCount: false,
        //关闭elementPath
        elementPathEnabled: false,
        //默认的编辑区域高度
        initialFrameHeight: 300,
        initialFrameWidth: 600
                //更多其他参数，请参考ueditor.config.js中的配置项
    })
</script>
