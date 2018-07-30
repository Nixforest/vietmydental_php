<?php

/**
 * This is the model class for table "renodcm3_tb_treatment".
 *
 * The followings are the available columns in table 'renodcm3_tb_treatment':
 * @property integer $Treatment_Id
 * @property integer $TreatmentProfiles_ID
 * @property integer $TreatmentPlanDetails_ID
 * @property integer $OrderTicket_ID
 * @property string $TreatmentDate
 * @property integer $TreatmentServiceId
 * @property string $TSCode
 * @property string $TreatmentTooth
 * @property string $Surface
 * @property integer $Do
 * @property string $PatientCode
 * @property integer $Patient_ID
 * @property integer $Broker
 * @property integer $Collaborator
 * @property integer $Marketing
 * @property integer $DentistAdvise
 * @property integer $Dentist
 * @property string $Dentist_Code
 * @property integer $Assistant
 * @property integer $Quantity
 * @property double $UnitPrice1
 * @property integer $UnitId
 * @property double $Rate
 * @property double $Decrease
 * @property integer $DecreaseByPercent
 * @property double $TotalMoney
 * @property double $Payed
 * @property double $Remain
 * @property string $Note
 * @property integer $Status
 * @property double $UnitPrice
 * @property integer $OrderLabo
 * @property double $MaterialCost
 * @property double $LaboCost
 * @property string $EstimatedCompletionTime
 * @property string $EstimateStartTime
 * @property string $CreateDate
 * @property integer $Creater
 * @property string $LastModify
 * @property integer $LastModifier
 * @property string $FinishDate
 * @property integer $IsInHoaDon
 * @property integer $Hidden
 * @property integer $IsDeleted
 * @property string $Description
 * @property integer $PriorityTreatment_ID
 *
 * The followings are the available model relations:
 * @property Renodcm3TbChitietphieuthu[] $renodcm3TbChitietphieuthus
 * @property Renodcm3TbPatient $patient
 * @property Renodcm3TbTreatmentprofiles $treatmentProfiles
 * @property Renodcm3TbTreatmentservice $treatmentService
 */
