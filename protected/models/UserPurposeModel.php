<?php

/**
 * This is the model class for table "user_purpose".
 *
 * The followings are the available columns in table 'user_purpose':
 * @property integer $id
 * @property integer $apply_job_type_id
 * @property integer $user_id
 * @property integer $resume_id
 * @property integer $wish_job_place_id
 * @property integer $wish_treatment_id
 * @property integer $wish_part_time_treatment_id
 * @property string $other_weal
 * @property integer $resume_position_id
 * @property integer $apply_job_status
 * @property string $part_time_type
 * @property integer $created
 */
class UserPurposeModel extends CActiveRecord {

    //其他福利
    public function get_other_weal($index = "") {
        $model = Yii::app()->db->createCommand()->select('id,name')->from('resume_other_weal')->order('id desc')->queryAll();
        $return = CHtml::listData($model, 'id', 'name');
        if ($index === "") {
            return $return;
        } else {
            if (numeric($index) > 0) {
                return $return[$index];
            }else{
                return "";
            }
        }
    }

    //兼职期望类型
    public function get_part_time_type($index = "") {
        $model = Yii::app()->db->createCommand()->select('id,name')->from('resume_part_time_type')->order('id desc')->queryAll();
        $return = CHtml::listData($model, 'id', 'name');
        if ($index === "") {
            return $return;
        } else {
            if (numeric($index) > 0) {
                return $return[$index];
            }else{
                return "";
            }
        }
    }

    public function apply_job_type_arr($index = "") {
        $return = array(
            1 => '兼职',
            2 => '全职',
            3 => '实习',
//            4 => '精英',
        );
        if ($index === "") {
            return $return;
        } else {
            if (numeric($index) > 0) {
                if($index == 4){
                    return '精英';
                }else{
                    return $return[$index];
                }
            }else{
                return "";
            }
        }
    }

    public function apply_job_status_arr($index = "") {
        $return = array(
            1 => '正在求职中',
            2 => '暂不求职'
        );
        if ($index === "") {
            return $return;
        } else {
            if (numeric($index) > 0) {
                return $return[$index];
            }else{
                return "";
            }
        }
    }

    //期待待遇
    public function wish_treatment_arr($index = "") {
        $return = array(
            1 => '1500~2999',
            2 => '3000~4999',
            3 => '5000~7999',
            4 => '8000以上',
        );
        if ($index === "") {
            return $return;
        } else {
            if (numeric($index) > 0) {
                return $return[$index];
            }else{
                return "";
            }
        }
    }

    //期待待遇
    public function wish_part_time_treatment_arr($index = "") {
        $return = array(
            1 => '50~100',
            2 => '101~200',
            3 => '201以上'
        );
        if ($index === "") {
            return $return;
        } else {
            if (numeric($index) > 0) {
                return $return[$index];
            }else{
                return "";
            }
        }
    }

    //获取地区
    public function get_area($index = "") {
        $model = Yii::app()->db->createCommand()->select('id,name')->from('area')->where('upid = 0')->queryAll();
        $return = CHtml::listData($model, 'id', 'name');
        if ($index === "") {
            return $return;
        } else {
            if (numeric($index) > 0) {
                return $return[$index];
            }else{
                return "";
            }
        }
    }

    //获取职位
    public function get_position($index = "") {
        $model = Yii::app()->db->createCommand()->select('id,name')->from('resume_position')->order('id desc')->queryAll();
        $return = CHtml::listData($model, 'id', 'name');
        if ($index === "") {
            return $return;
        } else {
            if (numeric($index) > 0) {
                return $return[$index];
            }else{
                return "";
            }
        }
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_purpose';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('resume_id', 'required'),
            array('apply_job_type_id, user_id, resume_id, wish_job_place_id, wish_treatment_id, wish_part_time_treatment_id, resume_position_id, apply_job_status, created', 'numerical', 'integerOnly' => true),
            array('other_weal, part_time_type', 'length', 'max' => 128),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, apply_job_type_id, user_id, resume_id, wish_job_place_id, wish_treatment_id, wish_part_time_treatment_id, other_weal, resume_position_id, apply_job_status, part_time_type, created', 'safe', 'on' => 'search'),
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
            'apply_job_type_id' => 'Apply Job Type',
            'user_id' => 'User',
            'resume_id' => 'Resume',
            'wish_job_place_id' => 'Wish Job Place',
            'wish_treatment_id' => 'Wish Treatment',
            'wish_part_time_treatment_id' => 'Wish Part Time Treatment',
            'other_weal' => 'Other Weal',
            'resume_position_id' => 'Resume Position',
            'apply_job_status' => 'Apply Job Status',
            'part_time_type' => 'Part Time Type',
            'created' => 'Created',
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
        $criteria->compare('apply_job_type_id', $this->apply_job_type_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('resume_id', $this->resume_id);
        $criteria->compare('wish_job_place_id', $this->wish_job_place_id);
        $criteria->compare('wish_treatment_id', $this->wish_treatment_id);
        $criteria->compare('wish_part_time_treatment_id', $this->wish_part_time_treatment_id);
        $criteria->compare('other_weal', $this->other_weal, true);
        $criteria->compare('resume_position_id', $this->resume_position_id);
        $criteria->compare('apply_job_status', $this->apply_job_status);
        $criteria->compare('part_time_type', $this->part_time_type, true);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserPurposeModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
