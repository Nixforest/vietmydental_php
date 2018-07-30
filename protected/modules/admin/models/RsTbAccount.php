<?php

/**
 * This is the model class for table "rs_tb_account".
 *
 * The followings are the available columns in table 'rs_tb_account':
 * @property integer $ID
 * @property integer $StaffID
 * @property string $Name
 * @property string $Username
 * @property string $Password
 * @property integer $Status
 * @property integer $GroupID
 * @property integer $IsSys
 */
class RsTbAccount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RsTbAccount the static model class
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
		return 'rs_tb_account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('StaffID, Status, GroupID, IsSys', 'numerical', 'integerOnly'=>true),
			array('Name, Username', 'length', 'max'=>25),
			array('Password', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, StaffID, Name, Username, Password, Status, GroupID, IsSys', 'safe', 'on'=>'search'),
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
			'ID' => 'ID',
			'StaffID' => 'Staff',
			'Name' => 'Name',
			'Username' => 'Username',
			'Password' => 'Password',
			'Status' => 'Status',
			'GroupID' => 'Group',
			'IsSys' => 'Is Sys',
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

		$criteria->compare('ID',$this->ID);
		$criteria->compare('StaffID',$this->StaffID);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Username',$this->Username,true);
		$criteria->compare('Password',$this->Password,true);
		$criteria->compare('Status',$this->Status);
		$criteria->compare('GroupID',$this->GroupID);
		$criteria->compare('IsSys',$this->IsSys);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}