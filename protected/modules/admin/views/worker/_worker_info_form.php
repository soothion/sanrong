<script type="text/javascript" src="/static/jquery/jquery.js"></script>
<?php
$isEdit = !empty($model->id);
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'id-form',
    'type' => 'horizontal',
	'action'=>$this->createUrl('worker_info_save'),
	'enableAjaxValidation'=>true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'afterValidate'=>'js:afterValidate',
	),
		
)); ?>
<?php if($isEdit):?>

<input type="hidden" name="id" value="<?php echo $model->id;?>" />
<?php endif;?>
<input type="hidden" name='worker_id' value="<?php echo $WorkerModel->id ?>" />
<?php echo $form->textFieldRow($WorkerModel, 'username', array('class'=>'input-xlarge','disabled'=>'true')); ?>
<?php echo $form->textFieldRow($model, 'score', array('class'=>'input-xlarge')); ?>
<?php echo $form->textAreaRow($model, 'content', array('class'=>'input-xlarge')); ?>
<?php echo $form->dropDownListRow($model, 'status', WorkerInfoModel::model()->getStatus("",array(0=>4))) ?>
<?php echo $form->textFieldRow($model, 'operated', array('class' => 'form_datetime')); ?>
<div class="form-actions">
  <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>' 保 存 ','url'=>$this->createUrl('save'))); ?>
</div>
<?php $this->endWidget(); ?>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-datetimepicker.zh-CN.js"></script>
<script>
    $(".form_datetime").datetimepicker({
        format: 'yyyy-mm-dd',
        language: 'zh-CN',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
function afterValidate(form, data, hasError){
	if(hasError==false){
		ajaxFormSubmit("#id-form",'successfun');
	}
	return false;
};
function successfun(data){
	setTimeout("history.go(-1);",1000);
}
</script> 
