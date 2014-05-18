<style>
</style>
<!--主体开始-->
<div class="main"> 
  <!--内容区开始-->
  <div class="wrap"> 
    <!--左栏 团购列表开始-->
    <div class="u_main fl">
      <div class="u_nav">
        <div class="con">
            <?php foreach($allModel as $k=>$v): ?>
            <a <?php if($_GET['id'] == $v->id): ?> class="on" <?php endif; ?> href="<?php echo $this->createUrl('/singlepage/view',array('id'=>$v->id)); ?>"><?php echo $v->title ?></a>
            <?php endforeach; ?>
        </div>
      </div>
      <div class="page_main">
          <?php echo $model->content ?>
      </div>      
    </div>    
    <!--右栏 侧边开始-->
    <?php $this->renderPartial('../common/fr');  ?>
    <!--右栏 侧边结束-->
    <div class="clear"></div>
  </div>
  <!--内容区结束--> 
</div>
<!--主体结束--> 

