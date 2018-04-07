<?php

/**
 * This is the model class for table "loggers".
 *
 * The followings are the available columns in table 'loggers':
 * @property string $id
 * @property string $ip_address
 * @property string $country
 * @property string $message
 * @property string $created_date
 * @property string $description
 * @property string $level
 * @property integer $logtime
 * @property string $category
 */
class Loggers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Loggers the static model class
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
		return 'loggers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('logtime', 'numerical', 'integerOnly'=>true),
			array('ip_address', 'length', 'max'=>50),
			array('country', 'length', 'max'=>100),
			array('description', 'length', 'max'=>250),
			array('level, category', 'length', 'max'=>128),
			array('message, created_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ip_address, country, message, created_date, description, level, logtime, category', 'safe', 'on'=>'search'),
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
			'ip_address' => 'Ip Address',
			'country' => 'Country',
			'message' => 'Message',
			'created_date' => 'Created Date',
			'description' => 'Description',
			'level' => 'Level',
			'logtime' => 'Logtime',
			'category' => 'Category',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('logtime',$this->logtime);
		$criteria->compare('category',$this->category,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => Settings::getListPageSize(),
                        ),
		));
	}
}