<!--主体开始-->
<div class="main"> 
    <div class="wrap">
        <div class="login">
            <div class="login_nav">
                <div class="con"><span>找回密码</span></div>
            </div>
            <div class="login_m">
                <div class="login_l fl">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'id-form',
                        'action' => $this->createUrl('/user/forget_pwd_handle'),
                        //'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:afterValidate',
                        ),
                    ));
                    ?>
                    <ul>
                        <li class="getpw">
                            <em>Email账号：</em><?php echo $form->textField($model, 'email', array('placeholder' => '您注册时填写的Email账号')); ?>
                        </li>
                        <li>
                            <em>验证码：</em><input class="span1 yzm" placeholder="验证码" name="UserModel[verifyCode]" id="UserModel_verifyCode" type="text"><?php $this->widget('CCaptcha', array('buttonLabel' => '看不清？', 'imageOptions' => array('style' => 'position:relative;top:15px'))); ?><?php echo $form->error($model, 'verifyCode', array('class' => 'login_error')); ?>
                        </li>
                    </ul>
                    
                    <div class="proBox">
<!--                        <a href="#" class="login_btn">提 交</a>-->
                        <input type="submit" class="login_btn" />
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <div class="clear"></div>
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