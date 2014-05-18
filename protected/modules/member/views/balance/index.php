<!--主体开始-->
<div class="main"> 
    <!--内容区开始-->
    <div class="wrap"> 
        <!--左栏 团购列表开始-->
        <div class="u_main fl">

            <?php $this->renderPartial('../common/member_header') ?>

            <div class="balance_operate">
                <span class="my_balance">您的账号现在余额为：<b>0元</b></span>
                <a href="/uc/account/charge" class="green_btn">充值</a>
            </div>
            <div class="zh_jl">交易记录</div>
            <table class="order_list module_table">
                <tr>
                    <th style="width:25%;">时间</th>
                    <th style="width:55%;">详情</th>
                    <th style="width:20%;">金额</th>
                </tr>
<!--                <tr>
                    <td>2014-01-13 16:31</td>
                    <td class="txt_left">退款到银行卡 -  <em class="c_949494">余额提现</em></td>
                    <td><span class="c_ff4d88">- ￥118</span></td>
                </tr>-->

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