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
 * @property string $created_date
 * @property integer $status
 * 
 * The followings are the available model relations:
 * @property TreatmentTypes                 $rTreatmentType             Treatment Type
 * @property LaboRequests                   $rLaboRequest               Labo request
 */
class TreatmentScheduleDetails extends BaseActiveRecord
{
    //-----------------------------------------------------
    // Autocomplete fields
    //-----------------------------------------------------
    public $autocomplete_medical_record;
    public $order_number;
    public $autocomplete_treatment;
    public $isFinish;
    
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
                    'rTreatmentType' => array(self::BELONGS_TO, 'TreatmentTypes', 'treatment_type_id',
                        'on' => 'status !=' . TreatmentTypes::STATUS_INACTIVE,
                    ),
                    'rProcess' => array(
                        self::HAS_MANY, 'TreatmentScheduleProcess', 'detail_id',
                        'on'    => 'status = ' . DomainConst::DEFAULT_STATUS_ACTIVE,
                        'order' => 'process_date DESC'
                    ),
                    'rTime' => array(
                        self::BELONGS_TO, 'ScheduleTimes', 'time_id'
                    ),
                    'rReceipt' => array(
                        self::HAS_ONE, 'Receipts', 'detail_id',
                        'on' => 'status !=' . Receipts::STATUS_INACTIVE,
                    ),
                    'rJoinTeeth' => array(
                        self::HAS_MANY, 'OneMany', 'one_id',
                        'on'    => 'type = ' . OneMany::TYPE_TREATMENT_DETAIL_TEETH,
                    ),
                    'rImgXRayFile' => array(    // XRay images
                        self::HAS_MANY, 'Files', 'belong_id',
                        'on' => 'type=' . Files::TYPE_2_TREATMENT_SCHEDULE_DETAIL_XRAY,
                        'order' => 'id DESC',
                    ),
                    'rImgRealFile' => array(    // Images before and after treatment
                        self::HAS_MANY, 'Files', 'belong_id',
                        'on' => 'type = ' . Files::TYPE_3_TREATMENT_SCHEDULE_REAL_IMG,
                        'order' => 'id DESC',
                    ),
                    'rPrescription' => array(
                        self::HAS_ONE, 'Prescriptions', 'process_id',
                        'on'    => 'status = ' . DomainConst::DEFAULT_STATUS_ACTIVE,
                    ),
                    'rPrescription' => array(
                        self::HAS_ONE, 'Prescriptions', 'process_id',
                        'on'    => 'status = ' . DomainConst::DEFAULT_STATUS_ACTIVE,
                    ),
                    'rLaboRequest' => array(
                        self::HAS_ONE, 'LaboRequests', 'treatment_detail_id',
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
			'schedule_id' => DomainConst::CONTENT00144,
			'time_id' => DomainConst::CONTENT00240,
			'start_date' => DomainConst::CONTENT00139,
			'end_date' => DomainConst::CONTENT00140,
			'teeth_id' => DomainConst::CONTENT00145,
			'diagnosis_id' => DomainConst::CONTENT00121,
			'treatment_type_id' => DomainConst::CONTENT00128,
			'description' => DomainConst::CONTENT00207,
			'type_schedule' => DomainConst::CONTENT00206,
			'created_date' => DomainConst::CONTENT00010,
			'status' => DomainConst::CONTENT00026,
			'isFinish' => 'Hoàn thành luôn',
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
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('status',$this->status);
                $criteria->order = 'id DESC';

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
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
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
        if (isset($this->rReceipt)) {
            $this->rReceipt->delete();
        }
        OneMany::deleteAllOldRecords($this->id, OneMany::TYPE_TREATMENT_DETAIL_TEETH);
        // Delete images XRay
        if (isset($this->rImgXRayFile)) {
            foreach ($this->rImgXRayFile as $image) {
                $image->delete();
            }
        }
        // Delete images before and after treatment
        if (isset($this->rImgRealFile)) {
            foreach ($this->rImgRealFile as $image) {
                $image->delete();
            }
        }
        Loggers::info("Deleted " . get_class($this) . " with id = $this->id.", __FUNCTION__, __LINE__);
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
            if (!$this->isCompleted()) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Check if record completed
     * @return True if status is completed, False otherwise
     */
    public function isCompleted() {
//        return $this->status === self::STATUS_COMPLETED;
        // Init can update flag
        $retVal = false;
        if ($this->status == self::STATUS_COMPLETED) {
            return true;
        }
        // Check if this detail was receipted
        if (isset($this->rReceipt)) {
            if ($this->rReceipt->status == Receipts::STATUS_RECEIPTIONIST) {
//            CommonProcess::dumpVariable('456');
                $retVal = true;
            }
        }
        return $retVal;
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
     * Get id of doctor
     * @return string
     */
    public function getDoctorId() {
        if (isset($this->rSchedule) && isset($this->rSchedule->rDoctor)) {
            return $this->rSchedule->rDoctor->id;
        }
        return '';
    }
    
    /**
     * Get customer id
     * @return string
     */
    public function getCustomer() {
        if (isset($this->rSchedule)) {
            return $this->rSchedule->getCustomer();
        }
        return '';
    }
    
    /**
     * Get customer model
     * @return Customer model, or NULL
     */
    public function getCustomerModel() {
        if (isset($this->rSchedule)) {
            return $this->rSchedule->getCustomerModel();
        }
        return NULL;
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
     * Get timer name
     * @return String Timer name
     */
    public function getTimer() {
        return isset($this->rTime) ? $this->rTime->name : '';
    }
    
    /**
     * Get treatment name
     * @return String Treatment name
     */
    public function getTreatment() {
        return isset($this->rTreatmentType) ? $this->rTreatmentType->name : '';
    }
    
    /**
     * Get treatment information, if treatment type is empty, return 'Lịch hẹn'
     * @return String
     */
    public function getTreatmentInfo() {
        $retVal = [];
        $treatment = trim($this->getTreatment());
        if (!empty($treatment)) {
            return $treatment;
//            $retVal[] = $treatment;
        }
        if (isset($this->rDiagnosis)) {
            $diagnosisName = trim($this->rDiagnosis->name);
            if (!empty($diagnosisName)) {
                $retVal[] = $diagnosisName;
            }
        }
        $description = trim($this->description);
        if (!empty($description)) {
            $retVal[] = $description;
        }
        if (!empty($retVal)) {
            return implode(DomainConst::SPLITTER_TYPE_1, $retVal);
        }
        return DomainConst::CONTENT00177;
    }
    
    /**
     * Get treatment price
     * @return String Treatment price
     */
    public function getTreatmentPrice() {
        return isset($this->rTreatmentType) ? $this->rTreatmentType->price : DomainConst::NUMBER_ZERO_VALUE;
    }
    
    /**
     * Get treatment price
     * @return String Treatment price
     */
    public function getTreatmentPriceText() {
        return CommonProcess::formatCurrency($this->getTreatmentPrice()) . " " . DomainConst::CONTENT00134;
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
        $info[] = CommonProcess::createConfigJson(
                CustomerController::ITEM_TIME,
                DomainConst::CONTENT00240,
                $this->getTimer());
        $info[] = CommonProcess::createConfigJson(
                CustomerController::ITEM_TIME_ID,
                '',
                $this->time_id);
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
        $info[] = $this->getListConfigTeethInfo();
        $info[] = $this->getListImageXRayInfo();
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
        $debt = 0;
        if ($this->getCustomerModel() != NULL) {
            $debt = $this->getCustomerModel()->getDebt();
        }
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_CUSTOMER_DEBT,
                DomainConst::CONTENT00300,
                $debt);
        $processArr = array();
        foreach ($this->rProcess as $process) {
            if ($process->status != DomainConst::DEFAULT_STATUS_INACTIVE) {
                $processArr[] = CommonProcess::createConfigJson(
                        $process->id, $process->name, $process->getJsonInfo());
            }
        }
        // Init can update flag
        $canUpdate = DomainConst::NUMBER_ONE_VALUE;
        // Check if this detail was receipted
        if (isset($this->rReceipt)) {
            if ($this->rReceipt->status === Receipts::STATUS_RECEIPTIONIST) {
                $canUpdate = DomainConst::NUMBER_ZERO_VALUE;
            }
        }
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_CAN_UPDATE,
            DomainConst::CONTENT00232,
//            $this->status != TreatmentScheduleDetails::STATUS_COMPLETED
//            ? DomainConst::NUMBER_ONE_VALUE : DomainConst::NUMBER_ZERO_VALUE);
            $canUpdate);
        
        if (empty($processArr)) {
            $process = new TreatmentScheduleProcess();
            $processArr[] = CommonProcess::createConfigJson(
                    isset($process->id) ? $process->id : '',
                    isset($process->name) ? $process->name : '',
                    $process->getJsonInfo());
        }
//        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_DETAILS,
//                DomainConst::CONTENT00233,
//                $processArr);
        if (isset($this->rReceipt)) {
            $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_RECEIPT,
                DomainConst::CONTENT00251,
                $this->rReceipt->getJsonInfo());
        }
        
        return $info;
    }
    
