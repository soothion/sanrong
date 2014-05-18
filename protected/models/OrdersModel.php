<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $id
 * @property string $order_sn
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_email
 * @property integer $order_status
 * @property integer $status1_time
 * @property integer $status2_time
 * @property integer $status3_time
 * @property integer $status4_time
 * @property string $out_trade_sn
 * @property string $total_price
 * @property string $return_pwd
 * @property integer $created
 */
class OrdersModel extends CActiveRecord {

    //获取支付方式名称
    public function get_order_type($index = '') {
        $return = array(
            0 => '',
            1 => '支付宝',
            2 => '财富通',
            3 => '网银',
            4 => '当面付',
        );
        if ($index === '') {
            return $return;
        } else {
            return $return[$index];
        }
    }

    public function get_order_status($index = '') {
        $return = array(
            0 => '待付款',
            1 => '待评价',
            2 => '交易成功',
            3 => '失效订单',
        );
        if ($index === '') {
            return $return;
        } else {
            return $return[$index];
        }
    }

    //改变订单状态
    public function change_order_status($id, $order_status) {
        $id = numeric($id);
        $order_status = numeric($order_status);
        $model = OrdersModel::model()->with('goods')->findByPk($id);
        if (!$model) {
            return false;
        } else {
            $isSaled = $model->order_status == 1 || $model->order_status == 2; //是否已经交易成功
            $model->order_status = $order_status;
            $model->status_time = time();
            switch (numeric($order_status)) {
                case 0:
                    $model->status1_time = 0;
                    $model->status2_time = 0;
                    $model->status3_time = 0;
                    break;
                case 1:
                    $model->status1_time = time();
                    $model->status2_time = 0;
                    $model->status3_time = 0;
                    break;
                case 2:
                    $model->status2_time = time();
                    $model->status3_time = 0;
                    break;
                case 3:
                    $model->status3_time = time();
                    break;
            }
            $model->status_time = time();
            if ($model->save()) {
                $goodsModel = GrouponGoodsModel::model()->findByPk($model->goods->goods_id);
                if ($isSaled) {
                    if ($order_status == 0 || $order_status == 3) {

                        $goodsModel->salenum = $goodsModel->salenum - 1;
                        $goodsModel->save();
                        return true;
                    }
                } else {
                    if ($order_status == 1 || $order_status == 2) {
                        $goodsModel->salenum = $goodsModel->salenum + 1;
                        $goodsModel->save();
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'orders';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, order_status, status_time,status1_time,status2_time,status3_time, created', 'numerical', 'integerOnly' => true),
            array('order_sn, out_trade_sn, return_pwd,address', 'length', 'max' => 128),
            array('user_name, user_email,address_name', 'length', 'max' => 64),
            array('total_price', 'length', 'max' => 10),
            array('user_mobile', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, order_sn, user_id, user_name,address,address_name, user_email,user_mobile, order_status, status_time, status1_time,status2_time,status3_time,out_trade_sn, total_price, return_pwd, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'goods' => array(self::HAS_ONE, 'OrderGoodsModel', 'order_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'order_sn' => '订单号',
            'user_id' => '用户id',
            'user_name' => '用户名',
            'user_email' => '邮箱',
            'user_mobile' => '手机',
            'order_type' => '支付类型',
            'order_status' => '订单状态',
            'status_time' => '更新时间',
            'status1_time' => '付款时间',
            'status2_time' => '完成时间',
            'status3_time' => '取消时间',
            'out_trade_sn' => '外部订单号',
            'total_price' => '总价',
            'address_name' => '收货人',
            'address' => '收货地址',
            'return_pwd' => 'Return Pwd',
            'created' => '下单时间',
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
        $criteria->compare('order_sn', $this->order_sn, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('user_name', $this->user_name, true);
        $criteria->compare('user_email', $this->user_email, true);
        $criteria->compare('order_status', $this->order_status);
        $criteria->compare('status_time', $this->status_time);
        $criteria->compare('out_trade_sn', $this->out_trade_sn, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('return_pwd', $this->return_pwd, true);
        $criteria->compare('created', $this->created);
        $criteria->compare('address', $this->address);
        $criteria->compare('address_name', $this->address_name);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OrdersModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
