<?php

/**
 * This is the model class for table "renodcm3_tb_treatmentdetails".
 *
 * The followings are the available columns in table 'renodcm3_tb_treatmentdetails':
 * @property integer $Id
 * @property integer $TreatmentProfiles_ID
 * @property integer $OrderTicket_ID
 * @property integer $TreatmentId
 * @property string $Date
 * @property integer $WorkId
 * @property string $ContentOfWork
 * @property integer $Doctor
 * @property string $Note
 * @property string $Teeth
 * @property integer $Status
 * @property integer $PriorityTreatment_ID
 *
 * The followings are the available model relations:
 * @property Renodcm3TbTreatmentprofiles $treatmentProfiles
 */
class Renodcm3TbTreatmentdetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Renodcm3TbTreatmentdetails the static model class
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
		return 'renodcm3_tb_treatmentdetails';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('TreatmentProfiles_ID, OrderTicket_ID, TreatmentId, WorkId, Doctor, Status, PriorityTreatment_ID', 'numerical', 'integerOnly'=>true),
			array('Teeth', 'length', 'max'=>100),
			array('Date, ContentOfWork, Note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, TreatmentProfiles_ID, OrderTicket_ID, TreatmentId, Date, WorkId, ContentOfWork, Doctor, Note, Teeth, Status, PriorityTreatment_ID', 'safe', 'on'=>'search'),
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
			'treatmentProfiles' => array(self::BELONGS_TO, 'Renodcm3TbTreatmentprofiles', 'TreatmentProfiles_ID'),
                        'rDoctor' => array(self::BELONGS_TO, 'Renodcm3TbStaff', 'Doctor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'TreatmentProfiles_ID' => 'Treatment Profiles',
			'OrderTicket_ID' => 'Order Ticket',
			'TreatmentId' => 'Treatment',
			'Date' => 'Date',
			'WorkId' => 'Work',
			'ContentOfWork' => 'Content Of Work',
			'Doctor' => 'Doctor',
			'Note' => 'Note',
			'Teeth' => 'Teeth',
			'Status' => 'Status',
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

		$criteria->compare('Id',$this->Id);
		$criteria->compare('TreatmentProfiles_ID',$this->TreatmentProfiles_ID);
		$criteria->compare('OrderTicket_ID',$this->OrderTicket_ID);
		$criteria->compare('TreatmentId',$this->TreatmentId);
		$criteria->compare('Date',$this->Date,true);
		$criteria->compare('WorkId',$this->WorkId);
		$criteria->compare('ContentOfWork',$this->ContentOfWork,true);
		$criteria->compare('Doctor',$this->Doctor);
		$criteria->compare('Note',$this->Note,true);
		$criteria->compare('Teeth',$this->Teeth,true);
		$criteria->compare('Status',$this->Status);
		$criteria->compare('PriorityTreatment_ID',$this->PriorityTreatment_ID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function createFields() {
        $fields = array();
        
        $fields[] = 'Date: ' . $this->Date;
        $fields[] = 'Teeth: ' . $this->Teeth;
        $fields[] = 'ContentOfWork: ' . $this->ContentOfWork;
        $fields[] = 'Doctor: ' . $this->getDoctorName();
        $fields[] = 'Note: ' . $this->Note;
        return $fields;
    }
    
    public function getDoctorName() {
        return isset($this->rDoctor) ? $this->rDoctor->LastName . ' ' . $this->rDoctor->FirstName : '';
    }
    
    public function createFieldsLbl() {
        $fields = array();
        
        $fields[] = 'Date';
        $fields[] = 'Teeth';
        $fields[] = 'ContentOfWork';
        $fields[] = 'Doctor';
        $fields[] = 'Note';
        return $fields;
    }
}