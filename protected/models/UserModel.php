<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $last_login
 * @property string $last_ip
 * @property integer $status
 * @property integer $logins
 * @property integer $created
 */
class UserModel extends CActiveRecord {

    public $verifyCode;
    public $read;
    public $password2;
    public $real_name;
    public $company_name;
    public $position;
    public $company_address;
    public $trading_certificate;

//    public function get_user_type($index = '') {
//        $return = array(
//            0 => '个人',
//            1 => '企业'
//        );
//        if ($index === '') {
//            return $return;
//        } else {
//            return $return[$index];
//        }
//    }

    public function get_user_type($index = '') {
        $return = array(
            0 => '个人',
            1 => '企业',
            2 => '企业审核中',
            3 => '企业审核不通过',
        );
        if ($index === '') {
            return $return;
        } else {
            return $return[$index];
        }
    }
    public function get_status($index = ''){
        $return = array(
            0 => '否',
            1 => '是',
        );
        if ($index === '') {
            return $return;
        } else {
            return $return[$index];
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('last_login, status, logins,user_type, created', 'numerical', 'integerOnly' => true),
            array('password, last_ip,codes', 'length', 'max' => 32),
            array('email', 'length', 'max' => 64),
            array('mobile,real_name,company_name,company_name,position,company_address,trading_certificate', 'safe'),
            array('password,password2,email,read', 'required', 'on' => 'register'),
            array('verifyCode', 'captcha', 'on' => 'register'),
            array('password,password2,email,read', 'required', 'on' => 'register_enterprise'),
            array('verifyCode', 'captcha', 'on' => 'register_enterprise'),
            array('email', 'email'),
            array('password2', 'compare', 'compareAttribute' => 'password', 'message' => '两次密码不一致'), //对比验证，如“确认密码”
            array('mobile', 'match', 'pattern' => '/^1\d{10}$/'),
            array('email', 'unique', 'message' => '邮箱已存在'), //唯一性验证，
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, password, email, mobile, last_login, codes,last_ip, status, logins, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'company' => array(self::HAS_ONE,'UserCompanyModel','user_id'),
            'info' => array(self::HAS_ONE,'UserInfoModel','user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'password' => '密码',
            'password2' => '确认密码',
            'email' => '邮箱',
            'mobile' => '手机',
            'user_type' => '用户身份',
            'last_login' => '上次登录',
            'last_ip' => '上次登录IP',
            'status' => '邮箱是否激活',
            'logins' => '登录次数',
            'codes' => '邮箱校验码',
            'created' => '创建时间',
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
        $criteria->compare('password', $this->password, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('last_login', $this->last_login);
        $criteria->compare('last_ip', $this->last_ip, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('logins', $this->logins);
        $criteria->compare('codes', $this->codes);
        $criteria->compare('created', $this->created);
        $criteria->compare('user_type', $this->user_type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
