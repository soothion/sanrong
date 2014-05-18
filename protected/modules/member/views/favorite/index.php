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
                    <th style="width:10%;">价格</th>
                    <th style="width:17%;">状态</th>
                    <th style="width:20%;">操作</th>
                </tr>
                <?php foreach($model as $k=>$v): ?>
                <tr>
                    <td>
                        <div class="order_list_img">
                            <a href="<?php echo $this->createUrl('/groupon_goods/index',array('id'=>$v->goods->id)) ?>" target="_blank">
                                <img src="<?php echo $v->goods->image ?>" alt="title"/>
                            </a>
                        </div>
                        <div class="order_list_title">
                            <h2>
<!--                                <span></span>-->
                                <a href="<?php echo $this->createUrl('/groupon_goods/index',array('id'=>$v->goods->id)) ?>" target="_blank"><?php echo $v->goods->title ?></a></h2>
                        </div></td>
                        <td>￥<?php echo $v->goods->g_price ?> </td>
                    <td>进行中</td>
                    <td><a href="<?php echo $this->createUrl('delete',array('id'=>$v->id)) ?>" class="delete_order d_block">删除</a></td>
                </tr>
                <?php endforeach; ?>
            </table>
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