    /**
     * Get start time string
     * @return String Time and Start date
     */
    public function getStartDate() {
        $retVal = CommonProcess::convertDateTime($this->start_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_5);
        return $retVal;
    }
    
    /**
     * Get start time string
     * @return String Time and Start date
     */
    public function getStartTime() {
        $retVal = isset($this->rTime) ? $this->rTime->name : '';
        if (!empty($retVal)) {
            $retVal .= ', ';
        } else {
            $retVal .= "Ngày";
        }
        $retVal .= CommonProcess::convertDateTime($this->start_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_5);
        return $retVal;
    }
    
    /**
     * Get start time raw value
     * Example: 
     */
    public function getStartTimeRawValue() {
        $retVal = isset($this->rTime) ? $this->rTime->name : '';
        $day = CommonProcess::convertDateTime($this->start_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_4);
        if (!empty($retVal)) {
            $retVal = $day . ' ' . $retVal . ':00';
            $retVal = CommonProcess::convertDateTime($retVal, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_9);
        } else {
            $retVal = $day;
            $retVal = CommonProcess::convertDateTime($retVal, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_10);
        }
        return $retVal;
    }
    
    /**
     * Get ajax schedule information
     * @return string
     */
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
                . ' onclick="{fnOpenUpdateSchedule(\'' . $this->id . '\');}">' . DomainConst::CONTENT00178 . '</a>';
        $infoSchedule .= '</div>';
        return $infoSchedule;
    }
    
    public function getAjaxScheduleInfo_1() {
        $detail = '<div class="list__2__des">';
        $detail .=      '<div class="list__2__item">';
        $detail .=      '<span class="icon28 icon-list"></span>';
        $detail .=      '<p>';
        $detail .=          '<strong>' . DomainConst::CONTENT00281 . '</strong>';
        $detail .=      '</p>';
        $detail .=      '<p>';
        $detail .=          DomainConst::CONTENT00282 . ': ' . $this->getStartTime();
        $detail .=          '<br/>';
        $detail .=          DomainConst::CONTENT00283 . ': ' . CommonProcess::convertDateTime($this->end_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_5);
        $detail .=      '</p>';
        $detail .=      '</div>';
        $detail .= '</div>';
        if (isset($this->rJoinTeeth) && !empty($this->rJoinTeeth)) {
            $detail .= '<div class="list__2__des">';
            $detail .=      '<div class="list__2__item">';
            $detail .=      '<span class="icon29 icon-list"></span>';
            $detail .=      '<p>';
            $detail .=          '<strong>' . DomainConst::CONTENT00284 . '</strong>';
            $detail .=      '</p>';
            $detail .=      '<p> ';
            $detail .=          $this->generateTeethInfo(", ");
            $detail .=      '</p>';
            $detail .=      '</div>';
            $detail .= '</div>';
        }
        if (!empty($this->getDiagnosis())) {
            $detail .= '<div class="list__2__des">';
            $detail .=      '<div class="list__2__item">';
            $detail .=      '<span class="icon31 icon-list"></span>';
            $detail .=      '<p>';
            $detail .=          '<strong>' . DomainConst::CONTENT00231 . '</strong>';
            $detail .=      '</p>';
            $detail .=      '<p>';
            $detail .=          $this->getDiagnosis();
            $detail .=      '</p>';
            $detail .=      '</div>';
            $detail .= '</div>';
        }
        if (!empty($this->getTreatment())) {
            $detail .= '<div class="list__2__des">';
            $detail .=      '<div class="list__2__item">';
            $detail .=      '<span class="icon32 icon-list"></span>';
            $detail .=      '<p>';
            $detail .=          '<strong>' . DomainConst::CONTENT00128 . '</strong>';
            $detail .=      '</p>';
            $detail .=      '<p>';
            $detail .=          $this->getTreatment();
            $detail .=      '</p>';
            $detail .=      '</div>';
            $detail .= '</div>';
        }
        
        return $detail;
    }
    
    /**
     * Get sale model
     * @return User model, can be NULL
     */
    public function getSale() {
        if (isset($this->rSchedule) && isset($this->rSchedule->rCreatedBy)) {
            $user = $this->rSchedule->rCreatedBy;
            if ($user->rRole->role_name == Roles::ROLE_SALE) {
                return $user;
            }
        }
        return NULL;
    }
    /**
     * Generate List teeth information string
     * @return String list teeth information string
     */
    public function generateTeethInfo($spliter = "<br>") {
        $array = array();
        foreach ($this->rJoinTeeth as $item) {
            $array[] = CommonProcess::getListTeeth()[$item->many_id];
        }        
        return implode($spliter, $array);
    }
    
    /**
     * Get list config teeth information
     * @return type Config object
     */
    public function getListConfigTeethInfo() {
        $data = array();
        Loggers::info(count($this->rJoinTeeth), __FUNCTION__, __LINE__);
        foreach ($this->rJoinTeeth as $item) {
            $data[] = CommonProcess::createConfigJson(
                    $item->many_id, 
                    CommonProcess::getListTeeth()[$item->many_id]);
        } 
        return CommonProcess::createConfigJson(
                CustomerController::ITEM_TEETH_INFO,
                DomainConst::CONTENT00145, $data);
    }
    
    /**
     * Get list image XRay information
     * @return type
     */
    public function getListImageXRayInfo() {
        $data = array();
        $index = 0;
        foreach ($this->rImgXRayFile as $image) {
            $data[] = CommonProcess::createConfigJson(
                    '' . $index++,
                    ImageHandler::bindImageByModel($image, '', '', array(Files::KEY_SIZE => Files::KEY_SMALL_SIZE)),
                    ImageHandler::bindImageByModel($image, '', '', array(Files::KEY_SIZE => self::KEY_NORMAL_SIZE)));
        }
        return CommonProcess::createConfigJson(CustomerController::ITEM_IMAGE,
                DomainConst::CONTENT00298, $data);
    }
    
    /**
     * Get list image before and after treatment information
     * @return type
     */
    public function getListImageRealInfo() {
        $data = array();
        $index = 0;
        foreach ($this->rImgRealFile as $image) {
            $data[] = CommonProcess::createConfigJson(
                    '' . $index++,
                    ImageHandler::bindImageByModel($image, '', '', array(Files::KEY_SIZE => self::KEY_SMALL_SIZE)),
                    ImageHandler::bindImageByModel($image, '', '', array(Files::KEY_SIZE => self::KEY_NORMAL_SIZE)));
        }
        return CommonProcess::createConfigJson(CustomerController::ITEM_IMAGE_TREATMENT,
                DomainConst::CONTENT00380, $data);
    }
    
    /**
     * Return count of teeth
     * @return int
     */
    public function getTeethCount() {
        $retVal = 0;
        if (isset($this->rJoinTeeth)) {
            $retVal = count($this->rJoinTeeth);
        }
        if ($retVal != 0) {
            return $retVal;
        }
        return 1;
    }
    
    /**
     * Get total money
     * @return Int
     */
    public function getTotalMoney() {
        $price = isset($this->rTreatmentType) ? $this->rTreatmentType->price : 0;
        $teethCount = 0;
        if (isset($this->rJoinTeeth)) {
            $teethCount = count($this->rJoinTeeth);
        }
        $retVal = $price * $teethCount;
        if ($retVal == 0) {
            $retVal = $price;
        }
        return $retVal;
    }
    
    /**
     * Get total money
     * @return Int
     */
    public function getTotalMoneyText() {
        return CommonProcess::formatCurrency($this->getTotalMoney()) . " " . DomainConst::CONTENT00134;
    }
    
    /**
     * Check is treament schedule detail has start_date is match with parameter date value
     * @param String $date Date value informat (DATE_FORMAT_4 = 'Y-m-d')
     * @return boolean True if treament schedule detail has start_date is match with parameter date value
     */
    public function isScheduleOnDate($date) {
        $retVal = false;
        $startDate = CommonProcess::convertDateTime($this->start_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_4);
        $createdDate = CommonProcess::convertDateTime($this->created_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_4);
        // Case date is empty
        if (empty($date)) {
            if ($this->status != self::STATUS_INACTIVE
                    && DateTimeExt::isToday($this->start_date, DomainConst::DATE_FORMAT_1)
                    && !DateTimeExt::isToday($this->created_date, DomainConst::DATE_FORMAT_1)) {
                $retVal = true;
            }
        } else {    // Date is not empty
            if ($this->status != self::STATUS_INACTIVE
                    && (DateTimeExt::compare($startDate, $date) == 0)) {
                $retVal = true;
            }
        }
        
        return $retVal;
    }
  
    /**
     * Get title of treatment schedule detail
     * @return String Title of treatment schedule detail
     */
    public function getTitle() {
        $retVal = '';
        if ($this->rTreatmentType) {
            $retVal .= $this->rTreatmentType->name;
        } else if ($this->rDiagnosis) {
            $retVal .= $this->rDiagnosis->name;
        } else if (!empty ($this->description)) {
            $retVal .= $this->description;
        } else {
            $retVal .= DomainConst::CONTENT00177;
        }
        return $retVal;
    }
    /**
     * Check model can update
     * @return boolean
     */
    public function canUpdate() {
//        return !$this->isCompleted();
        return true;
    }
    
    /**
     * Change status
     */
    public function changeStatus() {
        switch ($this->status) {
            case self::STATUS_INACTIVE:
                // Remove old record
                OneMany::deleteAllOldRecords($this->id, OneMany::TYPE_TREATMENT_DETAIL_TEETH);
                if (isset($this->rProcess)) {
                    foreach ($this->rProcess as $process) {
                        $process->status = DomainConst::DEFAULT_STATUS_INACTIVE;
                        $process->save();
                    }
                }
                if (isset($this->rReceipt)) {
                    $this->rReceipt->status = DomainConst::DEFAULT_STATUS_INACTIVE;
                    $this->rReceipt->changeStatus();
                    $this->rReceipt->save();
                }
                // Delete images XRay
                if (isset($this->rImgXRayFile)) {
                    foreach ($this->rImgXRayFile as $image) {
                        $image->status = DomainConst::DEFAULT_STATUS_INACTIVE;
                        $image->save();
                    }
                }
                // Delete images before and after treatment
                if (isset($this->rImgRealFile)) {
                    foreach ($this->rImgRealFile as $image) {
                        $image->status = DomainConst::DEFAULT_STATUS_INACTIVE;
                        $image->save();
                    }
                }
                break;
            case self::STATUS_COMPLETED:
                if (isset($this->rReceipt)) {
                    $this->rReceipt->status = Receipts::STATUS_RECEIPTIONIST;
                    // Update customer's debt
                    $this->rReceipt->updateCustomerDebt();
                    $this->rReceipt->save();
                }
            default:
                break;
        }
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
    
    /**
     * Get list all customersn have schedule in today
     * @return Array List of customer's id
     */
    public static function getListCustomerIdHaveScheduleToday($date = '') {
        $from = time();
        $retVal = array();
//        $arrModel = self::model()->findAll();
//        $agentId = isset(Yii::app()->user) ? Yii::app()->user->agent_id : '';
//        foreach ($arrModel as $value) {
////            if ($value->status != self::STATUS_INACTIVE
////                    && DateTimeExt::isToday($value->start_date, DomainConst::DATE_FORMAT_1)
////                    && !DateTimeExt::isToday($value->created_date, DomainConst::DATE_FORMAT_1)) {
//            if ($value->isScheduleOnDate($date)) {
//                $customerId = $value->getCustomer();
//                $mCustomer = $value->getCustomerModel();
//                if (isset($mCustomer) && ($mCustomer->getAgentId() == $agentId)) {
//                    $retVal[] = $mCustomer->id;
//                }
//            }
//        }
        $agentId = isset(Yii::app()->user) ? Yii::app()->user->agent_id : '';
        $criteria=new CDbCriteria;
        $criteria->addCondition('t.status !='. self::STATUS_INACTIVE);
        if(empty($date)){
            $today = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
            $criteria->compare('DATE(t.start_date)', $today);
            $criteria->addCondition('DATE(t.created_date) != "'. $today.'"');
        }else{
            $criteria->compare('DATE(t.start_date)', $date);
        }
        $tblTreatmentSchedules = TreatmentSchedules::model()->tableName();
        $tblMedicalRecords = MedicalRecords::model()->tableName();
        $tblOneMany = OneMany::model()->tableName();
        $criteria->join = 'JOIN '.$tblTreatmentSchedules.' AS tr ON t.schedule_id = tr.id';
        $criteria->join .= ' JOIN '.$tblMedicalRecords.' AS me ON tr.record_id = me.id';
        $criteria->join .= ' JOIN '.$tblOneMany.' AS om ON me.customer_id = om.many_id';
        $criteria->compare('om.type', OneMany::TYPE_AGENT_CUSTOMER);
        $criteria->compare('om.one_id', $agentId);
        $criteria->select = 'DISTINCT me.customer_id as id';
        $arrModel = self::model()->findAll($criteria);
        foreach ($arrModel as $mScheduleDetail) {
            $retVal[] = $mScheduleDetail->id; // id -> customer_id
        }
        return $retVal;
    }
    
    /**
     * Get list all customersn have schedule in today
     * AND was created on today
     * @return Array List of customer model
     */
    public static function getListCustomerHaveScheduleTodayCreatedToday() {
        $retVal = array();
//        $arrModel = self::model()->findAll();
//        $agentId = isset(Yii::app()->user) ? Yii::app()->user->agent_id : '';
//        foreach ($arrModel as $value) {
//            if ($value->status != self::STATUS_INACTIVE
//                    && DateTimeExt::isToday($value->start_date, DomainConst::DATE_FORMAT_1)
//                    && DateTimeExt::isToday($value->created_date, DomainConst::DATE_FORMAT_1)) {
//                $mCustomer = $value->getCustomerModel();
////                if (isset($mCustomer)) {
//                if (isset($mCustomer) && ($mCustomer->getAgentId() == $agentId)) {
//                    $retVal[] = $mCustomer;
//                }
//            }
//        }
        $arrCus = [];
        $agentId = isset(Yii::app()->user) ? Yii::app()->user->agent_id : '';
        $criteria=new CDbCriteria;
        $criteria->addCondition('t.status !='. self::STATUS_INACTIVE);
        $today = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
//        set date
        $criteria->compare('DATE(t.start_date)', $today);
        $criteria->compare('DATE(t.created_date)',$today);
        $tblTreatmentSchedules = TreatmentSchedules::model()->tableName();
        $tblMedicalRecords = MedicalRecords::model()->tableName();
        $tblOneMany = OneMany::model()->tableName();
        $criteria->join = 'JOIN '.$tblTreatmentSchedules.' AS tr ON t.schedule_id = tr.id';
        $criteria->join .= ' JOIN '.$tblMedicalRecords.' AS me ON tr.record_id = me.id';
        $criteria->join .= ' JOIN '.$tblOneMany.' AS om ON me.customer_id = om.many_id';
        $criteria->compare('om.type', OneMany::TYPE_AGENT_CUSTOMER);
        $criteria->compare('om.one_id', $agentId);
        $criteria->select = 'DISTINCT me.customer_id as id';
        $arrModel = self::model()->findAll($criteria);
        foreach ($arrModel as $mScheduleDetail) {
            $arrCus[] = $mScheduleDetail->id; // id -> customer_id
        }
//        find cus
        $criteriaCus=new CDbCriteria;
        $criteriaCus->addInCondition('t.id', $arrCus);
        $retVal = Customers::model()->findAll($criteriaCus);

        return $retVal;
    }
    
    /**
     * Get list all customersn have schedule in today
     * @return array
     */
    public static function getListCustomerByDoctor($doctorId, $from, $to) {
        $retVal = array();
        $arrModel = self::model()->findAll();
        foreach (array_reverse($arrModel) as $value) {
            if ($value->status != self::STATUS_INACTIVE
                    && ($value->getDoctorId() == $doctorId)) {
                $customer = $value->getCustomerModel();
                if ($customer != NULL && !in_array($customer, $retVal)) {
                    $retVal[$value->getStartTimeRawValue()] = $customer;
                }
            }
        }
        uksort($retVal, 'strcasecmp');
        return array_reverse($retVal);
//        return $retVal;
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
    
    public function createFields() {
        $fields = array();
        
        $fields[] = 'start_date: ' . $this->start_date;
        $fields[] = 'end_date: ' . $this->end_date;
        $fields[] = 'treatment_type: ' . (isset($this->rTreatmentType) ? $this->rTreatmentType->name : '');
        $fields[] = 'description: ' . $this->description;
        
        return $fields;
    }
}