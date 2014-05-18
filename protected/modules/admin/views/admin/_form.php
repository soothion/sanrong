<?php
$isEdit = !empty($model->id);
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'id-form',
    'type' => 'horizontal',
	'action'=>$this->createUrl('save'),
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
<?php echo $form->textFieldRow($model, 'username', array('class'=>'input-xlarge')); ?>
<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'input-large')); ?>
<?php echo $form->dropdownlistRow($model, 'role_id',array2keyname(object2array(AdminRoleModel::model()->findAll()), 'id', 'name'), array('class'=>'input-large')); ?>
<div class="form-actions">
  <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>' 保 存 ','url'=>$this->createUrl('save'))); ?>
</div>
<?php $this->endWidget(); ?>
<script>
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
