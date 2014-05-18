<?php

class UploadController extends Controller {

    public function actionIndex() {
        if (isset($_FILES['upfile']['tmp_name']) && !empty($_FILES['upfile']['tmp_name'])) {
            $Uploader = new Uploader();
            $Uploader->user_type = Uploader::USER_TYPE_MANAGER;
            $Uploader->user_id = Yii::app()->user->getId();
            if (isset($_GET['item_type']) && in_array($_GET['item_type'], Uploader::$item_type_config)) {
                $Uploader->item_type = $_GET['item_type'];
            }
            if (!empty($Uploader->item_type) && isset($_GET['item_id'])) {
                $Uploader->item_id = numeric($_GET['item_id']);
            }
            $Uploader->uniqid = isset($_REQUEST['uniqid']) ? $_REQUEST['uniqid'] : '';
            if ($Uploader->upload('upfile')) {
                $data = $Uploader->getAttributes();
                $data['status'] = 1;
                echo json_encode($data);
            } else {
                $data['error'] = $Uploader->getError('error');
                $data['status'] = 0;
                echo json_encode($data);
            }
        }
        exit;
    }

    public function actionUe_upload_image() {
        if (isset($_FILES['upfile']['tmp_name']) && !empty($_FILES['upfile']['tmp_name'])) {
            $Uploader = new Uploader();
            $Uploader->user_type = Uploader::USER_TYPE_MANAGER;
            $Uploader->user_id = Yii::app()->user->getId();
            if (isset($_GET['item_type']) && in_array($_GET['item_type'], Uploader::$item_type_config)) {
                $Uploader->item_type = $_GET['item_type'];
            }
            if (!empty($Uploader->item_type) && isset($_GET['item_id'])) {
                $Uploader->item_id = numeric($_GET['item_id']);
            }
            $Uploader->uniqid = isset($_REQUEST['uniqid']) ? $_REQUEST['uniqid'] : '';
            if ($Uploader->upload('upfile')) {
                $data = $Uploader->getAttributes();
                $data['status'] = 1;

                echo json_encode(array('url' => $Uploader->file, 'title' => '', 'state' => 'SUCCESS'));
            } else {
                $data['error'] = $Uploader->getError('error');
                $data['status'] = 0;
                echo json_encode($data);
            }
        }
        exit;
    }

    public function actionXheditor_upload_file() {
        if (isset($_FILES['filedata']['tmp_name']) && !empty($_FILES['filedata']['tmp_name'])) {
            $Uploader = new Uploader();
            $Uploader->userFile();
            $Uploader->uniqid = isset($_REQUEST['uniqid']) ? $_REQUEST['uniqid'] : '';
            if ($Uploader->upload('filedata')) {
                echo json_encode(array('err' => '', 'msg' => array('url' => '!' . $Uploader->file, 'id' => $Uploader->id)));
            } else {
                echo json_encode(array('err' => $Uploader->getError('error'), 'msg' => ''));
            }
        }
        exit;
    }

    public function actionXheditor_image() {
        if (isset($_FILES['filedata']['tmp_name']) && !empty($_FILES['filedata']['tmp_name'])) {
            $Uploader = new Uploader();
            $Uploader->useImage();
            $Uploader->uniqid = isset($_REQUEST['uniqid']) ? $_REQUEST['uniqid'] : '';
            if ($Uploader->upload('filedata')) {
                echo json_encode(array('err' => '', 'msg' => array('url' => '!' . $Uploader->file, 'id' => $Uploader->id)));
            } else {
                echo json_encode(array('err' => $Uploader->getError('error'), 'msg' => ''));
            }
        }
        exit;
    }

    public function actionDelete() {
        $Uploader = new Uploader();
        if (isset($_GET['id'])) {
            $data = $Uploader->findByPk(numeric($_GET['id']));
            if (!empty($data)) {
                @unlink(WWWROOT . $data->file);
                $data->delete();
                $this->showSuccess('删除成功！');
            }
            $this->showSuccess('删除成功！');
        }
    }

    public function actionDownload($id = 0, $file = '', $token = '') {
        if ($file != '') {
            $data = new Uploader();
            $data->file = $file;
        } else {
            if (md5($id . session_id()) != $token) {
                $this->showError('没有下载权限！');
            }
            $data = Uploader::model()->findByPk($id);
        }

        if (empty($data) || !file_exists(getWebPath() . $data->file)) {
            $this->showError('文件不存在！');
        }
        $filename = $data->name;
        $encoded_filename = urlencode($filename);
        $encoded_filename = str_replace("+", "%20", $encoded_filename);

        header('Content-Description: File Transfer');
        header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
        header('Pragma: public');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        // force download dialog
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream', false);
        header('Content-Type: application/download', false);

        header('Content-Type: application/octet-stream');

        if (preg_match("/MSIE/", $_SERVER["HTTP_USER_AGENT"])) {
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        } else if (preg_match("/Firefox/", $_SERVER["HTTP_USER_AGENT"])) {
            header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
        } else {
            header('Content-Disposition: attachment; filename="' . $filename . '"');
        }


        header('Content-Transfer-Encoding: binary');

        echo file_get_contents(getWebPath() . $data->file);
    }

    public function actionUploadify_image() {
        //file_put_contents('d:/log.txt', 'abc'.json_encode($_FILES));
        $Uploader = new Uploader();
        $Uploader->useImage();
        if ($Uploader->upload('Filedata')) {
            echo json_encode(array('status' => 'success', 'file' => $Uploader->file));
        }
    }

}
