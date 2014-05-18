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

<?php echo $form->textAreaRow($model, 'content', array()); ?>
<?php echo $form->dropDownListRow($model, 'stars',array(5=>'5星',4=>'4星',3=>'3星',2=>'2星',1=>'1星') ) ?>
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
    imageUploader.setPostParams({
        "action": "/project/upload/up.php"
    });
</script>
