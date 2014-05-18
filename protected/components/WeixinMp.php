<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WeixinMp
 *
 * @author andy
 */
class WeixinMp {

    public $token = '735323e9fcc0e87f8bca2ee80af72640';
    public $appId = 'wx11ab70681ca5ce70';
    public $appSecret = '7f074e47882315ef61e7f1a2844647e1';
    public $encodeKey = '899c73db4d00f';
    public $postObj = null;
    public $debug = false;

    static public function model() {
        return new self;
    }

    public function __construct($token = '', $appId = '', $appSecret = '', $debug = true) {
        $this->token = $token != '' ? $token : $this->token;
        $this->appId = $appId != '' ? $appId : $this->appId;
        $this->appSecret = $appSecret != '' ? $appSecret : $this->appSecret;
        $this->debug = $debug;
    }

    public function getAuthCode() {
        $string = serialize(array('wxopenid' => (string) $this->postObj->FromUserName, 'time' => time()));
        return urlencode(authcode($string, 'ENCODE', $this->encodeKey));
    }

    public function decodeAuthCode($code) {
        $string = authcode(urldecode($code), 'DECODE', $this->encodeKey);
        return (array) unserialize($string);
    }

    public function run($postStr) {
        $replyContent = '';

        $this->postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);


        if (!empty($this->postObj)) {
            $msgType = trim($this->postObj->MsgType);
            if (method_exists($this, 'run' . $msgType)) {
                $replyContent = $this->{'run' . $msgType}();
            }
        } else {
            $replyContent = $this->getDefaultReply();
        }
        if ($this->debug) {
            $TestModel = new TestModel();
            $TestModel->data = serialize(array('msgType' => $msgType, 'ToUserName' => (string) $this->postObj->ToUserName, 'FromUserName' => (string) $this->postObj->FromUserName, 'post' => $_POST, 'replyContent' => $replyContent, 'postStr' => $postStr, 'get' => $_GET));
            $TestModel->created = time();
            $TestModel->save();
        }
        return $replyContent;
    }

    private function runEvent() {
        $event = strtolower(trim($this->postObj->Event));
        if ($event == 'subscribe') {
            return $this->getDefaultReply();
            //return $this->responseTextFormat($this->postObj->FromUserName, SettingModel::model()->getSetting('smartreply_subscribe'));
        } elseif ($event == 'unsubscribe') {
            
        } elseif ($event == 'click') {
            $EventKey = strtolower(trim($this->postObj->EventKey));
            if ($EventKey == 'tj') {
                return $this->getStatistics();
            }
        }

        return $this->getDefaultReply();
    }

    private function runText() {
        $content = strtolower(trim($this->postObj->Content));
        if (strlen($content) < 50) {
            if ($content == 'y' || $content == 'yy') {
                return $this->getNews($content);
            } elseif ($content == 'tj') {
                return $this->getStatistics();
            }
        }

        return $this->getDefaultReply();
    }

    private function getStatistics() {
        $FromUserName = trim($this->postObj->FromUserName);
        $ralation = WxCustomersAdminRelationModel::model()->find('wxopenid=:wxopenid', array(':wxopenid' => $FromUserName));
        if (empty($ralation)) {
            return $this->responseTextFormat($FromUserName, '你还未绑定V房产账号      <a href="' . Yunad::WEBURL . '/client?wxopenid=' . $this->postObj->FromUserName . '">点击立即绑定</a>');
        } else {
            $customersAdminData = YunadCustomersAdminModel::model()->find('id=:id', array(':id' => $ralation->customers_admin_id));
            if (empty($customersAdminData)) {
                $ralation->delete();
                return $this->responseTextFormat($FromUserName, '你绑定V房产账号已经失效,请重新绑定新的账号  <a href="' . Yunad::WEBURL . '/client?wxopenid=' . $this->postObj->FromUserName . '">点击立即绑定</a>');
            }
            $criteria = new CDbCriteria();
            $criteria->limit = 10;
            $criteria->compare('customer_id', $customersAdminData->customer_id);
            if (!$customersAdminData->is_super) {
                $access_ad_ids = explode(',', $customersAdminData->access_ad_ids);
                $criteria->addInCondition('id', $access_ad_ids);
            }
            $newsData = array();
            //取得公司信息
            $customerData = YunadCustomersModel::model()->find('id=:id', array(':id' => $customersAdminData->customer_id));
            if (!empty($customerData)) {
                $newsData[] = array('title' => $customerData->company_name, 'description' => '', 'picurl' => '', 'url' => Yunad::WEBURL . '/client?client_id=' . $customerData->id);
            }
            $data = YunadAdvertsModel::model()->findAll($criteria);
            if (!empty($data)) {
                foreach ($data as $row) {
                    $newsData[] = array('title' => $row->title, 'description' => '', 'picurl' => '', 'url' => Yunad::WEBURL . '/client/statistic?wxopenid=' . $this->postObj->FromUserName . '&ad_id=' . $row['id']);
                }
            }
            $newsData[] = array('title' => '解绑并使用其它账号查看统计', 'description' => '', 'picurl' => '', 'url' => Yunad::WEBURL . '/client?unbound=1&wxopenid=' . $this->postObj->FromUserName);
            return $this->responseNewsFormat($this->postObj->FromUserName, $newsData, $this->postObj->ToUserName);
        }
    }

    private function getNews($commend) {
        $criteria = new CDbCriteria();
        $criteria->order = 'id desc';
        $criteria->limit = 3;
        if ($commend == 'y') {
            $criteria->compare('news_category_id', 7);
        } else {
            $criteria->compare('news_category_id', 8);
        }
        $data = NewsModel::model()->findAll($criteria);
        $newsData = array();
        if (!empty($data)) {
            foreach ($data as $row) {
                $newsData[] = array('title' => $row->title, 'description' => $row->summary, 'picurl' => $row->getImage(), 'url' => $row->getUrl(true));
            }
        }
        return $this->responseNewsFormat($this->postObj->FromUserName, $newsData, $this->postObj->ToUserName);
    }

    private function runImage() {
        return $this->getDefaultReply();
    }

    private function runLocation() {
        return $this->getDefaultReply();
    }

    private function runLink() {
        return $this->getDefaultReply();
    }

    public function responseTextFormat($toUsername, $Content, $fromUsername = '') {
        $time = time();
        return "<xml>
                    <ToUserName><![CDATA[{$toUsername}]]></ToUserName>
                    <FromUserName><![CDATA[{$fromUsername}]]></FromUserName>
                    <CreateTime>{$time}</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[{$Content}]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";
    }

    public function responseNewsFormat($toUsername, $news, $fromUsername = '') {
        $time = time();
        if (empty($news)) {
            return $this->responseTextFormat($toUsername, '找不到新闻!');
        }
        $ArticleCount = count($news);
        $Articles = '';
        foreach ($news as $value) {
            $Articles .= "<item>
                <Title><![CDATA[{$value['title']}]]></Title> 
                <Description><![CDATA[{$value['description']}]]></Description>
                <PicUrl><![CDATA[{$value['picurl']}]]></PicUrl>
                <Url><![CDATA[{$value['url']}]]></Url>
                </item>";
        }
        return "<xml>
                <ToUserName><![CDATA[{$toUsername}]]></ToUserName>
                <FromUserName><![CDATA[{$fromUsername}]]></FromUserName>
                <CreateTime>$time</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>{$ArticleCount}</ArticleCount>
                <Articles>{$Articles}</Articles>
                </xml> ";
    }

    public function getDefaultReply() {
        $newsData = array(
            array('title' => '产品介绍', 'description' => '', 'picurl' => Yii::app()->request->hostInfo . Yii::app()->params['themeUrl'] . 'images/pic_pro_small.jpg?2', 'url' => Yii::app()->request->hostInfo . '/about_us'),
            array('title' => '房产资讯', 'description' => '', 'picurl' => Yii::app()->request->hostInfo . Yii::app()->params['themeUrl'] . 'images/news.jpg?2', 'url' => Yii::app()->request->hostInfo . '/news/list'),
            array('title' => '广告统计', 'description' => '', 'picurl' => Yii::app()->request->hostInfo . Yii::app()->params['themeUrl'] . 'images/stat.jpg?2', 'url' => Yunad::WEBURL . '/client?wxopenid=' . $this->postObj->FromUserName),
            array('title' => '成功案例', 'description' => '', 'picurl' => Yii::app()->request->hostInfo . Yii::app()->params['themeUrl'] . 'images/case.jpg?2', 'url' => Yii::app()->request->hostInfo . '/case/list'),
            array('title' => '联系我们', 'description' => '', 'picurl' => Yii::app()->request->hostInfo . Yii::app()->params['themeUrl'] . 'images/contact_us.jpg?2', 'url' => Yii::app()->request->hostInfo . '/contact_us'),
        );

        return $this->responseNewsFormat($this->postObj->FromUserName, $newsData, $this->postObj->ToUserName);
        return $this->responseTextFormat($this->postObj->FromUserName, '欢迎关注联桥分众!', $this->postObj->ToUserName);
    }

    public function menuUpdate($data) {
        $access_token = curl('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $this->appId . '&secret=' . $this->appSecret);
        $access_token = (array) json_decode($access_token);
        if (isset($access_token['access_token'])) {
            $api = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $access_token['access_token'];
            echo curl_direct_post($api, $data);
        }
    }

}

?>
