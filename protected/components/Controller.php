<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to 'column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = 'column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $subnavtabs = array();
    public $seo = array();
    public $right = true;

    public function checkEmpty(&$data) {
        if (empty($data)) {
            $this->showError('找不到相应记录！');
        }
    }

    public function isPost() {
        return !empty($_POST);
    }

    public function isAjax() {
        return isset($_REQUEST['inajax']) || isset($_REQUEST['ajax']);
    }

    public function showmessage($message, $goUrl = '', $showTime = 2, $tpl = '') {
        if ($showTime == 0) {
            $this->redirect($goUrl);
            exit;
        }
        $showTime = $showTime * 1000;        
        $this->render('/common/'.$tpl,array('message'=>$message,'goUrl'=>$goUrl,'showTime'=>$showTime));
        exit;
    }

    public function showSuccess($message = 'success!', $goUrl = '', $showTime = 2) {
        if ($goUrl == '')
            $goUrl = $_SERVER['HTTP_REFERER'];
        if ($this->isAjax()) {
            echo json_encode(array('status' => 1, 'info' => $message, 'goUrl' => $goUrl, 'showTime' => $showTime));
            exit;
        }       
        $this->showmessage($message, $goUrl, $showTime, 'showmessage_success');
    }

    public function showError($message = '操作失败，请重新操作!', $goUrl = '', $showTime = 2) {
        if ($goUrl == '')
            $goUrl = 'back';
        if ($this->isAjax()) {
            echo json_encode(array('status' => 0, 'info' => $message, 'goUrl' => $goUrl, 'showTime' => $showTime));
            exit;
        }
        $this->showmessage($message, $goUrl, $showTime, 'showmessage_error');
    }
    public function checkAccess($action = '', $return = false) {
        if (Yii::app()->user->isGuest) {
            if ($return) {
                return true;
            } else {
                $this->showError('未登录，请登录后再操作', '/login?redirect_url=' . urlencode(Yii::app()->request->url) . (isset($_GET['iniframe']) ? '&iniframe=1' : ''), 0);
            }
        }
        if (Yii::app()->user->cAccess($action)) {
            return true;
        } else {
            if ($return) {
                return true;
            } else {
                //$this->showError('没有操作权限！');
                return false;
            }
        }
    }

}