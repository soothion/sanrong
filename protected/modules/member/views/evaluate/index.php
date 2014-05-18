<!--主体开始-->
<div class="main"> 
    <!--内容区开始-->
    <div class="wrap"> 
        <!--左栏 团购列表开始-->
        <div class="u_main fl">
            <?php $this->renderPartial('../common/member_header') ?>
            <table class="order_list module_table">
                <tr>
                    <th style="width:40%;">项目</th>
                    <th style="width:40%;">数量</th>
<!--                    <th style="width:17%;">总价</th>
                    <th style="width:15%;">状态</th>-->
                    <th style="width:20%;">操作</th>
                </tr>
                <?php foreach ($model as $k => $v): ?>
                    <tr>
                        <td><div class="order_list_img"><a href="#" target="_blank"><img src="<?php echo $v->order_goods->goods_image ?>" alt="title"/></a></div>
                            <div class="order_list_title">
                                <h2><span></span><a href="#" target="_blank"><?php echo $v->order_goods->goods_name ?></a></h2>
                            </div></td>
                        <td> <?php echo $v->order_goods->goods_count ?>&nbsp;&nbsp;&nbsp;&nbsp;￥<?php echo $v->orders->total_price ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo OrdersModel::model()->get_order_status($v->orders->order_status) ?></td>
                        <td><a href="<?php echo $this->createUrl('/member/evaluate/evaluate',array('id'=>$v->id)); ?>" class="print_upload">修改</a><a href="<?php echo $this->createUrl('/member/evaluate/delete',array('id'=>$v->id)); ?>" class="print_upload">删除</a></td>
                    </tr>
                <?php endforeach ?>
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
