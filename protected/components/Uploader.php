<?php

/**
 * This is the model class for table "upload".
 *
 * The followings are the available columns in table 'upload':
 * @property integer $id
 * @property integer $user_type
 * @property integer $user_id
 * @property integer $item_type
 * @property integer $item_id
 * @property string $name
 * @property string $file
 * @property integer $size
 * @property string $ext
 * @property string $uniqid
 * @property integer $created
 */
define('WEBROOT', Yii::getPathOfAlias('webroot') . '/');

class Uploader extends CActiveRecord {

    const USER_TYPE_SYSTEM = 0;
    const USER_TYPE_MANAGER = 1;
    const USER_TYPE_PROPERTY_SERVICER = 2;
    const ITEM_TYPE_COMMENT = 0;
    const ITEM_TYPE_NEWS = 1;
    const ITEM_TYPE_CASES = 2;

    public $thumbSize = array(
        'xxlarge' => array('width' => 800, 'height' => 800),
        'xlarge' => array('width' => 640, 'height' => 640),
        'large' => array('width' => 320, 'height' => 320),
        'middle' => array('width' => 240, 'height' => 240),
        'small' => array('width' => 80, 'height' => 80),
    );
    public $uniqid = '';
    private $uploadInfo = array();
    private $allowExt = array('png', 'jpg', 'jpeg', 'gif', 'rar', 'zip', 'gz', 'biz', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt');
    private $error = '';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Uploader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getWebRoot() {
        return WEBROOT;
    }

    public function getImageUrl($size = '') {
        return getImageUrl($this->file, $size);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'upload';
    }

    public function userByPropertyServicer() {
        $this->user_type = self::USER_TYPE_PROPERTY_SERVICER;
        $this->user_id = Yii::app()->user->getId();
    }

    public function userByManager() {
        $this->user_type = self::USER_TYPE_MANAGER;
        $this->user_id = Yii::app()->user->getId();
    }

    public function useImage() {
        $this->allowExt = array('png', 'jpg', 'jpeg', 'gif');
        return $this;
    }

    public function useFile() {
        $this->allowExt = array('zip', 'bz2', 'rar', 'gz', 'tar');
        return $this;
    }

    public function upload($field, $destination = '') {
        if (isset($_FILES[$field]['error']) && $_FILES[$field]['error'] == 0 && !empty($_FILES[$field]['tmp_name'])) {
            $fileext = strtolower($this->fileext($_FILES[$field]['name']));
            if (!in_array($fileext, $this->allowExt)) {
                $this->addError('error', '文件类型不允许上传！');
                return false;
            }
            $destination = $destination != '' ? $destination : '/upload/' . date('ym/dH/i/') . uniqid() . '.' . $fileext;
            mk_dir(dirname(WEBROOT . $destination));
            if (move_uploaded_file($_FILES[$field]['tmp_name'], WEBROOT . $destination)) {
                $this->file = $destination;
                $this->size = $_FILES[$field]['size'];
                $this->name = $_FILES[$field]['name'];
                $this->ext = $fileext;
                $this->created = time();
                $this->save();
                return true;
            } else {
                
            }
        }
        return false;
    }

//    public function uploadify_image($destination = '') {
//        $destination = $destination != '' ? $destination : '/upload/' . date('ym/dH/i/') . uniqid() . '.' . $fileext;
//        mk_dir(dirname(WEBROOT . $destination));
//        if (move_uploaded_file($_FILES[$field]['tmp_name'], WEBROOT . $destination)) {
//            $this->file = $destination;
//            $this->size = $_FILES[$field]['size'];
//            $this->name = $_FILES[$field]['name'];
//            $this->ext = $fileext;
//            $this->created = time();
//            $this->save();
//            return true;
//        }
//    }

    public function batch_upload($field, $upload_key = '', $destination = '') {
        $upload_result = array();
        if (isset($_FILES[$field]['tmp_name']) && is_array($_FILES[$field]['tmp_name'])) {
            foreach ($_FILES[$field]['tmp_name'] as $key => $value) {
                if (($upload_key !== '' && $upload_key !== $key) || empty($_FILES[$field]['tmp_name'][$key])) {
                    continue;
                }
                $fileext = strtolower($this->fileext($_FILES[$field]['name'][$key]));
                if (!in_array($fileext, $this->allowExt)) {
                    $this->addError('error', '文件类型不允许上传！');
                    continue;
                }
                $destination = $destination != '' ? $destination : '/upload/' . date('ym/dH/i/') . uniqid() . '.' . $fileext;
                mk_dir(dirname(WEBROOT . $destination));
                if (move_uploaded_file($_FILES[$field]['tmp_name'][$key], WEBROOT . $destination)) {
                    $uploader = new Uploader();
                    $uploader->file = $destination;
                    $uploader->size = $_FILES[$field]['size'][$key];
                    $uploader->name = $_FILES[$field]['name'][$key];
                    $uploader->ext = $fileext;
                    $uploader->created = time();
                    $uploader->save();
                    $upload_result[$key] = $uploader;
                } else {
                    
                }
            }
        }
        return $upload_result;
    }

    public function thumb_upload($field, $destination, $maxWidth = 200, $maxHeight = 200) {
        $this->useImage();
        if (isset($_FILES[$field]['error']) && $_FILES[$field]['error'] == 0 && !empty($_FILES[$field]['tmp_name'])) {
            $fileext = strtolower($this->fileext($_FILES[$field]['name']));
            if (!in_array($fileext, $this->allowExt)) {
                $this->addError('error', '文件类型不允许上传！');
                return false;
            }
            $destination = $destination != '' ? $destination : '/upload/' . date('ym/d/') . uniqid() . '.' . $fileext;
            mk_dir(dirname(WEBROOT . $destination));
            Yii::import('application.extensions.Image');
            $image = new Image();
            if (image::thumb($_FILES[$field]['tmp_name'], WEBROOT . $destination, $fileext, $maxWidth, $maxHeight)) {
                $this->file = $destination;
                $this->size = $_FILES[$field]['size'];
                $this->name = $_FILES[$field]['name'];
                $this->ext = $fileext;
                $this->created = time();
                $this->save();

                return true;
            } else {
                
            }
        }
        return false;
    }

    public function UpdateItemInfo($uniqid, $item_type, $item_id) {
        if (!empty($uniqid)) {
            $this->updateAll(array('item_type' => $item_type, 'item_id' => $item_id, 'uniqid' => ''), 'uniqid=:uniqid', array(':uniqid' => $uniqid));
        }
    }

    public function getUploadInfo() {
        return $this->uploadInfo;
    }

    function fileext($filename) {
        return substr(strrchr($filename, '.'), 1);
    }

    function getDefaultDestination() {
        
    }

    public function initUploadifyButton($elementId = 'file_upload', $options = array()) {
        static $script = null;
        $uploadifyroot = '/static/jquery/uploadify/';
        $allowExt = array();
        foreach ($this->allowExt as $value) {
            $allowExt[] = '*.' . $value;
        }
        $fileExt = implode(';', $allowExt);
        $fileDesc = '请选择' . implode(';', $this->allowExt) . '文件';
        $opt = array(
            'swf' => $uploadifyroot . 'uploadify.swf',
            'uploader' => Yii::app()->controller->createUrl('upload/index', array('uniqid' => uniqid())),
            'formData' => array('clientsession' => session_id()),
            'fileObjName' => 'filedata',
            'fileSizeLimit' => '2MB',
            'auto' => true,
            'multi' => true,
            'fileTypeExts' => $fileExt,
            'fileTypeDesc' => $fileDesc,
            'buttonImage' => $uploadifyroot . 'upload_attachment.png',
            'width' => '98',
            'height' => '28',
            'cancelImg' => $uploadifyroot . 'cancel.png',
        );
        $defaultFun = array(
            'overrideEvents' => "['onDialogClose']",
            'onUploadSuccess' => 'function(file, data, response){' . (isset($options['onUploadSuccess']) ? $options['onUploadSuccess'] . '(file, data, response)' : '') . '}',
            'onSelectError' => 'function(file, errorCode, errorMsg){' . (isset($options['onSelectError']) ? $options['onSelectError'] . '(file, errorCode, errorMsg)' : '') . '}',
            'onUploadError' => 'function(file, errorCode, errorMsg, errorString){' . (isset($options['onSelectError']) ? $options['onSelectError'] . '(file, errorCode, errorMsg, errorString)' : '') . '}',
            'onQueueComplete' => 'function(queueData){' . (isset($options['onQueueComplete']) ? $options['onQueueComplete'] . '(queueData)' : '$("#' . $elementId . '-queue").hide();') . '}',
            'onUploadStart' => 'function(file){' . (isset($options['onUploadStart']) ? $options['onUploadStart'] . '(file)' : '$("#' . $elementId . '-queue").hide();') . '}',
        );
        foreach ($defaultFun as $k => $v) {
            $defaultFun[$k] = $k . ':' . $v;
        }
        $uploadifyHtml = '<input type="file" name="' . $elementId . '" id="' . $elementId . '">';
        if ($script === null) {
            $script = 1;
            $uploadifyHtml .= '<script src="' . $uploadifyroot . 'jquery.uploadify.min.js" type="text/javascript"></script> ';
        }
        $uploadifyHtml .= '<script type="text/javascript">
            $("#' . $elementId . '").uploadify(' . rtrim(json_encode($opt), '}') . ',' . implode(",\n", $defaultFun) . '});
            </script>';
        return $uploadifyHtml;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('file,ext', 'required'),
            array('user_type, user_id, item_type, item_id, size, created', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 100),
            array('file', 'length', 'max' => 50),
            array('ext', 'length', 'max' => 5),
            array('uniqid', 'length', 'max' => 15),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, item_type, item_id, name, file, size, ext, uniqid, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'item_type' => 'Item Type',
            'item_id' => 'Item',
            'name' => 'Name',
            'file' => 'File',
            'size' => 'Size',
            'ext' => 'Ext',
            'uniqid' => 'Uniqid',
            'created' => 'Created',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('item_type', $this->item_type);
        $criteria->compare('item_id', $this->item_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('file', $this->file, true);
        $criteria->compare('size', $this->size);
        $criteria->compare('ext', $this->ext, true);
        $criteria->compare('uniqid', $this->uniqid, true);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
