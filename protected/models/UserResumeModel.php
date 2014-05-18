<?php

/**
 * This is the model class for table "user_resume".
 *
 * The followings are the available columns in table 'user_resume':
 * @property integer $id
 * @property integer $user_id
 * @property string $username
 * @property integer $gender
 * @property integer $marry_status
 * @property integer $birthday
 * @property integer $age
 * @property integer $grade
 * @property string $height
 * @property string $weight
 * @property string $graduate_school
 * @property integer $graduate_time
 * @property integer $education
 * @property integer $major_first_id
 * @property integer $major_second_id
 * @property integer $eyesight
 * @property string $foreign_lang_first
 * @property string $foreign_lang_second
 * @property integer $computer_level
 * @property string $work_year
 * @property integer $resume_technical_titles_id
 * @property integer $healthy
 * @property integer $account_where_id
 * @property integer $birthplace_id
 * @property string $one_size_photo
 * @property string $phone
 * @property string $qq
 * @property string $zipcode
 * @property string $contact_address
 * @property string $blog
 * @property string $description
 * @property integer $apply_job_type
 * @property integer $wish_job_place_id
 * @property integer $wish_treatment
 * @property string $other_weal
 * @property integer $resume_position_id
 * @property integer $apply_job_status
 * @property string $extracurricular
 * @property integer $created
 */
class UserResumeModel extends CActiveRecord {

    public $wish_treatment_id;
    public $wish_job_place_id;
    public $resume_position_id;
    public $wish_part_time_treatment_id;

    /**
     * @return string the associated database table name
     */
    public $major;
    public $mobile;
    public $technical_titles;

