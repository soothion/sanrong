<!--主体开始-->
<div class="main"> 
    <div class="wrap"> 
        <div class="u_main fl">
            <?php $this->renderPartial('../common/member_header') ?>

            <div class="order_details_title clearfix"> <strong>订单详情</strong> <a href="<?php echo $this->createUrl('/member/orders') ?>">返回我的订单</a> </div>
            <div class="order_details_state">

                <!--几种情况 1、交易成功，等待评价-->
                <p class="state_title">当前状态： <b class="c_ff4d88"> <?php echo OrdersModel::model()->get_order_status($model->order_status); ?></b></p>
                <?php if ($model->order_status == 1): ?>
                <div class="order_details_fn evaluate"> <a href="<?php echo $this->createUrl('/member/evaluate/evaluate',array('order_id'=>$model->id,'order_goods_id'=>$model->goods->id)) ?>" class="evaluate_btn pink_btn_new">发表评价</a> </div>
                <?php endif; ?>  

                <!-- 2、未付款，等待付款
                
                  <p class="state_title">当前状态： <b class="c_ff4d88"> 未付款</b></p>
                  <div class="order_details_fn evaluate"> <a href="#" class="evaluate_btn pink_btn_new">付款</a> <a href="#" class="delete_order d_block">删除</a></div>
                  
                -->

                <!-- 3、已付款，等待确认
               
                 <p class="state_title">当前状态： <b class="c_ff4d88"> 当面付，等待确认</b></p>
                 
                -->


            </div>

            <ul class="order_details_list">
                <li class="item">
                    <h2>订单信息</h2>
                    <ul class="order_infor clearfix">
                        <?php if ($model->order_status == 1): ?>
                            <!--几种情况 1、交易成功，等待评价-->
                            <li>订单编号：<?php echo $model->order_sn ?></li>
                            <li>下单时间：<?php echo date('Y-m-d H:i:s', $model->created); ?></li>         
                            <li>付款方式：<?php echo OrdersModel::model()->get_order_type($model->order_type) ?></li>
                            <li>付款时间：<?php echo date('Y-m-d H:i:s', $model->status1_time); ?></li>
                        <?php elseif ($model->order_status == 0): ?>
                            <!-- 2、未付款，等待付款 -->

                            <li>订单编号：<?php echo $model->order_sn ?></li>
                            <li>下单时间：<?php echo date('Y-m-d H:i:s', $model->created); ?></li>  
                            <?php if ($model->order_type): ?>
                                <li>付款方式：<?php echo OrdersModel::model()->get_order_type($model->order_type) ?></li>
                            <?php endif; ?>

                        <?php elseif ($model->order_status == 2): ?>
                            <!--交易成功，评价完成-->
                            <li>订单编号：<?php echo $model->order_sn ?></li>
                            <li>下单时间：<?php echo date('Y-m-d H:i:s', $model->created); ?></li>         
                            <li>付款方式：<?php echo OrdersModel::model()->get_order_type($model->order_type) ?></li>
                            <li>付款时间：<?php echo date('Y-m-d H:i:s', $model->status1_time); ?></li>
                            <li>完成时间：<?php echo date('Y-m-d H:i:s', $model->status2_time); ?></li>

                        <?php elseif ($model->order_status == 3): ?>
                            <!--订单已取消-->
                            <li>订单编号：<?php echo $model->order_sn ?></li>
                            <li>下单时间：<?php echo date('Y-m-d H:i:s', $model->created); ?></li>        
                            <li>取消时间：<?php echo date('Y-m-d H:i:s', $model->status3_time); ?></li>
                            <!-- 3、已付款，等待确认
                            
                            <li>订单编号：131734906</li>
                            <li>下单时间：2013-12-01 14:28</li> 
                            <li>付款方式：当面付</li>
                            
                            -->
                        <?php endif; ?>
                    </ul>
                </li>
                <li class="item">
                    <h2>商品信息</h2>
                    <table>
                        <tr>
                            <th style="width:45%;" class="padding20">
                                <a href="<?php echo $this->createUrl('/groupon_goods/index', array('id' => $model->goods->goods_id)); ?>" target="_blank"><img src="<?php echo $model->goods->goods_image ?>" width="50" /></a>
                                <a href="<?php echo $this->createUrl('/groupon_goods/index', array('id' => $model->goods->goods_id)); ?>" target="_blank"><?php echo $model->goods->goods_name ?></a>
                            </th>
                            <th style="width:15%;">单价</th>
                            <th style="width:5%;"></th>
                            <th style="width:10%;">数量</th>
                            <th style="width:5%;"></th>
                            <th style="width:20%;">支付金额</th>
                        </tr>
                        <tr>
                            <td class="padding20"><a target="_blank" href="<?php echo $this->createUrl('/groupon_goods/index', array('id' => $model->goods->goods_id)); ?>"><?php echo $model->goods->goods_name ?></a></td>
                            <td>￥<?php echo $model->goods->g_price ?></td>
                            <td><i></i></td>
                            <td><?php echo $model->goods->goods_count ?></td>
                            <td><i>=</i></td>
                            <td>￥<?php echo $model->goods->total_price ?></td>
                        </tr>
                    </table>
                    <div class="pay_infor clearfix">
                        <div class="amount">实付总额：<b>￥<?php echo $model->goods->total_price ?></b></div>
                    </div>
                </li>
                <li class="item">
                    <h2>收货人信息</h2>
                    <ul class="nmq_list">
                        <!--一张券或者多张券的情况-->
                        <li class="used"> 收货人姓名：<?php echo $model->address_name ?> </li>
                        <li class="used"> 收货人手机：<?php echo $model->user_mobile ?> </li>
                        <li class="used"> 收货人地址：<?php echo $model->address ?></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--左栏 团购列表结束--> 

        <!--右栏 侧边开始-->
        <?php $this->renderPartial('../common/fr'); ?>
        <!--右栏 侧边结束-->
        <div class="clear"></div>
    </div>
    <!--内容区结束--> 
</div>
<!--主体结束--> 