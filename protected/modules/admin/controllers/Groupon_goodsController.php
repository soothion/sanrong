<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Groupon_goods
 *
 * @author liuzihui
 */
class Groupon_goodsController extends Controller {

    public function actionIndex() {
        $this->breadcrumbs[] = '团购管理';
        $criteria = new CDbCriteria();
        $criteria->order = "id desc";
        if(isset($_GET['s_time']) && !empty($_GET['s_time'])){
            $criteria->addCondition("s_time <=".strtotime($_GET['s_time']));
        }
        if(isset($_GET['e_time']) && !empty($_GET['e_time'])){
            $criteria->addCondition("e_time >=".strtotime($_GET['e_time']));
        }
        if(isset($_GET['seller_id']) && !empty($_GET['seller_id'])){
            $criteria->compare('seller_id', $_GET['seller_id']);
        }
        if(isset($_GET['title']) && !empty($_GET['title'])){
            $criteria->addSearchCondition('title', $_GET['title']);
        }
        $dataProvider = new CActiveDataProvider('GrouponGoodsModel', array(
            'id' => '',
            'pagination' => array('pageSize' => 15),
            'criteria' => $criteria,
                )
        );
        //获取所有的商家
        $sellerModel = GrouponSellerModel::model()->findAll(array('order'=>'id desc'));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'sellerModel' => $sellerModel,
        ));
    }

    public function actionCreate($cate_id = 0) {
        $this->breadcrumbs[] = '添加团购';
        $model = new GrouponGoodsModel();
        $model->s_time = "";
        $model->e_time = "";
        $model->status = 1;
        $this->render('_form', array('model' => $model));
    }

    public function actionUpdate($id = 0) {
        $this->breadcrumbs[] = '编辑团购';
        $id = numeric($id);
        $model = GrouponGoodsModel::model()->find('id=:id', array(':id' => $id));
        $model->s_time = date('Y-m-d', $model->s_time);
        $model->e_time = date('Y-m-d', $model->e_time);
        $model->area = explode(',', $model->area);
        //取出关联商品
        $model->relation_goods_id = explode(',', $model->relation_goods_id);
        $relation_criteria = new CDbCriteria();
        $relation_criteria->addInCondition('id', $model->relation_goods_id);
        $relation_goods = GrouponGoodsModel::model()->findAll($relation_criteria);
        
        $this->checkEmpty($model);
        $this->render('_form', array('model' => $model,'relation_goods'=>$relation_goods));
    }

    public function actionSave() {
        $isEdit = isset($_POST['id']);
        if ($isEdit) {
            $model = GrouponGoodsModel::model()->find('id=:id', array(':id' => numeric($_POST['id'])));
            $this->checkEmpty($model);
        } else {
            $model = new GrouponGoodsModel();
            $model->created = time();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['delete_image'])) {
            $model->image = '';
        }
        if (isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])) {
            $Uploader = new Uploader();
            $Uploader->useImage();
            if ($Uploader->upload('image')) {
                $model->image = $Uploader->file;
            }
        }
        if (isset($_POST['GrouponGoodsModel'])) {
            $model->attributes = $_POST['GrouponGoodsModel'];
            //验证
            if (!isset($model->title) && empty($model->title)) {
                $this->showError('请填写标题！');
            }
            if (!isset($model->summary) && empty($model->summary)) {
                $this->showError('请填写摘要！');
            }
            if (!isset($model->area) && empty($model->area)) {
                $this->showError('请选择区域！');
            }
            if (!isset($model->s_time) && empty($model->s_time)) {
                $this->showError('开始时间不能为空！');
            }
            if (!isset($model->e_time) && empty($model->e_time)) {
                $this->showError('结束时间不能为空！');
            }
            if (numeric($model->m_price) <= 0 || numeric($model->g_price) <= 0) {
                $this->showError('请正确填写价格！');
            }
            if (numeric($model->m_price) < numeric($model->g_price)) {
                $this->showError('团购价应该大于门店价！');
            }
            //验证结束
            $model->admin_id = Yii::app()->user->id;
            $model->s_time = strtotime($model->s_time);
            $model->e_time = strtotime($model->e_time);
            if ($model->s_time >= $model->e_time) {
                $this->showError('团购时间有误！');
            }
            $model->m_price = price_format($model->m_price);
            $model->g_price = price_format($model->g_price);
            $model->discount = number_format($model->g_price / $model->m_price * 10, 1);
            $model->area = implode(',', $_POST['GrouponGoodsModel']['area']);
            
            if(isset($_POST['GrouponGoodsModel']['relation_goods_id']) && !empty($_POST['GrouponGoodsModel']['relation_goods_id'])){
                $model->relation_goods_id = implode(',', $_POST['GrouponGoodsModel']['relation_goods_id']);
            }else{
                $model->relation_goods_id = "";
            }
            
            if ($model->save()) {
                if (GrouponAreaModel::model()->save_goods($_POST['GrouponGoodsModel']['area'], $model->id)) {
                    $this->showSuccess('保存成功！');
                }
            } else {
                $this->showError($model->getErrors());
            }
        }
        $this->showError('操作失败！');
    }

    public function actionDelete() {
        $model = new GrouponGoodsModel();
        $criteria = new CDbCriteria();
        if (isset($_GET['id'])) {
            $goodsModel = GrouponGoodsModel::model()->findByPk($_GET['id']);
			if(!empty($goodsModel->area)){
            $area_arr = explode(',', $goodsModel->area);			
				foreach ($area_arr as $k => $v) {
					$areaModel = GrouponAreaModel::model()->findByPk($v);
					if($areaModel){
						$area_goods = explode(',', $areaModel->goods);
						foreach ($area_goods as $key => $val) {
							if ($val == $_GET['id']) {
								unset($area_goods[$key]);
							}
						}
						$areaModel->goods = implode(',', $area_goods);
						$areaModel->save();
					}
				}
			}
            $model->deleteByPk(numeric($_GET['id']), $criteria);
            $this->showSuccess('删除成功！');
        } elseif (isset($_POST['selected']) && is_array($_POST['selected'])) {
            //print_r($_POST['selected']);exit;
            foreach ($_POST['selected'] as $id) {
                $goodsModel = GrouponGoodsModel::model()->findByPk($id);
				if(!empty($goodsModel->area)){
					$area_arr = explode(',', $goodsModel->area);
					foreach ($area_arr as $k => $v) {
						$areaModel = GrouponAreaModel::model()->findByPk($v);
						if($areaModel){
							$area_goods = explode(',', $areaModel->goods);
							foreach ($area_goods as $key => $val) {
								if ($val == $id) {
									unset($area_goods[$key]);
								}
							}
							$areaModel->goods = implode(',', $area_goods);
							$areaModel->save();
						}
					}
				}
            }
            $criteria->addInCondition('id', $_POST['selected']);
            $model->deleteAll($criteria);
            $this->showSuccess('删除成功！');
        }
        $this->showError('操作失败！');
    }

    //搜索商家，用于关联商品功能
    public function actionSearch_goods_ajax() {
        $goods_name = $_POST['goods_name'];
        $seller_id = $_POST['seller_id'];
        $goods_id = $_POST['goods_id'];
        
        $criteria = new CDbCriteria();
        if($goods_id > 0 ){
            $relation_goods_id = GrouponGoodsModel::model()->findByPk($goods_id);
            $relation_goods_id = explode(',', $relation_goods_id->relation_goods_id);
            $criteria->addNotInCondition('id', $relation_goods_id);
        }
        if (isset($goods_name) && !empty($goods_name)) {
            $criteria->addSearchCondition('goods_name', $goods_name);
        }
        if (numeric($seller_id) > 0) {
            $criteria->addSearchCondition('seller_id', $seller_id);
        }
        $criteria->select = "id,title";
        $model = GrouponGoodsModel::model()->findAll($criteria);
        $data = object2array($model);
        echo json_encode($data);
    }

}
