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
                                <?php echo $model->discount ?>折
                            </div></div>
                    </div>
                    <div class="tx_a_con">
                        <div class="tx_a_btn"><a href="<?php echo $this->createUrl('orders/index', array('goods_id' => $model->id)) ?>" class="btn">抢购</a><a href="javascript:favorite(<?php echo $model->id ?>)" class="add">加入收藏</a></div>
                        <div class="tx_a_time"> 
                            <div class="tx_num"><b><?php echo GrouponGoodsModel::model()->get_salenum($model->id) ?></b>人已购买</div>
<!--                            <div class="lxftime" endtime="<?php echo date('m/d/Y H:i:s', $model->e_time) ?>"></div>-->
                        </div>
                        <div class="bz">
                            <b>温馨提示：</b><?php echo $model->feature ?>
                        </div>
                    </div>
                </div>
                <div class="tx_a_r"><img src="<?php echo $model->image ?>" width="460" height="280" /></div>
                <div class="clear"></div>
            </div>
            <div class="tx_a_di">
                <div class="favorite fl"><a href="javascript:favorite(<?php echo $model->id ?>)">加入收藏</a></div>
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
                <h4>同类其他热卖商品</h4>
                <?php foreach ($relation_goods as $k => $v): ?>
                    <p><a href="<?php echo $this->createUrl('groupon_goods/index', array('id' => $v->id)) ?>"><span class="b1">￥<?php echo numeric($v->g_price) ?></span><span class="b2">
                                <?php echo $v->discount ?>折</span><span class="b3"><?php echo $v->title ?>_<?php echo $v->summary ?></span><span class="b4"><?php echo GrouponGoodsModel::model()->get_salenum($v->id) ?>人购买</span></a></p>
                            <?php endforeach; ?>
            </div>

            <div class="tx_c">
                <div class="show_nav">
                    <div class="con"> <a href="javascript:;" class="on">商品介绍</a>
                        <!--                        <a href="javascript:;">商家介绍</a>-->
                        <a href="javascript:;">消费评价</a>
                    </div>
                </div>

                <!--本单详情开始-->
                <div class="tx_view_info">
                    <div class="tx_view_xq dd">                        
                        <?php echo $model->content ?>
                    </div>

                    <!--评论开始-->
                    <div class="tx_view_xq dd">

                        <!--无评论的模板--> 
                        <?php if (!$evaluate): ?>
                            <div class="evaluate tab_content">
                                <div class="evaluate_module overallEvaluate">
                                    <h2><strong>总体评价</strong></h2>
                                    <div class="evaluate_infor" id="evaluateInfor">
                                        <div class="member_grade clearfix">
                                            <div class="no_comment">暂无会员评分</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="evaluate_module" id="allEvaluate">
                                    <h2 class="allEvaluate clearfix"><strong class="title">全部评价</strong></h2>
                                    <div class="evaluate_infor1">
                                        <div class="no_comment">暂无会员评价</div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>

                        <!--end-->
                        <?php
                        $evaluateAll = GrouponEvaluateModel::model()->findAll('goods_id = ' . $_GET['id']);
                        $evaluate_count = count(object2array($evaluateAll));

                        $score = 0;
                        if ($evaluate_count) {
                            foreach ($evaluateAll as $v) {
                                $score += $v->stars;
                            }
                            $score = $score / $evaluate_count;
                        }
                        ?>
                        <!--有评论的模板-->
                        <div class="evaluate tab_content">
                            <div class="evaluate_module overallEvaluate">
                                <h2><strong>总体评价</strong></h2>
                                <div class="evaluate_infor" id="evaluateInfor">
                                    <div class="member_grade clearfix">
                                        <div class="grade_size">
                                            <p><strong><?php echo $score; ?></strong>分</p>
                                            <div class="grey_star">
                                                <div class="check_star" style="width:<?php echo ($score / 5) * 100 ?>%"></div>
                                            </div>
                                        </div>
                                        <div class="grade_state">
                                            <div class="g_statistics">
                                                <p>已有<strong><?php echo $evaluate_count ?></strong>人评价</p>
                                                <?php
                                                $satisfy = 0;
                                                $sat = 0;
                                                if (count(object2array($evaluateAll))) {
                                                    foreach ($evaluateAll as $k => $v) {
                                                        if ($v->stars == 4 || $v->stars == 5) {
                                                            $satisfy += 1;
                                                        }
                                                    }
                                                    $sat = ($satisfy / count(object2array($evaluateAll))) * 100;
                                                }
                                                ?>
                                                <p><strong><?php echo $sat ?>%</strong>的会员满意本次购买</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="evaluate_module" id="allEvaluate">
                                <div id="page_hide" style="display:none"><?php echo $count ?></div>
                                <h2 class="allEvaluate clearfix"><strong class="title">全部评价</strong></h2>
                                <div class="evaluate_infor1">
                                    <ol class="evaluate_list" id="evaluateList" style="position: relative;">
                                        <?php foreach ($evaluate as $k => $v): ?>
                                            <li>
                                                <div class="ei_top">
                                                    <div><?php echo $v->orders->user_email ?><em><?php echo date('Y-m-d H:i:s', $v->created) ?></em></div>
                                                    <div class="grade_star star_fr gsa<?php echo $v->stars ?>"></div>
                                                </div>
                                                <p><?php echo $v->content ?></p>
                                            </li>
                                        <?php endforeach; ?>

                                    </ol>
                                </div>
                                <div class="t_page">
                                    <?php echo $pages ?>
                                    <?php
