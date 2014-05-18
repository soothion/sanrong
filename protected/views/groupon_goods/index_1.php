<script type="text/javascript" src="/static/jquery/jquery.js"></script>
<div class='main'>
    <div class="position"><?php echo $this->seo['position'] ?></div>
    <div class="wrap">
        <div class="tx_deal fl">
            <div class="tx_a">
                <h1><?php echo $model->title ?></h1>
                <h2><?php echo $model->summary; ?></h2>
                <div class="tx_a_l">
                    <div class="tx_a_price">
                        <div class="price"><?php echo intval($model->g_price) ?></div>
                        <div class="old">
                            <div class="em">门店价￥ <?php echo intval($model->m_price) ?></div>
                            <div class="zk">
                                <?php if(numeric($model->m_price) > 0):?>
                                <?php echo number_format($model->g_price/$model->m_price*10,1) ?>
                                <?php else: ?>
                                <?php echo 0 ?>
                                <?php endif ?>折
                            </div></div>
                    </div>
                    <div class="tx_a_con">
                        <div class="tx_a_btn"><a href="<?php echo $this->createUrl('orders/index',array('goods_id'=>$model->id)) ?>" class="btn">抢购</a><a href="javascript:favorite(<?php echo $model->id ?>)" class="add">加入收藏</a></div>
                        <div class="tx_a_time"> 
                            <div class="tx_num"><b>201</b>人已团购</div>
                            <div class="lxftime" endtime="<?php echo date('m/d/Y H:i:s',$model->e_time)  ?>"></div>
                        </div>
                        <div class="bz">
                            <div class="bz1"></div>
                            <div class="bz2"></div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="tx_a_r"><img src="<?php echo $model->image ?>" width="460" height="280" /></div>
                <div class="clear"></div>
            </div>
            <div class="tx_a_di">
                <div class="favorite fl"><a href="javascript:favorite(<?php echo $model->id ?>)">收藏本单</a></div>
                <div class="share fr">
                    <!-- Baidu Button BEGIN -->
                    <div style="float:left; line-height:30px;">分享到：</div>
                    <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">

                        <a class="bds_renren"></a>
                        <a class="bds_sqq"></a>
                        <a class="bds_douban"></a>
                        <a class="bds_tsina"></a>
                        <a class="bds_qzone"></a>
                        <a class="bds_tqq"></a>
                        <span class="bds_more"></span>
                    </div>
                    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6665962" ></script>
                    <script type="text/javascript" id="bdshell_js"></script>
                    <script type="text/javascript">
                        document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date() / 3600000)
                    </script>
                    <!-- Baidu Button END -->
                </div>
            </div>

            <div class="tx_b">
                <h4>海口万达影城其他热卖套餐</h4>
                <?php foreach($relation_goods as $k=>$v): ?>
                <p><a href="<?php echo $this->createUrl('groupon_goods/index',array('id'=>$v->id)) ?>"><span class="b1">￥<?php echo $v->g_price ?></span><span class="b2"><?php if(numeric($model->m_price) > 0):?>
                                <?php echo number_format($model->g_price/$model->m_price*10,1) ?>
                                <?php else: ?>
                                <?php echo 0 ?>
                                <?php endif ?>折</span><span class="b3"><?php echo $v->title ?>_<?php echo $v->summary ?>_糯米网其他娱乐团购</span><span class="b4">6522人团购</span></a></p>
                <?php endforeach; ?>
            </div>

            <div class="tx_c">
                <div class="show_nav">
                    <div class="con"> <a href="javascript:;" class="on">本单详情</a><a href="javascript:;">商家介绍</a><a href="javascript:;">消费评价</a>
                    </div>
                </div>

                <!--本单详情开始-->
                <div class="tx_view_info">
                    <div class="tx_view_xq dd">
                        <div class="tx_tit_big"><div class="con">商家位置</div></div>
                        <div class="tx_address">
                            <div class="tx_map"><img src="<?php echo $model->seller->image ?>" width="408" height="206" /></div>
                            <div class="tx_dz">
                                <h4><?php echo $model->seller->name ?></h4>
                                <p><?php echo $model->seller->address ?></p>
                                <p><a href="#">查看地图</a></p>
                                <p>营业时间：<?php echo $model->seller->work_time ?></p>
                                <p>电话：<?php echo $model->seller->contact ?></p>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="tx_tit_big"><div class="con">团购详情</div></div>
                        <div class="tx_xq">
                            <div class="tx_tit_s">【本单详情】</div>
                            <div class="tx_info_con">
                                <?php echo $model->content ?>
                            </div>
                            <div class="tx_tit_ts">【温馨提示】</div>
                            <div class="tx_con_ts">
                                <?php echo $model->tip ?>
                            </div>

                            <div class="tx_tit_s"><?php echo $model->seller->name ?></div>
                            <div class="tx_info_con">
                                <p><?php echo $model->seller->introduce ?></p>
                            </div>
                        </div>
                    </div>

                    <!--商家介绍开始-->
                    <div class="tx_view_xq dd">
                        <div class="tx_tit_big"><div class="con">商家位置</div></div>
                        <div class="tx_address">
                            <div class="tx_map"><img src="<?php echo $model->seller->image ?>" width="408" height="206" /></div>
                            <div class="tx_dz">
                                <h4><?php echo $model->seller->name ?></h4>
                                <p><?php echo $model->seller->address ?></p>
                                <p><a href="#">查看地图</a></p>
                                <p>营业时间：<?php echo $model->seller->work_time ?></p>
                                <p>电话：<?php echo $model->seller->contact ?></p>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="tx_xq">
                            <div class="tx_tit_s"><?php echo $model->seller->name ?></div>
                            <div class="tx_info_con">
                                <p><?php echo $model->seller->introduce ?></p>
                            </div>
                        </div>
                    </div>
                    <!--商家介绍结束-->

                </div>
                <!--本单详情结束-->


            </div>

        </div>

        <!--右栏 侧边开始-->
        <?php $this->renderPartial('../common/fr');  ?>
        <!--右栏 侧边结束-->
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">

    $(function() {
        var tabTitle = ".show_nav a";
        var tabContent = ".dd";
        $(tabTitle + ":first").addClass("on");
        $(tabContent).not(":first").hide();
        $(tabTitle).unbind("click").bind("click", function() {
            $(this).siblings("a").removeClass("on").end().addClass("on");
            var index = $(tabTitle).index($(this));
            $(tabContent).eq(index).siblings(tabContent).hide().end().fadeIn(0);
        });
    });
