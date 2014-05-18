<?php

/**
 * This is the model class for table "friendlink".
 *
 * The followings are the available columns in table 'friendlink':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $is_target
 * @property integer $status
 * @property integer $created
 */
class FriendlinkModel extends CActiveRecord {

    public function getStatus($index = "") {
        $status = array(
            '0' => '隐藏',
            '1' => '显示'
        );
        if ($index === "") {
            return $status;
        } else {
            return $status[$index];
        }
    }

    public function getTarget($index = "") {
        $status = array(
            '0' => '否',
            '1' => '是'
        );
        if ($index === "") {
            return $status;
        } else {
            return $status[$index];
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return FriendlinkModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'friendlink';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('is_target, status, created, sort', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 32),
            array('url', 'length', 'max' => 128),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, url, is_target, status, created', 'safe', 'on' => 'search'),
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
            'name' => '名称',
            'url' => '链接',
            'is_target' => '新窗口打开',
            'status' => '状态',
            'sort' => '排序',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('is_target', $this->is_target);
        $criteria->compare('status', $this->status);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
