<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of 10ageWeixin
 *
 * @author andy
 */
class weixin10age extends WeixinMp {

    public $token = '735323e9fccye87f8mca2ee80af72862';
    public $appId = 'wx5c5490e55715a9c3';
    public $appSecret = '516064a5c98fe9b82bd8c04ac848c7bd';

    public function subscribe() {
        return $this->responseTextFormat($this->postObj->FromUserName, '拾年期待与您相伴，期盼为您捡拾年华，谢谢', $this->postObj->ToUserName);
    }

    public function unsubscribe() {
        
    }

    public function click($key) {
        
    }

}

?>
