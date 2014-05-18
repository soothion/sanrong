<?php

/**
 * This is the model class for table "groupon_goods".
 *
 * The followings are the available columns in table 'groupon_goods':
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property integer $seller_id
 * @property integer $area_id
 * @property integer $cate_id
 * @property integer $s_time
 * @property integer $e_time
 * @property integer $is_recommend
 * @property integer $is_top
 * @property integer $status
 * @property string $image
 * @property string $m_price
 * @property string $g_price
 * @property integer $views
 * @property string $content
 * @property string $tip
 * @property string $feature
 * @property integer $admin_id
 * @property string $relation_goods_id
 */
class GrouponGoodsModel extends CActiveRecord {

    public function get_seller() {
        $model = Yii::app()->db->createCommand()->select('id,name')->from('groupon_seller')->order('id desc')->queryAll();
        return CHtml::listData($model, 'id', 'name');
    }

    public function get_area() {
        //$model = Yii::app()->db->createCommand()->select('id,name')->from('groupon_area')->order('id desc')->queryAll();
        //return CHtml::listData($model,'id','name');
        $model = GrouponAreaModel::model()->findAll();
        $model = object2array($model);
        $data = GrouponGoodsModel::getArea($model);
        $area_data = array();
        foreach ($data as $k => $v) {
            $area_data[$v['id']] = $v['html'] . $v['name'];
        }
        return $area_data;
        //print_r($area_data);exit;
    }

    public function get_cate() {
        //$model = Yii::app()->db->createCommand()->select('id,name')->from('groupon_area')->order('id desc')->queryAll();
        //return CHtml::listData($model,'id','name');
        $model = GrouponCategoryModel::model()->findAll();
        $model = object2array($model);
        $data = GrouponGoodsModel::getArea($model);
        $area_data = array();
        foreach ($data as $k => $v) {
            $area_data[$v['id']] = $v['html'] . $v['name'];
        }
        return $area_data;
        //print_r($area_data);exit;
    }
    public function get_subject() {
        //$model = Yii::app()->db->createCommand()->select('id,name')->from('groupon_area')->order('id desc')->queryAll();
        //return CHtml::listData($model,'id','name');
        $model = GrouponSubjectModel::model()->findAll();
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
    
    public function get_status($value = "") {
        $data = array(
            '0' => '未审核',
            '1' => '已通过',
            '2' => '未通过',
            '3' => '已下架',
        );
        if ($value === "") {
            return $data;
        } else {
            return $data[$value];
        }
    }
    //获取销量
    public function get_salenum($id){
        $model = $this->findByPk($id);
        return numeric($model->salenum) + numeric($model->virtual_salenum);
    }
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'groupon_goods';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title,summary,area, s_time, e_time',  'required'),
            array('seller_id, cate_id,subject_id,  is_recommend,salenum, is_top, status, views,virtual_salenum, admin_id', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 64),
            array('summary,  feature', 'length', 'max' => 256),
            array('image', 'length', 'max' => 128),
            array('m_price, g_price,discount', 'length', 'max' => 10),
            array('content,tip,s_time,e_time,area,relation_goods_id', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title,area, summary, seller_id, area_id, cate_id, s_time, e_time,discount, salenum,is_recommend, is_top, status, image, m_price, g_price, views, content, tip, feature, admin_id, relation_goods_id,virtual_salenum,created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'subject'=>array(self::BELONGS_TO,'GrouponSubjectModel','subject_id'),
            'seller'=>array(self::BELONGS_TO,'GrouponSellerModel','seller_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => '标题',
            'summary' => '摘要',
            'seller_id' => '商家',
            'area' => '区域',
            'cate_id' => '类型',
            'subject_id' => '专题',
            's_time' => '开始时间',
            'e_time' => '结束时间',
            'is_recommend' => '是否推荐',
            'is_top' => '是否置顶',
            'status' => '状态',
            'image' => '图片',
            'm_price' => '门店价',
            'g_price' => '团购价',
            'views' => '浏览量',
            'content' => '内容',
            'tip' => '温馨提示',
            'salenum' => '销量',
            'virtual_salenum' => '虚拟销量',
            'discount' => '折扣',
            'feature' => '特色亮点',
            'admin_id' => '团购添加者',
            'created' => '发布时间'
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
        $criteria->compare('summary', $this->summary, true);
        $criteria->compare('seller_id', $this->seller_id);
        $criteria->compare('area_id', $this->area_id);
        $criteria->compare('cate_id', $this->cate_id);
        $criteria->compare('s_time', $this->s_time);
        $criteria->compare('e_time', $this->e_time);
        $criteria->compare('is_recommend', $this->is_recommend);
        $criteria->compare('is_top', $this->is_top);
        $criteria->compare('status', $this->status);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('m_price', $this->m_price, true);
        $criteria->compare('g_price', $this->g_price, true);
        $criteria->compare('views', $this->views);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('tip', $this->tip, true);
        $criteria->compare('feature', $this->feature, true);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('relation_goods_id', $this->relation_goods_id, true);
        $criteria->compare('discount', $this->discount, true);
        $criteria->compare('salenum', $this->salenum, true);
        $criteria->compare('virtual_salenum', $this->virtual_salenum, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GrouponGoodsModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
