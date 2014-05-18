<?php

/* *
 * 功能：标准双接口接入页
 * 版本：3.3
 * 修改日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 * ************************注意*************************
 * 如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 * 1、商户服务中心（https://b.alipay.com/support/helperApply.htm?action=consultationApply），提交申请集成协助，我们会有专业的技术工程师主动联系您协助解决
 * 2、商户帮助中心（http://help.alipay.com/support/232511-16307/0-16307.htm?sh=Y&info_type=9）
 * 3、支付宝论坛（http://club.alipay.com/read-htm-tid-8681712.html）
 * 如果不想使用扩展功能请把扩展功能参数赋空值。
 */

Class AlipayApi extends CComponent {

    private $payment_type = "1";
    //private $notify_url = Yii::app()->controller->createAbsoluteUrl('/orders/return');
    //private $return_url = "http://1.klwys.com/orders/return.html";
    private $seller_email = '289747370@qq.com';
    private $quantity = "1";
    private $logistics_fee = "0.00";
    private $logistics_type = "EXPRESS";
    private $logistics_payment = "SELLER_PAY";

    public function init() {
        Yii::import('application.vendors.alipay.lib.*');
        //Yii::import('application.vendors.alipay.*');
        
    }

    public function buildForm($config) {
        Yii::import('application.vendors.alipay.lib.*');
        require_once("lib/alipay_submit.class.php");
        require_once("alipay.config.php");
        $parameter = array(
            "service" => "trade_create_by_buyer",
            "partner" => trim($alipay_config['partner']),
            'payment_type' => $this->payment_type,
            'seller_email' => $this->seller_email,
            'quantity' => $this->quantity,
            'logistics_fee' => $this->logistics_fee,
            'logistics_type' => $this->logistics_type,
            'logistics_payment' => $this->logistics_payment,
            "_input_charset" => trim(strtolower($alipay_config['input_charset']))
        );
        $parameter = array_merge($parameter, $config);
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter, "get", " ");
        return $html_text;
    }
}
?>