class Renodcm3TbTreatment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Renodcm3TbTreatment the static model class
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
		return 'renodcm3_tb_treatment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('TreatmentProfiles_ID, TreatmentPlanDetails_ID, OrderTicket_ID, TreatmentServiceId, Do, Patient_ID, Broker, Collaborator, Marketing, DentistAdvise, Dentist, Assistant, Quantity, UnitId, DecreaseByPercent, Status, OrderLabo, Creater, LastModifier, IsInHoaDon, Hidden, IsDeleted, PriorityTreatment_ID', 'numerical', 'integerOnly'=>true),
			array('UnitPrice1, Rate, Decrease, TotalMoney, Payed, Remain, UnitPrice, MaterialCost, LaboCost', 'numerical'),
			array('TSCode, TreatmentTooth, Surface, PatientCode, Dentist_Code', 'length', 'max'=>50),
			array('Note', 'length', 'max'=>2000),
			array('TreatmentDate, EstimatedCompletionTime, EstimateStartTime, CreateDate, LastModify, FinishDate, Description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Treatment_Id, TreatmentProfiles_ID, TreatmentPlanDetails_ID, OrderTicket_ID, TreatmentDate, TreatmentServiceId, TSCode, TreatmentTooth, Surface, Do, PatientCode, Patient_ID, Broker, Collaborator, Marketing, DentistAdvise, Dentist, Dentist_Code, Assistant, Quantity, UnitPrice1, UnitId, Rate, Decrease, DecreaseByPercent, TotalMoney, Payed, Remain, Note, Status, UnitPrice, OrderLabo, MaterialCost, LaboCost, EstimatedCompletionTime, EstimateStartTime, CreateDate, Creater, LastModify, LastModifier, FinishDate, IsInHoaDon, Hidden, IsDeleted, Description, PriorityTreatment_ID', 'safe', 'on'=>'search'),
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
			'renodcm3TbChitietphieuthus' => array(self::HAS_MANY, 'Renodcm3TbChitietphieuthu', 'TreatmentId'),
			'patient' => array(self::BELONGS_TO, 'Renodcm3TbPatient', 'Patient_ID'),
			'treatmentProfiles' => array(self::BELONGS_TO, 'Renodcm3TbTreatmentprofiles', 'TreatmentProfiles_ID'),
			'treatmentService' => array(self::BELONGS_TO, 'Renodcm3TbTreatmentservice', 'TreatmentServiceId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Treatment_Id' => 'Treatment',
			'TreatmentProfiles_ID' => 'Treatment Profiles',
			'TreatmentPlanDetails_ID' => 'Treatment Plan Details',
			'OrderTicket_ID' => 'Order Ticket',
			'TreatmentDate' => 'Treatment Date',
			'TreatmentServiceId' => 'Treatment Service',
			'TSCode' => 'Tscode',
			'TreatmentTooth' => 'Treatment Tooth',
			'Surface' => 'Surface',
			'Do' => 'Do',
			'PatientCode' => 'Patient Code',
			'Patient_ID' => 'Patient',
			'Broker' => 'Broker',
			'Collaborator' => 'Collaborator',
			'Marketing' => 'Marketing',
			'DentistAdvise' => 'Dentist Advise',
			'Dentist' => 'Dentist',
			'Dentist_Code' => 'Dentist Code',
			'Assistant' => 'Assistant',
			'Quantity' => 'Quantity',
			'UnitPrice1' => 'Unit Price1',
			'UnitId' => 'Unit',
			'Rate' => 'Rate',
			'Decrease' => 'Decrease',
			'DecreaseByPercent' => 'Decrease By Percent',
			'TotalMoney' => 'Total Money',
			'Payed' => 'Payed',
			'Remain' => 'Remain',
			'Note' => 'Note',
			'Status' => 'Status',
			'UnitPrice' => 'Unit Price',
			'OrderLabo' => 'Order Labo',
			'MaterialCost' => 'Material Cost',
			'LaboCost' => 'Labo Cost',
			'EstimatedCompletionTime' => 'Estimated Completion Time',
			'EstimateStartTime' => 'Estimate Start Time',
			'CreateDate' => 'Create Date',
			'Creater' => 'Creater',
			'LastModify' => 'Last Modify',
			'LastModifier' => 'Last Modifier',
			'FinishDate' => 'Finish Date',
			'IsInHoaDon' => 'Is In Hoa Don',
			'Hidden' => 'Hidden',
			'IsDeleted' => 'Is Deleted',
			'Description' => 'Description',
			'PriorityTreatment_ID' => 'Priority Treatment',
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

		$criteria->compare('Treatment_Id',$this->Treatment_Id);
		$criteria->compare('TreatmentProfiles_ID',$this->TreatmentProfiles_ID);
		$criteria->compare('TreatmentPlanDetails_ID',$this->TreatmentPlanDetails_ID);
		$criteria->compare('OrderTicket_ID',$this->OrderTicket_ID);
		$criteria->compare('TreatmentDate',$this->TreatmentDate,true);
		$criteria->compare('TreatmentServiceId',$this->TreatmentServiceId);
		$criteria->compare('TSCode',$this->TSCode,true);
		$criteria->compare('TreatmentTooth',$this->TreatmentTooth,true);
		$criteria->compare('Surface',$this->Surface,true);
		$criteria->compare('Do',$this->Do);
		$criteria->compare('PatientCode',$this->PatientCode,true);
		$criteria->compare('Patient_ID',$this->Patient_ID);
		$criteria->compare('Broker',$this->Broker);
		$criteria->compare('Collaborator',$this->Collaborator);
		$criteria->compare('Marketing',$this->Marketing);
		$criteria->compare('DentistAdvise',$this->DentistAdvise);
		$criteria->compare('Dentist',$this->Dentist);
		$criteria->compare('Dentist_Code',$this->Dentist_Code,true);
		$criteria->compare('Assistant',$this->Assistant);
		$criteria->compare('Quantity',$this->Quantity);
		$criteria->compare('UnitPrice1',$this->UnitPrice1);
		$criteria->compare('UnitId',$this->UnitId);
		$criteria->compare('Rate',$this->Rate);
		$criteria->compare('Decrease',$this->Decrease);
		$criteria->compare('DecreaseByPercent',$this->DecreaseByPercent);
		$criteria->compare('TotalMoney',$this->TotalMoney);
		$criteria->compare('Payed',$this->Payed);
		$criteria->compare('Remain',$this->Remain);
		$criteria->compare('Note',$this->Note,true);
		$criteria->compare('Status',$this->Status);
		$criteria->compare('UnitPrice',$this->UnitPrice);
		$criteria->compare('OrderLabo',$this->OrderLabo);
		$criteria->compare('MaterialCost',$this->MaterialCost);
		$criteria->compare('LaboCost',$this->LaboCost);
		$criteria->compare('EstimatedCompletionTime',$this->EstimatedCompletionTime,true);
		$criteria->compare('EstimateStartTime',$this->EstimateStartTime,true);
		$criteria->compare('CreateDate',$this->CreateDate,true);
		$criteria->compare('Creater',$this->Creater);
		$criteria->compare('LastModify',$this->LastModify,true);
		$criteria->compare('LastModifier',$this->LastModifier);
		$criteria->compare('FinishDate',$this->FinishDate,true);
		$criteria->compare('IsInHoaDon',$this->IsInHoaDon);
		$criteria->compare('Hidden',$this->Hidden);
		$criteria->compare('IsDeleted',$this->IsDeleted);
		$criteria->compare('Description',$this->Description,true);
		$criteria->compare('PriorityTreatment_ID',$this->PriorityTreatment_ID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}