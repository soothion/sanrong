<?php if (isset($this->right) && $this->right == true): ?>
    <?php
    //取得推荐
    $recommendCriteria = new CDbCriteria();
    $recommendCriteria->compare('is_recommend', 1);
    $recommendCriteria->addCondition('e_time>' . time());
    $recommendCriteria->order = 'id desc';
    $recommendCriteria->limit = 4;
    $recommend_goods = GrouponGoodsModel::model()->findAll($recommendCriteria);
    ?>
    <div class="t_side fr">
        <div class="s1"><img src="<?php echo Yii::app()->request->baseUrl; ?>/static/images/ad1.jpg" width="240" height="130" /></div>
        <div class="s2"><img src="<?php echo Yii::app()->request->baseUrl; ?>/static/images/ad2.jpg" width="240" height="130" /></div>
        <div class="s3"><img src="<?php echo Yii::app()->request->baseUrl; ?>/static/images/ad3.jpg" width="240" height="124" /></div>
        <div class="t_side_hot">
            <div class="t_side_hot_tit"></div>
            <ul>
                <?php foreach ($recommend_goods as $k => $v): ?>
                    <li>
                        <h5 class="num1"><a href="<?php echo $this->createUrl('groupon_goods/index', array('id' => $v->id)) ?>"><?php echo $v->title ?></a></h5>
                        <div class="t_side_hot_img"><a href="<?php echo $this->createUrl('groupon_goods/index', array('id' => $v->id)) ?>"><img src="<?php echo $v->image ?>" width="130" height="79" /></a></div>
                        <div class="t_side_hot_con">
                            <p class="price">￥ <?php echo $v->g_price ?> </p>
                            <p class="num"><span>5</span>人团购</p>
                            <p>海口</p>
                        </div>
                        <div class="clear"></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>