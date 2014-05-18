<?php
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
<div class="control-group ">
    <label class="control-label required" for="SettingModel_name">网站标题</label>
    <div class="controls">
        <?php echo "<input type='text' name='title' value='".SettingModel::model()->find('k=:k',array(':k'=>'title'))->v."' />"; ?>
        <span class="help-inline error" id="SettingModel_name_em_" style="display: none"></span>
    </div>
</div>
<div class="control-group ">
    <label class="control-label required" for="SettingModel_name">关键词</label>
    <div class="controls">
        <?php echo "<input type='text' class='input-xxlarge' name='keyword' value='".SettingModel::model()->find('k=:k',array(':k'=>'keyword'))->v."' />"; ?>
        <span class="help-inline error" id="SettingModel_name_em_" style="display: none"></span>
    </div>
</div>
<div class="control-group ">
    <label class="control-label" for="SettingModel_content">描述</label>
    <div class="controls">
        <textarea rows="5" class="input-xxlarge" name="description" id="SettingModel_content"><?php echo SettingModel::model()->find('k=:k',array(':k'=>'description'))->v; ?>
        </textarea>
        <span class="help-inline error" id="SettingModel_content_em_" style="display: none"></span>
    </div>
</div>
<div class="control-group ">
    <label class="control-label" for="SettingModel_content">脏话过滤</label>
    <div class="controls">
        <?php echo "<input type='text' class='input-xlarge' name='filter_text' value='".SettingModel::model()->find('k=:k',array(':k'=>'filter_text'))->v."' />"; ?>
        用逗号隔开
        <span class="help-inline error" id="SettingModel_content_em_" style="display: none"></span>
    </div>
</div>
<div class="form-actions">
    <button class="btn" type="submit"> 保 存 </button>
</div>
<?php $this->endWidget(); ?>
<script>
//function afterValidate(form, data, hasError){
//	if(hasError==false){
//		ajaxFormSubmit("#id-form",'successfun');
//	}
//	return false;
//};
function successfun(data){
	setTimeout("location.reload();",1000);
}
</script> 
