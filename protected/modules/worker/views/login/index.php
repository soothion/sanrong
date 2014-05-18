<div class="main"> 
<div class="wrap">
<div class="login">
            <div class="login_nav">
                <div class="con"><span>业务员登录</span></div>
            </div>
            <div class="login_m">
                <div class="login_l fl">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'id-form',
                        'action' => $this->createUrl('login/login'),
                        //'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:afterValidate',
                        ),
                    ));
                    ?>
                    <ul>
                        <li>
                            <em>账号：</em><?php echo $form->textField($model, 'mobile', array('placeholder' => '账户')); ?><?php echo $form->error($model, 'username',array('class '=>'login_error')); ?>
                        </li>
                        <li>
                            <em>密码：</em><?php echo $form->passwordField($model, 'password', array('placeholder' => '密码')); ?><span><a href="#">忘记密码？</a></span><?php echo $form->error($model, 'password',array('class'=>'login_error')); ?>
                        </li>
                        <li>
                            <em>验证码：</em><input class="span1 yzm" placeholder="验证码" name="LoginForm[verifyCode]" id="LoginForm_verifyCode" type="text"><?php $this->widget('CCaptcha', array('buttonLabel' => '看不清？','imageOptions'=>array('style'=>'position:relative;top:15px'))); ?><?php echo $form->error($model, 'verifyCode',array('class'=>'login_error')); ?>
                        </li>
                    </ul>
                    <div class="autoLogin">
                        <label><input type="checkbox" id="autoLogin" name="remember"/>下次自动登录</label>
                    </div>
                    <div class="proBox">
                        <input type="submit" class="login_btn" value="登 录" />
                    </div>
                <?php $this->endWidget(); ?>
                </div>
                <div class="login_r fr">
                    <p>成为业务员？</p>
                    <p><a href="<?php echo $this->createUrl('/worker/apply') ?>" class="side_reg_btn">立即申请</a></p>
                </div>
                <div class="clear"></div>
            </div>
        </div>
</div></div>
<!--主体结束--> 
<script type="text/javascript">
function afterValidate(form, data, hasError){
	if(hasError==false){
            ajaxFormSubmit("#id-form",'successfun');
	}
	return false;
};
function successfun(data){
    setTimeout("location.href='"+data.goUrl+"';",1000);
}
</script> 