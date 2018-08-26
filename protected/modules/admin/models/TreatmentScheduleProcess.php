<?php

/**
 * This is the model class for table "treatment_schedule_process".
 *
 * The followings are the available columns in table 'treatment_schedule_process':
 * @property string $id
 * @property string $detail_id
 * @property string $process_date
 * @property integer $teeth_id
 * @property string $name
 * @property string $description
 * @property string $doctor_id
 * @property string $note
 * @property integer $status
 * 
 * The followings are the available model relations:
 * @property Users                  $rDoctor            Doctor of treatment
 */
class TreatmentScheduleProcess extends BaseActiveRecord
{
    //-----------------------------------------------------
    // Autocomplete fields
    //-----------------------------------------------------
    public $autocomplete_name_doctor;
    
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const STATUS_INACTIVE               = 0;
    const STATUS_ACTIVE                 = 1;
    const STATUS_COMPLETED              = 2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TreatmentScheduleProcess the static model class
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
		return 'treatment_schedule_process';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('detail_id', 'required'),
			array('teeth_id, status', 'numerical', 'integerOnly'=>true),
			array('detail_id, doctor_id', 'length', 'max'=>11),
			array('name', 'length', 'max'=>255),
			array('description, note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, detail_id, process_date, teeth_id, name, description, doctor_id, note, status', 'safe', 'on'=>'search'),
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
                    'rDetail' => array(self::BELONGS_TO, 'TreatmentScheduleDetails', 'detail_id'),
                    'rDoctor' => array(self::BELONGS_TO, 'Users', 'doctor_id'),
                    'rPrescription' => array(
                        self::HAS_MANY, 'Prescriptions', 'process_id',
                        'on'    => 'status = ' . DomainConst::DEFAULT_STATUS_ACTIVE,
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
			'detail_id' => DomainConst::CONTENT00146,
			'process_date' => DomainConst::CONTENT00147,
			'teeth_id' => DomainConst::CONTENT00145,
			'name' => DomainConst::CONTENT00148,
			'description' => DomainConst::CONTENT00062,
			'doctor_id' => DomainConst::CONTENT00143,
			'note' => DomainConst::CONTENT00091,
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
		$criteria->compare('detail_id',$this->detail_id,true);
		$criteria->compare('process_date',$this->process_date,true);
		$criteria->compare('teeth_id',$this->teeth_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
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
        // Format start date value
        $date = $this->process_date;
        $this->process_date = CommonProcess::convertDateTimeToMySqlFormat(
                $date, DomainConst::DATE_FORMAT_3);
        if (empty($this->process_date)) {
            $this->process_date = CommonProcess::convertDateTimeToMySqlFormat(
                    $date, DomainConst::DATE_FORMAT_4);
        }
        if ($this->isNewRecord) {   // Add
            
        } else {                    // Update
            
        }
        return parent::beforeSave();
    }
    
    /**
     * Override before delete method
     */
    public function beforeDelete() {
        if (isset($this->rPrescription)) {
            foreach ($this->rPrescription as $prescription) {
                $prescription->delete();
            }
        }
        return parent::beforeDelete();
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Get teeth name
     * @return String Teeth name
     */
    public function getTeeth() {
        if (!empty($this->teeth_id)) {
            return CommonProcess::getListTeeth()[$this->teeth_id];
        }
        return '';
    }
    
    /**
     * Get process date string
     * @return String Time and Start date
     */
    public function getDate() {
        $retVal = CommonProcess::convertDateTime($this->process_date, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_VIEW);
        return $retVal;
    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Get list status of treatment schedule detail object
     * @return Array
     */
    public static function getStatus() {
        return array(
            self::STATUS_INACTIVE  => DomainConst::CONTENT00028,
            self::STATUS_ACTIVE    => DomainConst::CONTENT00027,
            self::STATUS_COMPLETED => DomainConst::CONTENT00204,
        );
    }

    //-----------------------------------------------------
    // JSON methods
    //-----------------------------------------------------    
    /**
     * Get json list status
     * @return Array
     * [
     *      {
     *          id:"1",
     *          name:"Active",
     *      },
     *      ...
     * ]
     */
    public static function getJsonListStatus() {
        $retVal = array();
        foreach (self::getStatus() as $key => $value) {
            $retVal[] = CommonProcess::createConfigJson($key, $value);
        }
        return $retVal;
    }
    
    /**
     * Get json information
     * @return Array
     */
    public function getJsonInfo() {
        $info = array();
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_ID,
                DomainConst::CONTENT00003,
                $this->id);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_START_DATE,
                DomainConst::CONTENT00147,
                CommonProcess::convertDateTime($this->process_date, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_3));
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_TEETH,
                DomainConst::CONTENT00145,
                $this->getTeeth());
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_TEETH_ID,
                '',
                $this->teeth_id);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_NAME,
                DomainConst::CONTENT00148,
                $this->name);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_DESCRIPTION,
                DomainConst::CONTENT00062,
                $this->description);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_DOCTOR,
                DomainConst::CONTENT00143,
                isset($this->rDoctor) ? $this->rDoctor->getFullName() : '');
//        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_NOTE,
//                DomainConst::CONTENT00207,
//                $this->note);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_STATUS,
                DomainConst::CONTENT00026,
                $this->status);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_CAN_UPDATE,
            DomainConst::CONTENT00232,
            $this->status != TreatmentScheduleProcess::STATUS_COMPLETED
            ? DomainConst::NUMBER_ONE_VALUE : DomainConst::NUMBER_ZERO_VALUE);
        return $info;
    }
    
    /**
     * Get html information
     * @return string Html string
     */
    public function getHtmlInfo() {
        $teethInfo = !empty($this->teeth_id) ? '<p><i class="fas fa-tooth" title='.DomainConst::CONTENT00284.'></i> '. $this->getTeeth() .'</p>' : '';
        $description = !empty($this->description) ? '<p><i class="fas fa-sticky-note" title='.DomainConst::CONTENT00062.'></i> '. $this->description .'</p>' : '';
        $doctorInfo = !empty($this->doctor_id) ? '<p><i class="fas fa-user-md" title="' . DomainConst::CONTENT00143
                . '"></i> '. $this->rDoctor->first_name .'</p>' : '';
        
        $retVal = '<div class="lp-list-item" style=" width: 45%; margin: 10px 15px;float:left;>'
                    .       '<i class="fas fa-calendar-check lp-list-item-icon"></i>'
                    .       '<p><i class="fas fa-angle-double-right" title="Tên"></i> '. $this->name .'</p>'
                    .       '<p><i class="fas fa-calendar-alt" title="' . DomainConst::CONTENT00147 . '"></i> '. $this->getDate() .'</p>'
                    .       $teethInfo . $description
                    .       $doctorInfo
                    . '</div>';
        return $retVal;
    }
    
    public function createFields() {
        $fields = array();
        
        $fields[] = 'process_date: ' . $this->process_date;
        $fields[] = 'name: ' . $this->name;
        $fields[] = 'doctor: ' . (isset($this->rDoctor) ? $this->rDoctor->first_name : '');
        $fields[] = 'description: ' . $this->description;
        $fields[] = 'note: ' . $this->note;
        
        return $fields;
    }
    
    //++ BUG0076-IMT (DuongNV 20180823) Create treatment schedule process
    /*
     * Get customer model to reload info customer after close modal dialog
     */
    public function getCustomerModel() {
        if (isset($this->rDetail->rSchedule)) {
            return $this->rDetail->rSchedule->getCustomerModel();
        }
        return NULL;
    }
    //-- BUG0076-IMT (DuongNV 20180823) Create treatment schedule process
}