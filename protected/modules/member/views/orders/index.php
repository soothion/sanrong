<!--主体开始-->
<div class="main"> 
    <!--内容区开始-->
    <div class="wrap"> 
        <!--左栏 团购列表开始-->
        <div class="u_main fl">
            <?php $this->renderPartial('../common/member_header') ?>

            <table class="order_list module_table">
                <tr>
                    <th style="width:38%;">项目</th>
                    <th style="width:10%;">数量</th>
                    <th style="width:17%;">总价</th>
                    <th style="width:15%;">状态</th>
                    <th style="width:20%;">操作</th>
                </tr>
                <?php foreach ($model as $k => $v): ?>
                    <tr>
                        <td><div class="order_list_img"><a href="<?php echo $this->createUrl('/groupon_goods/index', array('id' => $v->goods->goods_id)); ?>" target="_blank"><img src="<?php echo $v->goods->goods_image ?>" alt="title"/></a></div>
                            <div class="order_list_title">
                                <h2><span></span><a href="#" target="_blank"><?php echo $v->goods->goods_name ?></a></h2>
                            </div></td>
                        <td> <?php echo $v->goods->goods_count ?> </td>
                        <td>￥<?php echo $v->total_price ?></td>
                        <td><span class="order_state"><?php echo OrdersModel::model()->get_order_status($v->order_status) ?></span> </td>
                        <td>
                            <?php if ($v->order_type != 4 && $v->order_status == 0): ?>
                            <a href="<?php echo $this->createUrl('/orders/check',array('order_id'=>$v->id)) ?>">去付款</a>
                            <?php endif; ?>
                            <?php if ($v->order_type == 4 && $v->order_status == 0): ?>
                                当面付,等待确认
                            <?php endif; ?>
                            <?php if ($v->order_status == 1): ?>
                                <a href="<?php echo $this->createUrl('/member/evaluate/evaluate',array('order_id'=>$v->id,'order_goods_id'=>$v->goods->id)) ?>">去评价</a>
                            <?php endif; ?>
                                <span class="details_link"> <a target="_blank" href="<?php echo $this->createUrl('/member/orders/view',array('id'=>$v->id)) ?>">订单详情</a></span>
                        </td>
                    </tr>
                <?php endforeach; ?>

<!--        <tr>
  <td><div class="order_list_img"><a href="#" target="_blank"><img src="images/buy.jpg" alt="title"/></a></div>
    <div class="order_list_title">
      <h2><span></span><a href="#" target="_blank">阿伦清吧KTV</a></h2>
    </div></td>
  <td> 1 </td>
  <td>￥118 </td>
  <td><span class="order_state">待付款</span> <span class="details_link"> <a href="#">订单详情</a></span></td>
  <td><a href="#" class="operate_btn pink_btn_new">付款</a><a href="#" class="delete_order d_block">删除订单</a></td>
</tr>-->


<!--        <tr>
  <td><div class="order_list_img"><a href="#" target="_blank"><img src="images/buy.jpg" alt="title"/></a></div>
    <div class="order_list_title">
      <h2><span></span><a href="#" target="_blank">阿伦清吧KTV</a></h2>
    </div></td>
  <td> 1 </td>
  <td>￥118 </td>
  <td><span class="order_state">交易成功</span> <span class="details_link"> <a href="#">订单详情</a> </span></td>
  <td><a href="#" class="operate_btn pink_btn_new">评价</a><a href="#" class="delete_order d_block">删除订单</a></td>
</tr>
<tr>
  <td><div class="order_list_img"><a href="#" target="_blank"><img src="images/buy.jpg" alt="title"/></a></div>
    <div class="order_list_title">
      <h2><span></span><a href="#" target="_blank">阿伦清吧KTV</a></h2>
    </div></td>
  <td> 1 </td>
  <td>￥118 </td>
  <td><span class="order_state">退款中</span> <span class="details_link"><a href="#">订单详情</a><a href="#">退款详情</a></span></td>
  <td><a href="#" class="print_upload d_block">打印下载</a></td>
</tr>

<tr>
  <td><div class="order_list_img"><a href="#" target="_blank"><img src="images/buy.jpg" alt="title"/></a></div>
    <div class="order_list_title">
      <h2><span></span><a href="#" target="_blank">阿伦清吧KTV</a></h2>
    </div></td>
  <td> 1 </td>
  <td>￥118 </td>
  <td><span class="order_state">已退款</span> <span class="details_link"><a href="#">订单详情</a><a href="#">退款详情</a></span></td>
  <td><a href="#" class="delete_order d_block">删除订单</a></td>
</tr>

<tr>
  <td><div class="order_list_img"><a href="#" target="_blank"><img src="images/buy.jpg" alt="title"/></a></div>
    <div class="order_list_title">
      <h2><span></span><a href="#" target="_blank">阿伦清吧KTV</a></h2>
    </div></td>
  <td> 1 </td>
  <td>￥118 </td>
  <td><span class="order_state">已过期</span> <span class="details_link"><a href="#">订单详情</a></span></td>
  <td><a href="#" class="delete_order d_block">删除订单</a></td>
</tr>-->

            </table>
            <div class="t_page">
                <?php
                $this->widget('CLinkPager', array(
                    'header' => '',
                    'firstPageLabel' => '首页',
                    'lastPageLabel' => '末页',
                    'prevPageLabel' => '上一页',
                    'nextPageLabel' => '下一页',
                    'pages' => $pager,
                    'maxButtonCount' => 13,
                    'htmlOptions' => array('class' => 'pagination'),
                        )
                );
                ?>
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