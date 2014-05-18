<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderController
 *
 * @author lzh
 */
class OrdersController extends Controller {

    //我的订单
    public function actionIndex() {
        $criteria = new CDbCriteria();
        $render_arr = array();
        if (isset($_GET['order_status'])) {
            $criteria->compare('order_status', $_GET['order_status']);
            $render_arr['order_status'] = $_GET['order_status'];
        }
        $criteria->order = "t.id desc";
        $criteria->compare('t.user_id', Yii::app()->user->id);
        $count = OrdersModel::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 15;
        $pager->applyLimit($criteria);
        $criteria->with = array('goods');
        $model = OrdersModel::model()->findAll($criteria);
        $render_arr['model'] = $model;
        $render_arr['pager'] = $pager;
        $this->render('index', $render_arr);
    }

    //订单详情
    public function actionView($id) {
        $model = OrdersModel::model()->with('goods')->findByPk($id);
        $goodsModel = GrouponGoodsModel::model()->with('seller')->findByPk($model->goods->goods_id);
        $this->checkEmpty($model);
        $this->render('view', array(
            'model' => $model,
            'goodsModel' => $goodsModel,
        ));
    }

}
