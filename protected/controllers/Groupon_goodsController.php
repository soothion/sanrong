<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GoodsController
 *
 * @author liuzihui
 */
class Groupon_goodsController extends Controller {

    public function actionIndex($id) {
        $id = numeric($id);
        $criteria = new CDbCriteria();
        $criteria->compare('t.id', $id);
        $criteria->with = array('subject', 'seller');
        $model = GrouponGoodsModel::model()->find($criteria);
        $model->views = $model->views + 1;
        $model->save();

        //取得推荐
        $recommendCriteria = new CDbCriteria();
        $recommendCriteria->compare('is_recommend', 1);
        $recommendCriteria->addCondition('e_time>' . time());
        $recommendCriteria->order = 'id desc';
        $recommendCriteria->limit = 4;
        $recommend_goods = GrouponGoodsModel::model()->findAll($recommendCriteria);

        //取得关联
        $relation_goods_id = $model->relation_goods_id;
        $relation_goods_id = explode(',', $relation_goods_id);
        $relation_criteria = new CDbCriteria();
        $relation_criteria->order = 'id desc';
        $relation_criteria->limit = 2;
        $relation_criteria->addInCondition('id', $relation_criteria);
        $relation_goods = GrouponGoodsModel::model()->findAll($recommendCriteria);

        //取得评论
        $evaluate_criteria = new CDbCriteria();        
        $evaluate_criteria->compare('t.goods_id', $id);
        $evaluate_criteria->with = array('orders', 'order_goods');
        $pageSize = 1;
        $count = GrouponEvaluateModel::model()->count('goods_id='.$id)/$pageSize;
        $evaluate_criteria->offset = '0';
        $evaluate_criteria->limit = $pageSize;
        $pager = GrouponEvaluateModel::model()->get_pages($count);
        $evaluate = GrouponEvaluateModel::model()->findAll($evaluate_criteria);
        $this->seo = array(
            'position' => '<a href="' . $this->createUrl('/') . '">首页</a> > <a href="' . $this->createUrl('/onefour/index') . '">培训中心</a> > <a href="' . get_subject_url($model->subject_id) . '">' . $model->subject->name . '</a> > ' . $model->title,
            //'position' => '<a href="'.$this->createUrl('/').'">首页</a> > <a href="'.$this->createUrl('/onefour/index').'">大一大四</a> > '.$model->title,
            'title' => $model->title,
        );
        $this->render('index', array(
            'model' => $model,
            'recommend_goods' => $recommend_goods,
            'relation_goods' => $relation_goods,
            'evaluate' => $evaluate,
            'pages' => $pager,
            'count' => $count,
        ));
    }

    public function actionFavorite() {
        if (numeric(Yii::app()->user->id) <= 0) {
            echo json_encode(array('status' => 0, 'info' => '请登录', 'url' => $this->createUrl('/member')));
            exit;
        }
        $goods_id = $_POST['goods_id'];
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', Yii::app()->user->id);
        $criteria->compare('goods_id', $goods_id);
        $model = GrouponFavorite::model()->find($criteria);
        if ($model) {
            echo json_encode(array('status' => 0, 'info' => '您已经收藏过了', 'url' => $this->createUrl('/member')));
        } else {
            $model = new GrouponFavorite();
            $model->user_id = Yii::app()->user->id;
            $model->goods_id = $goods_id;
            $model->created = time();
            if ($model->save()) {
                echo json_encode(array('status' => 1, 'info' => '收藏成功', 'url' => $this->createUrl('/member')));
            } else {
                echo json_encode(array('status' => 0, 'info' => '收藏失败', 'url' => $this->createUrl('/member')));
            }
        }
    }
    public function actionAjax_evaluate(){
        $page = $_POST['page'];
        $goods_id = $_POST['goods_id'];
        $pageSize = 1;
        $count = GrouponEvaluateModel::model()->count('goods_id='.$goods_id)/$pageSize;
        $criteria = new CDbCriteria();
        $criteria->offset = (numeric($page) - 1) * $pageSize;
        $criteria->limit = $pageSize;
        $criteria->compare('t.goods_id', $goods_id);
        $model = GrouponEvaluateModel::model()->findAll($criteria);
        $res = object2array($model);
        //$data = array();
        foreach($res as $k=>$v){
            $res[$k]['email'] = UserModel::model()->findByPk($v['user_id'])->email;
            $res[$k]['created'] = date('Y-m-d H:i:s',$res[$k]['created']);
        }
        $data = array(
            'pages' => GrouponEvaluateModel::model()->get_pages($count, $page),
            'data' => $res,
            'pageMax' => $count,
        );
        echo json_encode($data);
    }

}
