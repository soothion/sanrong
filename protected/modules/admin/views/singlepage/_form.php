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

<?php echo $form->textFieldRow($model, 'title', array()); ?>
<?php echo $form->textAreaRow($model, 'content', array('rows' => 5, 'class' => 'input-xxlarge')) ?>
<?php echo $form->textFieldRow($model, 'views', array('class' => '')); ?>
<?php echo $form->textFieldRow($model, 'keyword', array('class'=>'input-xxlarge')); ?>
<?php echo $form->textAreaRow($model, 'description', array('class'=>'input-xxlarge')); ?>
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
    UE.getEditor('SinglepageModel_content', {
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
//    imageUploader.setPostParams({
//        "action": "/project/upload/up.php"
//    });
</script>
