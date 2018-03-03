<?php

/**
 * This is the model class for table "treatment_schedule_details".
 *
 * The followings are the available columns in table 'treatment_schedule_details':
 * @property string $id
 * @property string $schedule_id
 * @property integer $time_id
 * @property string $start_date
 * @property string $end_date
 * @property integer $teeth_id
 * @property integer $diagnosis_id
 * @property integer $treatment_type_id
 * @property string $description
 * @property string $type_schedule
 * @property integer $status
 */
class TreatmentScheduleDetails extends BaseActiveRecord
{
    //-----------------------------------------------------
    // Autocomplete fields
    //-----------------------------------------------------
    public $autocomplete_medical_record;
    
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const STATUS_INACTIVE               = 0;
    const STATUS_ACTIVE                 = 1;
    const STATUS_COMPLETED              = 2;
    const STATUS_SCHEDULE               = 3;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TreatmentScheduleDetails the static model class
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
		return 'treatment_schedule_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('schedule_id, time_id, start_date', 'required'),
			array('time_id, teeth_id, diagnosis_id, treatment_type_id, status', 'numerical', 'integerOnly'=>true),
			array('schedule_id', 'length', 'max'=>11),
			array('description, type_schedule', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, schedule_id, time_id, start_date, end_date, teeth_id, diagnosis_id, treatment_type_id, description, type_schedule, status', 'safe', 'on'=>'search'),
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
                    'rSchedule' => array(self::BELONGS_TO, 'TreatmentSchedules', 'schedule_id'),
                    'rDiagnosis' => array(self::BELONGS_TO, 'Diagnosis', 'diagnosis_id'),
                    'rTreatmentType' => array(self::BELONGS_TO, 'TreatmentTypes', 'treatment_type_id'),
                    'rProcess' => array(
                        self::HAS_MANY, 'TreatmentScheduleProcess', 'detail_id',
                        'on'    => 'status = ' . DomainConst::DEFAULT_STATUS_ACTIVE,
                    ),
                    'rTime' => array(
                        self::BELONGS_TO, 'ScheduleTimes', 'time_id'
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
			'schedule_id' => DomainConst::CONTENT00144,
			'time_id' => DomainConst::CONTENT00240,
			'start_date' => DomainConst::CONTENT00139,
			'end_date' => DomainConst::CONTENT00140,
			'teeth_id' => DomainConst::CONTENT00145,
			'diagnosis_id' => DomainConst::CONTENT00121,
			'treatment_type_id' => DomainConst::CONTENT00128,
			'description' => DomainConst::CONTENT00207,
			'type_schedule' => DomainConst::CONTENT00206,
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
		$criteria->compare('schedule_id',$this->schedule_id,true);
		$criteria->compare('time_id',$this->time_id);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('teeth_id',$this->teeth_id);
		$criteria->compare('diagnosis_id',$this->diagnosis_id);
		$criteria->compare('treatment_type_id',$this->treatment_type_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('type_schedule',$this->type_schedule,true);
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
        $date = $this->start_date;
        $this->start_date = CommonProcess::convertDateTimeToMySqlFormat(
                $date, DomainConst::DATE_FORMAT_3);
        if (empty($this->start_date)) {
            // Handle when create by receiptionist
            $this->start_date = CommonProcess::convertDateTimeToMySqlFormat(
                    $date, DomainConst::DATE_FORMAT_1);
        }
        if (empty($this->start_date)) {
            // Handle when create by receiptionist
            $this->start_date = CommonProcess::convertDateTimeToMySqlFormat(
                    $date, DomainConst::DATE_FORMAT_4);
        }
        // Format end date value
        $date = $this->end_date;
        $this->end_date = CommonProcess::convertDateTimeToMySqlFormat(
                $date, DomainConst::DATE_FORMAT_3);
        if (empty($this->end_date)) {
            // Handle when create by receiptionist
            $this->end_date = $this->start_date;
        }
        if ($this->isNewRecord) {   // Add
            
        } else {                    // Update
            if ($this->status == self::STATUS_COMPLETED) {
                $this->end_date = CommonProcess::getCurrentDateTimeWithMySqlFormat();
            }            
        }
        return parent::beforeSave();
    }
    
    /**
     * Override before delete method
     */
    public function beforeDelete() {
        if (isset($this->rProcess)) {
            foreach ($this->rProcess as $process) {
                $process->delete();
            }
        }
        return parent::beforeDelete();
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Get diagnosis
     * @return String Diagnosis
     */
    public function getDiagnosis() {
        return isset($this->rDiagnosis) ? $this->rDiagnosis->name : '';
    }
    /**
     * Check if detail is schedule (lịch hẹn)
     * @return True if not set teeth, diagnosis and treatment type, False otherwise
     */
    public function isSchedule() {
        if (!isset($this->diagnosis_id) && !isset($this->treatment_type_id)) {
            return true;
        }
        return false;
    }
    
    /**
     * Get name of doctor
     * @return string
     */
    public function getDoctor() {
        if (isset($this->rSchedule) && isset($this->rSchedule->rDoctor)) {
            return $this->rSchedule->rDoctor->getFullname();
        }
        return '';
    }
    
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
     * Get teeth name
     * @return String Teeth name
     */
    public function getTreatment() {
        return isset($this->rTreatmentType) ? $this->rTreatmentType->name : '';
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
                DomainConst::CONTENT00139,
                CommonProcess::convertDateTime($this->start_date,
                DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_7));
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_END_DATE,
                DomainConst::CONTENT00140,
                CommonProcess::convertDateTimeWithFormat($this->end_date));
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_TEETH,
                DomainConst::CONTENT00145,
                $this->getTeeth());
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_TEETH_ID,
                '',
                $this->teeth_id);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_DIAGNOSIS,
                DomainConst::CONTENT00231,
                $this->getDiagnosis());
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_DIAGNOSIS_ID,
                '',
                $this->diagnosis_id);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_TREATMENT,
                DomainConst::CONTENT00128,
                $this->getTreatment());
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_TREATMENT_TYPE_ID,
                '',
                $this->treatment_type_id);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_NOTE,
                DomainConst::CONTENT00207,
                $this->description);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_STATUS,
                DomainConst::CONTENT00026,
                $this->status);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_TYPE,
                DomainConst::CONTENT00206,
                $this->type_schedule);
        $processArr = array();
        foreach ($this->rProcess as $process) {
            if ($process->status != DomainConst::DEFAULT_STATUS_INACTIVE) {
                $processArr[] = CommonProcess::createConfigJson(
                        $process->id, $process->name, $process->getJsonInfo());
            }
        }
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_CAN_UPDATE,
            DomainConst::CONTENT00232,
            $this->status != TreatmentScheduleDetails::STATUS_COMPLETED
            ? DomainConst::NUMBER_ONE_VALUE : DomainConst::NUMBER_ZERO_VALUE);
        
        if (empty($processArr)) {
            $process = new TreatmentScheduleProcess();
            $processArr[] = CommonProcess::createConfigJson(
                    isset($process->id) ? $process->id : '',
                    isset($process->name) ? $process->name : '',
                    $process->getJsonInfo());
        }
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_DETAILS,
                DomainConst::CONTENT00233,
                $processArr);
        return $info;
    }
    
    /**
     * Get start time string
     * @return String Time and Start date
     */
    public function getStartTime() {
        $retVal = isset($this->rTime) ? $this->rTime->name : '';
        if (!empty($retVal)) {
            $retVal .= ' ngày ';
        } else {
            $retVal .= "Ngày";
        }
        $retVal .= CommonProcess::convertDateTime($this->start_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_5);
        return $retVal;
    }
    
    public function getAjaxScheduleInfo() {
        $infoSchedule = '<div class="title-2">' . DomainConst::CONTENT00177 . ': </div>';
        $infoSchedule .= '<div class="item-search">';
//                $infoSchedule .=    '<p>' . $mSchedule->start_date . '</p>';
        $infoSchedule .=    '<p>' . $this->getStartTime() . '</p>';
        $infoSchedule .=    '<p>Hình thức: ' . $this->type_schedule . '</p>';
        $infoSchedule .=    '<p>Chi Tiết Công Việc: ' . $this->description . '</p>';
        $infoSchedule .=    '<p>Bác sĩ: ' . $this->getDoctor() . '</p>';
        $infoSchedule .= '</div>';
        $infoSchedule .= '<div class="group-btn">';
        $infoSchedule .=    '<a style="cursor: pointer;"'
                . ' onclick="{updateSchedule(); $(\'#dialogUpdateSchedule\').dialog(\'open\');}">' . DomainConst::CONTENT00178 . '</a>';
        $infoSchedule .= '</div>';
        return $infoSchedule;
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
            self::STATUS_SCHEDULE  => DomainConst::CONTENT00177,
        );
    }
    
    /**
     * Get teeth by id
     * @param String $id    Id
     * @return String       Teeth id
     */
    public static function getTeethById($id) {
        $model = self::model()->findByPk($id);
        if ($model) {
            return $model->teeth_id;
        }
        return '0';
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
}