<?php

/**
 * This is the model class for table "user_company".
 *
 * The followings are the available columns in table 'user_company':
 * @property integer $id
 * @property integer $user_id
 * @property string $real_name
 * @property string $company_name
 * @property string $position
 * @property string $company_address
 * @property string $trading_certificate
 * @property integer $created
 */
class UserCompanyModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, created', 'numerical', 'integerOnly'=>true),
			array('real_name', 'length', 'max'=>32),
			array('company_name, position, company_address, trading_certificate', 'length', 'max'=>128),
                        array('verifyCode', 'captcha', 'on' => 'register_enterprise'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, real_name, company_name, position, company_address, trading_certificate, created', 'safe', 'on'=>'search'),
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
			'real_name' => 'Real Name',
			'company_name' => 'Company Name',
			'position' => 'Position',
			'company_address' => 'Company Address',
			'trading_certificate' => 'Trading Certificate',
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
		$criteria->compare('real_name',$this->real_name,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('company_address',$this->company_address,true);
		$criteria->compare('trading_certificate',$this->trading_certificate,true);
		$criteria->compare('created',$this->created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserCompanyModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
