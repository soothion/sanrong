<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Groupon_subjectController
 *
 * @author liuzihui
 */
class Groupon_subjectController extends Controller {

    //put your code here
    public function actionIndex($id) {
        if (numeric($id) <= 0) {
            $this->showError('请指定哪个专题！');
        }
        $render_arr = array();
        $groupon_category = GrouponCategoryModel::model()->findAll('pid=:pid', array('pid' => 0));
        $groupon_area = GrouponAreaModel::model()->findAll('pid=:pid', array('pid' => 0));
        $groupon_subject = GrouponSubjectModel::model()->findAll('is_hot=:is_hot', array('is_hot' => 1));
        $render_arr['groupon_category'] = $groupon_category;
        $render_arr['groupon_area'] = $groupon_area;
        $render_arr['groupon_subject'] = $groupon_subject;
        //取出商品
        $goodsCriteria = new CDbCriteria();
        $filter = Yii::app()->request->getParam('filter');
        if (isset($filter)) {
            $filter_arr = explode('-', $filter);
            $sub_category = "";
            $sub_area = "";
            if (numeric($filter_arr[0]) > 0 && numeric($filter_arr[1]) == 0) {
                $sub_category = GrouponCategoryModel::model()->findAll('pid=:id', array(':id' => $filter_arr[0]));
                $sub_id = GrouponCategoryModel::model()->getAllSub($filter_arr[0]);
                $goodsCriteria->addInCondition('cate_id', $sub_id);
            }
            if (numeric($filter_arr[1]) > 0) {
                $sub_category = GrouponCategoryModel::model()->findAll('pid=:id', array(':id' => $filter_arr[0]));
                $goodsCriteria->compare('cate_id', $filter_arr[1]);
            }

            if (numeric($filter_arr[2]) > 0 && numeric($filter_arr[3]) == 0) {
                $sub_area = GrouponAreaModel::model()->findAll('pid = :id', array(':id' => $filter_arr[2]));
                $model = Yii::app()->db->createCommand()->select('id,goods')->from('groupon_area')->where('pid=:pid or id=:id', array(':pid' => $filter_arr[2], ':id' => $filter_arr[2]))->queryAll();
                $area_ids = CHtml::listData($model, 'id', 'goods');
                $goods = "";
                foreach ($area_ids as $k => $v) {
                    $goods .= $v . ",";
                }
                $goods = rtrim($goods, ',');
                $goods = explode(',', $goods);
                $goods_ids = array_unique($goods);
                $goodsCriteria->addInCondition('id', $goods_ids);
            }
            if (numeric($filter_arr[3]) > 0) {
                $sub_area = GrouponAreaModel::model()->findAll('pid = :id', array(':id' => $filter_arr[2]));
                $goods_ids = GrouponAreaModel::model()->getGoodsId($filter_arr[3]);
                $goodsCriteria->addInCondition('id', $goods_ids);
            }
            $render_arr['sub_category'] = $sub_category;
            $render_arr['sub_area'] = $sub_area;
            switch ($filter_arr[4]) {
                case 'iasc':
                    $goodsCriteria->order = 'id asc';
                    break;
                case 'idesc':
                    $goodsCriteria->order = 'id desc';
                    break;
                case 'sasc':
                    $goodsCriteria->order = 'salenum asc';
                    break;
                case 'sdesc':
                    $goodsCriteria->order = 'salenum desc';
                    break;
                case 'dasc':
                    $goodsCriteria->order = 'discount asc';
                    break;
                case 'ddesc':
                    $goodsCriteria->order = 'discount desc';
                    break;
                default :
                    $goodsCriteria->order = 'id desc';
                    break;
            }
        }
        $goodsCriteria->compare('subject_id', $id);
        $goodsCriteria->addCondition('e_time>' . time());
        $goodsCriteria->order = 'id desc';
        $count = GrouponGoodsModel::model()->count($goodsCriteria);
        $pager = new CPagination($count);
        $pager->pageSize = 6;
        $pager->applyLimit($goodsCriteria);
        $groupo_goods = GrouponGoodsModel::model()->findAll($goodsCriteria);
        $render_arr['pages'] = $pager;
        $render_arr['groupo_goods'] = $groupo_goods;
        //取得推荐
        $recommendCriteria = new CDbCriteria();
        $recommendCriteria->compare('is_recommend', 1);
        $recommendCriteria->addCondition('e_time>' . time());
        $recommendCriteria->order = 'id desc';
        $recommendCriteria->limit = 4;
        $recommend_goods = GrouponGoodsModel::model()->findAll($recommendCriteria);
        $render_arr['recommend_goods'] = $recommend_goods;

        $this->seo = array(
            'title' => '商品列表'
        );
        $this->render('index', $render_arr);
//        $this->render('index', array(
//            'groupon_category' => $groupon_category,
//            'groupon_area' => $groupon_area,
//            'groupo_goods' => $groupo_goods,
//            'pages' => $pager,
//            'recommend_goods' => $recommend_goods,
//            'sub_category' => $sub_category,
//            'sub_area' => $sub_area,
//            'groupon_subject' => $groupon_subject,
//        ));
    }

}
