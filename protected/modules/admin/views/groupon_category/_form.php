<style>
    .tabs{
        padding:10px;
        border: 1px solid #ddd;
        border-collapse: separate;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }
    .form-horizontal .control-label{width:80px;}
    .form-horizontal .controls{margin-left:100px}
</style>

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
    <!-- Tab panes -->
    <div class="">
            <?php echo $form->textFieldRow($model, 'pid_text', array('class' => 'input-large', 'disabled' => 'disabled')); ?>
            <input type="hidden" name="GrouponCategoryModel[pid]" value="<?php echo $model->pid ?>" />
            <?php echo $form->textFieldRow($model, 'name', array('class' => 'input-large')); ?>
            <?php echo $form->radioButtonListInlineRow($model, 'is_hot', GrouponCategoryModel::model()->is_hot_data()); ?>
            <div class="form-actions"><input type="submit" class="btn" value="保存" /></div>
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
//    UE.getEditor('CategoryModel_content',{
//    	imagePath:"",
//    	imageUrl:"<?php echo $this->createUrl('upload/ue_upload_image'); ?>",
//    	//关闭字数统计
//    	wordCount:false,
//    	//关闭elementPath
//    	elementPathEnabled:false,
//    	//默认的编辑区域高度
//    	initialFrameHeight:300,
//    	initialFrameWidth:600
//    })
    imageUploader.setPostParams({
        "action":"/project/upload/up.php"
    });
</script>



