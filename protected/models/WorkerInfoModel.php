<?php

/**
 * This is the model class for table "worker_info".
 *
 * The followings are the available columns in table 'worker_info':
 * @property integer $id
 * @property integer $worker_id
 * @property integer $admin_id
 * @property string $content
 * @property integer $updated
 * @property integer $created
 */
class WorkerInfoModel extends CActiveRecord {

    public function getStatus($index = "", $unset = null) {
        $arr = array(
            '0' => '正常',
            '1' => '申诉中，等待回复',
            '2' => '申诉中，已回复',
            '3' => '申诉成功',
            '4' => '申诉失败',
        );
        if ($index === "") {
            if ($unset) {
                foreach ($unset as $v) {
                    unset($arr[$v]);
                }
                return $arr;
            } else {
                return $arr;
            }
        } else {
            return $arr[$index];
        }
    }

    //改变申诉状态
    public function updateStatus($id, $status) {
        $model = $this->findByPk($id);
        $model->status = $status;
        return $model->save();
    }

    //递归取得申诉以及回复
    Static Public function getInfo($info, $pid = 0, $html = '&nbsp;&nbsp;&nbsp;&nbsp;', $level = 0) {
        $arr = array();
        foreach ($info as $v) {
            if ($v['pid'] == $pid) {
                $v['html'] = str_repeat($html, $level);
                $v['level'] = $level + 1;
                $arr[] = $v;
                $arr = array_merge($arr, self::getInfo($info, $v['id'], $html, $level + 1));
            }
        }
        return $arr;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'worker_info';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('worker_id, admin_id, updated,status,operated, created', 'numerical', 'integerOnly' => true),
            array('content', 'length', 'max' => 512),
            array('score', 'length', 'max' => 32),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, worker_id, admin_id, content,score, updated,operated, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'worker' => array(self::BELONGS_TO, 'WorkerModel', 'worker_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'worker_id' => '业务员编号',
            'admin_id' => '管理员',
            'content' => '工作记录',
            'updated' => '更新时间',
            'operated' => '操作时间',
            'score' => '积分',
            'status' => '申诉状态',
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
        $criteria->compare('worker_id', $this->worker_id);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('updated', $this->updated);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return WorkerInfoModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
