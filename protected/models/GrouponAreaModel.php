<?php

/**
 * This is the model class for table "groupon_area".
 *
 * The followings are the available columns in table 'groupon_area':
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property string $first_letter
 * @property integer $created
 */
class GrouponAreaModel extends CActiveRecord {

    public $pid_text = '';

    public function get_pid_text($pid) {
        $model = $this->find('id = :id', array(':id' => $pid));
        if ($model) {
            return $model->name;
        } else {
            return '顶级区域';
        }
    }

    Static Public function getArea($cate, $pid = 0, $html = '&nbsp;&nbsp;&nbsp;&nbsp;', $level = 0) {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                $v['html'] = str_repeat($html, $level);
                $v['level'] = $level + 1;
                $arr[] = $v;
                $arr = array_merge($arr, self::getArea($cate, $v['id'], $html, $level + 1));
            }
        }
        return $arr;
    }

    public $all_sub_category = array();

    Public function get_all_sub_category($id) {
        $this->all_sub_category = array_merge($this->all_sub_category, array($id));
        $model = GrouponAreaModel::model()->findAll('pid=:id', array(':id' => $id));
        if ($model > 0) {
            foreach ($model as $v) {
                GrouponAreaModel::model()->get_all_sub_category($v->id);
            }
        }
        return $this->all_sub_category;
    }

    public function get_typename($id) {
        $model = $this->find('id=:id', array(':id' => $id));
        return $model->typename;
    }
    
    public function save_goods($area_arr,$goods_id){
        foreach($area_arr as $k=>$id){
            $model = $this->find('id=:id',array(':id'=>$id));
            if($model){
                if(!empty($model->goods)){
                    $goods = explode(',', $model->goods);
                    $goods[] = $goods_id;
                    $goods = array_unique($goods);
                    $model->goods = implode(',', $goods);
                }else{
                    $model->goods = $goods_id;
                }
                $model->save();
            }else{
                return false;
            }
        }
        return true;
    }
    //取出指定区域的goods_id
    public function getGoodsId($area_id){
        //$model = Yii::app()->db->createCommand()->select('goods')->from('groupon_area')->where('id=:area_id',array(':area_id'=>$area_id))->query();
        $model = GrouponAreaModel::model()->find('id=:area_id',array(':area_id'=>$area_id));
        return explode(',', $model->goods);
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return GrouponAreaModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'groupon_area';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pid, created', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 64),
            array('first_letter', 'length', 'max' => 4),
            array('goods','safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, pid, first_letter, created', 'safe', 'on' => 'search'),
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
            'name' => '区域名称',
            'pid_text' => '上级区域',
            'pid' => 'Pid',
            'first_letter' => 'First Letter',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('pid', $this->pid);
        $criteria->compare('first_letter', $this->first_letter, true);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
