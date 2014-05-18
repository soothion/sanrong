<?php

/**
 * This is the model class for table "user_company".
 *
 * The followings are the available columns in table 'user_company':
 * @property integer $id
 * @property integer $user_id
 * @property string $real_name
 * @property string $company_name
 * @property string $position
 * @property string $company_address
 * @property integer $created
 */
class UserCompanyModel extends CActiveRecord {

    public $verifyCode;
    public $read;
    public $email;
    public $password;
    public $password2;
    public $mobile;

    /**
     * @return string the associated database table name
     */
    public function get_trading_certificate($id){
        if(!empty($this->findByPk($id)->trading_certificate)){
            return '已上传';
        }else{
            return '该公司未上传营业执照';
        }
    }
    public function tableName() {
        return 'user_company';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, created', 'numerical', 'integerOnly' => true),
            array('real_name', 'length', 'max' => 32),
            array('company_name, position, company_address,trading_certificate', 'length', 'max' => 128),
            array('email', 'email'),
            array('password2', 'compare', 'compareAttribute' => 'password', 'message' => '两次密码不一致'), //对比验证，如“确认密码”
            //array('mobile', 'match', 'pattern' => '/^1\d{10}$/'),
            array('email', 'unique', 'message' => '邮箱已存在'), //唯一性验证，
//            array('password,password2,email', 'required'),
            array('verifyCode', 'captcha', 'on' => 'register_enterprise'),
            array('company_phone','safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, real_name, company_name, position, company_address, trading_certificate,created', 'safe', 'on' => 'search'),
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
            'user_id' => 'User',
            'real_name' => '真实姓名',
            'company_name' => '公司名称',
            'company_phone' => '公司电话',
            'position' => '申请人职位',
            'company_address' => '公司地址',
            'trading_certificate' => '营业执照',
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('real_name', $this->real_name, true);
        $criteria->compare('company_phone', $this->company_phone, true);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('company_address', $this->company_address, true);
        $criteria->compare('trading_certificate', $this->trading_certificate, true);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserCompanyModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
