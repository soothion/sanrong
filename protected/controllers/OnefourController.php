<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author liuzihui
 */
class OnefourController extends Controller{
    public function actionIndex(){
        $groupon_category = GrouponCategoryModel::model()->findAll('pid=:pid',array('pid'=>0));
        $groupon_area = GrouponAreaModel::model()->findAll('pid=:pid',array('pid'=>0));
        $groupon_subject = GrouponSubjectModel::model()->findAll('is_hot=:is_hot',array('is_hot'=>1));
        //取出商品
        $goodsCriteria = new CDbCriteria();
        $goodsCriteria->addCondition('e_time>'.time());
        $goodsCriteria->order = 'id desc';
        $count = GrouponGoodsModel::model()->count($goodsCriteria);
        $pager = new CPagination($count);         
	$pager->pageSize = 6;                  
	$pager->applyLimit($goodsCriteria);      
        $groupo_goods = GrouponGoodsModel::model()->findAll($goodsCriteria);
        //取得推荐
        $recommendCriteria = new CDbCriteria();
        $recommendCriteria->compare('is_recommend', 1);
        $recommendCriteria->addCondition('e_time>'.time());
        $recommendCriteria->order = 'id desc';
        $recommendCriteria->limit = 4;
        $recommend_goods = GrouponGoodsModel::model()->findAll($recommendCriteria);
        
        $this->seo = array(
            'title' => '首页'
        );
        
        $this->render('index',array(
            'groupon_category' => $groupon_category,
            'groupon_area' => $groupon_area,
            'groupo_goods' => $groupo_goods,
            'pages'=>$pager,
            'recommend_goods' => $recommend_goods,
            'groupon_subject' => $groupon_subject,
        ));
    }
}
