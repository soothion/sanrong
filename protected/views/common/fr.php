<?php if (isset($this->right) && $this->right == true): ?>
    <?php
    //取得推荐
    $recommendCriteria = new CDbCriteria();
    $recommendCriteria->compare('is_recommend', 1);
    $recommendCriteria->addCondition('e_time>' . time());
    $recommendCriteria->order = 'id desc';
    $recommendCriteria->limit = 4;
    $recommend_goods = GrouponGoodsModel::model()->findAll($recommendCriteria);
    //取得公告
    $newsModel = NewsModel::model()->findAll();
    //取得广告
    $advertCriteria = new CDbCriteria();
    $advertCriteria->compare('type', 1);
    $advertCriteria->compare('status', 1);
    $advertCriteria->order = "id desc";
    $advertModel = AdvertModel::model()->findAll($advertCriteria);
    ?>
    <div class="t_side fr">
            <?php foreach($newsModel as $k=>$v): ?>
    	<div class="t_side_news">
        	<div class="t_side_news_tit"></div>
            <ul>
                <li><a target="_blank" href="<?php echo $this->createUrl('/news/index',array('id'=>$v->id)); ?>"><?php echo $v->title ?></a><span>(<?php echo date('m-d',$v->created); ?>)</span></li>
            </ul>
        </div>
        <?php endforeach; ?>
                <?php foreach($advertModel as $k=>$v): ?>
        <div class="s<?php echo $k+1; ?> "><a href="http://<?php echo $v->url ?>"><img src="<?php echo $v->image ?>" width="240" /></a></div>
                    <?php endforeach; ?>
        <div class="t_side_hot">
            <div class="t_side_hot_tit"></div>
            <ul>
                <?php foreach ($recommend_goods as $k => $v): ?>
                    <li>
                        <h5 class="num<?php echo $k+1 ?>"><a href="<?php echo $this->createUrl('groupon_goods/index', array('id' => $v->id)) ?>"><?php echo $v->title ?></a></h5>
                        <div class="t_side_hot_img"><a href="<?php echo $this->createUrl('groupon_goods/index', array('id' => $v->id)) ?>"><img src="<?php echo $v->image ?>" width="130" height="79" /></a></div>
                        <div class="t_side_hot_con">
                            <p class="price">￥ <?php echo numeric($v->g_price) ?> </p>
                            <p class="num"><span><?php echo GrouponGoodsModel::model()->get_salenum($v->id) ?></span>人购买</p>
                            <p>海口</p>
                        </div>
                        <div class="clear"></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>