<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>管理后台</title>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
        <script type="text/javascript" src="/static/jquery/jqueryui/js/jquery-ui-1.8.14.custom.min.js"></script>        
        <script type="text/javascript" src="/static/jquery/jquery.form.js"></script>
        <?php Yii::app()->bootstrap->register(); ?>
        <script type="text/javascript">
            window.UEDITOR_HOME_URL = "/static/ueditor/";
        </script>
        <script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.all.js"></script>
        <script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.config.js"></script>
        <script type="text/javascript" src="/static/jquery/jquery.validate.js"></script>
        <script type="text/javascript" src="/static/jquery/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="/static/js/common.js"></script>
        <script type="text/javascript">
            $(function() {
                $('.mp_left dt').click(function() {
                    $(this).parents('dl').children('dd').slideToggle();
                });
                $('.current').parent().children('dd').show();
            });
        </script>
    </head>
    <body>
        <div class="mp_left">
            <div class="logo">
                <img src="/static/images/logo.png" />
            </div>
            <div class="main_nav">
                <dl>
                    <dt>团购模型</dt>
                    <dd <?php if (Yii::app()->controller->getId() == 'groupon_area'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/groupon_area'); ?>" >区域管理</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'groupon_category'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/groupon_category'); ?>" >分类管理</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'groupon_subject'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/groupon_subject'); ?>" >团购专题</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'groupon_seller'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/groupon_seller'); ?>" >商家管理</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'groupon_goods'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/groupon_goods'); ?>">商品管理</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'groupon_evaluate'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/groupon_evaluate'); ?>">评论管理</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'groupon_order'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/groupon_order'); ?>">订单管理</a></dd>
                </dl>
                <dl>
                    <dt>人才在线模型</dt>
                    <dd <?php if (Yii::app()->controller->getId() == 'resume'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/resume'); ?>" >简历管理</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'resume_technical_titles'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/resume_technical_titles'); ?>" >技术职称管理</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'resume_major'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/resume_major'); ?>" >专业管理</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'resume_speciality'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/resume_speciality'); ?>" >技能特长管理</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'resume_position'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/resume_position'); ?>" >职位管理</a></dd>                    
                    <dd <?php if (Yii::app()->controller->getId() == 'resume_other_weal'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/resume_other_weal'); ?>" >其他福利管理</a></dd>                    
                    <dd <?php if (Yii::app()->controller->getId() == 'resume_part_time_type'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/resume_part_time_type'); ?>" >兼职期望类型管理</a></dd>                    
                </dl>
                <dl>
                    <dt>业务员模型</dt>
                    <dd <?php if (Yii::app()->controller->getId() == 'worker' && Yii::app()->controller->action->id == 'index'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/worker'); ?>">业务员管理</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'worker' && Yii::app()->controller->action->getId() == 'worker_info'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/worker/worker_info'); ?>">业务员申诉管理</a></dd>
                </dl>
                <dl>
                    <dt>新闻模块</dt>
                    <dd <?php if (Yii::app()->controller->getId() == 'news_category'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/news_category'); ?>">类别管理</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'news'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/news'); ?>">新闻管理</a></dd>
                </dl>
                <dl>
                    <dt>公共模块</dt>
                    <dd <?php if (Yii::app()->controller->getId() == 'advert'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/advert'); ?>">广告管理</a></dd>
<!--                    <dd <?php if (Yii::app()->controller->getId() == 'friendlink'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/friendlink'); ?>">友情链接管理</a></dd>-->
                    <dd <?php if (Yii::app()->controller->getId() == 'singlepage'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/singlepage'); ?>">单页管理</a></dd>
                </dl>
                <dl>
                    <dt>网站信息模块</dt>
                    <dd <?php if (Yii::app()->controller->getId() == 'setting'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/setting'); ?>">系统设置</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'mysqlback'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/mysqlback'); ?>">数据库备份</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'admin'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/admin'); ?>">管理员管理</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == 'user' && Yii::app()->controller->action->id == 'index'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/user'); ?>" >用户管理</a></dd>
                </dl>
<!--                <dl>
                    <dt>企业模型管理</dt>
                    <dd <?php if (Yii::app()->controller->getId() == 'enterprise'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/enterprise'); ?>">企业管理</a></dd>
                </dl>-->
            </div>

        </div>
        <div class="alert alert-success">
            <span style="padding-left:20px">您好：<?php echo Yii::app()->user->name; ?></span>
            <span style="position: absolute; right: 10px;"><a target="_blank" style="margin-right:50px" href="<?php echo $this->createAbsoluteUrl('/') ?>">前往网站首页</a><a style="margin-right:50px" href="<?php echo $this->createUrl('/admin') ?>">前往后台首页</a><a href="<?php echo $this->createUrl('/admin/login/logout'); ?>">注销登录</a></span>
        </div>
        <div class="mp_right">

            <h2><?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs, 'homeLink' => CHtml::link('管理中心', $this->createUrl('/mp/')),)); ?></h2>
            <?php if (isset($this->subnavtabs) && !empty($this->subnavtabs)): ?>
                <ul class="nav nav-tabs" style="height:37px;">
                    <?php foreach ($this->subnavtabs as $key => $row): ?>
                        <li <?php if (Yii::app()->controller->id . '_' . Yii::app()->controller->action->id == $key): ?>class="active"<?php endif; ?> ><a href="<?php echo isset($row['url']) && !empty($row['url']) ? $row['url'] : 'javascript:void(0);'; ?>"><?php echo $row['title']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php echo $content; ?>
            <div class="clearfix"></div>
        </div>
    </body>
</html>