</script>
<script>
    function lxfEndtime() {
        $(".lxftime").each(function() {
            var lxfday = $(this).attr("lxfday");//用来判断是否显示天数的变量
            var endtime = new Date($(this).attr("endtime")).getTime();//取结束日期(毫秒值)
            var nowtime = new Date().getTime();        //今天的日期(毫秒值)
            var youtime = endtime - nowtime;//还有多久(毫秒值)
            var seconds = youtime / 1000;
            var minutes = Math.floor(seconds / 60);
            var hours = Math.floor(minutes / 60);
            var days = Math.floor(hours / 24);
            var CDay = days;
            var CHour = hours % 24;
            var CMinute = minutes % 60;
            var CSecond = Math.floor(seconds % 60);//"%"是取余运算，可以理解为60进一后取余数，然后只要余数。
            if (endtime <= nowtime) {
                $(this).html("已过期")//如果结束日期小于当前日期就提示过期啦
            } else {
                if ($(this).attr("lxfday") == "no") {
                    $(this).html("<span>" + CHour + "</span>时<span>" + CMinute + "</span>分<span>" + CSecond + "</span>秒");          //输出没有天数的数据
                } else {
                    $(this).html("<span>" + days + "</span><em>天</em><span>" + CHour + "</span><em>时</em><span>" + CMinute + "</span><em>分</em><span>" + CSecond + "</span><em>秒</em>");          //输出有天数的数据
                }
            }
        });
        setTimeout("lxfEndtime()", 1000);
    }
    ;
    $(function() {
        lxfEndtime();
    });
    function favorite(goods_id){
        $.post("<?php echo $this->createUrl('groupon_goods/favorite') ?>",{goods_id:goods_id},function(data){
            alert(data.info);
        },'json')
    }
</script>
