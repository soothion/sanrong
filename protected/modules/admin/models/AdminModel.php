<?php

/**
 * This is the model class for table "admin".
 *
 * The followings are the available columns in table 'admin':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $last_login
 * @property string $last_ip
 * @property integer $role_id
 * @property integer $logins
 * @property integer $created
 */
class AdminModel extends CActiveRecord {
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'admin';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username,password', 'required'),
            array('last_login, role_id, logins, created', 'numerical', 'integerOnly' => true),
            array('username', 'ruleUsername', 'on' => 'create'),
            array('username', 'length', 'max' => 16),
            array('password, last_ip', 'length', 'max' => 32),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, password, last_login, last_ip, role_id, logins, created', 'safe', 'on' => 'search'),
        );
    }

    public function ruleUsername() {
       return $data = $this->find('username=:username', array(':username' => $this->username));
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'role' => array(self::BELONGS_TO, 'AdminRoleModel', array('role_id' => 'id'), 'joinType' => 'left join', 'alias' => 'role', 'select' => '*'),
                //'roles' => array(self::BELONGS_TO,'AdminRoleModel','role_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => '用户名',
            'password' => '密码',
            'last_login' => '上次登录时间',
            'last_ip' => '上次登录ip',
            'role_id' => '角色',
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
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('last_login', $this->last_login);
        $criteria->compare('last_ip', $this->last_ip, true);
        $criteria->compare('role_id', $this->role_id);
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
     * @return AdminModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
