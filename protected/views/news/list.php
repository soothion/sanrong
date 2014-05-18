<!--主体开始-->
<div class="main"> 
  <!--内容区开始-->
  <div class="wrap"> 
    <!--左栏 团购列表开始-->
    <div class="u_main fl">
      <div class="u_nav">
        <div class="con">
            
            <?php foreach($model as $k=>$v): ?>
            <a <?php if($_GET['cate_id'] == $v->id): ?>class="on"<?php endif; ?> href="<?php echo $this->createUrl('/news/list',array('cate_id'=>$v->id)) ?>"><?php echo $v->name ?></a>
            <?php endforeach; ?>
        </div>
      </div>
      <div class="list_main">
      	<div class="list">
      		<ul>
                    <?php foreach($newsModel as $k=>$v): ?>
                    <li><a target="_blank" href="<?php echo $this->createUrl('news/index',array('id'=>$v->id)) ?>"><?php echo $v->title ?></a><span><?php echo date('Y-m-d',$v->created) ?></span></li>
                        <?php endforeach; ?>
        		
                
        	</ul>
            
        </div>
          <?php
                $this->widget('CLinkPager', array(
                    'header' => '',
                    'firstPageLabel' => '首页',
                    'lastPageLabel' => '末页',
                    'prevPageLabel' => '上一页',
                    'nextPageLabel' => '下一页',
                    'pages' => $pager,
                    'maxButtonCount' => 13,
                    'htmlOptions' => array('class' => 'list_page'),
                        )
                );
                ?>
<!--        <div class="list_page"> 
            <span class="current">1</span><a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">5</a> <a href="#">下一页</a> <a href="#">最后一页</a>
        </div>-->

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