<?php

/**
 * This is the model class for table "labo_services".
 *
 * The followings are the available columns in table 'labo_services':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property double $price
 * @property string $type_id
 * @property string $producer_id
 * @property string $time
 * @property integer $status
 * @property string $created_date
 * @property string $created_by
 */
class LaboProducers extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaboProducers the static model class
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
		return 'labo_services';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, price, time, status, created_date', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('name, description', 'length', 'max'=>255),
			array('type_id, producer_id, time, created_by', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, price, type_id, producer_id, time, status, created_date, created_by', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'description' => 'Description',
			'price' => 'Price',
			'type_id' => 'Type',
			'producer_id' => 'Producer',
			'time' => 'Time',
			'status' => 'Status',
			'created_date' => 'Created Date',
			'created_by' => 'Created By',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('type_id',$this->type_id,true);
		$criteria->compare('producer_id',$this->producer_id,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}