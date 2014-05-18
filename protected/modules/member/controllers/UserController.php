<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author lzh
 */
class UserController extends Controller{
    //put your code here
    public function actionEnterprise(){
        $criteria = new CDbCriteria();
        $criteria->compare('user_type', 1);
        $criteria->with = array('company');
        $count = UserModel::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 15;
        $pager->applyLimit($criteria);
        $model = UserModel::model()->findAll($criteria);
        $virtural_enterprise_model = VirtualEnterpriseModel::model()->findAll();
        //print_r($model);exit;
        $this->render('enterprise',array(
            'model' => $model,
            'pager' => $pager,
            'virtural_enterprise_model' => $virtural_enterprise_model,
        ));
    }
}
