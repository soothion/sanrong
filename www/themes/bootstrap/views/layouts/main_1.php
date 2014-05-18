<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>管理后台</title>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
        <script type="text/javascript" src="/static/jquery/jqueryui/js/jquery-ui-1.8.14.custom.min.js"></script>        
        <script type="text/javascript" src="/static/jquery/jquery.form.js"></script>
        <?php Yii::app()->bootstrap->register(); ?>
        <script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.all.js"></script>
        
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
                    <dd <?php if (Yii::app()->controller->getId() == ''): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/groupon_seller'); ?>">评论管理</a></dd>
                    <dd <?php if (Yii::app()->controller->getId() == ''): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/groupon_seller'); ?>">订单管理</a></dd>
                </dl>
            </div>
            <dl>
                <dt>人才在线模型</dt>
                <dd></dd>
            </dl>
            <dl>
                <dt>新闻模块</dt>
                <dd <?php if (Yii::app()->controller->getId() == 'news_category'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/news_category'); ?>">类别管理</a></dd>
                <dd <?php if (Yii::app()->controller->getId() == 'news'): ?>class="current"<?php endif; ?>><a href="<?php echo $this->createUrl('/admin/news'); ?>">新闻管理</a></dd>
            </dl>
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
    <script type="text/javascript">
    
    </script>
</html>