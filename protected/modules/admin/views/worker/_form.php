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
        ));
?>
<?php if ($isEdit): ?>

    <input type="hidden" name="id" value="<?php echo $model->id; ?>" />
<?php endif; ?>
<?php echo $form->textFieldRow($model, 'mobile', array('class' => 'input-xlarge')); ?>
<?php echo $form->textFieldRow($model, 'username', array('class' => 'input-xlarge')); ?>
<?php echo $form->passwordFieldRow($model, 'password', array('class' => 'input-large')); ?>
<?php echo $form->dropDownListRow($model, 'status', WorkerModel::model()->get_status_arr()); ?>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => ' 保 存 ', 'url' => $this->createUrl('save'))); ?>
</div>
<?php $this->endWidget(); ?>
<script>
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
    $(function(){
        $('.form-horizontal .control-group:first .controls .help-inline').after('添加业务员时，手机号选填，系统自动创建业务员编号');
    });
</script> 
