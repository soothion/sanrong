<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewsController
 *
 * @author lzh
 */
class NewsController extends Controller{
    //put your code here
    public function actionList($cate_id){
//        $model = NewsCategoryModel::model()->findAll();
//        $allNews = array();
//        foreach($model as $k=>$v){
//            $allNews[$v->id]['cate'] = $v;
//            $newsModel = NewsModel::model()->findAll('cate_id=:cate_id',array(':cate_id'=>$v->id));
//            $allNews[$v->id]['news'] = $newsModel;
//        }
//        $this->render('list',array('allNews'=>$allNews));
        $model = NewsCategoryModel::model()->findAll();
        $criteria = new CDbCriteria();
        $criteria->compare('cate_id', $cate_id);
        $criteria->order = "id desc";
        $count = NewsModel::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 15;
        $pager->applyLimit($criteria);
        $newsModel = NewsModel::model()->findAll($criteria);
        $this->render('list',array(
            'model'=>$model,
            'newsModel' => $newsModel,
            'pager'=>$pager,
        ));
    }
    public function actionIndex($id){
        $model = NewsModel::model()->with('cate')->findByPk($id);
        if(!$model){
            $this->showError('无此文章');
        }
        $this->render('index',array(
            'model'=>$model
        ));
    }
}
