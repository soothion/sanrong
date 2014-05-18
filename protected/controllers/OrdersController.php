<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrdersController
 *
 * @author liuzihui
 */
class OrdersController extends Controller {

//put your code here
    public function actionIndex($goods_id) {
        $criteria = new CDbCriteria();
        $criteria->compare('id', $goods_id);
        $goodsModel = GrouponGoodsModel::model()->find($criteria);
        $this->seo = array(
            'title' => '提交订单',
        );
        $this->render('index', array(
            'goodsModel' => $goodsModel,
        ));
    }

//生成订单并且去付款
    public function actionCheck() {
        $user_id = Yii::app()->user->id;
        if (isset($_REQUEST['order_id']) && $_REQUEST['order_id'] > 0) { //如果是根据order_id查询的
            $order_id = $_REQUEST['order_id'];
            if (numeric($user_id) <= 0) {
                Yii::app()->session['http_referer'] = $this->createUrl('/orders/check', array('order_id' => $order_id));
                $this->redirect($this->createUrl('/member/login'));
                exit;
            }
            $goodsCriteria = new CDbCriteria();
            $goodsCriteria->compare('order_id', $order_id);
            $orderGoodsModel = OrderGoodsModel::model()->find($goodsCriteria);
            $criteria = new CDbCriteria();
            $criteria->compare('user_id', $user_id);
            $criteria->compare('id', $order_id);
            $model = OrdersModel::model()->find($criteria);
        } elseif (isset(Yii::app()->session['order_id']) && numeric(Yii::app()->session['order_id']) > 0) {//如果是根据session的order_id查询的
            $order_id = Yii::app()->session['order_id'];
            if (numeric($user_id) <= 0) {
                Yii::app()->session['http_referer'] = $this->createUrl('/orders/check');
                $this->redirect($this->createUrl('/member/login'));
                exit;
            }
            Yii::app()->session['order_id'] = 0;
            $goodsCriteria = new CDbCriteria();
            $goodsCriteria->compare('order_id', $order_id);
            $orderGoodsModel = OrderGoodsModel::model()->find($goodsCriteria);
            $criteria = new CDbCriteria();
            $criteria->compare('user_id', $user_id);
            $criteria->compare('id', $order_id);
            $model = OrdersModel::model()->find($criteria);
        } else {
            if (Yii::app()->request->isPostRequest) {
                $goods_id = numeric($_POST['goods_id']);
                $goods_count = numeric($_POST['goods_count']);
                if (!isset($_POST['goods_id']) || empty($_POST['goods_id'])) {
                    $this->showError('非法操作！', $this->createUrl('/'));
                    exit;
                }
                if (!isset($_POST['goods_count']) || empty($_POST['goods_count'])) {
                    $this->showError('非法操作！', $this->createUrl('/'));
                    exit;
                }
                if (numeric($user_id) <= 0) {
                    Yii::app()->session['goods_id'] = $goods_id;
                    Yii::app()->session['goods_count'] = $goods_count;
                    Yii::app()->session['http_referer'] = $this->createUrl('/orders/check');
                    $this->redirect($this->createUrl('/member/login'));
                    exit;
                }
            } else {
                if (numeric($user_id) <= 0) {
                    Yii::app()->session['http_referer'] = $this->createUrl('/orders/check');
                    $this->redirect($this->createUrl('/member/login'));
                    exit;
                }
                $goods_id = Yii::app()->session['goods_id'];
                $goods_count = Yii::app()->session['goods_count'];
                if (!isset($goods_id) || numeric($goods_id) <= 0) {
                    $this->showError('非法操作！', $this->createUrl('/'));
                    exit;
                }
                if (!isset($goods_count) || numeric($goods_count) <= 0) {
                    $this->showError('非法操作！', $this->createUrl('/'));
                    exit;
                }
                Yii::app()->session['goods_id'] = 0;
                Yii::app()->session['goods_count'] = 0;
            }

            //以上获取到goods_id和goods_count

            $goodsModel = GrouponGoodsModel::model()->findByPk($goods_id);
            $g_price = doubleval($goodsModel->g_price);

            $total_price = $g_price * $goods_count;

            $total_price = price_format($total_price);

            $userModel = UserModel::model()->with('info')->findByPk($user_id);
            $model = new OrdersModel();
            $model->user_id = $user_id;
            $model->user_email = $userModel->email;
            //$model->user_name = $userModel->username;
            $model->user_mobile = $userModel->mobile;
            $model->order_sn = get_order_sn();
            $model->total_price = $total_price;
            $model->address_name = $userModel->info ? $userModel->info->address_name : "";
            $model->address = $userModel->info ? $userModel->info->address :"";
            $model->created = time();            
            $model->status_time = time();
            if ($model->save()) {
                $this->seo = array(
                    'title' => '选择支付方式',
                );
                $orderGoodsModel = new OrderGoodsModel();
                $orderGoodsModel->order_id = $model->id;
                $orderGoodsModel->goods_id = $goods_id;
                $orderGoodsModel->goods_name = $goodsModel->title;
                $orderGoodsModel->g_price = $g_price;
                $orderGoodsModel->goods_count = $goods_count;
                $orderGoodsModel->total_price = $total_price;
                $orderGoodsModel->goods_image = $goodsModel->image;
                $orderGoodsModel->created = time();
                $orderGoodsModel->save();
            } else {
                $this->showError('操作失败！请重新操作！');
            }
        }
        $this->render('check', array(
            'orderGoodsModel' => $orderGoodsModel,
            'model' => $model,
        ));
    }

//改变数量后的价格
    public function actionChange_price() {
        $goods_id = $_POST['goods_id'];
        $goods_count = $_POST['goods_count'];
        $goodsModel = GrouponGoodsModel::model()->findByPk($goods_id);
        $g_price = doubleval($goodsModel->g_price);
        $goods_count = numeric($goods_count);
        $total_price = $g_price * $goods_count;
        $total_price = price_format($total_price);
        echo json_encode(array('status' => 1, 'total_price' => $total_price));
    }

