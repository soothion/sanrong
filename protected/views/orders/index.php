<div class='main'>
    <!--内容区开始-->
    <div class="wrap">
        <div class="tg_buy">
            <div class="buy_nav">
                <div class="buy_process_h">购买<span>仅需三步</span></div>
                <div class="buy_process">
                    <ul>
                        <li class="item1 current">1 提交订单</li>
                        <li class="item2 no_current" >2 选择支付方式</li>
                        <li class="item3">3 购买成功</li>
                    </ul>
                </div>
            </div>

            <table class="shoppingC_list" id="shoppingCartList">
                <tr>
                    <th class="check_hidden" style="width: 2%;"></th>
                    <th style="width: auto;">商品名称</th>
                    <th style="width: 20%;">数量<span class="restriction">（限<i>100</i>件）</span></th>
                    <th style="width: 14%;">单价</th>
                    <th style="width: 14%;">小计（元）</th>
                    <th style="width: 2%;"></th>
                </tr>
                <tr>
                    <td class="no_border">
                        <input type="hidden" name="count" id="count" value="1">
                        <input type="hidden" name="dealId" id="dealId" value="413549">
                        <input type="hidden" name="city" value="2600010000">
                        <input type="hidden" name="orderId" value="0">
                    </td>
                    <td class="goods_name">
                        <a href="<?php echo $this->createUrl('groupon_goods/index',array('id'=>$goodsModel->id)) ?>" target="_blank" title="<?php echo $goodsModel->title ?>" class="clearfix">
                            <img src="<?php echo $goodsModel->image ?>"/> <strong><?php echo $goodsModel->title ?></strong>
                        </a>
                    </td>
                    <td>      
                        <a href="javascript:changeCount('reduce')" class="reducing_num out_scope_r" id="minus">-</a>
                        <input type="text" value="1" onblur="changeCount('set')" id="goods_count" autocomplete="off" maxlength="4" price="31.5" max="100" min="1" class="num_box" data-max='5' data-min='1' />
                        <a href="javascript:changeCount('add')" class="add_num" id="plus">+</a>
                        <span class="s_error"></span>    
                    </td>
                    <td>
                        ￥<?php echo $goodsModel->g_price ?>
                    </td>
                    <td>
                        ￥<span class="s_total">
                            <?php echo $goodsModel->g_price ?>
                        </span>

                    </td>
                    <td class="no_border"></td>
                </tr>
                <tr>
                    <td colspan="3"><!--<p class="c_prompt">提示：代金券、余额已调整至下一步"选择支付方式"中，您可以在下一步选择使用，以抵充应付金额。</p>--></td>
                    <td colspan="3" class="price_count">
                        <p>
                            应付总额：<strong id="totalAmount">
                                ￥<span class="t_amount">
                                    <?php echo $goodsModel->g_price ?>
                                </span>
                            </strong>
                        </p>
                    </td>
            </table>
            <div class="order_pay">
                <form method="post" action="<?php echo $this->createUrl('orders/check'); ?>">
                <input type="submit" islogin="false" value="提交订单，去支付"
                       id="submitOrderGoPay"/>
                <input type='hidden' name='goods_id' value="<?php echo $goodsModel->id ?>" />
                <input type='hidden' name='goods_count' value='1' />
                </form>
            </div>
            <div class="clear"></div>
        </div>
    </div> 
</div>
<!--主体结束--> 
<script type="text/javascript">
    function changeCount(way){
        var goods_count = $('#goods_count').val();
        goods_count = parseInt(goods_count);
        if(way == 'reduce'){
            
            if(goods_count == 1){
                alert('数量不能小于1');
                return false;
            }
            goods_count -= 1;
        }else if(way == 'add'){
            if(goods_count == 100){
                alert('数量不能大于100');
                return false;
            }
            goods_count += 1;
        }else if(way == 'set'){
            if(goods_count <= 0){
                $('#goods_count').val(1); 
                alert('数量不能小于1');
                return false;
            }
            if(goods_count > 100){               
                $('#goods_count').val(100);
                alert('数量不能大于100');
                return false;
            }
        }
        $('#goods_count').val(goods_count);
        $('input[name=goods_count]').val(goods_count);
        changePrice(goods_count);
    }
    function changePrice(goods_count){
        $.post("<?php echo $this->createUrl('orders/change_price'); ?>",{goods_count:goods_count,goods_id:<?php echo $goodsModel->id; ?>},function(data){
            if(data.status == 1){
                $('.t_amount').html(data.total_price);
                $('.s_total').html(data.total_price);
            }
        },'json');
    }
</script>