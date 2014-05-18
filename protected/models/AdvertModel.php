<?php

/**
 * This is the model class for table "advert".
 *
 * The followings are the available columns in table 'advert':
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property string $image
 * @property string $content
 * @property integer $position
 * @property integer $status
 * @property integer $created
 */
class AdvertModel extends CActiveRecord
{
        public function getStatus($index = ""){
            $status = array(
                '0' => '隐藏',
                '1' => '显示'
            );
            if($index === ""){
                return $status;
            }else{
                return $status[$index];
            }
        }
        public function getPostion(){
            return array(
                '0' => '首页'
            );
        }
        public function getType($index=""){
            $type = array(
                '0' => '文字广告',
                '1' => '图片广告',
                '2' => 'JS代码广告'
            );
            if($index === ""){
                return $type;
            }else{
                return $type[$index];
            }
        }

        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdvertModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'advert';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('type, position, status, created', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('image,url', 'length', 'max'=>128),
                        array('content','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, type, image, content, position, status,url, created', 'safe', 'on'=>'search'),
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
			'name' => '名称',
			'type' => '类型',
			'image' => '图片',
			'content' => '内容',
			'position' => '位置',
			'url' => '链接',
			'status' => '状态',
			'created' => '创建时间',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('status',$this->status);
		$criteria->compare('created',$this->created);
		$criteria->compare('url',$this->url);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}