    public function gender_arr($index = "") {
        $return = array(
            1 => '男',
            2 => '女',
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

    public function marry_arr($index = "") {
        $return = array(
            1 => '单身',
            2 => '恋爱',
            3 => '已婚',
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

    public function age_arr($index = "") {
        $return = array(
            1 => '15~20',
            2 => '21~25',
            3 => '25~30',
            4 => '31~40',
            5 => '40岁上',
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

    public function education_arr($index = "") {
        $return = array(
            1 => '本科',
            2 => '硕士',
            3 => '博士',
            4 => '专科',
            5 => '其他',
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

    public function eyesight_arr($index = "") {
        $return = array(
            1 => '极好',
            2 => '很好',
            3 => '一般',
            4 => '很差'
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

    public function political_status_arr($index = "") {
        $return = array(
            1 => '团员',
            2 => '党员',
            3 => '预备党员',
            4 => '群众'
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

    public function computer_level_arr($index = "") {
        $return = array(
            1 => '极好',
            2 => '很好',
            3 => '一般',
            4 => '很差'
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

    public function healthy_arr($index = "") {
        $return = array(
            1 => '极好',
            2 => '很好',
            3 => '一般',
            4 => '很差'
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
                return $return[$index];
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

    //获取专业
    public function get_major($index = "") {
        $model = Yii::app()->db->createCommand()->select('id,name')->from('resume_major')->order('id desc')->queryAll();
        $return = CHtml::listData($model, 'id', 'name');
        if ($index === '') {
            return $return;
        } else {
            return $return[$index];
        }
    }

    //工作年限
    public function work_year_arr($index = "") {
        $return = array(
            1 => '毕业生',
            2 => '1~2年',
            3 => '3~5年',
            4 => '5年以上',
            5 => '在校生',
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

    //技术职称
    public function get_technical_titles($index = '') {
        $model = Yii::app()->db->createCommand()->select('id,name')->from('resume_technical_titles')->order('id desc')->queryAll();
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

    //技能特长
    public function get_speciality($index = "") {
        $model = Yii::app()->db->createCommand()->select('id,name')->from('resume_speciality')->order('id desc')->queryAll();
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

    //期待待遇
    public function wish_treatment_arr($index = "") {
        $return = array(
            1 => '2000~3999',
            2 => '4000~5999',
            3 => '6000~9999',
            4 => '10000以上',
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

    //年级
    public function get_grade_arr($index = "") {
        $return = array(
            1 => '大一',
            2 => '大二',
            3 => '大三',
            4 => '大四',
            5 => '在校生',
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

    //
    public function get_status($index = "") {
        $return = array(
            0 => '未审核',
            1 => '审核通过',
            2 => '审核不通过'
        );
        if ($index === "") {
            return $return;
        } else {
            return $return[$index];
        }
    }

    public function is_elite_arr($index = "") {
        $return = array(
            0 => '否',
            1 => '是',
        );
        if ($index === "") {
            return $return;
        } else {
            return $return[$index];
        }
    }

    public function tableName() {
        return 'user_resume';
    }

    //根据搜索的KEY获取搜索的值
    public function get_search_text($key, $val) {
        $return = '';
        switch ($key) {
            case 'technical_titles' : $return = $this->get_technical_titles($val);
                break;
            case 'major' : $return = $this->get_major($val);
                break;
            case 'education' : $return = $this->education_arr($val);
                break;
            case 'grade' : $return = $this->get_grade_arr($val);
                break;
            case 'resume_speciality_id' : $return = $this->get_speciality($val);
                break;
            case 'work_year' : $return = $this->work_year_arr($val);
                break;
            case 'wish_treatment_id' : $return = $this->wish_treatment_arr($val);
                break;
            case 'wish_part_time_treatment_id' : $return = UserPurposeModel::model()->wish_part_time_treatment_arr($val);
                break;
            case 'wish_job_place_id' : $return = $this->get_area($val);
                break;
            case 'resume_position_id' : $return = $this->get_position($val);
                break;
            case 'gender' : $return = $this->gender_arr($val);
                break;
            case 'age' : $return = $this->age_arr($val);
                break;
            case 'birthplace_id' : $return = $this->get_area($val);
                break;
        }
        return $return;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, gender, marry_status, birthday, age,political_status, grade, graduate_time, education,major, major_first_id, major_second_id, eyesight, computer_level, resume_technical_titles_id,resume_technical_titles_second_id, healthy, account_where_id, resume_speciality_id, work_year,birthplace_id, apply_job_type, status, is_elite,updated,created', 'numerical', 'integerOnly' => true),
            array('username', 'length', 'max' => 64),
            array('height, weight, foreign_lang_first, foreign_lang_second, phone, qq, zipcode', 'length', 'max' => 16),
            array('graduate_school, one_size_photo, contact_address, blog', 'length', 'max' => 128),
            array('description, extracurricular,mobile,technical_titles', 'safe'),
            array('wish_treatment_id,wish_part_time_treatment_id,wish_job_place_id,resume_position_id', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, username, gender, marry_status, birthday, age, grade, major,height, weight, graduate_school, graduate_time, education, major_first_id, major_second_id, eyesight, resume_speciality_id, foreign_lang_first, foreign_lang_second, computer_level, work_year, resume_technical_titles_id, healthy, account_where_id, birthplace_id, one_size_photo, phone, qq, zipcode, contact_address, blog, description, apply_job_type,status,is_elite, extracurricular,updated, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'major_first' => array(self::BELONGS_TO, 'ResumeMajorModel', 'major_first_id,'),
            'major_second' => array(self::BELONGS_TO, 'ResumeMajorModel', 'major_second_id'),
            'technical_titles_first' => array(self::BELONGS_TO, 'ResumeTechnicalTitlesModel', 'resume_technical_titles_id'),
            'technical_titles_second' => array(self::BELONGS_TO, 'ResumeTechnicalTitlesModel', 'resume_technical_titles_second_id'),
            'account_where' => array(self::BELONGS_TO, 'AreaModel', 'account_where_id'),
            'birthplace' => array(self::BELONGS_TO, 'AreaModel', 'birthplace_id'),
            'user' => array(self::BELONGS_TO, 'UserModel', 'user_id', 'select' => 'id,mobile,email'),
            'resume_speciality' => array(self::BELONGS_TO, 'ResumeSpecialityModel', 'resume_speciality_id', 'select' => 'id,name'),
                //'resume_position' => array(self::BELONGS_TO, 'ResumePositionModel', 'resume_position_id'),
        );
    }

//    public $wish_treatment_id;
//    public $wish_job_place_id;
//    public $resume_position_id;
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'username' => 'Username',
            'gender' => '性别',
            'marry_status' => 'Marry Status',
            'birthday' => 'Birthday',
            'age' => '年龄',
            'grade' => '年级',
            'height' => '身高',
            'weight' => '体重',
            'graduate_school' => '毕业院校',
            'graduate_time' => '毕业时间',
            'education' => '学历',
            'major_first_id' => 'Major First',
            'major_second_id' => 'Major Second',
            'eyesight' => 'Eyesight',
            'foreign_lang_first' => 'Foreign Lang First',
            'foreign_lang_second' => 'Foreign Lang Second',
            'computer_level' => 'Computer Level',
            'work_year' => '工作经验',
            'resume_technical_titles_id' => '技术职称',
            'resume_technical_titles_second_id' => '技术职称',
            'technical_titles' => '技术职称',
            'healthy' => 'Healthy',
            'account_where_id' => 'Account Where',
            'birthplace_id' => '籍贯',
            'one_size_photo' => 'One Size Photo',
            'phone' => 'Phone',
            'qq' => 'Qq',
            'zipcode' => 'Zipcode',
            'contact_address' => 'Contact Address',
            'blog' => 'Blog',
            'description' => 'Description',
            'apply_job_type' => 'Apply Job Type',
            'status' => '简历状态',
            'is_elite' => '是否精英',
            'political_status' => '政治面貌',
            'extracurricular' => 'Extracurricular',
            'updated' => 'updated',
            'created' => 'Created',
            'major' => '专业',
            'resume_speciality_id' => '技能特长',
            'wish_treatment_id' => '期待待遇',
            'wish_part_time_treatment_id' => '期待待遇',
            'wish_job_place_id' => '工作地点',
            'resume_position_id' => '期望职位'
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('gender', $this->gender);
        $criteria->compare('marry_status', $this->marry_status);
        $criteria->compare('birthday', $this->birthday);
        $criteria->compare('age', $this->age);
        $criteria->compare('grade', $this->grade);
        $criteria->compare('height', $this->height, true);
        $criteria->compare('weight', $this->weight, true);
        $criteria->compare('graduate_school', $this->graduate_school, true);
        $criteria->compare('graduate_time', $this->graduate_time);
        $criteria->compare('education', $this->education);
        $criteria->compare('major_first_id', $this->major_first_id);
        $criteria->compare('major_second_id', $this->major_second_id);
        $criteria->compare('eyesight', $this->eyesight);
        $criteria->compare('foreign_lang_first', $this->foreign_lang_first, true);
        $criteria->compare('foreign_lang_second', $this->foreign_lang_second, true);
        $criteria->compare('computer_level', $this->computer_level);
        $criteria->compare('work_year', $this->work_year, true);
        $criteria->compare('resume_technical_titles_id', $this->resume_technical_titles_id);
        $criteria->compare('healthy', $this->healthy);
        $criteria->compare('account_where_id', $this->account_where_id);
        $criteria->compare('birthplace_id', $this->birthplace_id);
        $criteria->compare('one_size_photo', $this->one_size_photo, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('qq', $this->qq, true);
        $criteria->compare('zipcode', $this->zipcode, true);
        $criteria->compare('contact_address', $this->contact_address, true);
        $criteria->compare('blog', $this->blog, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('apply_job_type', $this->apply_job_type);

        $criteria->compare('status', $this->status);
        $criteria->compare('is_elite', $this->is_elite);
        $criteria->compare('extracurricular', $this->extracurricular, true);
        $criteria->compare('updated', $this->updated);
        $criteria->compare('created', $this->created);
        $criteria->compare('major', $this->major);
        $criteria->compare('resume_speciality_id', $this->resume_speciality_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserResumeModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
