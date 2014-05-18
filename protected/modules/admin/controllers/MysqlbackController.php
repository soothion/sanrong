<?php

/**
 * 功能描述:后台数据备份+还原等操作
 * @Author:冰封<574578944@qq.com>
 * @date:2012-09-03
 */
class MysqlbackController extends Controller {

    private $config;
    private $mr;
    public $layout = false; //设置当前默认布局文件为假

    public function init() {//初始化相关属性  
        $this->layout = '//layouts/column2';
        if (!$this->checkAccess(4)) {
            $this->showError('没有操作权限！', '/admin');
        }
        Yii::import('application.extensions.mysqlback.mysqlback', TRUE); //导入Mysql备份类库  
        $connect_str = parse_url(Yii::app()->db->connectionString);
        $re_str = explode('=', implode('=', explode(';', $connect_str['path']))); //取得数据库IP,数据库名
        $this->config = array(//设置参数
            'host' => $re_str[1],
            'dbname' => $re_str[3],
            'port' => 3306,
            'db_username' => Yii::app()->db->username,
            'db_password' => Yii::app()->db->password,
            'db_prefix' => Yii::app()->db->tablePrefix,
            'charset' => Yii::app()->db->charset,
            'path' => Yii::app()->basePath . '/../protected/data/backup/', //定义备份文件的路径
            'isCompress' => 1, //是否开启gzip压缩{0为不开启1为开启}
            'isDownload' => 0                    //压缩完成后是否自动下载{0为不自动1为自动}
        );
        $this->mr = new Mysqlback($this->config);
    }

    /**
     * @显示已备份的数据列表
     */
    public function actionIndex() {
        $this->breadcrumbs[] = '数据备份';
        $path = $this->config['path'];
        $fileArr = $this->MyScandir($path);
        $list = array();
        foreach ($fileArr as $key => $value) {
            if ($key > 1) {
                //获取文件创建时间        
                $fileTime = date('Y-m-d H:i', filemtime($path . $value));
                $fileSize = filesize($path . $value) / 1024;
                //获取文件大小
                $fileSize = $fileSize < 1024 ? number_format($fileSize, 2) . ' KB' :
                        number_format($fileSize / 1024, 2) . ' MB';
                //构建列表数组
                $list[] = array(
                    'name' => $value,
                    'time' => $fileTime,
                    'size' => $fileSize
                );
            }
        }
        $this->render('index', array('data' => $list));
    }

    /**
     * @备份数据库
     */
    public function actionBackup() {
        $this->mr->setdbname($this->config['dbname']);
        if ($this->mr->backup()) {
           $this->showSuccess('数据库备份成功！');
        } else {
           $this->showError('数据库备份失败！');
        }
    }

    /**
     * @删除数据备份
     */
    public function actionDelete_back() {
        if (unlink($this->config['path'] . $_GET['file'])) {
             $this->showSuccess('删除备份成功！');
        } else {
             $this->showError('删除备份失败！');
        }
    }

    /**
     * @下载备份文件
     */
    public function actionDownloadbak() {
        $this->download($this->config['path'] . $_GET['file']);
    }

    /**
     * @还原数据库
     */
    public function actionrecover() {
        $this->mr->setDBName($this->config['dbname']);
        if ($this->mr->recover($_GET['file'])) {
            $this->showSuccess('数据还原成功！');
        } else {
            $this->showSuccess('数据还原失败！');
        }
    }

    /**
     * @获取目录下文件数组
     */
    public function MyScandir($FilePath = './', $Order = 0) {
        $FilePath = opendir($FilePath);
        while ($filename = readdir($FilePath)) {
            $fileArr[] = $filename;
        }
        $Order == 0 ? sort($fileArr) : rsort($fileArr);
        return $fileArr;
    }

    /**
     * @公共下载方法
     */
    public function download($filename) {
        ob_end_clean();
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-streamextension');
        header('Content-Length: ' . filesize($filename));
        header('Content-Disposition: attachment; filename=' . basename($filename));
        readfile($filename);
    }

}
