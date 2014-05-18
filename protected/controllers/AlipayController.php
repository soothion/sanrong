<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlipayControler
 *
 * @author liuzihui
 */
class AlipayController extends Controller {

    //put your code here
    public function actionIndex() {
        echo file_exists(Yii::app()->basePath . '/config/setting.php'); exit;
        $alipay = Yii::app()->alipay;
        // If starting a guaranteed payment, use AlipayGuaranteeRequest instead
        $config = array(
            'out_trade_no' => 'E123456',
            'subject' => '团购商品',
            'price' => '0.01',
            'body' => 'aa',
            'show_url' => '',
            'receive_name' => '',
            'receive_address' => '',
            'receive_zip' => '',
            'receive_phone' => '',
            'receive_mobile' => '',
        );
        // Set other optional params if needed
        $form = $alipay->buildForm($config);
        echo $form;
        exit();
    }

    public function actionNotify() {
        $alipay = Yii::app()->alipay;
        if ($alipay->verifyNotify()) {
            $order_id = $_POST['out_trade_no'];
            $order_fee = $_POST['total_fee'];
            if ($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
                update_order_status($order_id, $order_fee, $_POST['trade_status']);
                echo "success";
            } else {
                echo "success";
            }
        } else {
            echo "fail";
            exit();
        }
    }

//Redirect notification
    public function actionReturn() {
        $alipay = Yii::app()->alipay;
        if ($alipay->verifyReturn()) {
            $order_id = $_GET['out_trade_no'];
            $total_fee = $_GET['total_fee'];

            if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                update_order_status($order_id, $total_fee, $_POST['trade_status']);
                $this->render('order_paid');
            } else {
                echo "trade_status=" . $_GET['trade_status'];
            }
        } else {
            echo "fail";
            exit();
        }
    }
    public function actionLog(){
        $user_id = $_REQUEST['user_id'];
        $model = ResumeLogModel::model()->find("user_id = $user_id");
        echo "<pre>";
        print_r(json_decode($model->content,true));
    }
    public function actionDao(){
        $model = Yii::app()->db->createCommand()->select('id,name')->from('resume_major')->order('id desc')->queryAll();
        print_r($model);
    }

}
