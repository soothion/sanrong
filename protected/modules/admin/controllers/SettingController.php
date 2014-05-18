<?php

class SettingController extends Controller
{
	public function actionIndex()
	{
            $this->breadcrumbs[] = '系统设置';
            $model = SettingModel::model()->findAll();
            $this->render('index',array('model' => $model));
	}
        public function actionSave(){
            if (isset($_POST)) {
                $res=1;
                foreach($_POST as $k=>$v){
                    $model = SettingModel::model()->find('k=:k',array(':k'=>$k));
                    $model->k = $k;
                    $model->v = $v;
                    $iu_id=$model->save();
                    $res=$res*$iu_id;
                    $model->setIsNewRecord(TRUE);
                }
                if($res){
                   $setting_path = Yii::app()->basePath."/config/setting.php";
                   $content = "<?php\r\n return ".var_export($_POST,TRUE).';';
                   file_put_contents($setting_path, $content);
                   $this->showSuccess('设置成功！'); 
                }else{
                    $this->showError('设置失败！');
                }
            }
        }
}