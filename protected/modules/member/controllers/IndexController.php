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
class IndexController extends Controller{
    public function actionIndex(){ 
        $criteria = new CDbCriteria();
        if(isset($_GET['order_status'])){
            $criteria->compare('order_status', $_GET['order_status']);
        }
        $criteria->order = "t.id desc";
        $count = OrdersModel::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 15;
        $pager->applyLimit($criteria);
        $criteria->with = array('goods');
        $model = OrdersModel::model()->findAll($criteria);
        //echo $model->goods->goods_name;echo 11;
        $this->render('index', array(
            'model' => $model,
            'pager' => $pager,
        ));
    }
//    public function actionOrders(){
//        $this->render('index');
//    }
}
