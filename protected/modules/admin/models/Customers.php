<?php

/**
 * This is the model class for table "customers".
 *
 * The followings are the available columns in table 'customers':
 * @property string $id
 * @property string $name
 * @property integer $gender
 * @property string $date_of_birth
 * @property string $phone
 * @property string $email
 * @property integer $city_id
 * @property integer $district_id
 * @property integer $ward_id
 * @property string $street_id
 * @property string $house_numbers
 * @property string $address
 * @property integer $type_id
 * @property integer $career_id
 * @property string $user_id
 * @property integer $status
 * @property string $characteristics
 * @property string $created_by
 * @property string $created_date
 */
class Customers extends BaseActiveRecord
{
    public $autocomplete_name_user;
    public $autocomplete_name_street;
    public $agent;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Customers the static model class
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
		return 'customers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, date_of_birth, city_id, district_id', 'required'),
			array('gender, city_id, district_id, ward_id, type_id, career_id, status', 'numerical', 'integerOnly'=>true),
			array('name, house_numbers', 'length', 'max'=>255),
			array('phone, email', 'length', 'max'=>200),
			array('street_id, user_id, created_by', 'length', 'max'=>11),
			array('address, characteristics', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, gender, date_of_birth, phone, email, city_id, district_id, ward_id, street_id, house_numbers, address, type_id, career_id, user_id, status, characteristics, created_by, created_date', 'safe', 'on'=>'search'),
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
                    'rCity' => array(self::BELONGS_TO, 'Cities', 'city_id'),
                    'rDistrict' => array(self::BELONGS_TO, 'Districts', 'district_id'),
                    'rWard' => array(self::BELONGS_TO, 'Wards', 'ward_id'),
                    'rStreet' => array(self::BELONGS_TO, 'Streets', 'street_id'),
                    'rType' => array(self::BELONGS_TO, 'CustomerTypes', 'type_id'),
                    'rCareer' => array(self::BELONGS_TO, 'Careers', 'career_id'),
                    'rUser' => array(self::BELONGS_TO, 'Users', 'user_id'),
                    'rCreatedBy' => array(self::BELONGS_TO, 'Users', 'created_by'),
                    'rStreet' => array(self::BELONGS_TO, 'Streets', 'street_id'),
                    'rMedicalRecord' => array(
                        self::HAS_ONE, 'MedicalRecords', 'customer_id',
                        'on' => 'status = 1',
                    ),
                    'rJoinAgent' => array(
                        self::HAS_MANY, 'OneMany', 'many_id',
                        'on'    => 'type = ' . OneMany::TYPE_AGENT_CUSTOMER,
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
			'name' => DomainConst::CONTENT00100,
			'gender' => DomainConst::CONTENT00047,
			'date_of_birth' => DomainConst::CONTENT00101,
			'phone' => DomainConst::CONTENT00048,
			'email' => DomainConst::CONTENT00040,
			'city_id' => DomainConst::CONTENT00102,
			'district_id' => DomainConst::CONTENT00103,
			'ward_id' => DomainConst::CONTENT00104,
			'street_id' => DomainConst::CONTENT00105,
			'house_numbers' => DomainConst::CONTENT00106,
			'address' => DomainConst::CONTENT00045,
			'type_id' => DomainConst::CONTENT00107,
			'career_id' => DomainConst::CONTENT00099,
			'user_id' => DomainConst::CONTENT00008,
			'status' => DomainConst::CONTENT00026,
			'characteristics' => DomainConst::CONTENT00108,
			'created_by' => DomainConst::CONTENT00054,
			'created_date' => DomainConst::CONTENT00010,
                        'agent' => DomainConst::CONTENT00199,
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('date_of_birth',$this->date_of_birth,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('district_id',$this->district_id);
		$criteria->compare('ward_id',$this->ward_id);
		$criteria->compare('street_id',$this->street_id,true);
		$criteria->compare('house_numbers',$this->house_numbers,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('career_id',$this->career_id);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('characteristics',$this->characteristics,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('created_date',$this->created_date,true);
                $criteria->order = 'created_date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => Settings::getListPageSize(),
                        ),
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
        // Format birthday value
        $date = $this->date_of_birth;
        $this->date_of_birth = CommonProcess::convertDateTimeToMySqlFormat(
                $date, DomainConst::DATE_FORMAT_3);
        if (empty($this->date_of_birth)) {
            $this->date_of_birth = CommonProcess::convertDateTimeToMySqlFormat(
                        $date, DomainConst::DATE_FORMAT_4);
        }
        if (empty($this->date_of_birth)) {
            $this->date_of_birth = $date;
        }
        $this->address = CommonProcess::createAddressString(
                $this->city_id, $this->district_id,
                $this->ward_id, $this->street_id,
                $this->house_numbers);
        if ($this->isNewRecord) {   // Add
            // Handle created by
            if (empty($this->created_by)) {
                $this->created_by = $userId;
            }
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        } else {                    // Update
            
        }
        return parent::beforeSave();
    }
    
    /**
     * Override before delete method
     * @return Parent result
     */
    public function beforeDelete() {
        if (isset($this->rMedicalRecord)) {
            $this->rMedicalRecord->delete();
        }
        OneMany::deleteAllManyOldRecords($this->id, OneMany::TYPE_AGENT_CUSTOMER);
        return parent::beforeDelete();
    }

    //-----------------------------------------------------
    // Utility methods
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
            $_items[$model->id] = $model->name;
        }
        return $_items;
    }

    /**
     * Get autocomplete customer name
     * @return String [username - last_name first_name]
     */
    public function getAutoCompleteCustomerName() {
        $retVal = $this->name;
        $retVal .= ' - ' . $this->phone;
        $retVal .= ' -  SN: ' . $this->date_of_birth;
        return $retVal;
    }
    
    /**
     * Check if customer have schedule date
     * @return Id of treatment schedule (have not detail data), empty otherwise
     */
    public function getSchedule() {
        $retVal = '';
        // Get medical record info and treatment schedule info
        if (isset($this->rMedicalRecord) && isset($this->rMedicalRecord->rTreatmentSchedule)) {
            if (count($this->rMedicalRecord->rTreatmentSchedule) == 0) {
                // Have no any treatment schedule
                $retVal = '';
            } else { // #0
                // Get newest record
                $schedule = $this->rMedicalRecord->rTreatmentSchedule[0];
                // Status of schedule is Completed
                if ($schedule->status == TreatmentSchedules::STATUS_COMPLETED) {
                    $retVal = '';
                } else {
                    if (isset($schedule->rDetail)) {
                        if (count($schedule->rDetail) == 0) {                        
                            $retVal = '';
                        } else { // #0
                            if ($schedule->rDetail[0]->isSchedule()) {
                                return $schedule->rDetail[0]->id;
                            } else {
                                $retVal = '';
                            }
                        }
                    } else {
                        $retVal = '';
                    }
                }                
            }
        }
        return $retVal;
    }
    
    /**
     * Get value of id
     * @return String
     */
    public function getId() {
        $retVal = CommonProcess::generateID(DomainConst::CUSTOMER_ID_PREFIX, $this->id);
        return $retVal;
    }
    
    /**
     * Get name of agent
     * @return Name of agent
     */
    public function getAgentName() {
        if (isset($this->rJoinAgent) && count($this->rJoinAgent) > 0) {
            if (isset($this->rJoinAgent[0]->rAgent)) {
                return $this->rJoinAgent[0]->rAgent->name;
            }
        }
        return '';
    }
    
    /**
     * Get id of agent
     * @return Id of agent
     */
    public function getAgentId() {
        if (isset($this->rJoinAgent) && count($this->rJoinAgent) > 0) {
            if (isset($this->rJoinAgent[0]->rAgent)) {
                return $this->rJoinAgent[0]->rAgent->id;
            }
        }
        return '';
    }
    
    /**
     * Get birthday with format
     * @return String Birthday with format {01 thg 11, 2018}
     */
    public function getBirthday() {
        $date = CommonProcess::convertDateTime($this->date_of_birth,
                            DomainConst::DATE_FORMAT_4,
                            DomainConst::DATE_FORMAT_5);
        if (empty($date)) {
            $date = CommonProcess::convertDateTime($this->date_of_birth,
                            DomainConst::DATE_FORMAT_1,
                            DomainConst::DATE_FORMAT_5);
        }
        return $date;
    }
    
    /**
     * Get age of customer
     * $return String Age of customer
     */
    public function getAge() {
        $retVal = '0';
        $age = DateTime::createFromFormat(
                DomainConst::DATE_FORMAT_4,
                $this->date_of_birth);
        if ($age) {
            $retVal = $age->diff(new DateTime('now'))->y;
        }
        return $retVal . 't';
    }
    
    /**
     * Get phone value
     * @return String
     */
    public function getPhone() {
        return isset($this->phone) ? $this->phone : '';
    }
    
    /**
     * Get email value
     * @return String
     */
    public function getEmail() {
        return isset($this->email) ? $this->email : '';
    }
    
    /**
     * Get address value
     * @return String
     */
    public function getAddress() {
        return isset($this->address) ? $this->address : '';
    }
    
    /**
     * Get career value
     * @return String
     */
    public function getCareer() {
        return isset($this->rCareer) ? $this->rCareer->name : '';
    }
    
    /**
     * Get characteristics value
     * @return String
     */
    public function getCharacteristics() {
        return isset($this->characteristics) ? $this->characteristics : '';
    }
    
    /**
     * Get record number value
     * @return String
     */
    public function getMedicalRecordNumber() {
        return isset($this->rMedicalRecord) ? $this->rMedicalRecord->record_number : '';
    }
    
    /**
     * Get customer ajax info
     * @return string
     */
    public function getCustomerAjaxInfo() {
        $recordNumber = '';
        if (isset($this->rMedicalRecord)) {
            $recordNumber = $this->rMedicalRecord->record_number;
        }
        $rightContent = '<div class="info-result">';
        $rightContent .=    '<div class="title-2">' . DomainConst::CONTENT00173 . '</div>';
        $rightContent .=    '<div class="item-search">';
        $rightContent .=        '<table>';
        $rightContent .=            '<tr>';
        $rightContent .=                '<td>' . DomainConst::CONTENT00100 . ': ' . '<b>' . $this->name . '<b>' . '</td>';
        $rightContent .=                '<td>' . DomainConst::CONTENT00101 . ': ' . '<b>' . $this->getBirthday() . '<b>' . '</td>';
        $rightContent .=            '</tr>';
        $rightContent .=            '<tr>';
        $rightContent .=                '<td>' . DomainConst::CONTENT00170 . ': ' . '<b>' . $this->getPhone() . '<b>' . '</td>';
        $rightContent .=                '<td>' . DomainConst::CONTENT00047 . ': ' . '<b>' . CommonProcess::getGender()[$this->gender] . '<b>' . '</td>';
        $rightContent .=            '</tr>';
        $rightContent .=            '<tr>';
        $rightContent .=                '<td colspan="2">' . DomainConst::CONTENT00045 . ': ' . '<b>' . $this->getAddress() . '<b>' . '</td>';
        $rightContent .=            '</tr>';
        $rightContent .=            '<tr>';
        $rightContent .=                '<td>' . '<b>' . $this->getAgentName() . '<b>' . '</td>';
        $rightContent .=                '<td>' . DomainConst::CONTENT00136 . ': ' . '<b>' . $recordNumber . '<b>' . '</td>';
        $rightContent .=            '</tr>';
        $pathological = '';
        if (isset($this->rMedicalRecord)) {
            $pathological = $this->rMedicalRecord->generateMedicalHistory(", ");
            Settings::saveAjaxTempValue($this->rMedicalRecord->id);
        }
        if (!empty($pathological)) {
            $rightContent .=        '<tr>';
            $rightContent .=            '<td colspan="2">' . DomainConst::CONTENT00137 . ': ' . '<b>' . $pathological . '<b>' . '</td>';
            $rightContent .=        '</tr>';
        }                
        $rightContent .=        '</table>';
        $rightContent .=    '</div>';
        $rightContent .=    '<div class="title-2">' . DomainConst::CONTENT00174 . '</div>';
        $rightContent .=    '<div class="item-search">';                
        if (isset($this->rMedicalRecord) && isset($this->rMedicalRecord->rTreatmentSchedule)) {
            $i = count($this->rMedicalRecord->rTreatmentSchedule);
            foreach ($this->rMedicalRecord->rTreatmentSchedule as $schedule) {
                if ($schedule->rPathological) {
                    $rightContent .= '<p>Đợt ' . $i . ': ' . $schedule->rPathological->name . '</p>';
                }
                $i--;
            }
        }
        $rightContent .=    '</div>';
        $rightContent .= '</div>';
        return $rightContent;
    }
    
    /**
     * Get customer ajax schedule information
     * @return string
     */
    public function getCustomerAjaxScheduleInfo() {
        $infoSchedule = '';
        $scheduleId = $this->getSchedule();

        $infoSchedule .= '<div class="group-btn">';
        $infoSchedule .=    '<a style="cursor: pointer;"'
//        $infoSchedule .=    '<a style="cursor: pointer;" href="'
                        . ' onclick="{createSchedule(); $(\'#dialogUpdateSchedule\').dialog(\'open\');}">' . DomainConst::CONTENT00179 . '</a>';
//                        . Yii::app()->createAbsoluteUrl("front/receptionist/createScheduleExt") . '">' . DomainConst::CONTENT00179 . '</a>';
        $infoSchedule .= '</div>';
        if (!empty($scheduleId)) {
            Settings::saveAjaxTempValue($scheduleId);
            $mSchedule = TreatmentScheduleDetails::model()->findByPk($scheduleId);
            if ($mSchedule) {
                $infoSchedule = '<div class="title-2">' . DomainConst::CONTENT00177 . ': </div>';
                $infoSchedule .= '<div class="item-search">';
//                $infoSchedule .=    '<p>' . $mSchedule->start_date . '</p>';
                $infoSchedule .=    '<p>' . $mSchedule->getStartTime() . '</p>';
                $infoSchedule .=    '<p>' . DomainConst::CONTENT00260 . ': ' . $mSchedule->rSchedule->getInsurrance() . '</p>';
                $infoSchedule .=    '<p>Chi Tiết Công Việc: ' . $mSchedule->description . '</p>';
                $infoSchedule .=    '<p>Bác sĩ: ' . $mSchedule->getDoctor() . '</p>';
                $infoSchedule .= '</div>';
                $infoSchedule .= '<div class="group-btn">';
                $infoSchedule .=    '<a style="cursor: pointer;"'
                        . ' onclick="{updateSchedule(); $(\'#dialogUpdateSchedule\').dialog(\'open\');}">' . DomainConst::CONTENT00264 . '</a>';
                $infoSchedule .= '</div>';
            }
        }
        return $infoSchedule;
    }

    //-----------------------------------------------------
    // JSON methods
    //-----------------------------------------------------
    /**
     * Get medical history
     * @return String
     *  [
     *      {
     *          id:"1",
     *          name:"Tiểu đường",
     *      },
     *      {
     *          id:"2",
     *          name:"Chảy máu răng",
     *      }
     *      {
     *          id:"3",
     *          name:"Đang mang thai",
     *      },
     *  ]
     */
    public function getMedicalHistory() {
        $retVal = array();
        if (isset($this->rMedicalRecord)) {
            foreach ($this->rMedicalRecord->rJoinPathological as $item) {
                if (isset($item->rPathological)) {
                    $retVal[] = CommonProcess::createConfigJson(
                            $item->rPathological->id,
                            $item->rPathological->name);
                }
            }
        }
        return $retVal;
    }
    
    /**
     * Get 3 of last record TreatmentSchedules
     * @return String
     *  [
     *      {
     *          id:"1",
     *          name:"Chảy máu răng",
     *          data:{,
     *              start_date:"01/12/2017",
     *              end_date:"02/12/2017",
     *              diagnosis:"Tật không răng một phần"
     *          }
     *      },
     *      {
     *          id:"2",
     *          name:"Chảy máu răng",
     *          data:{,
     *              start_date:"01/12/2017",
     *              end_date:"02/12/2017",
     *              diagnosis:"Tật không răng một phần"
     *          }
     *      }
     *      {
     *          id:"3",
     *          name:"Đang mang thai",
     *          data:{,
     *              start_date:"01/12/2017",
     *              end_date:"02/12/2017",
     *              diagnosis:"Tật không răng một phần"
     *          }
     *      },
     *  ]
     */
    public function getTreatmentHistory() {
        $retVal = array();
        $count = 0;
        if (isset($this->rMedicalRecord)) {
            $mMedicalRecord = $this->rMedicalRecord;
            if (isset($mMedicalRecord->rTreatmentSchedule)) {
                foreach ($mMedicalRecord->rTreatmentSchedule as $schedule) {
//                    $pathological = isset($schedule->rPathological) ? $schedule->rPathological->name : '';
//                    $diagnosis = isset($schedule->rDiagnosis) ? $schedule->rDiagnosis->name : '';
//                    $retVal[] = CommonProcess::createConfigJson(
//                            $schedule->id,
//                            $pathological,
//                            array(
//                                DomainConst::KEY_START_DATE => CommonProcess::convertDateTimeWithFormat(
//                                        $schedule->start_date),
//                                DomainConst::KEY_END_DATE => CommonProcess::convertDateTimeWithFormat(
//                                        $schedule->end_date),
//                                DomainConst::KEY_DIAGNOSIS => $diagnosis,
//                            ));
                    $retVal[] = $schedule->getJsonTreatmentInfo();
                    $count++;
                    if ($count >= 3) {
                        $retVal[] = CommonProcess::createConfigJson(
                                CustomerController::ITEM_UPDATE_DATE,
                                DomainConst::CONTENT00230);
                        return $retVal;
                    }
                }
            }
        }
        $retVal[] = CommonProcess::createConfigJson(
                CustomerController::ITEM_UPDATE_DATE,
                DomainConst::CONTENT00230);
        
        return $retVal;
    }
    
    /**
     * List api return
     * @param Array $root Root value
     * @param Obj $mUser User object
     * @return CActiveDataProvider
     */
    public function apiList($root, $mUser) {
        $criteria = new CDbCriteria();
        $criteria->compare('t.status', DomainConst::DEFAULT_STATUS_ACTIVE);
//        $criteria->order = 't.id DESC';
        $criteria->order = 't.created_date DESC';
        // Set condition
        $roleName = isset($mUser->rRole) ? $mUser->rRole->role_name : '';
        switch ($roleName) {
            case Roles::ROLE_DOCTOR:
                $today = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_6);
                $from = isset($root->date_from) ? $root->date_from : $today;
                $to = isset($root->date_to) ? $root->date_to : $today;
                if ($mUser->isTestUser()) {
                    $from = '2018/01/01';
                    $to = '2018/12/01';
                }
                // Get list customers assign at doctor
                $criteria->addInCondition('t.id', $mUser->getListCustomerOfDoctor($from, $to));
                break;

            default:
                break;
        }
        
        // Get return value
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
}