<?php

/**
 * This is the model class for table "renodcm3_tb_treatmentprofiles".
 *
 * The followings are the available columns in table 'renodcm3_tb_treatmentprofiles':
 * @property integer $TreatmentProfiles_ID
 * @property integer $Patient_ID
 * @property string $PatientCode
 * @property string $Reason
 * @property integer $Broker
 * @property integer $Collaborator
 * @property integer $Marketing
 * @property integer $Doctor_ID
 * @property string $Diagnosis
 * @property string $Description
 * @property string $DateOfProfiles
 * @property string $EndDateOfProfiles
 * @property integer $Unit_ID
 * @property integer $DecreaseByPercent
 * @property double $Decrease
 * @property double $TotalCost
 * @property double $Payment
 * @property double $Debt
 * @property integer $TreatmentStatus_ID
 * @property integer $Creater
 * @property integer $Modifier
 * @property string $DateOfChange
 * @property integer $IsLock
 * @property integer $IsDeleted
 * @property integer $Hidden
 *
 * The followings are the available model relations:
 * @property Renodcm3TbTreatmentdetails[] $renodcm3TbTreatmentdetails
 */
class Renodcm3TbTreatmentprofiles extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Renodcm3TbTreatmentprofiles the static model class
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
		return 'renodcm3_tb_treatmentprofiles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Patient_ID, Broker, Collaborator, Marketing, Doctor_ID, Unit_ID, DecreaseByPercent, TreatmentStatus_ID, Creater, Modifier, IsLock, IsDeleted, Hidden', 'numerical', 'integerOnly'=>true),
			array('Decrease, TotalCost, Payment, Debt', 'numerical'),
			array('PatientCode', 'length', 'max'=>50),
			array('Reason, Diagnosis', 'length', 'max'=>250),
			array('Description, DateOfProfiles, EndDateOfProfiles, DateOfChange', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('TreatmentProfiles_ID, Patient_ID, PatientCode, Reason, Broker, Collaborator, Marketing, Doctor_ID, Diagnosis, Description, DateOfProfiles, EndDateOfProfiles, Unit_ID, DecreaseByPercent, Decrease, TotalCost, Payment, Debt, TreatmentStatus_ID, Creater, Modifier, DateOfChange, IsLock, IsDeleted, Hidden', 'safe', 'on'=>'search'),
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
			'renodcm3TbTreatmentdetails' => array(self::HAS_MANY, 'Renodcm3TbTreatmentdetails', 'TreatmentProfiles_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'TreatmentProfiles_ID' => 'Treatment Profiles',
			'Patient_ID' => 'Patient',
			'PatientCode' => 'Patient Code',
			'Reason' => 'Reason',
			'Broker' => 'Broker',
			'Collaborator' => 'Collaborator',
			'Marketing' => 'Marketing',
			'Doctor_ID' => 'Doctor',
			'Diagnosis' => 'Diagnosis',
			'Description' => 'Description',
			'DateOfProfiles' => 'Date Of Profiles',
			'EndDateOfProfiles' => 'End Date Of Profiles',
			'Unit_ID' => 'Unit',
			'DecreaseByPercent' => 'Decrease By Percent',
			'Decrease' => 'Decrease',
			'TotalCost' => 'Total Cost',
			'Payment' => 'Payment',
			'Debt' => 'Debt',
			'TreatmentStatus_ID' => 'Treatment Status',
			'Creater' => 'Creater',
			'Modifier' => 'Modifier',
			'DateOfChange' => 'Date Of Change',
			'IsLock' => 'Is Lock',
			'IsDeleted' => 'Is Deleted',
			'Hidden' => 'Hidden',
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

		$criteria->compare('TreatmentProfiles_ID',$this->TreatmentProfiles_ID);
		$criteria->compare('Patient_ID',$this->Patient_ID);
		$criteria->compare('PatientCode',$this->PatientCode,true);
		$criteria->compare('Reason',$this->Reason,true);
		$criteria->compare('Broker',$this->Broker);
		$criteria->compare('Collaborator',$this->Collaborator);
		$criteria->compare('Marketing',$this->Marketing);
		$criteria->compare('Doctor_ID',$this->Doctor_ID);
		$criteria->compare('Diagnosis',$this->Diagnosis,true);
		$criteria->compare('Description',$this->Description,true);
		$criteria->compare('DateOfProfiles',$this->DateOfProfiles,true);
		$criteria->compare('EndDateOfProfiles',$this->EndDateOfProfiles,true);
		$criteria->compare('Unit_ID',$this->Unit_ID);
		$criteria->compare('DecreaseByPercent',$this->DecreaseByPercent);
		$criteria->compare('Decrease',$this->Decrease);
		$criteria->compare('TotalCost',$this->TotalCost);
		$criteria->compare('Payment',$this->Payment);
		$criteria->compare('Debt',$this->Debt);
		$criteria->compare('TreatmentStatus_ID',$this->TreatmentStatus_ID);
		$criteria->compare('Creater',$this->Creater);
		$criteria->compare('Modifier',$this->Modifier);
		$criteria->compare('DateOfChange',$this->DateOfChange,true);
		$criteria->compare('IsLock',$this->IsLock);
		$criteria->compare('IsDeleted',$this->IsDeleted);
		$criteria->compare('Hidden',$this->Hidden);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}