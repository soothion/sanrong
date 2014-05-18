<?php
$resumeModel2 = UserResumeModel::model()->find('status = 0');
$orderModel2 = OrdersModel::model()->find('order_status = 0 and order_type = 4');
$enterpriseModel2 = UserModel::model()->find('(status = 0 and user_type > 0) or user_type = 2');
$WorkerModel2 = WorkerModel::model()->find('status = 0');
$workerInfoModel2 = WorkerInfoModel::model()->find('status = 1 or status = 2');
//商品总数
$goodsCount = GrouponGoodsModel::model()->count();
$goodsModel = GrouponGoodsModel::model()->findAll(array('select'=>'views'));
$goodsViews = 0;
foreach($goodsModel as $v){
    $goodsViews = $goodsViews + $v->views;
}
$orderModel = OrdersModel::model()->findAll(array('select'=>'order_status'));
$orderAll = count(object2array($orderModel));//所有订单
$orderPaied = 0;//已付款订单
$orderPay = 0;//未付款订单

foreach($orderModel as $v){
    if($v->order_status == 0){
        $orderPay += 1;
    }elseif($v->order_status == 1 || $v->order_status == 2){
        $orderPaied += 1;
    }
}
//会员总数
$userCount = UserModel::model()->count('user_type=0');
//简历
$resumeModel = UserResumeModel::model()->findAll(array('select'=>'status'));
$resumeAll = count(object2array($resumeModel));
$resume1 = 0;//已通过
$resume0 = 0;//未通过
foreach($resumeModel as $v){
    if($v->status == 1){
        $resume1 += 1;
    }else{
        $resume0 += 1;
    }
}
//企业会员
$enterpriseAll =  UserModel::model()->count('user_type > 0');
$enterpriseAll1 = UserModel::model()->count('user_type = 1');
$enterpriseAll2 = UserModel::model()->count('user_type > 1');
//业务员
$workerAll = WorkerModel::model()->count();
$workerAll1 = WorkerModel::model()->count('status = 1');
$workerAll2 = WorkerModel::model()->count('status = 0 or status = 2');
?>
<table class='table'>
    <thead>
        <tr>
            <th colspan='4'>登录信息</th>
        </tr>
        <tr>
            <td colspan='4'>您好：<?php echo Yii::app()->user->name ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                您上次登录时间是：<?php echo date('Y-m-d H:i:s', Yii::app()->user->getState('last_login')) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                IP是：<?php echo Yii::app()->user->getState('last_ip'); ?>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th colspan='4'>待办事项</th>
        <tr>
            <td><?php
                if ($resumeModel2) {
                    echo "您有未审核的简历，<a href='" . $this->createUrl('/admin/resume') . "'>前往审核？</a>";
                }else{
                    echo "无未审核的简历";
                }
                ?>
            </td>
            <td><?php
                if ($orderModel2) {
                    echo "您有未处理的订单，<a href='" . $this->createUrl('/admin/groupon_order') . "'>前往处理？</a>";
                }else{
                    echo "无未处理的订单";
                }
                ?></td>
            <td><?php
                if ($enterpriseModel2) {
                    echo "您有未审核的企业，<a href='" . $this->createUrl('/admin/enterprise') . "'>前往审核？</a>";
                }else{
                    echo '无未审核的企业';
                }
                ?></td>
            <td>
                <?php
                if ($WorkerModel2) {
                    echo "您有未审核的业务员，<a href='" . $this->createUrl('/admin/worker') . "'>前往审核？</a>";
                }else{
                    echo '无未审核的业务员';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php
                if ($workerInfoModel2) {
                    echo "您有未处理的业务反馈，<a href='" . $this->createUrl('/admin/worker/worker_info') . "'>前往处理？</a>";
                }else{
                    echo '无未处理的业务反馈';
                }
                ?>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th colspan='4'>统计信息</th>            
        <tr>
            <tr>
                <td>商品总数：<?php echo $goodsCount; ?></td>
                <td>浏览总次数：<?php echo $goodsViews; ?></td>
                <td></td><td></td>
            </tr>
            <tr>
                <td>总订单数：<?php echo $orderAll ?></td>
                <td>已付款订单数：<?php echo $orderPaied ?></td>
                <td>未付款订单数：<?php echo $orderPay ?></td>
                <td></td>
            </tr>
            <tr>
                <td>会员总数：<?php echo $userCount ?></td>
                <td></td><td></td><td></td>
            </tr>
            <tr>
                <td>总简历份数：<?php echo $resumeAll ?></td>
                <td>已通过：<?php echo $resume1?></td>
                <td>未通过：<?php echo $resume0 ?></td>
                <td></td>
            </tr>
            <tr>
                <td>总企业会员数量： <?php echo $enterpriseAll ?> </td>
                <td>已通过： <?php echo $enterpriseAll1 ?> </td>
                <td>未通过： <?php echo $enterpriseAll2 ?> </td>
                <td></td>
            </tr>
            <tr>
                <td>总业务员数量： <?php echo $workerAll ?> </td>
                <td>已通过： <?php echo $workerAll1 ?> </td>
                <td>未通过： <?php echo $workerAll2 ?> </td>
                <td></td>
            </tr>
    <!--    <tr>
            <th colspan='4'>系统信息</th>
        </tr>
        <tr>
            <td style="width:120px" valign="top">服务器操作系统：</td>
            <td  valign="top"><?php echo php_uname(); ?></td>
            <td style="width:120px" valign="top">软件版本：</td>
            <td  valign="top"><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
        </tr>
        <tr>
            <td valign="top">服务器协议：</td>
            <td valign="top"><?php echo $_SERVER['SERVER_PROTOCOL']; ?></td>
            <td valign="top">服务器名称：</td>
            <td valign="top"><?php echo $_SERVER['SERVER_NAME']; ?></td>
        </tr>
        <tr>
            <td valign="top">网关接口：</td>
            <td valign="top"><?php echo $_SERVER['GATEWAY_INTERFACE']; ?></td>
            <td valign="top">服务器IP：</td>
            <td valign="top"><?php echo $_SERVER['SERVER_ADDR']; ?></td>
        </tr>
        <tr>
            <td valign="top">Socket支持：</td>
            <td valign="top">是</td>
            <td valign="top">时区设置：</td>
            <td valign="top">中华人民共和国</td>
        </tr>
        <tr>
            <td valign="top">是否开启文件上传：</td>
            <td valign="top"><?php echo ini_get('file_uploads') ?>
                &nbsp;&nbsp;[1代表开启,0代表关闭]</td>
            <td valign="top">文件上传的最大大小：</td>
            <td valign="top"><?php echo ini_get('upload_max_filesize') ?></td>
        </tr>
        <tr>
            <td valign="top">编码：</td>
            <td valign="top">UTF-8</td>
            <td valign="top">是否自动转义：</td>
            <td valign="top"><?php echo ini_get('magic_quotes_gpc') ? "是" : "否"; ?></td>
        </tr>-->
    </tbody>
</table>
<script>
//    $(function() {
//        $(".table tbody tr").each(function(k, v) {
//            $(this).find('td:eq(0)').css({'text-align': 'right', "font-weight": 'bold'});
//            $(this).find('td:eq(2)').css({'text-align': 'right', "font-weight": 'bold'});
//        });
//    })
</script>