<?php

/**
 * This is the model class for table "treatment_schedules".
 *
 * The followings are the available columns in table 'treatment_schedules':
 * @property string $id
 * @property string $record_id
 * @property integer $time_id
 * @property string $start_date
 * @property string $end_date
 * @property integer $diagnosis_id
 * @property integer $pathological_id
 * @property string $doctor_id
 * @property string $created_date
 * @property string $created_by
 * @property integer $status
 */
class TreatmentSchedules extends BaseActiveRecord
{
    //-----------------------------------------------------
    // Autocomplete fields
    //-----------------------------------------------------
    public $autocomplete_medical_record;
    public $autocomplete_name_doctor;
    
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const STATUS_INACTIVE               = 0;
    const STATUS_ACTIVE                 = 1;
    const STATUS_SCHEDULE               = 2;
    const STATUS_COMPLETED              = 3;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TreatmentSchedules the static model class
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
		return 'treatment_schedules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('record_id, time_id, start_date, doctor_id', 'required'),
			array('time_id, diagnosis_id, pathological_id, status', 'numerical', 'integerOnly'=>true),
			array('record_id, doctor_id, created_by', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, record_id, time_id, start_date, end_date, diagnosis_id, pathological_id, doctor_id, created_date, created_by, status', 'safe', 'on'=>'search'),
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
                    'rMedicalRecord' => array(self::BELONGS_TO, 'MedicalRecords', 'record_id'),
                    'rDiagnosis' => array(self::BELONGS_TO, 'Diagnosis', 'diagnosis_id'),
                    'rPathological' => array(self::BELONGS_TO, 'Pathological', 'pathological_id'),
                    'rDoctor' => array(self::BELONGS_TO, 'Users', 'doctor_id'),
                    'rJoinPathological' => array(
                        self::HAS_MANY, 'OneMany', 'one_id',
                        'on'    => 'type = ' . OneMany::TYPE_TREATMENT_SCHEDULES_PATHOLOGICAL,
                    ),
                    'rDetail' => array(
                        self::HAS_MANY, 'TreatmentScheduleDetails', 'schedule_id',
                        'on'    => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
                        'order' => 'id DESC',
                    ),
                    'rTime' => array(
                        self::BELONGS_TO, 'ScheduleTimes', 'time_id'
                    ),
                    'rCreatedBy' => array(
                        self::BELONGS_TO, 'Users', 'created_by'
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
			'record_id' => DomainConst::CONTENT00138,
			'time_id' => DomainConst::CONTENT00240,
			'start_date' => DomainConst::CONTENT00139,
			'end_date' => DomainConst::CONTENT00140,
			'diagnosis_id' => DomainConst::CONTENT00121,
			'pathological_id' => DomainConst::CONTENT00141,
			'doctor_id' => DomainConst::CONTENT00143,
			'created_date' => DomainConst::CONTENT00010,
			'created_by' => DomainConst::CONTENT00054,
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
		$criteria->compare('record_id',$this->record_id,true);
		$criteria->compare('time_id',$this->time_id);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('diagnosis_id',$this->diagnosis_id);
		$criteria->compare('pathological_id',$this->pathological_id);
		$criteria->compare('doctor_id',$this->doctor_id,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by,true);
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
        $userId = isset(Yii::app()->user) ? Yii::app()->user->id : '';
        // Format start date value
        $date = $this->start_date;
        $this->start_date = CommonProcess::convertDateTimeToMySqlFormat(
                $date, DomainConst::DATE_FORMAT_3);
        if (empty($this->start_date)) {
            $this->start_date = CommonProcess::convertDateTimeToMySqlFormat(
                    $date, DomainConst::DATE_FORMAT_4);
        }
//        if (empty($this->start_date)) {
//            $this->start_date = CommonProcess::convertDateTime($date, DomainConst::DATE_FORMAT_1, $toFormat)
//        }
        if (empty($this->start_date)) {
            $this->start_date = $date;
        }
        
//        CommonProcess::dumpVariable($this->start_date);
        // Format end date value
        $date = $this->end_date;
        $this->end_date = CommonProcess::convertDateTimeToMySqlFormat(
                $date, DomainConst::DATE_FORMAT_3);
        if (empty($this->end_date)) {
            // Handle when create by receiptionist
            $this->end_date = $this->start_date;
        }
        if ($this->isNewRecord) {   // Add
            // Handle created by
            if (empty($this->created_by)) {
                $this->created_by = $userId;
            }
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
     * @return Parent result
     */
    public function beforeDelete() {
        OneMany::deleteAllOldRecords($this->id, OneMany::TYPE_TREATMENT_SCHEDULES_PATHOLOGICAL);
        if (isset($this->rDetail)) {
            foreach ($this->rDetail as $detail) {
                $detail->delete();
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
     * Get pathological
     * @return String Pathological
     */
    public function getPathological() {
        return isset($this->rPathological) ? $this->rPathological->name : '';
    }

    /**
     * Generate Healthy condition string
     * @return String Healthy condition string
     */
    public function generateHealthy($spliter = "<br>") {
        $array = array();
        foreach ($this->rJoinPathological as $item) {
            if (isset($item->rPathological)) {
                $array[] = $item->rPathological->name;
            }
        }
        return implode($spliter, $array);
    }
    
    /**
     * Get details list
     * @return CArrayDataProvider
     */
    public function getDetails() {
        return new CArrayDataProvider(
                $this->rDetail,
                array(
                    'id'        => 'treatment_schedule_details',
                    'sort'      => array(
                        'attributes'    => array(
                            'id', 'schedule_id', 'start_date', 'end_date', 'teeth_id', 'diagnosis_id', 'treatment_type_id', 'status',
                        ),
                    ),
                    'pagination'=>array(
                        'pageSize'=>Settings::getListPageSize(),
                    ),
                )
            );
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
    
    /**
     * Get status of treatment schedule
     * @return STATUS_COMPLETED in case all treatment schedule details are
     * Completed or Inactive, False otherwise
     */
    public function getCurrentStatus() {
        $retVal = $this->status;
        $isCompleted = true;
        if (isset($this->rDetail)) {
            foreach ($this->rDetail as $key => $value) {
                if (($value->status != TreatmentScheduleDetails::STATUS_COMPLETED)
                        && ($value->status != TreatmentScheduleDetails::STATUS_INACTIVE)) {
                    $isCompleted = false;
                    break;
                }
            }
        } else {
            $isCompleted = false;
        }
        if ($isCompleted) {
            $retVal = strval(TreatmentSchedules::STATUS_COMPLETED);
        }
        
        return $retVal;
    }
    
    /**
     * Get customer id
     * @return string Customer id, empty string if failed
     */
    public function getCustomer() {
        if (isset($this->rMedicalRecord) && isset($this->rMedicalRecord->rCustomer)) {
            return $this->rMedicalRecord->rCustomer->id;
        }
        return '';
    }
    
    /**
     * Get customer model
     * @return Customer model, or NULL
     */
    public function getCustomerModel() {
        if (isset($this->rMedicalRecord)) {
            return $this->rMedicalRecord->rCustomer;
        }
        return NULL;
    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Loads the application items for the specified type from the database
     * @param type $emptyOption boolean the item is empty
     * @return type List data
     */
    public static function loadItems($emptyOption = false) {
        $_items = array();
        if ($emptyOption) {
            $_items[""] = "";
        }
        $models = self::model()->findAll(array(
            'order' => 'id ASC',
        ));
        foreach ($models as $model) {
            if ($model->status == DomainConst::DEFAULT_STATUS_ACTIVE) {
                $_items[$model->id] = $model->id;
            }
        }
        return $_items;
    }
    /**
     * Loads the application items for the specified type from the database
     * @param type $emptyOption boolean the item is empty
     * @return type List data
     */
    public static function loadItemsByRecordId($recordId, $emptyOption = false) {
        $_items = array();
        if ($emptyOption) {
            $_items[""] = "";
        }
        $models = self::model()->findAll(array(
            'order' => 'id ASC',
        ));
        foreach ($models as $model) {
            if (($model->status != DomainConst::DEFAULT_STATUS_INACTIVE)
                && ($model->record_id == $recordId)) {
                $_items[$model->id] = $model->id;
            }
        }
        return $_items;
    }
    
    /**
     * Get list status of treatment schedule object
     * @return Array
     */
    public static function getStatus() {
        return array(
            TreatmentSchedules::STATUS_INACTIVE  => DomainConst::CONTENT00028,
            TreatmentSchedules::STATUS_ACTIVE    => DomainConst::CONTENT00027,
            TreatmentSchedules::STATUS_SCHEDULE  => DomainConst::CONTENT00177,
            TreatmentSchedules::STATUS_COMPLETED => DomainConst::CONTENT00204,
        );
    }

    //-----------------------------------------------------
    // JSON methods
    //-----------------------------------------------------
    /**
     * List api return
     * @param Array $root   Root value
     * @param Obj $mUser    User object
     * @return CActiveDataProvider
     */
    public function apiList($root, $mUser) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.status!=" . DomainConst::DEFAULT_STATUS_INACTIVE);
        $criteria->order = 't.id DESC';
        // Set condition
        $mCustomer = Customers::model()->findByPk($root->id);
        if ($mCustomer) {
            if (isset($mCustomer->rMedicalRecord)) {
                $criteria->addCondition('t.record_id=' . $mCustomer->rMedicalRecord->id);
            }
        }
        $retVal = new CActiveDataProvider(
                $this,
                array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Settings::getApiListPageSize(),
                        'currentPage' => (int)$root->page,
                    ),
                ));
        return $retVal;
    }
    
    /**
     * Get treatment info in Json format
     * @return String
     *      {
     *          id:"1",
     *          name:"Chảy máu răng",
     *          data:{,
     *              start_date:"01/12/2017",
     *              end_date:"02/12/2017",
     *              diagnosis:"Tật không răng một phần"
     *          }
     *      }
     */
    public function getJsonTreatmentInfo() {
        $pathological = $this->getPathological();
        if (empty($pathological)) {
            $pathological = DomainConst::CONTENT00177;
        }
        $diagnosis = $this->getDiagnosis();
        return CommonProcess::createConfigJson(
                $this->id,
                $pathological,
                array(
//                    DomainConst::KEY_START_DATE => CommonProcess::convertDateTimeWithFormat(
//                            $this->start_date),
//                    DomainConst::KEY_START_DATE => $this->getStartTime(),
                    DomainConst::KEY_START_DATE => CommonProcess::convertDateTime(
                            $this->start_date,
                            DomainConst::DATE_FORMAT_1,
                            DomainConst::DATE_FORMAT_VIEW),
                    DomainConst::KEY_END_DATE => CommonProcess::convertDateTimeWithFormat(
                            $this->end_date),
                    DomainConst::KEY_DIAGNOSIS => $diagnosis,
//                    DomainConst::KEY_STATUS     => $this->status,
                    DomainConst::KEY_STATUS     => $this->getCurrentStatus(),
                ));
    }
    
    /**
     * Get treatment detail info in Json format
     * @param Array $role   Role name
     * @return String
     *      {
     *          id:"1",
     *          start_date:"01/12/2017",								
     *          end_date:"02/12/2017",								
     *          diagnosis:"Tật không răng",								
     *          pathological:"Cạo vôi răng",								
     *          doctor:"Nguyễn Văn Nam",								
     *          healthy:"Cảm sốt",								
     *          status:"1",								
     *          details:[								
     *              {							
     *   		id:"6",						
     *   		start_date:"01/12/2017",						
     *   		end_date:"02/12/2017",						
     *   		diagnosis:"Răng thừa".						
     *   		teeth:"1",						
     *   		treatment:"Điều trị nha chu",						
     *   		description:"Mô tả",						
     *   		status:"1",						
     *   		type:"Tái khám"						
     *              },							
     *              ...							
     *          ]
     *      }
     */
    public function getJsonTreatmentDetail($role) {
        $retVal = array();
//        $retVal[DomainConst::KEY_ID]                    = $this->id;
//        $retVal[DomainConst::KEY_START_DATE]            = CommonProcess::convertDateTimeWithFormat($this->start_date);
//        $retVal[DomainConst::KEY_END_DATE]              = CommonProcess::convertDateTimeWithFormat($this->end_date);
//        $retVal[DomainConst::KEY_DIAGNOSIS]             = $this->getDiagnosis();
//        $retVal[DomainConst::KEY_PATHOLOGICAL]          = $this->getPathological();
//        $retVal[DomainConst::KEY_DOCTOR]                = isset($this->rDoctor) ? $this->rDoctor->getFullName() : '';
//        $retVal[DomainConst::KEY_HEALTHY]               = $this->generateHealthy(', ');
//        $retVal[DomainConst::KEY_STATUS]                = $this->status;
        $details = array();
        foreach ($this->rDetail as $detail) {
            if ($detail->status != DomainConst::DEFAULT_STATUS_INACTIVE) {
//                $details[] = array(
//                    DomainConst::KEY_ID             => $detail->id,
//                    DomainConst::KEY_START_DATE     => CommonProcess::convertDateTimeWithFormat($detail->start_date),
//                    DomainConst::KEY_END_DATE       => CommonProcess::convertDateTimeWithFormat($detail->end_date),
//                    DomainConst::KEY_DIAGNOSIS      => $detail->getDiagnosis(),
//                    DomainConst::KEY_TEETH          => $detail->getTeeth(),
//                    DomainConst::KEY_TREATMENT      => $detail->getTreatment(),
//                    DomainConst::KEY_NOTE           => $detail->description,
//                    DomainConst::KEY_STATUS         => $detail->status,
//                    DomainConst::KEY_TYPE           => $detail->type_schedule,
//                );
//                $info = array();
//                $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_ID,
//                        DomainConst::CONTENT00003,
//                        $detail->id);
//                $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_START_DATE,
//                        DomainConst::CONTENT00139,
//                        CommonProcess::convertDateTimeWithFormat($detail->start_date));
//                $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_END_DATE,
//                        DomainConst::CONTENT00140,
//                        CommonProcess::convertDateTimeWithFormat($detail->end_date));
//                $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_DIAGNOSIS,
//                        DomainConst::CONTENT00231,
//                        $detail->getDiagnosis());
//                $retVal[] = CommonProcess::createConfigJson(CustomerController::ITEM_DIAGNOSIS_ID,
//                        '',
//                        $detail->diagnosis_id);
//                $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_TEETH,
//                        DomainConst::CONTENT00145,
//                        $detail->getTeeth());
//                $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_TEETH_ID,
//                        '',
//                        $detail->teeth_id);
//                $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_TREATMENT,
//                        DomainConst::CONTENT00128,
//                        $detail->getTreatment());
//                $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_TREATMENT_TYPE_ID,
//                        '',
//                        $detail->treatment_type_id);
//                $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_NOTE,
//                        DomainConst::CONTENT00207,
//                        $detail->description);
//                $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_STATUS,
//                        DomainConst::CONTENT00026,
//                        $detail->status);
//                $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_TYPE,
//                        DomainConst::CONTENT00206,
//                        $detail->type_schedule);
//                $processArr = array();
//                foreach ($detail->rProcess as $process) {
//                    if ($process->status != DomainConst::DEFAULT_STATUS_INACTIVE) {
//                        $processInfo = array();
//                        $processArr[] = CommonProcess::createConfigJson(
//                                $process->id, $process->name, $processInfo);
//                    }
//                }
//                $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_CAN_UPDATE,
//                    DomainConst::CONTENT00232,
//                    $detail->status != TreatmentScheduleDetails::STATUS_COMPLETED
//                    ? DomainConst::NUMBER_ONE_VALUE : DomainConst::NUMBER_ZERO_VALUE);
//                
//                $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_DETAILS,
//                        DomainConst::CONTENT00233,
//                        $processArr);
                $details[] = CommonProcess::createConfigJson(
//                        CommonProcess::convertDateTimeWithFormat($detail->start_date),
                        $detail->getStartTime(),
                        $detail->getTreatment(),
                        $detail->getJsonInfo());
            }
        }
//        $retVal[DomainConst::KEY_DETAILS]               = $details;
//        $retVal[DomainConst::KEY_CAN_UPDATE]            = $this->status != TreatmentSchedules::STATUS_COMPLETED
//                ? DomainConst::NUMBER_ONE_VALUE : DomainConst::NUMBER_ZERO_VALUE;
        
        $retVal[] = CommonProcess::createConfigJson(CustomerController::ITEM_START_DATE,
                DomainConst::CONTENT00139,
//                CommonProcess::convertDateTimeWithFormat($this->start_date));
                CommonProcess::convertDateTime($this->start_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_VIEW));
        $retVal[] = CommonProcess::createConfigJson(CustomerController::ITEM_END_DATE,
                DomainConst::CONTENT00140,
                CommonProcess::convertDateTimeWithFormat($this->end_date));
        $retVal[] = CommonProcess::createConfigJson(CustomerController::ITEM_PATHOLOGICAL,
                DomainConst::CONTENT00237,
                $this->getPathological());
        $retVal[] = CommonProcess::createConfigJson(CustomerController::ITEM_PATHOLOGICAL_ID,
                '',
                $this->pathological_id);
        $retVal[] = CommonProcess::createConfigJson(CustomerController::ITEM_DIAGNOSIS,
                DomainConst::CONTENT00231,
                $this->getDiagnosis());
        $retVal[] = CommonProcess::createConfigJson(CustomerController::ITEM_DIAGNOSIS_ID,
                '',
                $this->diagnosis_id);
        
        switch ($role) {
            case Roles::ROLE_DOCTOR:
                break;
            default:
                $retVal[] = CommonProcess::createConfigJson(CustomerController::ITEM_DOCTOR,
                DomainConst::CONTENT00143,
                isset($this->rDoctor) ? $this->rDoctor->getFullName() : '');
                break;
        }
        
        $retVal[] = CommonProcess::createConfigJson(CustomerController::ITEM_HEALTHY,
                DomainConst::CONTENT00142,
                $this->generateJsonHealthy());
        $retVal[] = CommonProcess::createConfigJson(CustomerController::ITEM_STATUS,
                DomainConst::CONTENT00026,
                $this->status);
        if (empty($details)) {
            $detail = new TreatmentScheduleDetails();
            $details[] = CommonProcess::createConfigJson(
                        CommonProcess::convertDateTimeWithFormat($detail->start_date),
                        $detail->getTreatment(),
                        $detail->getJsonInfo());
        }
        $retVal[] = CommonProcess::createConfigJson(CustomerController::ITEM_DETAILS,
                DomainConst::CONTENT00146,
                $details);
        $retVal[] = CommonProcess::createConfigJson(CustomerController::ITEM_CAN_UPDATE,
                DomainConst::CONTENT00232,
                $this->status != TreatmentSchedules::STATUS_COMPLETED
                ? DomainConst::NUMBER_ONE_VALUE : DomainConst::NUMBER_ZERO_VALUE);
        return $retVal;
    }
    
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
        foreach (TreatmentSchedules::getStatus() as $key => $value) {
            $retVal[] = CommonProcess::createConfigJson($key, $value);
        }
        return $retVal;
    }

    /**
     * Generate Healthy condition json string
     * @return String Healthy condition string
     */
    public function generateJsonHealthy() {
        $retVal = array();
        foreach ($this->rJoinPathological as $item) {
            if (isset($item->rPathological)) {
                $retVal[] = CommonProcess::createConfigJson(
                        $item->rPathological->id,
                        $item->rPathological->name);
            }
        }
        return $retVal;
    }
}