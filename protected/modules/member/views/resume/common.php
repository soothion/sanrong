<div class="order_details_title clearfix"> <strong>个人简历</strong> <a href="#">预览我的简历</a>
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
