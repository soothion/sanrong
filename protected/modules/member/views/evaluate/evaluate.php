<!--主体开始-->
<div class="main"> 
    <!--内容区开始-->
    <div class="wrap"> 
        <!--左栏 团购列表开始-->
        <div class="u_main fl">
            <div class="u_nav">
                <div class="con">
                    <a href="<?php echo $this->id == 'orders' ? 'javascript:;' : $this->createUrl('/member/orders') ?>" <?php if ($this->id == 'orders'): ?>class='on'<?php endif; ?>>我的订单</a>
                    <a href="<?php echo $this->id == 'favorite' ? 'javascript:;' : $this->createUrl('/member/favorite') ?>" <?php if ($this->id == 'favorite'): ?>class='on'<?php endif; ?>>培训收藏</a>
                    <a href="<?php echo $this->id == 'evaluate' ? 'javascript:;' : $this->createUrl('/member/evaluate') ?>" <?php if ($this->id == 'evaluate'): ?>class='on'<?php endif; ?>>我的评价</a>
                    <?php if (Yii::app()->user->getState('user_type') == 1): ?>
                        <a href="<?php echo $this->id == 'resume' ? 'javascript:;' : $this->createUrl('/member/resume/favorite') ?>" <?php if ($this->id == 'resume'): ?>class='on'<?php endif; ?>>人才收藏</a>
                    <?php else: ?>
                        <a href="<?php echo $this->id == 'resume' ? 'javascript:;' : $this->createUrl('/member/resume') ?>" <?php if ($this->id == 'resume'): ?>class='on'<?php endif; ?>>我的简历</a>
                    <?php endif; ?>
                <!--<a href="<?php echo $this->id == 'balance' ? 'javascript:;' : $this->createUrl('/member/balance') ?>" <?php if ($this->id == 'balance'): ?>class='on'<?php endif; ?>>账户余额</a>-->
                    <a href="<?php echo $this->id == 'setting' ? 'javascript:;' : $this->createUrl('/member/setting') ?>" <?php if ($this->id == 'setting'): ?>class='on'<?php endif; ?>>账户设置</a>
                    <?php if (Yii::app()->user->getState('user_type') == 0): ?>
                        <a href="<?php echo $this->id == 'user' ? 'javascript:;' : $this->createUrl('/member/user/enterprise') ?>" <?php if ($this->id == 'user'): ?>class='on'<?php endif; ?>>企业目录</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="my_pl">
                <p style="padding-left:20px;">对“<a href="#" target="_blank"><?php echo $orderGoodsModel->goods_name ?></a>”的评价：</p>
                
                <?php
                $isEdit = !empty($model->id);
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'id-form',
                    'action' => $this->createUrl('save'),
                    //'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'afterValidate' => 'js:afterValidate',
                    ),
                ));
                ?>
				<div class="post_star">
                         <label title="很满意"><div class="ps_star"><input checked="checked" type="radio" name="GrouponEvaluateModel[stars]" value="5" id="stars" /><div class="grade_star gsa5"></div></div></label>
                         <label title="满意"><div class="ps_star"><input type="radio" name="GrouponEvaluateModel[stars]" value="4" id="stars" /><div class="grade_star gsa4"></div></div></label>
                         <label title="一般"><div class="ps_star"><input type="radio" name="GrouponEvaluateModel[stars]" value="3" id="stars" /><div class="grade_star gsa3"></div></div></label>
                         <label title="不满意"><div class="ps_star"><input type="radio" name="GrouponEvaluateModel[stars]" value="2" id="stars" /><div class="grade_star gsa2"></div></div></label>
                         <label title="很不满意"><div class="ps_star"><input type="radio" name="GrouponEvaluateModel[stars]" value="1" id="stars" /><div class="grade_star gsa1"></div></div></label>             
          	   </div>

                <?php if ($isEdit): ?>
                    <input type="hidden" name="id" value="<?php echo $model->id; ?>" />
                <?php endif; ?>
                <?php echo $form->textArea($model, 'content', array('placeholder' => '', 'cols' => '60', 'rows' => '10')); ?>
                <input type="hidden" name="GrouponEvaluateModel[order_id]" value="<?php echo $orderModel->id ?>"  />    
                <input type="hidden" name="GrouponEvaluateModel[order_goods_id]" value="<?php echo $orderGoodsModel->id ?>"  />    
                <div class="proBox">
                    <input type="submit" class="login_btn" value='提交' />
                </div>
                <?php $this->endWidget(); ?>
            </div>


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