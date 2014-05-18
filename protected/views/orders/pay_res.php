<?php if($order_type == 4): ?>
<div class="wrap">
  <div class="tg_buy">
    <div class="buy_nav">
      <div class="buy_process_h">购买<span>仅需三步</span></div>
      <div class="buy_process">
        <ul>
          <li class="item1 no_current">1 提交订单</li>
          <li class="item2 no_current1" >2 选择支付方式</li>
          <li class="item3 current">3 购买成功</li>
        </ul>
      </div>
    </div>
    <div class="order_sucess">
        <p>当面付提交成功，稍后工作人员会与您（<?php echo $model->user_mobile ?>）联系。如有疑问，请致电：0898-66861101（工作时间：8:00--18:00）。</p>
        <p>您可以：<a href="<?php echo $this->createUrl('/member/orders/view',array('id'=>$model->id)) ?>">查看订单</a> 或 <a href="<?php echo $this->createAbsoluteUrl('/'); ?>">返回首页</a></p>
    </div>
  </div>
</div>
<?php endif; ?>