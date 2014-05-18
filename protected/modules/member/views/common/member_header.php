<!--<div style="border-top:1px solid #d6d6d6;padding:10px">
    您的身份是：
<?php if (Yii::app()->user->getState('user_type') == 0): ?>
                个人
<?php elseif (Yii::app()->user->getState('user_type') == 2): ?>
                企业，审核中...
<?php elseif (Yii::app()->user->getState('user_type') == 1): ?>
                企业
<?php elseif (Yii::app()->user->getState('user_type') == 3): ?>
                企业审核未通过
<?php endif; ?>
</div>-->
<div class="u_nav">
    <div class="con">
        <?php if ($this->id == 'orders' && $this->action->id == 'view'): ?>
            <a href="javascript:;" class='on'>我的订单</a>
        <?php else: ?>
            <a href="<?php echo $this->id == 'orders' ? 'javascript:;' : $this->createUrl('/member/orders') ?>" <?php if ($this->id == 'orders'): ?>class='on'<?php endif; ?>>我的订单</a>
        <?php endif; ?>

        <a href="<?php echo $this->id == 'favorite' ? 'javascript:;' : $this->createUrl('/member/favorite') ?>" <?php if ($this->id == 'favorite'): ?>class='on'<?php endif; ?>>培训收藏</a>
        <a href="<?php echo $this->id == 'evaluate' ? 'javascript:;' : $this->createUrl('/member/evaluate') ?>" <?php if ($this->id == 'evaluate'): ?>class='on'<?php endif; ?>>我的评价</a>
        <?php if (Yii::app()->user->getState('user_type') >= 1): ?>
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
<?php if ($this->id == 'resume' && $this->action->id != 'favorite'): ?>
    <div class="order_details_title clearfix"> <strong>个人简历</strong> <a href="<?php echo $this->createUrl('/resume') ?>">预览我的简历</a>
        <div class="clear"></div>
    </div>
    <div class="u_nav2"> 
        <a href="<?php echo $this->createUrl('index') ?>" <?php if ($this->action->id == 'index'): ?>class='on'<?php endif; ?> >基本资料</a>
        <a href="<?php echo $this->createUrl('contact') ?>" <?php if ($this->action->id == 'contact'): ?>class='on'<?php endif; ?> >联系方式</a>
        <a href="<?php echo $this->createUrl('description') ?>" <?php if ($this->action->id == 'description'): ?>class='on'<?php endif; ?>>个人描述</a>
        <a href="<?php echo $this->createUrl('purpose') ?>" <?php if ($this->action->id == 'purpose'): ?>class='on'<?php endif; ?>>求职意向</a>
        <a href="<?php echo $this->createUrl('education') ?>" <?php if ($this->action->id == 'education'): ?>class='on'<?php endif; ?>>教育背景</a>
        <a href="<?php echo $this->createUrl('train') ?>" <?php if ($this->action->id == 'train'): ?>class='on'<?php endif; ?>>培训经历</a>
        <a href="<?php echo $this->createUrl('experience') ?>" <?php if ($this->action->id == 'experience'): ?>class='on'<?php endif; ?>>工作经历</a>
        <a href="<?php echo $this->createUrl('extracurricular') ?>" <?php if ($this->action->id == 'extracurricular'): ?>class='on'<?php endif; ?>>课外经历</a>
        <div class="clear"></div>
    </div>
<?php elseif ($this->id == 'orders' && $this->action->id == 'index'): ?>
    <div class="u_nav2"> 
        <a href="<?php echo $this->createUrl('/member/orders'); ?>" <?php if (!isset($_GET['order_status'])): ?>class="on"<?php endif; ?> >全部</a>
        <?php foreach (OrdersModel::model()->get_order_status() as $k => $v): ?>
            <a <?php if (isset($_GET['order_status']) && $_GET['order_status'] == $k): ?>class="on"<?php endif; ?> href="<?php echo $this->createUrl('/member/orders', array('order_status' => $k)); ?>"><?php echo $v ?></a>
        <?php endforeach ?>
        <div class="clear"></div>
    </div>
    <?php //elseif ($this->id == 'favorite'): ?>
    <!--    <div class="u_nav2"> 
            <a href="<?php echo $this->createUrl('index') ?>" <?php if ($this->action->id == 'index'): ?>class='on'<?php endif; ?> >进行中</a>
            <a href="<?php echo $this->createUrl('favorite_overdue') ?>" <?php if ($this->action->id == 'favorite_overdue'): ?>class='on'<?php endif; ?> >已结束</a>
            <div class="clear"></div>
        </div>-->
<?php elseif ($this->id == 'setting'): ?>
    <div class="u_nav2"> 
        <a href="<?php echo $this->createUrl('index') ?>" <?php if ($this->action->id == 'index'): ?>class='on'<?php endif; ?> >基本资料</a>
        <a href="<?php echo $this->createUrl('address') ?>" <?php if ($this->action->id == 'address'): ?>class='on'<?php endif; ?> >收货地址</a>
        <a href="<?php echo $this->createUrl('change_password') ?>" <?php if ($this->action->id == 'change_password'): ?>class='on'<?php endif; ?> >修改密码</a>
        <div class="clear"></div>
    </div>
<?php endif; ?>
