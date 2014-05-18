<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-model-profile-form',
	'enableAjaxValidation'=>false,
)); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_list table_dash">
  <tr>
    <td width="100" align="right">用户名：</td>
    <td><?php echo $model->username;?></td>
  </tr>
  <tr>
    <td align="right"><?php echo $form->labelEx($model,'email'); ?>：</td>
    <td><?php echo $form->textField($model,'email',array('class'=>'input w180')); ?> <?php echo $form->error($model,'email'); ?></td>
  </tr>
  <tr>
    <td align="right"><?php echo $form->labelEx($model,'baby_name'); ?>：</td>
    <td><?php echo $form->textField($model,'baby_name',array('class'=>'input w180')); ?> <?php echo $form->error($model,'baby_name'); ?></td>
  </tr>
  <tr>
    <td align="right"><?php echo $form->labelEx($model,'baby_age'); ?>：</td>
    <td><?php echo $form->textField($model,'baby_age',array('class'=>'input w180')); ?> <?php echo $form->error($model,'baby_age'); ?></td>
  </tr>
  <tr>
    <td align="right"><?php echo $form->labelEx($model,'parent_name'); ?>：</td>
    <td><?php echo $form->textField($model,'parent_name',array('class'=>'input w180')); ?> <?php echo $form->error($model,'parent_name'); ?></td>
  </tr>
  <tr>
    <td align="right"><?php echo $form->labelEx($model,'relationship'); ?>：</td>
    <td><?php echo $form->textField($model,'relationship',array('class'=>'input w180')); ?> <?php echo $form->error($model,'relationship'); ?></td>
  </tr>
  <tr>
    <td align="right"><?php echo $form->labelEx($model,'qq'); ?>：</td>
    <td><?php echo $form->textField($model,'qq',array('class'=>'input w180')); ?> <?php echo $form->error($model,'qq'); ?></td>
  </tr>
  <tr>
    <td align="right"><?php echo $form->labelEx($model,'in_hk'); ?>：</td>
    <td><?php echo $form->dropDownList($model,'in_hk',array('1'=>'是','2'=>'否')); ?> <?php echo $form->error($model,'in_hk'); ?></td>
  </tr>
  <tr>
    <td align="right"><?php echo $form->labelEx($model,'area_for_school'); ?>：</td>
    <td><?php echo $form->dropDownList($model,'area_for_school',ConfigModel::getAreas()); ?> <?php echo $form->error($model,'area_for_school'); ?></td>
  </tr>
  <tr>
    <td align="right"><?php echo $form->labelEx($model,'area'); ?>：</td>
    <td><?php echo $form->dropDownList($model,'area',ConfigModel::getAreas()); ?> <?php echo $form->error($model,'area'); ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>
      <input type="submit" name="button" id="button" value=" 保 存 " class="button" />
    </td>
  </tr>
</table>
<?php $this->endWidget(); ?>
<script>
$(function(){
	$("#user-model-profile-form").validate({
		submitHandler:function(){ajaxFormSubmit("#user-model-profile-form",'successfun');},
		errorClass:"validate-error",
		rules:
		{	
			"username":{ required:true},
			"password":{ required:true}
		},
		messages:
		{	
			"username":{required:"用户名不能为空！"},
			"password":{required:"密码不能为空！"}
		}
	});	
})
function successfun(data){
	setTimeout("location.href='"+data.goUrl+"'",1500);
}
</script>