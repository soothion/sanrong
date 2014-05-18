<div class='main'>
    <div class='wrap'>
        <div class="u_main fl">
            <?php $this->renderPartial('../common/member_header') ?>
            <?php
            $isEdit = !empty($model->id);
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'id-form',
                'action' => $this->createUrl('contact_save'),
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
                <div class="log_res">
                    <?php
                    if (isset($log_res)) {
                        echo "<span class='log_status'>".$log_res['status']."</span>";
                        if(!empty($log_res['info'])){
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;<span class='log_reason'>失败原因：".$log_res['info']."</span>";
                        }
                    }
                    ?>
                </div>
                <li><b>手机</b><?php echo $form->textField($userModel, 'mobile') ?></li>
                <li><b>电话</b><?php echo $form->textField($model, 'phone') ?></li>
                <li><b>QQ</b><?php echo $form->textField($model, 'qq') ?></li>
                <li><b>Email</b><input type="text" disabled="disabled" value="<?php echo $userModel->email ?>" /></li>
                
<!--                <li><b>邮政编码</b><?php echo $form->textField($model, 'zipcode') ?></li>-->
                <li><b>通讯地址</b><?php echo $form->textField($model, 'contact_address') ?></li>
<!--                <li><b>个人博客</b><?php echo $form->textField($model, 'blog') ?></li>-->
                <div class="lbtn"><input name="" type="submit" value="提交"  class="submit_btn" /></div>
            </ul>
            <?php $this->endWidget(); ?>
        </div>
        <?php echo $this->renderPartial('../common/fr') ?>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".datepicker").datePicker({
            clickInput: true,
            startDate: '1900-01-01'
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
        setTimeout("location.href='" + data.goUrl + "';", 1000);
    }
</script>
