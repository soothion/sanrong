<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker.css" rel="stylesheet" media="screen">
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-datepicker.js"></script>
<?php
$isEdit = !empty($model->id);
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'id-form',
    'type' => 'horizontal',
    'action' => $this->createUrl('save'),
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
<?php echo $form->textFieldRow($model, 'name', array()); ?>
<?php echo $form->textFieldRow($model, 'url', array('placeholder'=>'不用填写http://')); ?>
<?php echo $form->dropDownListRow($model, 'type', AdvertModel::model()->getType()) ?>
<div class="control-group ">
    <label class="control-label" for="AdvertModel_image">图片</label>
    <div class="controls">
        <input id="ytAdvertModel_image" type="hidden" value="" name="image">
        <input name="image" id="AdvertModel_image" type="file">
        <span class="help-inline error" id="AdvertModel_image_em_" style="display: none"></span>
    </div>
</div>
<?php if ($model->image != ''): ?>
    <div class="control-group ">
        <label class="control-label" for="AdvertModel_image"></label>
        <div class="controls">

            <img src="<?php echo getImageUrl($model->image); ?>" width="100" /> <br />
            <input type="checkbox" name="delete_image" value="1" />
            删除图片

        </div>
    </div>
<?php endif; ?>

<?php echo $form->textAreaRow($model, 'content', array('rows' => 5, 'class' => 'input-xxlarge')) ?>
<?php echo $form->dropDownListRow($model, 'status', AdvertModel::model()->getStatus()) ?>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => ' 保 存 ', 'url' => $this->createUrl('save'))); ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-datetimepicker.zh-CN.js"></script>
<script>
    $(function() {
        $('.form_datetime').datepicker({
            format: 'yyyy-mm-dd'
        });
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
//    UE.getEditor('AdvertModel_content', {
//        imagePath: "",
//        imageUrl: "<?php echo $this->createUrl('upload/ue_upload_image'); ?>",
//        //关闭字数统计
//        wordCount: false,
//        //关闭elementPath
//        elementPathEnabled: false,
//        //默认的编辑区域高度
//        initialFrameHeight: 300,
//        initialFrameWidth: 600
//                //更多其他参数，请参考ueditor.config.js中的配置项
//    })
//    imageUploader.setPostParams({
//        "action": "/project/upload/up.php"
//    });
</script>
