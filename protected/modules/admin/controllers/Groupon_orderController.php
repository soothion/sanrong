<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Groupon_orderController
 *
 * @author liuzihui
 */
class Groupon_orderController extends Controller {

    public function actionIndex() {        
        $this->breadcrumbs[] = '订单管理';
        $criteria = new CDbCriteria();
        $criteria->order = "id desc";
        if(isset($_GET['order_type']) && !empty($_GET['order_type'])){
            $criteria->compare('order_type', $_GET['order_type']);
        }
        if(isset($_GET['order_status']) && $_GET['order_status'] >= 0){ 
            $criteria->compare('order_status', $_GET['order_status']);
        }
        if(isset($_GET['order_sn']) && !empty($_GET['order_sn'])){
            $criteria->addSearchCondition('order_sn', $_GET['order_sn']);
        }
        $count = OrdersModel::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 15;
        $pager->applyLimit($criteria);
        $model = OrdersModel::model()->findAll($criteria);
        $this->render('index', array(
            'model' => $model,
            'pager' => $pager,
        ));
    }

    //改变订单状态
    public function actionOrder_status() {
        $id = numeric($_GET['id']);
        $order_status = numeric($_GET['order_status']);
        if (OrdersModel::model()->change_order_status($id, $order_status)) {
            $this->redirect($this->createUrl('index'));
        }
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
