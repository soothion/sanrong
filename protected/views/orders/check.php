    <!--内容区开始-->
    <div class="wrap">
        <div class="tg_buy">
            <div class="buy_nav">
                <div class="buy_process_h">购买<span>仅需三步</span></div>
                <div class="buy_process">
                    <ul>
                        <li class="item1 no_current1">1 提交订单</li>
                        <li class="item2 current" >2 选择支付方式</li>
                        <li class="item3">3 购买成功</li>
                    </ul>
                </div>
            </div>
            <div class="order_details">
                <h2>项目名称及数量</h2>
                <ul>
                    <li>
                        <p><?php echo $orderGoodsModel->goods_name ?><i>单价：￥<?php echo $orderGoodsModel->g_price ?></i><i>共<?php echo $orderGoodsModel->goods_count ?>份</i></p>
                    </li>
                </ul>
<!--                <h2>接收密码的手机号</h2>
                <p><span><?php //echo $model->user_mobile ?></span>，凭密码去商家消费</p>-->
            </div> 
            <div class="payable_money">应付金额<strong id="payableMoney">￥<?php echo $model->total_price ?></strong></div>
            <form action="<?php echo $this->createUrl('/orders/pay'); ?>" method="post" >
            <div class="payment_way" id="paymentWay">
                <h2>请选择支付方式</h2>
                <div class="item">
                   <!-- <h3>其他方式支付：</h3>-->
                    <div class="other_payment_way">
                        <label for="mobilePayment" class="payment_way_activity">
                            <input type="radio" name="payType" checked="checked" value="4" id="mobilePayment"/>
                            <span class="">当面付</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="payment_way">
                <h2>收货人信息</h2>
                <div class="item">
                    <div class="payinfo">
            			<ul>
                                    <li><em>收货人姓名：</em><input type="text" id="address_name" name="address_name" value="<?php echo $model->address_name ?>" /> <i>*</i> </li>
                    		<li><em>收货人手机：</em><input type="text" id="user_mobile" name="user_mobile" value="<?php echo $model->user_mobile ?>" /> <i>*</i></li>
                    		<li><em>收货人地址：</em><input type="text" id="address" name="address" value="<?php echo $model->address ?>"  class="address"/> <i>*</i></li>
                 		</ul>
   					</div>    
              	</div>
      		</div>
            <div class="payment_btn">
                <a href="/deal/buy?tinyurl=mftt0fx1&orderId=136949626&city=haikou&p=-">&lt&lt返回修改订单</a>
                <input type="submit" id="cSubmit" isChargeDeal="false"/>
            </div>
                <input type="hidden" name="order_id" value="<?php echo $model->id ?>" />
            </form>
            <div class="clear"></div>
        </div>
    </div>
    <!--内容区结束--> 