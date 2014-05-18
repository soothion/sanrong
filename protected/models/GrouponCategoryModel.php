<?php

/**
 * This is the model class for table "groupon_category".
 *
 * The followings are the available columns in table 'groupon_category':
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property integer $is_hot
 * @property integer $created
 */
class GrouponCategoryModel extends CActiveRecord {

    public $pid_text = '';

    public function get_pid_text($pid) {
        $model = $this->find('id = :id', array(':id' => $pid));
        if ($model) {
            return $model->name;
        } else {
            return '顶级分类';
        }
    }
    
    Static Public function getCategory($cate, $pid = 0, $html = '&nbsp;&nbsp;&nbsp;&nbsp;', $level = 0) {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                $v['html'] = str_repeat($html, $level);
                $v['level'] = $level + 1;
                $arr[] = $v;
                $arr = array_merge($arr, self::getCategory($cate, $v['id'], $html, $level + 1));
            }
        }
        return $arr;
    }
    /**
     * 取得所有的子类
     */
    public function getAllSub($id){
        $model = Yii::app()->db->createCommand()->select('id')->from('groupon_category')->where('pid=:id',array(':id'=>$id))->queryAll();
        $cate_ids = CHtml::listData($model, 'id', 'id');
        $cate_ids[] = $id;
        return $cate_ids;
    }
    public $all_sub_category = array();

    Public function get_all_sub_category($id) {
        $this->all_sub_category = array_merge($this->all_sub_category, array($id));
        $model = GrouponCategoryModel::model()->findAll('pid=:id', array(':id' => $id));
        if ($model > 0) {
            foreach ($model as $v) {
                GrouponCategoryModel::model()->get_all_sub_category($v->id);
            }
        }
        return $this->all_sub_category;
    }

    public function get_typename($id) {
        $model = $this->find('id=:id', array(':id' => $id));
        return $model->typename;
    }

    public function is_hot_data() {
        $status_arr = array(
            '1' => '是',
            '0' => '否',
        );
        return $status_arr;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'groupon_category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pid, is_hot, created', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 64),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, pid, is_hot, created', 'safe', 'on' => 'search'),
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
            'name' => '分类名称',
            'pid_text' => '上级分类',
            'pid' => 'Pid',
            'is_hot' => '是否热门',
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
        $criteria->compare('pid', $this->pid);
        $criteria->compare('is_hot', $this->is_hot);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GrouponCategoryModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
