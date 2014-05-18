<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property string $title
 * @property integer $cate_id
 * @property integer $views
 * @property string $content
 * @property string $keyword
 * @property string $description
 * @property integer $created
 */
class NewsModel extends CActiveRecord {


    public function get_cate() {
        //$model = Yii::app()->db->createCommand()->select('id,name')->from('groupon_area')->order('id desc')->queryAll();
        //return CHtml::listData($model,'id','name');
        $model = NewsCategoryModel::model()->findAll();
        $model = object2array($model);
        $data = GrouponGoodsModel::getArea($model);
        $area_data = array();
        foreach ($data as $k => $v) {
            $area_data[$v['id']] = $v['html'] . $v['name'];
        }
        return $area_data;
        //print_r($area_data);exit;
    }

    

    Static Public function getArea($cate, $pid = 0, $html = '----', $level = 0) {
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

    public function get_boolean_arr($value = "") {
        if ($value === "") {
            return array(
                '1' => '是',
                '0' => '否',
            );
        } else {
            return $value == 1 ? '是' : '否';
        }
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'news';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('description', 'required'),
            array('cate_id, views, created', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 64),
            array('keyword', 'length', 'max' => 128),
            array('content', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, cate_id, views, content, keyword, description, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cate' => array(self::BELONGS_TO,'NewsCategoryModel','cate_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => '标题',
            'cate_id' => '分类',
            'views' => '浏览量',
            'content' => '内容',
            'keyword' => '关键词',
            'description' => '描述',
            'created' => '发布时间',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('cate_id', $this->cate_id);
        $criteria->compare('views', $this->views);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('keyword', $this->keyword, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return NewsModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
