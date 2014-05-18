<style type="text/css">
    .reg_type{text-align: center}
</style>
<div class='main'>
    <div class="wrap">
        <div class="login">
            <div class="login_nav">
                <div class="con"><span>免费注册</span></div>
            </div>
            <div class="login_m">

                <div class="login_l fl">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'id-form',
                        'action' => $this->createUrl('register/register'),
                        //'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:afterValidate',
                        ),
                    ));
                    ?>
                    <ul>
                        <div class="reg_type">
                            <label><input type="radio" checked="checked" name="user" value="geren" id="radio1" />个人注册</label> 
                            <label><input type="radio"  name="company" value="qiye" id="radio2" />企业注册</label>
                        </div>
                        <li class="reg">
                            <em>邮箱：</em><?php echo $form->textField($model, 'email', array('placeholder' => '请填写常用邮箱账号')); ?> <i>*</i><?php echo $form->error($model, 'email', array('class ' => 'login_error')); ?> 
                        </li>
                        <li class="reg">
                            <em>密码：</em><?php echo $form->passwordField($model, 'password', array('placeholder' => '')); ?> <i>*</i> <?php echo $form->error($model, 'password', array('class ' => 'login_error')); ?>
                        </li>
                        <li class="reg">
                            <em>确认密码：</em><?php echo $form->passwordField($model, 'password2', array('placeholder' => '')); ?> <i>*</i> <?php echo $form->error($model, 'password2', array('class ' => 'login_error')); ?>
                        </li>
                        <li class="reg">
                            <em>手机：</em><?php echo $form->textField($model, 'mobile', array('placeholder' => '请填写常用手机号码')); ?> <i>*</i><?php echo $form->error($model, 'mobile', array('class ' => 'login_error')); ?>
                        </li>
                        <li>
                            <em>验证码：</em><input class="span1 yzm" placeholder="验证码" name="UserModel[verifyCode]" id="UserModel_verifyCode" type="text"><?php $this->widget('CCaptcha', array('buttonLabel' => '看不清？', 'imageOptions' => array('style' => 'position:relative;top:15px'))); ?><?php echo $form->error($model, 'verifyCode', array('class' => 'login_error')); ?>
                        </li>
                    </ul>
                    <div class="autoLogin">
                        <label><input type="checkbox" checked="checked" name='UserModel[read]' value="read" />我已阅读并接受<a href="#">《三容用户协议》</a></label>
                    </div>
                    <div class="proBox">
                        <input type="submit" class="login_btn" value='注 册' />
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <div class="login_r fr">
                    <p>已有三容账号？</p>
                    <p><a href="<?php echo $this->createUrl('/member/login') ?>" class="side_reg_btn">立即登录</a></p>
                    <p><a href="<?php echo $this->createUrl('/member/register_enterprise') ?>" class="side_reg_btn">企业注册</a></p>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.reg_type input[name=user]').click(function() {
        window.location.href = "<?php echo $this->createUrl('/member/register') ?>";
    });
    $('.reg_type input[name=company]').click(function() {
        window.location.href = "<?php echo $this->createUrl('/member/register_enterprise') ?>";
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
