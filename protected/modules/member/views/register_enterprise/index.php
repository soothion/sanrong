<style type="text/css">
    .reg_type{text-align: center}
    .uploader-btn{
        border: 1px solid #D3D3D3;
        text-align: center;
        margin-bottom: 10px;
        background: #EEE;
        cursor: pointer;
    }
    .trading_certificate em,.trading_certificate .uploadify{float:left}
</style>
<div class='main'>
    <div class="wrap">
        <div class="login">
            <div class="login_nav">
                <div class="con"><span>企业申请</span></div>
            </div>
            <div class="login_m">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'id-form',
                    'action' => $this->createUrl('register_enterprise/register_enterprise'),
                    //'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'afterValidate' => 'js:afterValidate',
                    ),
                ));
                ?>
                <div class="login_l fl">
                    <ul>
                        <div class="reg_type">
                            <label><input type="radio"  name="user" value="geren" id="radio1" />个人注册</label> 
                            <label><input type="radio" checked="checked"  name="company" value="qiye" id="radio2" />企业注册</label>
                        </div>
                        <li class="reg">
                            <em>账号：</em><?php echo $form->textField($model, 'email', array('placeholder' => '请填写常用邮箱账号')); ?> <i>*</i><?php echo $form->error($model, 'email', array('class ' => 'login_error')); ?> 
                        </li>
                        <li class="reg">
                            <em>密码：</em><?php echo $form->passwordField($model, 'password', array('placeholder' => '')); ?> <i>*</i> <?php echo $form->error($model, 'password', array('class ' => 'login_error')); ?>
                        </li>
                        <li class="reg">
                            <em>确认密码：</em><?php echo $form->passwordField($model, 'password2', array('placeholder' => '')); ?> <i>*</i> <?php echo $form->error($model, 'password2', array('class ' => 'login_error')); ?>
                        </li>
                        <li class="reg">
                            <em>真实姓名：</em><?php echo $form->textField($model, 'real_name', array('placeholder' => '请填写您的真实姓名')); ?> <i>*</i>
                        </li>
                        <li class="reg">
                            <em>手机号码：</em><?php echo $form->textField($model, 'mobile', array('placeholder' => '请填写能您的常用手机号码')); ?> <i>*</i>
                        </li>
                        <li class="reg">
                            <em>公司名称：</em><?php echo $form->textField($model, 'company_name', array('placeholder' => '请填写公司全称')); ?>  <i>*</i>
                        </li>
                        <li class="reg">
                            <em>公司电话：</em><?php echo $form->textField($model, 'company_phone', array('placeholder' => '请填写公司电话')); ?>  
                        </li>
                        <li class="reg">
                            <em>您的职务：</em><?php echo $form->textField($model, 'position', array('placeholder' => '如：总经理，人事经理等')); ?>  <i>*</i>
                        </li>
                        <li class="reg ">
                            <em>详细地址：</em><?php echo $form->textField($model, 'company_address', array('placeholder' => '请填写公司所在地的地址')); ?>  <i>*</i>
                        </li>
                        <li class="reg trading_certificate">
                            <em>营业执照：</em><input type="hidden" id="trading_certificate" name="UserCompanyModel[trading_certificate]" value=""><input type="file" name="yyzz" id="yingyuezhizhao"/>
                            <img src="" id="yyzzed" width="100" />
                        </li>
                        <li>
                            <em>验证码：</em><input class="span1 yzm" placeholder="验证码" name="UserCompanyModel[verifyCode]" id="userCompanyModel_verifyCode" type="text"><?php $this->widget('CCaptcha', array('buttonLabel' => '看不清？', 'imageOptions' => array('style' => 'position:relative;top:15px'))); ?><?php echo $form->error($model, 'verifyCode', array('class' => 'login_error')); ?>
                        </li>
                    </ul>
                    <div class="autoLogin">
                        <label><input type="checkbox" id="autoLogin" name="remember" checked="checked" />我已阅读并接受<a href="#">《三容企业申请协议》</a></label>
                    </div>
                    <div class="proBox">
                        <input type="submit" class="login_btn" value="注 册"  />
                    </div>
                </div>
                <?php $this->endWidget(); ?>
                <div class="login_r login_yw fr">
                    <p>已申请过了？</p>
                    <p><a href="#" class="side_reg_btn">立即登录</a></p>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/jquery/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript">
    $(function() {
        $("#yingyuezhizhao").uploadify({
            height: 30,
            swf: '/static/jquery/uploadify/uploadify.swf',
            uploader: '<?php echo $this->createUrl("/upload/uploadify_image"); ?>',
            width: 120,
            buttonText: '请上传营业执照',
            buttonClass: 'uploader-btn',
            'onUploadSuccess': function(file, data, response) {
                var data = eval("(" + data + ")");
                $('#trading_certificate').val(data.file);
                $('#yyzzed').attr('src', data.file);
            }
        });
    });
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



