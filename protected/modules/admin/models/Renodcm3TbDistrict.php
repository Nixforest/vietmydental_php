<?php

/**
 * This is the model class for table "renodcm3_tb_district".
 *
 * The followings are the available columns in table 'renodcm3_tb_district':
 * @property integer $Id
 * @property string $Name
 * @property string $Code
 * @property integer $ProvinceId
 */
class Renodcm3TbDistrict extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Renodcm3TbDistrict the static model class
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
		return 'renodcm3_tb_district';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ProvinceId', 'numerical', 'integerOnly'=>true),
			array('Name', 'length', 'max'=>255),
			array('Code', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Name, Code, ProvinceId', 'safe', 'on'=>'search'),
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
			'Name' => 'Name',
			'Code' => 'Code',
			'ProvinceId' => 'Province',
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
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Code',$this->Code,true);
		$criteria->compare('ProvinceId',$this->ProvinceId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}