<?php

/**
 * This is the model class for table "worker".
 *
 * The followings are the available columns in table 'worker':
 * @property integer $id
 * @property string $mobile
 * @property string $username
 * @property string $password
 * @property string $academy
 * @property string $address
 * @property integer $admin_id
 * @property string $email
 * @property integer $last_login
 * @property string $last_ip
 * @property integer $status
 * @property integer $logins
 * @property integer $created
 */
class WorkerModel extends CActiveRecord {

    public $verifyCode;
    public $read;
    public function get_status_arr($index=""){
        $return = array(
            '0' => '未审核',
            '1' => '审核通过',
            '2' => '审核失败'
        ); 
        if($index === ""){
            return $return;
        }else{
            return $return[$index];
        }
    }
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'worker';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('admin_id, last_login, status, logins, created', 'numerical', 'integerOnly' => true),
            array('mobile, password, last_ip', 'length', 'max' => 32),
            array('username', 'length', 'max' => 16),
            array('academy', 'length', 'max' => 128),
            array('address', 'length', 'max' => 256),
            array('email', 'length', 'max' => 64),
            array('password,mobile,read', 'required', 'on' => 'register'),
            array('verifyCode', 'captcha', 'on' => 'apply'),
            array('email', 'email'),
            array('mobile','unique','message'=>'手机号已存在'),//唯一性验证，
            array('mobile', 'match', 'pattern' => '/^1\d{10}$/'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, mobile, username, password, academy, address, admin_id, email, last_login, last_ip, status, logins, created', 'safe', 'on' => 'search'),
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
            'id' => '编号',
            'mobile' => '手机号',
            'username' => '业务员姓名',
            'password' => '密码',
            'academy' => '院系',
            'address' => '地址',
            'admin_id' => '创建或者审核者',
            'email' => '邮箱',
            'last_login' => '上次登录',
            'last_ip' => '上次IP',
            'status' => '状态',
            'logins' => '登录次数',
            'created' => '创建时间',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('academy', $this->academy, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('last_login', $this->last_login);
        $criteria->compare('last_ip', $this->last_ip, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('logins', $this->logins);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return WorkerModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
