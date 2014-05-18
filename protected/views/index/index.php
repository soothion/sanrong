<!--主体开始-->
<div class='main'>

    <!--筛选器开始-->
    <div class="search_box">
        <!--专题筛选开始-->
        <div class="selbox hotbox">
            <h5>热门专题：</h5>
            <ul>
                <?php foreach( $groupon_subject as $k=>$v): ?>
                <li><a href="<?php echo get_subject_url($v->id) ?>"><?php echo $v->name; ?></a></li>
                <?php endforeach; ?>
            </ul>
            <div class="clear"></div>
        </div>
        <!--专题筛选结束--> 

        <!--分类筛选开始-->
        <div class="selbox sortbox">
            <h5>分类：</h5>
            <ul>
                <li><a href="javascript:goods_filter(0,0)" class='on'>全部</a></li>
                <?php foreach ($groupon_category as $k => $v): ?>
                    <li><a  href="javascript:goods_filter(<?php echo $v->id ?>,0)"><?php echo $v->name; ?><em></em></a></li>
                <?php endforeach; ?>
            </ul>
            
            <div class="clear"></div>            
        </div>
        <!--分类筛选结束--> 

        <!--区域筛选开始-->
        <div class="selbox areabox">
            <h5>区域：</h5>
            <ul>
                <li><a href="javascript:goods_filter(0,2)" class='on'>全部</a></li>
                <?php foreach ($groupon_area as $k => $v): ?>
                <li><a  href="javascript:goods_filter(<?php echo $v->id ?>,2)" ><?php echo $v->name ?><em></em></a></li>
                <?php endforeach; ?>
            </ul>

            

            <div class="clear"></div>
        </div>
        <!--区域筛选结束--> 

        <!--结果排序开始-->
        <div class="resultbox">
            <h5>排序：</h5>
            <div class="order"> <a href="<?php echo $this->createUrl('/groupon_category/index',array('filter'=>"0-0-0-0-iasc")); ?>" class="default default_on">默认</a><a href="<?php echo $this->createUrl('/groupon_category/index',array('filter'=>"0-0-0-0-sdesc")); ?>" class="sales">销量</a><a href="<?php echo $this->createUrl('/groupon_category/index',array('filter'=>"0-0-0-0-ddesc")); ?>" class="discount">折扣</a> </div>
        </div>
        <!--结果排序结束--> 

    </div>
    <!--筛选器结束--> 
    <!--内容区开始-->
    <div class="wrap">
        <!--左栏 团购列表开始-->
        <div class="t_deal fl">
            <ul>

                <!--团购列表 li标签循环-->
                <?php foreach ($groupo_goods as $k => $v): ?>
                    <li>
                        <div class="deal_outer">

                            <!--新单开始    如果是最近两天发布的，就有下面这个div，否则没有-->
                            <?php if (($v->created) + 3600 * 2 >= time()): ?>
                                <div class="deal_new"></div>
                            <?php endif; ?>
                            <!--新单结束-->

                            <div class="deal_img"><a href="<?php echo $this->createUrl('groupon_goods/index',array('id'=>$v->id)) ?>"><img src="<?php echo $v->image ?>" width="470" height="285" /></a></div>
                            <h2><a href="<?php echo $this->createUrl('groupon_goods/index',array('id'=>$v->id)) ?>"><?php echo $v->title ?></a></h2>
                            <h3><a href="<?php echo $this->createUrl('groupon_goods/index',array('id'=>$v->id)) ?>"><?php echo $v->summary; ?></a></h3>
                            <div class="deal_price">
                                <div class="price"> <span class="symbol">￥</span><?php echo numeric($v->g_price) ?> <span class="value">价值<span class="symbol">￥</span><?php echo numeric($v->m_price) ?></span></div>
                                <span class="deal_btn"> <a href="<?php echo $this->createUrl('groupon_goods/index',array('id'=>$v->id)) ?>" target="_blank" class="go" description="" alt="">抢购</a></span></div>
                            <div class="deal_people"> <span class="people"><span class="num"><?php echo GrouponGoodsModel::model()->get_salenum($v->id) ?></span>人购买</span></div>
                        </div>
                    </li>
                <?php endforeach; ?>
                <!--团购列表 结束-->
                <div class="clear"></div>
            </ul>
        </div>
        <!--左栏 团购列表结束--> 

        <!--右栏 侧边开始-->
        <?php $this->renderPartial('../common/fr');  ?>
        <!--右栏 侧边结束-->
        <div class="clear"></div>
        <!--<div class="t_page"><span class="page_cur">1</span><a href="#">2</a> <a href="#">下一页</a> <a  href="#">最后一页</a> 20 条记录</div>-->
        <div class="t_page">
            <?php
            $this->widget('CLinkPager', array(
                'header' => '',
                'firstPageLabel' => '首页',
                'lastPageLabel' => '末页',
                'prevPageLabel' => '上一页',
                'nextPageLabel' => '下一页',
                'pages' => $pages,
                'maxButtonCount' => 13
                    )
            );
            ?>
        </div>
    </div>
</div>
    <!--内容区结束--> 
<!--主体结束--> 
<script type="text/javascript">
                function goods_filter(id, layer) {
                    var url = "<?php echo $this->createUrl('groupon_category/index',array('filter'=>'0-0-0-0'))  ?>";
                    var filter = "";                
                    switch (layer) {
                        case 0:
                            filter = id + "-0-0-0-idesc";
                            break;
                        case 1:
                            filter = "0-" + id + "-0-0-idesc";
                            break;
                        case 2:
                            filter = "0-0-" + id + "-0-idesc";
                            break;
                        case 3:
                            filter = "0-0-0-" + id+'-idesc';
                            break;
                    }
                    url = url.replace("0-0-0-0",filter);
                    window.location.href = url;
                }
            </script>
