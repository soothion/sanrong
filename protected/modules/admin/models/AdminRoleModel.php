<?php

/**
 * This is the model class for table "admin_role".
 *
 * The followings are the available columns in table 'admin_role':
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property string $access
 * @property integer $created
 */
class AdminRoleModel extends CActiveRecord {

    static public $accessConfig = array(
        '0' => '团购模型',
        '1' => '人才模型',
        '2' => '业务模型',
        '3' => '管理员模块',
        '4' => '数据库模块'
    );

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'admin_role';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, desc, access, created', 'required'),
            array('created', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 50),
            array('desc', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, desc, access, created', 'safe', 'on' => 'search'),
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
            'name' => '角色名',
            'desc' => '角色描述',
            'access' => '权限',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('access', $this->access, true);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AdminRoleModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
