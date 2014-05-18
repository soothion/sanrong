<!--主体开始-->
<div class="main"> 
    <!--内容区开始-->
    <div class="wrap"> 
            <!--左栏 团购列表开始-->
            <div class="u_main fl">
                <div class="u_nav">
                    <div class="con"><a href="<?php echo $this->createUrl('/news/list', array('cate_id' => $model->cate->id)); ?>" class="on"><?php echo $model->cate->name ?></a></div>
                </div>
                <div class="page_main">
                    <div class="page_other">
                        <h1><?php echo $model->title ?></h1>
                        <p><span>发布于：<?php echo date('Y-m-d', $model->created) ?></span><span>来源：本站</span><span>查看：<?php echo $model->views ?>次</span><span><a href="<?php echo $this->createUrl('/news/list', array('cate_id' => $model->cate->id)); ?>">返回</a></span></p>
                    </div>
                    <div class="page_con">
                        <p><?php echo $model->content ?></p>
                    </div>
                </div>
            </div>

        <!--右栏 侧边开始-->
        <?php $this->renderPartial('../common/fr') ?>
        <!--右栏 侧边结束-->
        <div class="clear"></div>
    </div>
    <!--内容区结束--> 
</div
<!--主体结束--> 
