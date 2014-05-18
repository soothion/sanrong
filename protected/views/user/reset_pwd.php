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
                        'action' => $this->createUrl('/user/reset_pwd_handle'),
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
                    	<em>新的密码：</em><input type="password" id="username" name="password" value="" />
                    </li>
                    <li>
                    	<em>再次输入：</em><input type="password" id="username" name="password2" value="" />
                    </li>
                    <input type="hidden" name="id" value="<?php echo $model->id ?>" />
                    <input type="hidden" name="codes" value="<?php echo $model->codes ?>" />
                 </ul>
                  	<div class="proBox">
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
