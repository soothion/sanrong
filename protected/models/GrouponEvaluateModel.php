<?php

/**
 * This is the model class for table "groupon_evaluate".
 *
 * The followings are the available columns in table 'groupon_evaluate':
 * @property integer $id
 * @property integer $goods_id
 * @property integer $order_id
 * @property integer $pid
 * @property string $content
 * @property integer $created
 */
class GrouponEvaluateModel extends CActiveRecord {

    public function get_pages($count, $page = 1) {
        $url = "<a href='javascript:;' id='first'>首页</a><a href='javascript:;' id='prev'>上一页</a>";
        if ($count <= 5) {
            for ($i = 1; $i <= $count; $i++) {
                if ($page == $i) {
                    $url .= "<a class='page_cur' id='page_" . $i . "' herf='javascript:;'>" . $i . "</a>";
                } else {
                    $url .= "<a id='page_" . $i . "' herf='javascript:;'>" . $i . "</a>";
                }
            }
        } else {
            if ($page <= 5) {
                for ($i = 1; $i <= 5; $i++) {
                    if ($page == $i) {
                        $url .= "<a class='page_cur' id='page_" . $i . "' herf='javascript:;'>" . $i . "</a>";
                    } else {
                        $url .= "<a id='page_" . $i . "' herf='javascript:;'>" . $i . "</a>";
                    }
                }
            } else {
                for ($i = numeric($page)-2; $i <= numeric($page)+2; $i++) {
                    if ($page == $i) {
                        $url .= "<a class='page_cur' id='page_" . $i . "' herf='javascript:;'>" . $i . "</a>";
                    } else {
                        $url .= "<a id='page_" . $i . "' herf='javascript:;'>" . $i . "</a>";
                    }
                }
            }
        }
        $url .= "<a href='javascript:;' id='next'>下一页</a><a href='javascript:;' id='last'>尾页</a>";
        return $url;
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return GrouponEvaluateModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'groupon_evaluate';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('content', 'required'),
            array('user_id,order_goods_id,goods_id, order_id, pid, stars,created', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, goods_id, order_id, pid, content,stars, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'order_goods' => array(self::BELONGS_TO, 'OrderGoodsModel', 'order_goods_id'),
            'orders' => array(self::BELONGS_TO, 'OrdersModel', 'order_id'),
           // 'user'=>array(self::BELONGS_TO,'UserModel','user_id'),
            //'goods'=>array(self::BELONGS_TO,'GrouponGoodsModel','goods_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'user_id',
            'goods_id' => '商品ID',
            'order_goods_id' => 'order_goods_id',
            'order_id' => 'Order',
            'pid' => 'Pid',
            'content' => '评论内容',
            'stars' => '满意度',
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('goods_id', $this->goods_id);
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('order_goods_id', $this->order_goods_id);
        $criteria->compare('pid', $this->pid);
        $criteria->compare('stars', $this->stars);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
