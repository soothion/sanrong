<div class='main'>
    <div class="wrap">
<div class="login">
    <div class="login_nav">
        <div class="con"><span>��ҵ����</span></div>
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
            	<div class="">
                 <label><input type="radio" name="radio" value="geren" id="radio1" />����ע��</label> 
                    <label><input type="radio" checked="checked" name="radio" value="qiye" id="radio2" />��ҵע��</label>
                </div>
                <li class="reg">
                    	<em>�˺ţ�</em><?php echo $form->textField($model, 'email', array('placeholder' => '����д���������˺�')); ?> <i>*</i><?php echo $form->error($model, 'email',array('class '=>'login_error')); ?> 
                    </li>
                    <li class="reg">
                    	<em>���룺</em><?php echo $form->passwordField($model, 'password', array('placeholder' => '')); ?> <i>*</i> <?php echo $form->error($model, 'password',array('class '=>'login_error')); ?>
                    </li>
                    <li class="reg">
                    	<em>ȷ�����룺</em><?php echo $form->passwordField($model, 'password', array('placeholder' => '')); ?> <i>*</i> <?php echo $form->error($model, 'password',array('class '=>'login_error')); ?>
                    </li>
                <li class="reg">
                    <em>��ʵ������</em><?php echo $form->textField($userCompanyModel, 'real_name', array('placeholder' => '����д������ʵ����')); ?> <i>*</i>
                </li>
                <li class="reg">
                    <em>�ֻ����룺</em><?php echo $form->textField($model, 'mobile', array('placeholder' => '����д�����ĳ����ֻ�����')); ?> <i>*</i>
                </li>
                <li class="reg">
                    <em>��˾���ƣ�</em><?php echo $form->textField($userCompanyModel, 'company_name', array('placeholder' => '����д��˾ȫ��')); ?>  <i>*</i>
                </li>
                <li class="reg">
                    <em>����ְ��</em><?php echo $form->textField($userCompanyModel, 'position', array('placeholder' => '�磺�ܾ������¾����')); ?>  <i>*</i>
                </li>
                <li class="reg">
                    <em>��ϸ��ַ��</em><?php echo $form->textField($userCompanyModel, 'company_address', array('placeholder' => '����д��˾���ڵصĵ�ַ')); ?>  <i>*</i>
                </li>
                 <li class="reg">
                   <em>Ӫҵִ�գ�</em>�������һ���ϴ�Ӫҵִ�յ�������ϴ��󼴿�Ԥ����
                </li>
                <li>
                    <em>��֤�룺</em><input class="span1 yzm" placeholder="��֤��" name="userCompanyModel[verifyCode]" id="userCompanyModel_verifyCode" type="text"><?php $this->widget('CCaptcha', array('buttonLabel' => '�����壿', 'imageOptions' => array('style' => 'position:relative;top:15px'))); ?><?php echo $form->error($userCompanyModel, 'verifyCode', array('class' => 'login_error')); ?>
                </li>
            </ul>
            <div class="autoLogin">
                <label><input type="checkbox" id="autoLogin" name="remember" checked="checked" />�����Ķ�������<a href="#">��������ҵ����Э�顷</a></label>
            </div>
            <div class="proBox">
                <input type="submit" class="login_btn" value="ע ��"  />
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <div class="login_r login_yw fr">
            <p>��������ˣ�</p>
            <p><a href="#" class="side_reg_btn">������¼</a></p>
        </div>
        <div class="clear"></div>
    </div>
</div>
</div>
</div>



