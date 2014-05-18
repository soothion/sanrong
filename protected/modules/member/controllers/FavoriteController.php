<?php

Class FavoriteController extends Controller {

    public function actionIndex() {
        $user_id = numeric(Yii::app()->user->id);
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        //$criteria->addCondition('e_time >= ' . time());
        $criteria->with = array('goods');
        $model = GrouponFavorite::model()->findAll($criteria);
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionFavorite_overdue() {
        $user_id = numeric(Yii::app()->user->id);
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $criteria->addCondition('e_time < ' . time());
        $criteria->with = array('goods');
        $model = GrouponFavorite::model()->findAll($criteria);
        $this->render('favorite_overdue', array(
            'model' => $model,
        ));
    }

    public function actionDelete() {
        $model = new GrouponFavorite();
        $criteria = new CDbCriteria();
        if (isset($_GET['id'])) {
            $model->deleteByPk(numeric($_GET['id']), $criteria);
            $this->showSuccess('删除成功！');
        } else {
            $this->showSuccess('删除失败！');
        }
    }

}