//                                    $this->widget('CLinkPager', array(
//                                        'header' => '',
//                                        'firstPageLabel' => '首页',
//                                        'lastPageLabel' => '末页',
//                                        'prevPageLabel' => '上一页',
//                                        'nextPageLabel' => '下一页',
//                                        'pages' => $pages,
//                                        'maxButtonCount' => 13
//                                            )
//                                    );
                                    ?>
                                </div>
                            </div>
                            
                        </div>
                        <?php endif; ?>
                        <!--end-->          
                    </div>
                    <!--end-->  
                </div>



            </div>

        </div>

        <!--右栏 侧边开始-->
        <?php $this->renderPartial('../common/fr'); ?>
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
    function favorite(goods_id) {
        $.post("<?php echo $this->createUrl('groupon_goods/favorite') ?>", {goods_id: goods_id}, function(data) {
            alert(data.info);
        }, 'json')
    }
    $(function() { //alert($('#page_hide').html());
        $('.t_page a').live('click', function() {
            var goods_id = <?php echo $_GET['id'] ?>;
            var page = 1;
            switch ($(this).attr('id')) {
                case 'first':
                    page = 1;
                    break;
                case 'prev' :
                    var current = parseInt($('.page_cur').html());
                    if (current > 1) {
                        page = current - 1;
                    } else {
                        //page = 1 
                        return false;
                    }
                    break;
                case 'next' :
                    var current = parseInt($('.page_cur').html());
                    if (current < parseInt($('#page_hide').html())) {
                        page = current + 1;
                    } else {
                        return false;
                    }
                    break;
                case 'last':
                    page = parseInt($('#page_hide').html());
                    break;
                default:
                    page = $(this).html();
            }
            $.post("<?php echo $this->createUrl('/groupon_goods/ajax_evaluate') ?>", {page: page, goods_id: goods_id}, function(data) {
                var content = "";
                $.each(data.data, function(k, v) {
                    content += '<li><div class="ei_top"><div>' + v.email + '<em>' + v.created + '</em></div><div class="grade_star star_fr gsa' + v.stars + '"></div></div><p>' + v.content + '</p></li>';
                });
                $('#evaluateList').html(content);
                $('.t_page').html(data.pages);
                $('#page_hide').html(data.pageMax)
            }, 'json');
            $("html,body").animate({scrollTop: $(".show_nav").offset().top}, 1000);
            return false;
        });
//        $('.t_page a').click(function() {
//            
//        });
    });
</script>
