<?php
$filter = Yii::app()->request->getParam('filter');
if (isset($filter)) {
    $filter_arr = explode('-', $filter);
} else {
    $filter_arr = array(0, 0, 0, 0, 'iasc');
}
$url = Yii::app()->request->getUrl();
$default_order_url = "";
$sales_order_url = "";
$discount_order_url = "";
switch ($filter_arr[4]) {
    case 'iasc':
        $default_order_url = str_replace('iasc', 'idesc',$url);
        $sales_order_url = str_replace('iasc', 'sdesc',$url);
        $discount_order_url = str_replace('iasc', 'ddesc',$url);
        break;
    case 'idesc':
        $default_order_url = str_replace('idesc', 'iasc',$url);
        $sales_order_url = str_replace('idesc', 'sdesc',$url);
        $discount_order_url = str_replace('idesc', 'ddesc',$url);
        break;
    case 'sdesc':
        $default_order_url = str_replace('sdesc', 'idesc',$url);
        $sales_order_url = str_replace('sdesc', 'sasc',$url);
        $discount_order_url = str_replace('sdesc', 'ddesc',$url);
        break;
    case 'sasc':
        $default_order_url = str_replace('sasc', 'idesc',$url);
        $sales_order_url = str_replace('sasc', 'sdesc',$url);
        $discount_order_url = str_replace('sasc', 'ddesc',$url);
        break;
    case 'ddesc':
        $default_order_url = str_replace('ddesc', 'idesc',$url);
        $sales_order_url = str_replace('ddesc', 'sdesc',$url);
        $discount_order_url = str_replace('ddesc', 'dasc',$url);
        break;
    case 'dasc':
        $default_order_url = str_replace('dasc', 'idesc',$url);
        $sales_order_url = str_replace('dasc', 'sdesc',$url);
        $discount_order_url = str_replace('dasc', 'ddesc',$url);
        break;
    
}
?>
<div class='main'>
    <!--筛选器开始-->
    <div class="search_box"> 

        <!--专题筛选开始-->
        <div class="selbox hotbox">
            <h5>热门专题：</h5>
            <ul>
                <?php foreach ($groupon_subject as $k => $v): ?>
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
                <li><a href="javascript:goods_filter(0,0)" <?php if (numeric($filter_arr[0]) == 0): ?>class='on'<?php endif; ?>>全部</a></li>
                <?php foreach ($groupon_category as $k => $v): ?>
                    <li><a <?php if (numeric($filter_arr[0]) == $v->id): ?>class='on'<?php endif; ?> href="javascript:goods_filter(<?php echo $v->id ?>,0)"><?php echo $v->name; ?></a></li>
                <?php endforeach; ?>
            </ul>
            <!-- 二级筛选开始，根据上级选中状态，隐藏或者显示-->
            <?php if (!empty($sub_category)): ?>
                <div class="unfold">
                    <ul>
                        <li><a href="javascript:goods_filter(0,1)" <?php if (numeric($filter_arr[1]) == 0): ?>class='on'<?php endif; ?>>全部</a></li>
                        <?php foreach ($sub_category as $k => $v): ?>
                            <li><a <?php if (numeric($filter_arr[1]) == $v->id): ?>class='on'<?php endif; ?> href="javascript:goods_filter(<?php echo $v->id ?>,1)"><?php echo $v->name ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <!-- 二级筛选结束-->
            <div class="clear"></div>            
        </div>
        <!--分类筛选结束--> 

        <!--区域筛选开始-->
        <div class="selbox areabox">
            <h5>区域：</h5>
            <ul>
                <li><a href="javascript:goods_filter(0,2)" <?php if (numeric($filter_arr[2]) == 0): ?>class='on'<?php endif; ?>>全部</a></li>
                <?php foreach ($groupon_area as $k => $v): ?>
                    <li><a <?php if (numeric($filter_arr[2]) == $v->id): ?>class='on'<?php endif; ?> href="javascript:goods_filter(<?php echo $v->id ?>,2)" ><?php echo $v->name ?></a></li>
                <?php endforeach; ?>
            </ul>

            <!-- 二级筛选开始，根据上级选中状态，隐藏或者显示-->
            <?php if (!empty($sub_area)): ?>
                <div class="unfold">
                    <ul>

                        <li><a href="javascript:goods_filter(0,3)" <?php if (numeric($filter_arr[3]) == 0): ?>class='on'<?php endif; ?>>全部</a></li>
                        <?php foreach ($sub_area as $k => $v): ?>
                            <li><a <?php if (numeric($filter_arr[3]) == $v->id): ?>class='on'<?php endif; ?> href="javascript:goods_filter(<?php echo $v->id ?>,3)"><?php echo $v->name; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <!-- 二级筛选结束-->

            <div class="clear"></div>
        </div>
        <!--区域筛选结束--> 

        <!--结果排序开始-->
        <div class="resultbox">
            <h5>排序：</h5>
            <div class="order"> 
                <a href="<?php echo $default_order_url ?>" class="default default_on">默认</a><a href="<?php echo $sales_order_url ?>" class="sales">销量</a><a href="<?php echo $discount_order_url ?>" class="discount">折扣</a> 
            </div>
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

                            <div class="deal_img"><a href="<?php echo $this->createUrl('groupon_goods/index', array('id' => $v->id)) ?>"><img src="<?php echo $v->image ?>" width="470" height="285" /></a></div>
                            <h2><a href="<?php echo $this->createUrl('groupon_goods/index', array('id' => $v->id)) ?>"><?php echo $v->title ?></a></h2>
                            <h3><a href="<?php echo $this->createUrl('groupon_goods/index', array('id' => $v->id)) ?>"><?php echo $v->summary; ?></a></h3>
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
        <?php $this->renderPartial('../common/fr'); ?>
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
<script type="text/javascript">
    var cate_top = <?php echo $filter_arr[0] ?>;
    var cate_sub = <?php echo $filter_arr[1] ?>;
    var area_top = <?php echo $filter_arr[2] ?>;
    var area_sub = <?php echo $filter_arr[3] ?>;
    function goods_filter(id, layer) {
        var filter = "";
        switch (layer) {
            case 0:
                filter = id + "-" + "0" + "-" + area_top + "-" + area_sub + '-idesc';
                break;
            case 1:
                filter = cate_top + "-" + id + "-" + area_top + "-" + area_sub + '-idesc';
                break;
            case 2:
                filter = cate_top + "-" + cate_sub + "-" + id + "-" + 0 + '-idesc';
                break;
            case 3:
                filter = cate_top + "-" + cate_sub + "-" + area_top + "-" + id + '-idesc';
                break;
        }
        var url = document.URL;
<?php if (!isset($filter)): ?>
            url = "<?php echo $this->createUrl('/groupon_subject/index', array('id' => $_GET['id'], 'filter' => "0-0-0-0")); ?>";
            url = url.replace("0-0-0-0", filter);
<?php else: ?>
            url = url.replace("<?php echo $filter ?>", filter);
<?php endif; ?>
        window.location.href = url;
    }
</script>
