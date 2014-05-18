<?php

/**
 * This is the model class for table "user_education".
 *
 * The followings are the available columns in table 'user_education':
 * @property integer $id
 * @property integer $user_id
 * @property integer $resume_id
 * @property integer $from_time
 * @property integer $to_time
 * @property string $school
 * @property string $major
 * @property string $gain
 * @property integer $created
 */
class UserEducationModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_education';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, resume_id, from_time, to_time, created', 'numerical', 'integerOnly'=>true),
			array('school, major', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, resume_id, from_time, to_time, school, major, gain, created', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'resume_id' => 'Resume',
			'from_time' => 'From Time',
			'to_time' => 'To Time',
			'school' => 'School',
			'major' => 'Major',
			'gain' => 'Gain',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('resume_id',$this->resume_id);
		$criteria->compare('from_time',$this->from_time);
		$criteria->compare('to_time',$this->to_time);
		$criteria->compare('school',$this->school,true);
		$criteria->compare('major',$this->major,true);
		$criteria->compare('gain',$this->gain,true);
		$criteria->compare('created',$this->created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserEducationModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
