<?php
$isEdit = !empty($model->id);
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'id-form',
    'type' => 'horizontal',
    'action' => $this->createUrl('company_info_save'),
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

<?php echo $form->textFieldRow($model, 'real_name', array()); ?>
<?php echo $form->textFieldRow($model, 'company_name', array()); ?>
<?php echo $form->textFieldRow($model, 'position', array()); ?>
<?php echo $form->textFieldRow($model, 'company_address', array()); ?>
<?php echo $form->textFieldRow($model, 'company_phone', array()); ?>
        <?php if (empty($model->trading_certificate)) {
            echo '该公司未上传营业执照';
        }else{
            echo "<img src='".$model->trading_certificate."' width='100' /><a href='".$model->trading_certificate."'>下载</a>";
        } ?>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => ' 保 存 ', 'url' => $this->createUrl('save'))); ?>
</div>
<?php $this->endWidget(); ?>
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
</script>
