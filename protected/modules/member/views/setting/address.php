<!--主体开始-->
<div class="main"> 
    <!--内容区开始-->
    <div class="wrap"> 
        <!--左栏 团购列表开始-->
        <div class="u_main fl">
            <?php $this->renderPartial('../common/member_header') ?>  
            <?php
            $isEdit = !empty($model->id);
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'id-form',
                'action' => $this->createUrl('address_save'),
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
            <ul class="jl_xq">
                <li><b>收货人姓名</b><?php echo $form->textField($model, 'address_name') ?></li>
                <li><b>手机号码</b><input type="text" name='UserModel[mobile]' value="<?php echo $userModel->mobile ?>" /></li>
                <li><b>详细地址</b><?php echo $form->textField($model, 'address', array('class' => 'w500')) ?></li>
                <div class="lbtn"><input name="" type="submit" value="提交"  class="submit_btn" /></div>
            </ul>
            <?php $this->endWidget(); ?>
        </div>
        <!--左栏 团购列表结束--> 

        <!--右栏 侧边开始-->
        <?php $this->renderPartial('../common/fr') ?>
        <!--右栏 侧边结束-->
        <div class="clear"></div>
    </div>
    <!--内容区结束--> 
</div>
<!--主体结束--> 
<script type="text/javascript">
    function afterValidate(form, data, hasError) {
        if (hasError == false) {
            ajaxFormSubmit("#id-form", 'successfun');
        }
        return false;
    }
    ;
    function successfun(data) {
        setTimeout("location.href='" + data.goUrl + "';", 1000);
    }
</script>

