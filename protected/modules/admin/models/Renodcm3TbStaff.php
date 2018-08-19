<?php

/**
 * This is the model class for table "renodcm3_tb_staff".
 *
 * The followings are the available columns in table 'renodcm3_tb_staff':
 * @property integer $Id
 * @property string $Code
 * @property string $LastName
 * @property string $FirstName
 * @property integer $PositionId
 * @property double $Salary
 * @property double $BHXH
 * @property double $BHYT
 * @property double $CongDoan
 * @property integer $TreatmentService
 * @property integer $Work
 * @property double $Salary_Time
 * @property double $Bonus
 * @property double $Other
 * @property integer $isAbsence
 * @property integer $TruPhiLabo
 * @property integer $TruPhiVatLieu
 * @property integer $TruPhiMarketing
 * @property string $PayrollFormula_ID
 *
 * The followings are the available model relations:
 * @property Renodcm3TbTreatment[] $renodcm3TbTreatments
 */
class Renodcm3TbStaff extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Renodcm3TbStaff the static model class
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
		return 'renodcm3_tb_staff';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Code', 'required'),
			array('PositionId, TreatmentService, Work, isAbsence, TruPhiLabo, TruPhiVatLieu, TruPhiMarketing', 'numerical', 'integerOnly'=>true),
			array('Salary, BHXH, BHYT, CongDoan, Salary_Time, Bonus, Other', 'numerical'),
			array('Code', 'length', 'max'=>50),
			array('LastName, FirstName', 'length', 'max'=>250),
			array('PayrollFormula_ID', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Code, LastName, FirstName, PositionId, Salary, BHXH, BHYT, CongDoan, TreatmentService, Work, Salary_Time, Bonus, Other, isAbsence, TruPhiLabo, TruPhiVatLieu, TruPhiMarketing, PayrollFormula_ID', 'safe', 'on'=>'search'),
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
			'renodcm3TbTreatments' => array(self::HAS_MANY, 'Renodcm3TbTreatment', 'Dentist'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'Code' => 'Code',
			'LastName' => 'Last Name',
			'FirstName' => 'First Name',
			'PositionId' => 'Position',
			'Salary' => 'Salary',
			'BHXH' => 'Bhxh',
			'BHYT' => 'Bhyt',
			'CongDoan' => 'Cong Doan',
			'TreatmentService' => 'Treatment Service',
			'Work' => 'Work',
			'Salary_Time' => 'Salary Time',
			'Bonus' => 'Bonus',
			'Other' => 'Other',
			'isAbsence' => 'Is Absence',
			'TruPhiLabo' => 'Tru Phi Labo',
			'TruPhiVatLieu' => 'Tru Phi Vat Lieu',
			'TruPhiMarketing' => 'Tru Phi Marketing',
			'PayrollFormula_ID' => 'Payroll Formula',
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
		$criteria->compare('Code',$this->Code,true);
		$criteria->compare('LastName',$this->LastName,true);
		$criteria->compare('FirstName',$this->FirstName,true);
		$criteria->compare('PositionId',$this->PositionId);
		$criteria->compare('Salary',$this->Salary);
		$criteria->compare('BHXH',$this->BHXH);
		$criteria->compare('BHYT',$this->BHYT);
		$criteria->compare('CongDoan',$this->CongDoan);
		$criteria->compare('TreatmentService',$this->TreatmentService);
		$criteria->compare('Work',$this->Work);
		$criteria->compare('Salary_Time',$this->Salary_Time);
		$criteria->compare('Bonus',$this->Bonus);
		$criteria->compare('Other',$this->Other);
		$criteria->compare('isAbsence',$this->isAbsence);
		$criteria->compare('TruPhiLabo',$this->TruPhiLabo);
		$criteria->compare('TruPhiVatLieu',$this->TruPhiVatLieu);
		$criteria->compare('TruPhiMarketing',$this->TruPhiMarketing);
		$criteria->compare('PayrollFormula_ID',$this->PayrollFormula_ID,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}