<style>
    .table.table1 th, .table td {
        border-top: 0;
    }
</style>
<table class="table table1">
    <tr>
        <th>买家信息：</th>
    </tr>
    <tr>
        <td>ID: <?php echo $model->user_id ?></td>
        <td>账号: <?php echo $model->user_email ?></td>
        <td></td>
    </tr>
    <tr>
        <td>收货人：<?php echo $model->address_name ?></td>
        <td>联系方式：<?php echo $model->user_mobile ?></td>
        <td>收货地址：<?php echo $model->address ?></td>
    </tr>
    <tr>
        <th>卖家信息：</th>

    </tr>
    <tr><td>名称：<?php echo $goodsModel->seller->name ?></td><td>地址：<?php echo $goodsModel->seller->address ?></td>
        <td>联系方式：<?php echo $goodsModel->seller->contact ?></td>
    </tr>
    <tr>
        <th>订单信息：</th>

    </tr>
    <tr><td>订单编号：<?php echo $model->order_sn ?></td><td>下单时间：<?php echo date('Y-m-d H:i:s',$model->created) ?></td>
        <?php if(numeric($model->status1_time) > 0): ?>
            <td>付款时间：<?php echo date('Y-m-d H:i:s',$model->status1_time) ?></td>
        <?php endif; ?>
            <?php if(numeric($model->status2_time) > 0): ?>
            <td>完成时间：<?php echo date('Y-m-d H:i:s',$model->status2_time) ?></td>
        <?php endif; ?>
        <?php if(numeric($model->status3_time) > 0): ?>
            <td>取消时间：<?php echo date('Y-m-d H:i:s',$model->status3_time) ?></td>
        <?php endif; ?>
    </tr>   
   
</table>
<table class="table">
    <thead>
     <tr>
        <th>商品信息：</th>
    </tr>
    <tr>
    <th>商品名称</th>
    <th>状态</th>
    <th>单价</th>
    <th>数量</th>
    <th>总价</th>
    </tr>
    </thead>
    <tbody>
    <td>
        <a target="_blank" href="<?php echo $this->createUrl('/groupon_goods/index',array('id'=>$model->goods->goods_id)); ?>"><img src="<?php echo $model->goods->goods_image ?>" width="50" /></a>
        <a target="_blank" href="<?php echo $this->createUrl('/groupon_goods/index',array('id'=>$model->goods->goods_id)); ?>"><?php echo $model->goods->goods_name ?></a>
    </td>
    <td><?php echo OrdersModel::model()->get_order_status($model->order_status) ?></td>
    <td><?php echo $model->goods->g_price ?></td>
    <td><?php echo $model->goods->goods_count ?></td>
    <td><?php echo $model->goods->total_price ?></td>
</tbody>
</table>
