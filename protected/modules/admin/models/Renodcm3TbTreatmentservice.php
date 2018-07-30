<?php

/**
 * This is the model class for table "renodcm3_tb_treatmentservice".
 *
 * The followings are the available columns in table 'renodcm3_tb_treatmentservice':
 * @property integer $Id
 * @property string $TSCode
 * @property string $Name
 * @property double $UnitPrice
 * @property integer $UnitId
 * @property integer $GroupServiceId
 * @property integer $OrderLabo
 * @property double $MaterialCost
 * @property double $LaboCost
 * @property integer $IsUse
 * @property integer $OrderServiceNumber
 * @property string $Description
 */
class Renodcm3TbTreatmentservice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Renodcm3TbTreatmentservice the static model class
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
		return 'renodcm3_tb_treatmentservice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('UnitId, GroupServiceId, OrderLabo, IsUse, OrderServiceNumber', 'numerical', 'integerOnly'=>true),
			array('UnitPrice, MaterialCost, LaboCost', 'numerical'),
			array('TSCode', 'length', 'max'=>50),
			array('Name', 'length', 'max'=>500),
			array('Description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, TSCode, Name, UnitPrice, UnitId, GroupServiceId, OrderLabo, MaterialCost, LaboCost, IsUse, OrderServiceNumber, Description', 'safe', 'on'=>'search'),
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
			'Id' => 'ID',
			'TSCode' => 'Tscode',
			'Name' => 'Name',
			'UnitPrice' => 'Unit Price',
			'UnitId' => 'Unit',
			'GroupServiceId' => 'Group Service',
			'OrderLabo' => 'Order Labo',
			'MaterialCost' => 'Material Cost',
			'LaboCost' => 'Labo Cost',
			'IsUse' => 'Is Use',
			'OrderServiceNumber' => 'Order Service Number',
			'Description' => 'Description',
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

		$criteria->compare('Id',$this->Id);
		$criteria->compare('TSCode',$this->TSCode,true);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('UnitPrice',$this->UnitPrice);
		$criteria->compare('UnitId',$this->UnitId);
		$criteria->compare('GroupServiceId',$this->GroupServiceId);
		$criteria->compare('OrderLabo',$this->OrderLabo);
		$criteria->compare('MaterialCost',$this->MaterialCost);
		$criteria->compare('LaboCost',$this->LaboCost);
		$criteria->compare('IsUse',$this->IsUse);
		$criteria->compare('OrderServiceNumber',$this->OrderServiceNumber);
		$criteria->compare('Description',$this->Description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}