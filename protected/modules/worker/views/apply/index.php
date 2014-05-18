<!--主体开始-->
<div class="main"> 
    <div class="wrap">
        <div class="login">
            <div class="login_nav">
                <div class="con"><span>业务员申请</span></div>
            </div>
            <div class="login_m">
                <div class="login_l fl">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'id-form',
                        'action' => $this->createUrl('apply/apply'),
                        //'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:afterValidate',
                        ),
                    ));
                    ?>
                    <ul>
                        <li class="reg">
                            <em>真实姓名：</em><?php echo $form->textField($model, 'username', array('placeholder' => '请填写您的真实姓名，虚假信息将无法通过审核')); ?> <i>*</i><?php echo $form->error($model, 'username', array('class ' => 'login_error')); ?> 
                        </li>
                        <li class="reg">
                            <em>手机号码：</em><?php echo $form->textField($model, 'mobile', array('placeholder' => '请填写常用手机号码')); ?> <i>*</i><?php echo $form->error($model, 'mobile', array('class ' => 'login_error')); ?> 
                        </li>
                        <li class="reg">
                            <em>所在院校：</em><?php echo $form->textField($model, 'academy', array('placeholder' => '')); ?> <i>*</i><?php echo $form->error($model, 'academy', array('class ' => 'login_error')); ?> 
                        </li>
                        <li class="reg">
                            <em>详细住址：</em><?php echo $form->textField($model, 'address', array('placeholder' => '请填写宿舍楼号以及宿舍门号')); ?> <i>*</i><?php echo $form->error($model, 'address', array('class ' => 'login_error')); ?>
                        </li>
                        <li>
                            <em>验证码：</em><input class="span1 yzm" placeholder="验证码" name="WorkerModel[verifyCode]" id="WorkerModel_verifyCode" type="text"><?php $this->widget('CCaptcha', array('buttonLabel' => '看不清？', 'imageOptions' => array('style' => 'position:relative;top:15px'))); ?><?php echo $form->error($model, 'verifyCode', array('class' => 'login_error')); ?>
                        </li>
                    </ul>
                    <div class="autoLogin">
                        <label><input type="checkbox" checked="checked" name='UserModel[read]' value="read" />我已阅读并接受<a href="#">《三容业务员协议》</a></label>
                    </div>
                    <div class="proBox">
                        <input type="submit" class="login_btn" value='注 册' />
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <div class="login_r login_yw fr">
                    <p>已是业务员？</p>
                    <p><a href="<?php echo $this->createUrl('/worker/login') ?>" class="side_reg_btn">立即登录</a></p>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
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