    public function actionPay() {        
        $order_id = $_POST['order_id'];
        if(empty($_POST['address_name']) || empty($_POST['address']) || empty($_POST['user_mobile'])){
            Yii::app()->session['order_id'] = $order_id;
            $this->showError('请填写收货信息',$this->createUrl('/orders/check'));
        }
        $user_id = Yii::app()->user->id;
        if (!isset($user_id) || numeric($user_id) <= 0) {
            Yii::app()->session['order_id'] = $order_id;
            $this->showError('请登录', $this->createUrl('/member/login'));
        }
        if (!isset($_POST['payType']) || numeric($_POST['payType']) <= 0) {
            Yii::app()->session['order_id'] = $order_id;
            $this->showError('请选择支付方式', $this->createUrl('/orders/check'));
        }
        $order_type = $_POST['payType'];
        $criteria = new CDbCriteria();
        $criteria->compare('t.user_id', $user_id);
        $criteria->compare('t.id', $order_id);
        $criteria->with = array('goods');
        $model = OrdersModel::model()->find($criteria);
        if (!$model) {
            $this->showError('无此订单');
        } else {
            $model->user_mobile = $_POST['user_mobile'];
            $model->address_name = $_POST['address_name'];
            $model->address = $_POST['address'];
            $model->save();
            switch (numeric($order_type)) {
                case 1: //支付宝
                    $alipay = Yii::app()->alipay;
                    // If starting a guaranteed payment, use AlipayGuaranteeRequest instead
                    $config = array(
                        'out_trade_no' => $model->order_sn,
                        'subject' => $model->goods->goods_name,
                        'price' => 0.01,
                        'notify_url' => $this->createAbsoluteUrl('/orders/notify'),
                        'return_url' => $this->createAbsoluteUrl('/orders/return'),
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
                    break;
                case 4: //当面付
                    $model->order_type = 4;
                    $model->order_status = 0;
                    $model->status_time = time();
                    $userInfoModel= UserInfoModel::model()->find('user_id = :user_id', array(':user_id' => $model->user_id));
                    if($userInfoModel){
                        $model->user_name = $userInfoModel->nickname;
                    }else{
                        $model->user_name = '';
                    }
                    $model->save();
                    $this->render('pay_res',array('order_type'=>4,'model'=>$model));
                    break;
            }
            
        }
    }

    public function actionNotify() {
        Yii::import('application.vendors.alipay.*');
        require_once(Yii::app()->basePath . "/vendors/alipay/alipay.config.php");

        require_once(Yii::app()->basePath . "/vendors/alipay/lib/alipay_notify.class.php");

        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();

        if ($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];

            //支付宝交易号
            $trade_no = $_POST['trade_no'];

            //交易状态
            $trade_status = $_POST['trade_status'];


            if ($_POST['trade_status'] == 'WAIT_BUYER_PAY') {
                //该判断表示买家已在支付宝交易管理中产生了交易记录，但没有付款
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序

                echo "success";  //请不要修改或删除
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            } else if ($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
                //该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序

                echo "success";  //请不要修改或删除
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            } else if ($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {
                //该判断表示卖家已经发了货，但买家还没有做确认收货的操作
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序

                echo "success";  //请不要修改或删除
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            } else if ($_POST['trade_status'] == 'TRADE_FINISHED') {
                //该判断表示买家已经确认收货，这笔交易完成
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序

                echo "success";  //请不要修改或删除
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            } else {
                //其他状态判断
                echo "success";

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult ("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            echo "fail";

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }

//Redirect notification
    public function actionReturn() {
        Yii::import('application.vendors.alipay.*');
        require_once(Yii::app()->basePath . "/vendors/alipay/alipay.config.php");

        require_once(Yii::app()->basePath . "/vendors/alipay/lib/alipay_notify.class.php");
        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        if ($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
            //商户订单号
            $out_trade_no = $_GET['out_trade_no'];

            //支付宝交易号
            $trade_no = $_GET['trade_no'];

            //交易状态
            $trade_status = $_GET['trade_status'];


            if ($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
            } else if ($_GET['trade_status'] == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
            } else {
                echo "trade_status=" . $_GET['trade_status'];
            }

            echo "验证成功<br />";
            echo "trade_no=" . $trade_no;

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数
            echo "验证失败";
        }
    }

    

}
