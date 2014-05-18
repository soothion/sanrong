<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EvaluateController
 *
 * @author liuzihui
 */
class EvaluateController extends Controller {

    public function actionIndex() {
        $user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->compare('t.user_id', $user_id);
        $criteria->compare('t.pid', 0);
        $criteria->order = 't.id desc';
        $criteria->with = array('order_goods', 'orders');
        $count = GrouponEvaluateModel::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 15;
        $pager->applyLimit($criteria);
        $model = GrouponEvaluateModel::model()->findAll($criteria);
        $this->render('index', array(
            'model' => $model,
            'pager' => $pager
        ));
    }

    public function actionEvaluate() {
        if (isset($_GET['id']) && numeric($_GET['id']) > 0) {
            $model = GrouponEvaluateModel::model()->findByPk($_GET['id']);
            $ordersModel = OrdersModel::model()->findByPk($model->order_id);
            $orderGoodsModel = OrderGoodsModel::model()->findByPk($model->order_goods_id);
            $this->render('evaluate', array('orderModel' => $ordersModel, 'orderGoodsModel' => $orderGoodsModel, 'model' => $model));
            exit;
        }
        $order_id = numeric($_REQUEST['order_id']);
        $order_goods_id = numeric($_REQUEST['order_goods_id']);
        $ordersModel = OrdersModel::model()->findByPk($order_id);
        if ($ordersModel && $ordersModel->order_status == 1) {
            $orderGoodsModel = OrderGoodsModel::model()->find('order_id=:order_id and id=:order_goods_id', array(':order_id' => $order_id, ':order_goods_id' => $order_goods_id));
            if (!$orderGoodsModel) {
                $this->showError('无此订单！');
            }
            $model = new GrouponEvaluateModel();
            $this->render('evaluate', array('orderModel' => $ordersModel, 'orderGoodsModel' => $orderGoodsModel, 'model' => $model));
        } else {
            $this->showError('没有评价的权限');
        }
    }

    public function actionSave() {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        $order_id = numeric($_POST['GrouponEvaluateModel']['order_id']);
        $order_goods_id = numeric($_POST['GrouponEvaluateModel']['order_goods_id']);
        $ordersModel = OrdersModel::model()->findByPk($order_id);
        if ($ordersModel && $ordersModel->order_status == 1 || $ordersModel->order_status == 2) {
            $orderGoodsModel = OrderGoodsModel::model()->find('order_id=:order_id and id=:order_goods_id', array(':order_id' => $order_id, ':order_goods_id' => $order_goods_id));
            if (!$orderGoodsModel) {
                $this->showError('无此订单！');
            }
            $isEdit = isset($_POST['id']);
            if ($isEdit) {
                $model = GrouponEvaluateModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
                $this->checkEmpty($model);
                $data = $_POST['GrouponEvaluateModel'];
                $model->content = $data['content'];
                $model->stars = $data['stars'];
                if ($model->save()) {
                    $this->showSuccess('评论成功！', $this->createUrl('/member'));
                }
            } else {
                $model = new GrouponEvaluateModel();
                $data = $_POST['GrouponEvaluateModel'];
                $model->content = $data['content'];
                $model->stars = $data['stars'];
                $model->order_id = $data['order_id'];
                $model->goods_id = $orderGoodsModel->goods_id;
                $model->order_goods_id = $data['order_goods_id'];
                $model->user_id = Yii::app()->user->id;
                $model->created = time();
                if ($model->save()) {
                    $ordersModel->order_status = 2;
                    if ($ordersModel->save()) {
                        $this->showSuccess('评论成功！', $this->createUrl('/member'));
                    }
                }
            }
        } else {
            $this->showError('没有评价的权限');
        }
    }

    public function actionDelete() {
        $model = new GrouponEvaluateModel();        
        $criteria = new CDbCriteria();
        if (isset($_GET['id'])) {
            $evaluateModel = GrouponEvaluateModel::model()->findByPk($_GET['id']);
            if ($model->deleteByPk(numeric($_GET['id']), $criteria)) {
                $ordersModel = OrdersModel::model()->findByPk($evaluateModel->order_id);
                $ordersModel->order_status = 1;
                $ordersModel->save();
                $this->showSuccess('删除成功！');
            }
        }
        $this->showError('操作失败！');
    }

}
