<?php

/**
 * This is the model class for table "prescriptions".
 *
 * The followings are the available columns in table 'prescriptions':
 * @property string $id
 * @property string $process_id
 * @property string $created_date
 * @property string $doctor_id
 * @property string $note
 * @property integer $status
 */
class Prescriptions extends BaseActiveRecord
{
    public $autocomplete_name_doctor;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Prescriptions the static model class
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
		return 'prescriptions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('process_id, created_date, doctor_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('process_id, doctor_id', 'length', 'max'=>11),
			array('note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, process_id, created_date, doctor_id, note, status', 'safe', 'on'=>'search'),
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
                    'rTreatmentScheduleDetail' => array(self::BELONGS_TO, 'TreatmentScheduleDetails', 'process_id'),
                    'rDoctor' => array(self::BELONGS_TO, 'Users', 'doctor_id'),
                    'rDetail' => array(
                        self::HAS_MANY, 'PrescriptionDetails', 'prescription_id',
                        'on'    => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
                        'order' => 'id DESC',
                    ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'process_id' => DomainConst::CONTENT00388,
			'created_date' => DomainConst::CONTENT00150,
			'doctor_id' => DomainConst::CONTENT00151,
			'note' => DomainConst::CONTENT00152,
			'status' => DomainConst::CONTENT00026,
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
		$criteria->compare('process_id',$this->process_id,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('doctor_id',$this->doctor_id,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    //-----------------------------------------------------
    // Parent override methods
    //-----------------------------------------------------
    /**
     * Override before save method
     * @return Parent result
     */
    public function beforeSave() {
        // Format created date value
        $this->created_date = CommonProcess::convertDateTimeToMySqlFormat(
                $this->created_date, DomainConst::DATE_FORMAT_BACK_END);
        if ($this->isNewRecord) {   // Add
            
        } else {                    // Update
            
        }
        return parent::beforeSave();
    }
    
    /**
     * Override before delete method
     */
    public function beforeDelete() {
        if (isset($this->rDetail)) {
            foreach ($this->rDetail as $detail) {
                $detail->delete();
            }
        }
        return parent::beforeDelete();
    }
}