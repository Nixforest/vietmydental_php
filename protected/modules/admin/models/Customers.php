<?php

/**
 * This is the model class for table "customers".
 *
 * The followings are the available columns in table 'customers':
 * @property string $id                 Id of record
 * @property string $name               Name of customer
 * @property integer $gender            Gender
 * @property string $date_of_birth      Birthday
 * @property string $year_of_birth      Year of birth
 * @property string $phone              Phone
 * @property string $email              Email
 * @property integer $city_id           Id of city
 * @property integer $district_id       Id of district
 * @property integer $ward_id           Id of ward
 * @property string $street_id          Id of street
 * @property string $house_numbers      House number
 * @property string $address            Address
 * @property integer $type_id           Id of type
 * @property integer $career_id         Id career
 * @property string $user_id            Id of user account
 * @property string $debt               Debt
 * @property integer $status            Status
 * @property string $characteristics    Characteristics
 * @property string $created_by         Created by
 * @property string $created_date       Created date
 * 
 * The followings are the available model relations:
 * @property Cities                 $rCity              City of customer
 * @property Districts              $rDistrict          District of customer
 * @property Users                  $rCreatedBy         User created this record
 * @property MedicalRecords         $rMedicalRecord     Medical record
 * @property ReferCodes             $rReferCode         Refer code model
 */
class Customers extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = '0';
    /** Active */
    const STATUS_ACTIVE                 = '1';
    /** New */
    const STATUS_NEW                    = '2';

    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $autocomplete_name_user;
    public $autocomplete_name_street;
    public $agent;
    public $referCode;
    public $autocomplete_name_refercode;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Customers the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'customers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //++ BUG0041-IMT (DuongNV 20180725) Un required district when create patient
//			array('name, city_id, district_id', 'required'),
            array('name, city_id', 'required'),
            //-- BUG0041-IMT (DuongNV 20180725) Un required district when create patient
            array('gender, city_id, district_id, ward_id, type_id, career_id, status', 'numerical', 'integerOnly' => true),
            array('name, house_numbers', 'length', 'max' => 255),
            array('year_of_birth', 'length', 'max' => 4),
            array('phone, email', 'length', 'max' => 200),
            array('street_id, user_id, created_by', 'length', 'max' => 11),
            array('debt', 'length', 'max' => 10),
            array('date_of_birth, address, characteristics', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, gender, date_of_birth, year_of_birth, phone, email, city_id, district_id, ward_id, street_id, house_numbers, address, type_id, career_id, user_id, status, characteristics, created_by, created_date', 'safe', 'on' => 'search'),
            array('type_id', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
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
                'on' => 'type = ' . OneMany::TYPE_AGENT_CUSTOMER,
            ),
            'rReferCode' => array(
                self::HAS_ONE, 'ReferCodes', 'object_id',
                'on' => 'type = ' . ReferCodes::TYPE_CUSTOMER . ' AND status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
                'order' => 'id desc',
            ),
            'rSocialNetwork' => array(
                self::HAS_MANY, 'SocialNetworks', 'object_id',
                'on' => 'type = ' . SocialNetworks::TYPE_CUSTOMER,
            ),
            'rWarranty' => array(self::HAS_MANY, 'Warranties', 'customer_id',
                'on' => 'status!=' . DomainConst::DEFAULT_STATUS_INACTIVE,
                'order' => 'id ASC',
            ),
            'rAgents' => array(self::MANY_MANY, 'Agents', 'one_many(many_id,one_id)',
                'condition' => 'rAgents_rAgents.type = ' . OneMany::TYPE_AGENT_CUSTOMER,
                'order' => 'rAgents_rAgents.id DESC'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'                => DomainConst::CONTENT00389,
            'name'              => DomainConst::CONTENT00100,
            'gender'            => DomainConst::CONTENT00047,
            'date_of_birth'     => DomainConst::CONTENT00101,
            'year_of_birth'     => DomainConst::CONTENT00368,
            'phone'             => DomainConst::CONTENT00048,
            'email'             => DomainConst::CONTENT00040,
            'city_id'           => DomainConst::CONTENT00102,
            'district_id'       => DomainConst::CONTENT00103,
            'ward_id'           => DomainConst::CONTENT00104,
            'street_id'         => DomainConst::CONTENT00105,
            'house_numbers'     => DomainConst::CONTENT00106,
            'address'           => DomainConst::CONTENT00045,
            'type_id'           => DomainConst::CONTENT00107,
            'career_id'         => DomainConst::CONTENT00099,
            'user_id'           => DomainConst::CONTENT00008,
            'debt'              => DomainConst::CONTENT00300,
            'status'            => DomainConst::CONTENT00026,
            'characteristics'   => DomainConst::CONTENT00108,
            'created_by'        => DomainConst::CONTENT00054,
            'created_date'      => DomainConst::CONTENT00010,
            'agent'             => DomainConst::CONTENT00199,
            'referCode'         => DomainConst::CONTENT00271,
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('gender', $this->gender);
        $criteria->compare('date_of_birth', $this->date_of_birth, true);
        $criteria->compare('year_of_birth', $this->year_of_birth, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('district_id', $this->district_id);
        $criteria->compare('ward_id', $this->ward_id);
        $criteria->compare('street_id', $this->street_id, true);
        $criteria->compare('house_numbers', $this->house_numbers, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('career_id', $this->career_id);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('debt', $this->debt, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('characteristics', $this->characteristics, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->order = 'created_date DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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
                        $this->city_id, $this->district_id, $this->ward_id, $this->street_id, $this->house_numbers);
        if ($this->isNewRecord) {   // Add
            // Handle created by
            if (empty($this->created_by)) {
                $this->created_by = $userId;
            }
            // Handle created date
            if (empty($this->created_date)) {
                $this->created_date = CommonProcess::getCurrentDateTime();
            }
        } else {                    // Update
        }
        return parent::beforeSave();
    }

    /**
     * Override before delete method
     * @return Parent result
     */
    public function beforeDelete() {
        // Handle relation
        if (isset($this->rMedicalRecord)) {
            $this->rMedicalRecord->delete();
        }
        if (isset($this->rReferCode)) {
            $this->rReferCode->delete();
        }
        if (isset($this->rWarranty)) {
            foreach ($this->rWarranty as $warranty) {
                $warranty->delete();
            }
        }
        // Handle Agent relation
        OneMany::deleteAllManyOldRecords($this->id, OneMany::TYPE_AGENT_CUSTOMER);
        // Handle Social network relation
        SocialNetworks::deleteAllOldRecord($this->id, SocialNetworks::TYPE_CUSTOMER);
        Loggers::info("Deleted " . get_class($this) . " with id = $this->id.", __FUNCTION__, __LINE__);
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
     * Get auto complete customer name
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
    public function getSchedule($isActive = true) {
        $retVal = '';
        // Get medical record info and treatment schedule info
        if (isset($this->rMedicalRecord) && isset($this->rMedicalRecord->rTreatmentSchedule)) {
            if (count($this->rMedicalRecord->rTreatmentSchedule) == 0) {
                // Have no any treatment schedule
                $retVal = '';
            } else { // #0
                // Get newest record
                $schedule = $this->rMedicalRecord->rTreatmentSchedule[0];
                if ($isActive && ($schedule->status == TreatmentSchedules::STATUS_COMPLETED)) {
//                // Status of schedule is Completed
//                if ($schedule->status == TreatmentSchedules::STATUS_COMPLETED) {
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
        $retVal = '';

        if (empty($retVal) && !DateTimeExt::isDateNull($this->date_of_birth)) {
            $date = CommonProcess::convertDateTime($this->date_of_birth, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_5);
            if (empty($date)) {
                $date = CommonProcess::convertDateTime($this->date_of_birth, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_5);
            }
            $retVal = $date;
        }
        if (empty($retVal) && !DateTimeExt::isYearNull($this->year_of_birth)) {
            $retVal = $this->year_of_birth;
        }

        return $retVal;
    }

    /**
     * Get birth year
     * @return String Birthday with format {2018}
     */
    public function getBirthYear() {
        $retVal = '';
        if (!DateTimeExt::isDateNull($this->date_of_birth)) {
            $retVal = CommonProcess::convertDateTime($this->date_of_birth, DomainConst::DATE_FORMAT_4, 'Y');
        } else if (!DateTimeExt::isYearNull($this->year_of_birth)) {
            $retVal = $this->year_of_birth;
        }


        return $retVal;
    }

    /**
     * Get age of customer
     * $return String Age of customer
     */
    public function getAge() {
        $retVal = '0';
        $age = '';
        if (!DateTimeExt::isDateNull($this->date_of_birth)) {
            $age = DateTime::createFromFormat(
                            DomainConst::DATE_FORMAT_4, $this->date_of_birth);
        } else if (!DateTimeExt::isYearNull($this->year_of_birth)) {
            $age = DateTime::createFromFormat(
                            'Y', $this->year_of_birth);
        }
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
//        return isset($this->email) ? $this->email : '';
        if (isset($this->rSocialNetwork)) {
            foreach ($this->rSocialNetwork as $value) {
                if ($value->type_network == SocialNetworks::TYPE_NETWORK_EMAIL) {
                    return $value->value;
                }
//                $retVal[] = SocialNetworks::TYPE_NETWORKS[$value->type_network] . ": $value->value";
            }
        }
        return '';
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
     * @return string Ajax information data
     */
    public function getCustomerAjaxInfo() {
        $recordNumber = '';
        if (isset($this->rMedicalRecord)) {
            $recordNumber = $this->rMedicalRecord->record_number;
        }
        //++BUG0017-IMT (DuongNV 20180717) modify
        $rightContent = '<div class="info-result">';
        $rightContent .= '<div class="title-2">';
        $rightContent .= DomainConst::CONTENT00173;
        $rightContent .= '</div>';
        $rightContent .= '<div class="item-search" style="position:relative;">';

        $rightContent .= '<table style="font-size: 15px;width: 85%;" id="patient-records-tbl">';
        $rightContent .= '<tr>';
        $rightContent .= '<td style="width:10%;"><i title="' . DomainConst::CONTENT00100 . '" class="glyphicon glyphicon-ok"></i></td>';
        $rightContent .= '<td>';
        $rightContent .= '<b>' . $this->name . '<b>';
//        $rightContent .=                '<a href=' . CommonProcess::generateQRCodeURL($this->id)
//                                            . ' class="btn btn-default glyphicon glyphicon-info-sign"'
//                                            . ' title="' . DomainConst::CONTENT00011 . '"></a>';
        $rightContent .= '</td>';
        $rightContent .= '</tr>';

        $rightContent .= '<tr>';
        $rightContent .= '<td><i title="' . DomainConst::CONTENT00170 . '" class="glyphicon glyphicon-earphone"></i></td>';
        $rightContent .= '<td>';
        $rightContent .= '<b>' . $this->getPhone() . '<b>';
//        $rightContent .=                    '<a onclick="{fnOpenUpdateCustomer(\'' . $this->id . '\');}"'
//                                            . ' class="btn btn-default glyphicon glyphicon-pencil"'
//                                            . ' title="' . DomainConst::CONTENT00229 . '"></a>';
        $rightContent .= '</td>';
        $rightContent .= '</tr>';

        $rightContent .= '<tr>';
        $rightContent .= '<td><i title="' . DomainConst::CONTENT00106 . '" class="glyphicon glyphicon-home"></i></td>';
        $rightContent .= '<td>';
        $rightContent .= '<b>' . $this->getAddress() . '<b>';
//        $rightContent .=                '<a class="btn btn-default glyphicon glyphicon-print"'
//                                        .'title="In phiếu thu"'
//                                        .'onclick="{fnOpenPrintReceipt(\'' . $this->id . '\');}" ></a>';
        $rightContent .= '</td>';
        $rightContent .= '</tr>';

        $rightContent .= '<tr>';
        $rightContent .= '<td><i title="' . DomainConst::CONTENT00197 . '" class="glyphicon glyphicon-map-marker"></i></td>';
        $rightContent .= '<td>';
        $rightContent .= '<b>' . $this->getAgentName() . '<b>';
        $rightContent .= '</td>';
        $rightContent .= '</tr>';

        $rightContent .= '<tr>';
        $rightContent .= '<td><i title="' . DomainConst::CONTENT00101 . '" class="	glyphicon glyphicon-gift"></i></td>';
        $rightContent .= '<td>';
        $rightContent .= '<b>' . $this->getBirthday() . '<b>';
        $rightContent .= '</td>';
        $rightContent .= '</tr>';
        $rightContent .= '<tr>';
        $rightContent .= '<td title="' . DomainConst::CONTENT00047 . '"><i class="	glyphicon glyphicon-user"></i></td>';
        $rightContent .= '<td>';
        $rightContent .= '<b>' . CommonProcess::getGender()[$this->gender] . '<b>';
        $rightContent .= '</td>';
        $rightContent .= '</tr>';
        $rightContent .= '<tr>';
        $rightContent .= '<td><i title="' . DomainConst::CONTENT00136 . '" class="	glyphicon glyphicon-tasks"></i></td>';
        $rightContent .= '<td>';
        $rightContent .= '<b>' . $recordNumber . '<b>';
        $rightContent .= '</td>';
        $rightContent .= '</tr>';
        $rightContent .= '<tr>';
        $rightContent .= '<td><i title="' . DomainConst::CONTENT00300 . '" class="fa fa-dollar"></i></td>';
        $rightContent .= '<td>';
        $rightContent .= '<b>' . $this->getDebt() . '<b>';
        $rightContent .= '</td>';
        $rightContent .= '</tr>';
        $pathological = '';
        if (isset($this->rMedicalRecord)) {
            $pathological = $this->rMedicalRecord->generateMedicalHistory(", ");
            Settings::saveAjaxTempValue($this->rMedicalRecord->id);
        }
        if (!empty($pathological)) {
            $rightContent .= '<tr>';
            $rightContent .= '<td colspan="2">' . DomainConst::CONTENT00137 . ': ' . '<b>' . $pathological . '<b>' . '</td>';
            $rightContent .= '</tr>';
        }
        $rightContent .= '</table>';
        $rightContent .= '<div class="btn-bar">'
                . '<a href=' . CommonProcess::generateQRCodeURL($this->id)
                . ' class="btn btn-default glyphicon glyphicon-info-sign"'
                . ' title="' . DomainConst::CONTENT00011 . '"></a>'
                . '<a onclick="{fnOpenUpdateCustomer(\'' . $this->id . '\');}"'
                . ' class="btn btn-default glyphicon glyphicon-pencil"'
                . ' title="' . DomainConst::CONTENT00229 . '"></a>'
                . '<a class="btn btn-default glyphicon glyphicon-print"'
                . 'title="In phiếu thu"'
                . 'onclick="{fnOpenPrintReceipt(\'' . $this->id . '\');}" ></a>'
                . '</div>';
        //--BUG0017-IMT (DuongNV 20180717) modify
        $rightContent .= '</div>';
        $rightContent .= '<div class="title-2">' . DomainConst::CONTENT00201 . '</div>';
        $rightContent .= '<div class="item-search treatment-history-container">';

        //DuongNV add custom html
        $htmlIcon = '<svg class="mark-icon"'
                . ' viewBox="0 0 14 16" version="1.1" width="14" height="16" aria-hidden="true">'
                . '<path fill-rule="evenodd" d="M10.86 7c-.45-1.72-2-3-3.86-3-1.86 0-3.41 1.28-3.86 3H0v2h3.14c.45 1.72 2 3 3.86 3 1.86 0 3.41-1.28 3.86-3H14V7h-3.14zM7 10.2c-1.22 0-2.2-.98-2.2-2.2 0-1.22.98-2.2 2.2-2.2 1.22 0 2.2.98 2.2 2.2 0 1.22-.98 2.2-2.2 2.2z"></path>'
                . '</svg>'; //END
        if (isset($this->rMedicalRecord) && isset($this->rMedicalRecord->rTreatmentSchedule)) {
//            $i = count($this->rMedicalRecord->rTreatmentSchedule);
            $i = 0;
            foreach ($this->rMedicalRecord->rTreatmentSchedule as $schedule) {
                if (!empty($schedule->rDetail)) {
                    $i++;
                }
            }
            foreach ($this->rMedicalRecord->rTreatmentSchedule as $schedule) {
//                if (isset($schedule->rDetail)) {
                if (!empty($schedule->rDetail)) {
                    $rightContent .= '<b style="float: left">';
                    if ($schedule->rPathological) {
                        $rightContent .= $htmlIcon . '<span class="round-txt">Đợt ' . $i . ': ' . $schedule->getStartDate() . ' - ' . $schedule->rPathological->name . '</span>';
                    } else {
                        $rightContent .= $htmlIcon . '<span class="round-txt">Đợt ' . $i . ': ' . $schedule->getStartDate() . '</span>';
                    }
                    $rightContent .= '</b>';
                    // Add button create new treatment schedule detail
                    $rightContent .= HtmlHandler::createAjaxButtonWithImage('', DomainConst::IMG_ADD_ICON, '{fnOpenCreateNewTreatment(\'' . $schedule->id . '\');}', '', 'create-treatment-btn');

                    $detailIdx = count($schedule->rDetail);
                    // Html container of all treatment by Duong
                    $rightContent .= '<div class="round-container">';
                    foreach ($schedule->rDetail as $detail) {
                        $btnTitle = $detail->getTitle();
                        $updateTag = '';
                        switch (Yii::app()->user->role_name) {
                            case Roles::ROLE_ASSISTANT:
                            case Roles::ROLE_RECEPTIONIST:
                                $createPrescription = '{fnOpenCreatePrescription(\'' . $detail->id . '\');}';
                                $updateTreatment = '{fnOpenUpdateTreatment(\'' . $detail->id . '\');}';
                                $createReceipt = '{fnOpenCreateReceipt(\'' . $detail->id . '\')}';
                                // Show item was completed
                                //++BUG0054-IMT (DuongNV 20180806) Update UI treatment history
                                $mTreatmentProcess = empty($detail->rProcess) ? [] : $detail->rProcess;
                                //--BUG0054-IMT (DuongNV 20180806) Update UI treatment history
                                if ($detail->isCompleted()) {
                                    $updateTag = HtmlHandler::createCustomButton(
                                                    $updateTreatment, $btnTitle, $detail->getStartTime(), $detail->getDoctor(), '', '', $createReceipt, $createPrescription, array(
                                                DomainConst::KEY_NAME => DomainConst::CONTENT00204,
                                                DomainConst::KEY_TYPE => 1
                                                    ),
                                                    //++ BUG0017-IMT (DuongNV 20180717) Add id to change status treatment history
                                                    $detail->id
                                                    //-- BUG0017-IMT (DuongNV 20180717) Add id to change status treatment history
                                                    //++BUG0054-IMT (DuongNV 20180806) Update UI treatment history
                                                    , $mTreatmentProcess
                                                    //--BUG0054-IMT (DuongNV 20180806) Update UI treatment history
                                    );
                                } else {    // Normal item
                                    $updateTag = HtmlHandler::createCustomButton(
                                                    $updateTreatment, $btnTitle, $detail->getStartTime(), $detail->getDoctor(), '', '', $createReceipt, $createPrescription, array(
                                                DomainConst::KEY_NAME => DomainConst::CONTENT00402,
                                                DomainConst::KEY_TYPE => 0
                                                    ),
                                                    //++ BUG0017-IMT (DuongNV 20180717) Add id to change status treatment history
                                                    $detail->id
                                                    //-- BUG0017-IMT (DuongNV 20180717) Add id to change status treatment history
                                                    //++BUG0054-IMT (DuongNV 20180806) Update UI treatment history
                                                    , $mTreatmentProcess
                                                    //--BUG0054-IMT (DuongNV 20180806) Update UI treatment history
                                    );
                                }
                            default:
                                break;
                        }
                        $rightContent .= $updateTag;
                        $detailIdx--;
                    }
                    $rightContent .= '</div>'; //Duong
                }
                $i--;
            }
        }
        $rightContent .= '</div>';
        $rightContent .= '</div>';
        return $rightContent;
    }

    /**
     * Get active schedule time
     * @return string Schedule time
     */
    public function getScheduleTime($isFull = false) {
//        $scheduleId = $this->getSchedule(false);
//        if (!empty($scheduleId)) {
//            $mSchedule = TreatmentScheduleDetails::model()->findByPk($scheduleId);
//            if ($mSchedule) {
//                return $mSchedule->getTimer();
//            }
//        }
        $schedule = !empty($this->rMedicalRecord->rTreatmentSchedule[0]) ? $this->rMedicalRecord->rTreatmentSchedule[0] : null;
        if (!empty($schedule)) {
            if ($isFull) {
                return $schedule->getStartTime();
            } else {
                return isset($schedule->rTime) ? $schedule->rTime->name : '';
            }
        }
        return '';
    }

    /**
     * Get active schedule doctor
     * @return string Doctor name
     */
    public function getScheduleDoctor() {
//        $scheduleId = $this->getSchedule(false);
//        if (!empty($scheduleId)) {
//            $mSchedule = TreatmentScheduleDetails::model()->findByPk($scheduleId);
//            if ($mSchedule) {
//                return $mSchedule->getDoctor();
//            }
//        }
        $schedule = !empty($this->rMedicalRecord->rTreatmentSchedule[0]) ? $this->rMedicalRecord->rTreatmentSchedule[0] : null;
        if (!empty($schedule)) {
            return $schedule->getDoctor();
        }
        return '';
    }

    /**
     * Get customer ajax schedule information
     * @return string
     */
    public function getCustomerAjaxScheduleInfo() {
        $infoSchedule = '';
        $scheduleId = $this->getSchedule();

        $infoSchedule .= HtmlHandler::createAjaxButtonWithImage(
                        DomainConst::CONTENT00179, DomainConst::IMG_APPOINTMENT_ICON, '{fnOpenCreateSchedule();}', 'cursor: pointer;');
        if (!empty($scheduleId)) {
            Settings::saveAjaxTempValue($scheduleId);
            $mSchedule = TreatmentScheduleDetails::model()->findByPk($scheduleId);
            if ($mSchedule) {
                $infoSchedule = '<div class="title-2">' . DomainConst::CONTENT00177 . ': </div>';
                $infoSchedule .= '<div class="item-search schedule-apmt-info">';
                $infoSchedule .= '<p><i class="glyphicon glyphicon-time" title="Thời gian"></i> ' . $mSchedule->getStartTime() . '</p>';
                //++ BUG0017-IMT (NguyenPT 20170717) Show/hide item base on value
//                $infoSchedule .=        '<p><i class="glyphicon glyphicon-credit-card" title="' . DomainConst::CONTENT00260 . '"></i> ' . $mSchedule->rSchedule->getInsurrance() . '</p>';
//                $infoSchedule .=        '<p><i class="glyphicon glyphicon-info-sign" title="Chi Tiết Công Việc"></i> ' . $mSchedule->description . '</p>';
//                $infoSchedule .=        '<p><i class="glyphicon glyphicon-user" title="Bác sĩ"></i> ' . $mSchedule->getDoctor() . '</p>';
                if ($mSchedule->rSchedule->getInsurrance() != "0") {
                    $infoSchedule .= '<p><i class="glyphicon glyphicon-credit-card" title="'
                            . DomainConst::CONTENT00260 . '">'
                            . '</i> ' . $mSchedule->rSchedule->getInsurrance() . '</p>';
                }
                if (!empty($mSchedule->description)) {
                    $infoSchedule .= '<p><i class="glyphicon glyphicon-info-sign" title="'
                            . DomainConst::CONTENT00207 . '">'
                            . '</i> ' . $mSchedule->description . '</p>';
                }
                $infoSchedule .= '<p><i class="fas fa-user-md" title="'
                        . DomainConst::CONTENT00143 . '"></i> ' . $mSchedule->getDoctor() . '</p>';
                //-- BUG0017-IMT (NguyenPT 20170717) Show/hide item base on value
                $infoSchedule .= '</div>';
                $infoSchedule .= HtmlHandler::createAjaxButtonWithImage(
                                DomainConst::CONTENT00346, DomainConst::IMG_EDIT_ICON, '{fnOpenUpdateSchedule(\'' . $scheduleId . '\');}', 'cursor: pointer;');
            }
        }
        return $infoSchedule;
    }

    /**
     * Get landing page schedule information
     * @return string
     */
    public function getLandingPageScheduleInfo() {
        $scheduleId = $this->getSchedule();
        $retVal = '';
        if (!empty($scheduleId)) {
            $mSchedule = TreatmentScheduleDetails::model()->findByPk($scheduleId);
            if ($mSchedule) {
                $retVal .= '<div class="lp-text-content">';
                $retVal .= '<p>';
                $retVal .= '<i class="fas fa-angle-double-right"></i> ';
                $retVal .= '<strong>' . $mSchedule->getTitle() . '</strong><br>';
                $retVal .= '<i class="fas fa-calendar-plus" title="Ngày bắt đầu"></i> ';
                $retVal .= $mSchedule->getStartTime() . '<br>';
                $retVal .= '</p>';
                $retVal .= '</div>';
            }
        }
        return $retVal;
    }

    /**
     * Get social network information
     * @return String
     */
    public function getSocialNetworkInfo() {
        $retVal = array();
//        $retVal[] = "Điện thoại: " . $this->getPhone();
        if (isset($this->rSocialNetwork)) {
            foreach ($this->rSocialNetwork as $value) {
                $retVal[] = SocialNetworks::TYPE_NETWORKS[$value->type_network] . ": $value->value";
            }
        }
        return implode('<br>', $retVal);
    }

    /**
     * Get social network value
     * @param Int $type_network Network type
     * @return String
     */
    public function getSocialNetwork($type_network) {
        if (isset($this->rSocialNetwork)) {
            foreach ($this->rSocialNetwork as $value) {
                if ($value->type_network == $type_network) {
                    return $value->value;
                }
            }
        }
        return '';
    }

    /**
     * Get medical history html
     * @return type
     */
    public function getMedicalHistoryHtml() {
        $retVal = array();
        if (isset($this->rMedicalRecord)) {
            foreach ($this->rMedicalRecord->rJoinPathological as $item) {
                if (isset($item->rPathological)) {
                    $retVal[] = CommonProcess::createConfigJson(
                                    $item->rPathological->id, $item->rPathological->name);
                }
            }
        }
        return $retVal;
    }

    /**
     * Get list of customer's treatment schedule
     * @return Array List of customer's treatment schedule
     */
    public function getListTreatmentSchedule() {
        $retVal = array();
        if (isset($this->rMedicalRecord) && isset($this->rMedicalRecord->rTreatmentSchedule)) {
            foreach ($this->rMedicalRecord->rTreatmentSchedule as $schedule) {
//                if (isset($schedule->rDetail)) {
//                    foreach ($schedule->rDetail as $detail) {
//                        $retVal[] = $detail;
//                    }
//                }
                $retVal[] = $schedule;
            }
        }
        return $retVal;
    }

    /**
     * Get debt information
     * @return String
     */
    public function getDebt() {
        return CommonProcess::formatCurrency($this->debt) . ' ' . DomainConst::CONTENT00134;
    }

    /**
     * Get list receipt of this customer
     * @return array
     */
    public function getReceipts() {
        $retVal = array();

        if (isset($this->rMedicalRecord) && isset($this->rMedicalRecord->rTreatmentSchedule)) {
            // Loop for all treatment schedules
            foreach ($this->rMedicalRecord->rTreatmentSchedule as $treatmentSchedule) {
                if (isset($treatmentSchedule->rDetail)) {
                    // Loop for all treatment schedule details
                    foreach ($treatmentSchedule->rDetail as $detail) {
                        $receipt = $detail->rReceipt;
                        if (isset($receipt) && $receipt->status != Receipts::STATUS_INACTIVE) {
                            $retVal[] = $receipt;
                        }
                    }
                }
            }
        }

        return $retVal;
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
                                    $item->rPathological->id, $item->rPathological->name);
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
                                        CustomerController::ITEM_UPDATE_DATE, DomainConst::CONTENT00230);
                        return $retVal;
                    }
                }
            }
        }
        $retVal[] = CommonProcess::createConfigJson(
                        CustomerController::ITEM_UPDATE_DATE, DomainConst::CONTENT00230);

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
        $criteria->order = 't.created_date DESC';
        // Set condition
        $roleName = isset($mUser->rRole) ? $mUser->rRole->role_name : '';
        switch ($roleName) {
            case Roles::ROLE_DOCTOR:
                Loggers::info('Switch', 'Roles::ROLE_DOCTOR', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
                $today = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_6);
                $lastMonth = CommonProcess::getPreviousMonth(DomainConst::DATE_FORMAT_6);
                $from = isset($root->date_from) ? $root->date_from : $lastMonth;
                $to = isset($root->date_to) ? $root->date_to : $today;
                Loggers::info("From: $from", __FUNCTION__, __LINE__);
                Loggers::info("From: $to", __FUNCTION__, __LINE__);
                if ($mUser->isTestUser()) {
                    $from = '2018/01/01';
                    $to = '2018/12/01';
                }
                // Get list customers assign at doctor
//                $criteria->addInCondition('t.id', $mUser->getListCustomerOfDoctor($from, $to));
                return $mUser->getListCustomerOfDoctor($from, $to, $root->page);
//                return $mUser->getListCustomersByDoctorAPI($from, $to, $root->page);
//                return TreatmentScheduleDetails::getListCustomerByDoctor($mUser->id, $from, $to);
//                break;

            default:
                break;
        }

        // Get return value
        $retVal = new CActiveDataProvider(
                $this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Settings::getApiListPageSize(),
                'currentPage' => (int) $root->page,
            ),
        ));
        return $retVal;
    }

    /**
     * get field name
     * @param type $fieldName
     * @return type
     */
    public function getFieldName($fieldName = 'name') {
        return !empty($this->$fieldName) ? $this->$fieldName : '';
    }

    /**
     * get created by
     */
    public function getCreatedBy() {
        return !empty($this->rCreatedBy) ? $this->rCreatedBy->getFullName() : '';
    }
    
    /**
     * Update refer code
     * @param String $referCode Value of refer code
     */
    public function updateReferCode($referCode) {
        if (empty($referCode)) {    // Empty
            if (isset($this->rReferCode)) {
                // Case need disconnect (user delete refer code)
                ReferCodes::disconnect($this->rReferCode->code);
            }
        } else {    // Refer code not empty
            if (isset($this->rReferCode)) {         // Customer was connected before
                if ($this->rReferCode->code != $referCode) {    // User change refer code
                    // Delete old
                    ReferCodes::disconnect($this->rReferCode->code);
                }
            }
            // Connect new
            ReferCodes::connect($referCode, $this->id, ReferCodes::TYPE_CUSTOMER);
        }
    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Get customer model by id
     * @param String $id Id of customer
     * @return Customers Model customer, NULL if not found
     */
    public static function getCustomerById($id) {
        $model = self::model()->findByPk($id);
        if ($model) {
            return $model;
        }
        return NULL;
    }
    
    public static function transferCustomer($renoPatient, $agentId) {
        $records = MedicalRecords::model()->findAllByAttributes(array(
            'record_number' => $renoPatient->Code,
        ));
        $medicalRecord = NULL;
        foreach ($records as $record) {
            if (isset($record->rCustomer) && ($record->rCustomer->getAgentId() == $agentId)) {
                $medicalRecord = $record;
                break;
            }
        }
        if (!empty($medicalRecord)) {
            // Update
            $customer = $medicalRecord->rCustomer;
            // Remove old record
            OneMany::deleteAllManyOldRecords($customer->id, OneMany::TYPE_AGENT_CUSTOMER);
            Loggers::info("Cập nhật Bệnh nhân: ", $renoPatient->Code, __FUNCTION__ . __LINE__);
            return self::saveCustomer($renoPatient, $agentId, $customer, false);
        } else {
            // Create new
            $customer = new Customers();
            Loggers::info("Tạo mới Bệnh nhân: ", $renoPatient->Code, __FUNCTION__ . __LINE__);
            return self::saveCustomer($renoPatient, $agentId, $customer, true);
        }
    }

    public static function saveCustomer($renoPatient, $agentId, &$customer, $needCreateMedicalRecord = true, $isValidate = false) {
        $customer->name = $renoPatient->FullName;
        $customer->gender = DomainConst::GENDER_FEMALE;
        if ($renoPatient->Sex == '1') {
            $customer->gender = DomainConst::GENDER_MALE;
        }
        $customer->date_of_birth = $renoPatient->DateOfBirth;
        $customer->year_of_birth = $renoPatient->YearOfBirth;
        $customer->phone = $renoPatient->Mobile;
        $customer->city_id = '2';
        if (!empty($renoPatient->ProvinceId)) {
            $city = Cities::getModelByName($renoPatient->rCity->Name);
            if (isset($city)) {
                $customer->city_id = $city->id;
            }
        }
        if (isset($renoPatient->rDistrict)) {
            $district = Districts::getModelByName($renoPatient->rDistrict->Name);
            if (isset($district)) {
                $customer->district_id = $district->id;
            }
        }
        $customer->house_numbers = $renoPatient->Address;
        if (isset($renoPatient->CreateDate)) {
            $customer->created_date = $renoPatient->CreateDate;
        }
        if (isset($renoPatient->rCreatedBy)) {
            $user = Users::getUserByName($renoPatient->getCreatedBy());
            if (isset($user)) {
                $customer->created_by = $user->id;
            }
        }
        if (!$isValidate) {
            if ($customer->save()) {
                Loggers::info("Lưu Bệnh nhân thành công: ", $renoPatient->Code, __FUNCTION__ . __LINE__);
                OneMany::insertOne($agentId, $customer->id, OneMany::TYPE_AGENT_CUSTOMER);
                if ($needCreateMedicalRecord) {
                    $medicalRecord = new MedicalRecords();
                    $medicalRecord->customer_id = $customer->id;
                    $medicalRecord->record_number = $renoPatient->Code;
                    if ($medicalRecord->save()) {
                        Loggers::info("Lưu Hồ sơ Bệnh án thành công: ", $medicalRecord->id, __FUNCTION__ . __LINE__);
                        return $medicalRecord->id;
                    } else {
                        Loggers::info("Lỗi khi lưu Hồ sơ Bệnh án: ", $customer->id, __FUNCTION__ . __LINE__);
                        Loggers::info(CommonProcess::json_encode_unicode($medicalRecord->getErrors()), '', __FUNCTION__ . __LINE__);
                    }
                } else {
                    return isset($customer->rMedicalRecord) ? $customer->rMedicalRecord->id : '';
                }
            } else {
                Loggers::info("Lỗi khi lưu Bệnh nhân: ", $renoPatient->Code, __FUNCTION__ . __LINE__);
                Loggers::info(CommonProcess::json_encode_unicode($customer->getErrors()), '', __FUNCTION__ . __LINE__);
            }
            return '';
        } else {
            return $customer->createFields();
        }
    }

    public static function transferTreatmentSchedule($renoTreatmentProfile, $medicalRecord, $agentId, $isValidate = false) {
        $treatment = new TreatmentSchedules();
        if (!$isValidate) {
            $treatment->record_id = $medicalRecord;
        }

        $treatment->time_id = 1;
        $treatment->start_date = $renoTreatmentProfile->DateOfProfiles;
        $treatment->end_date = $renoTreatmentProfile->EndDateOfProfiles;
//        $doctor = Users::getDoctorByName($renoTreatmentProfile->getDoctorName(), $agentId);
        Loggers::info('Doctor', $renoTreatmentProfile->getDoctorName(), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $doctor = Users::getUserByName($renoTreatmentProfile->getDoctorName());
        if (!empty($doctor)) {
            $treatment->doctor_id = $doctor->id;
        }
        if (!$isValidate) {
            if ($treatment->save()) {
                Loggers::info("Lưu TreatmentProfile thành công: ", $treatment->id, __FUNCTION__ . __LINE__);
                return $treatment->id;
            } else {
                Loggers::info("Lỗi khi lưu TreatmentProfile: ", $renoTreatmentProfile->TreatmentProfiles_ID, __FUNCTION__ . __LINE__);
                Loggers::info(CommonProcess::json_encode_unicode($treatment->getErrors()), '', __FUNCTION__ . __LINE__);
                Loggers::info("Doctor: ", $renoTreatmentProfile->getDoctorName(), __FUNCTION__ . __LINE__);
            }
            return '';
        } else {
            return $treatment->createFields();
        }
    }

    public static function transferTreatmentScheduleDetail($renoTreatment, $treatmentId, $agentId, $isValidate = false) {
        $detail = new TreatmentScheduleDetails();
        if (!$isValidate) {
            $detail->schedule_id = $treatmentId;
        }

        $detail->time_id = 1;
        $detail->start_date = $renoTreatment->TreatmentDate;
        $detail->end_date = $renoTreatment->FinishDate;
        $name = isset($renoTreatment->treatmentService) ? $renoTreatment->treatmentService->Name : '';
        if (!empty($name)) {
            $model = TreatmentTypes::getModelByName($name);
            if (!empty($model)) {
                $detail->treatment_type_id = $model->id;
            }
        }
        if (isset($renoTreatment->treatmentProfiles)) {
            $detail->description = '';
            if (!empty($name)) {
                $detail->description .= $name . '. ';
            }
//            $detail->description    .= $renoTreatment->treatmentProfiles->Reason . '. ';
//            $detail->description    .= 'BS ' . $renoTreatment->getDoctorName() . ' thực hiện. ';
        }
        $detail->status = TreatmentScheduleDetails::STATUS_COMPLETED;
        if (!$isValidate) {
            if ($detail->save()) {
                Loggers::info("Lưu Treatment thành công: ", $detail->id, __FUNCTION__ . __LINE__);
                // Teeth
                if (!empty($renoTreatment->TreatmentTooth)) {
                    $arrTeeth = explode(',', $renoTreatment->TreatmentTooth);
                    foreach ($arrTeeth as $teeth) {
                        $teethIndex = CommonProcess::convertTeethIndex($teeth);
                        if (!empty($teethIndex)) {
                            OneMany::insertOne($detail->id, $teethIndex, OneMany::TYPE_TREATMENT_DETAIL_TEETH);
                        }
                    }
                }
                $receipt = new Receipts();
                $receipt->detail_id = $detail->id;
                $receipt->process_date = CommonProcess::convertDateTime($detail->start_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_4);
                $receipt->total = $renoTreatment->TotalMoney + $renoTreatment->Decrease;
                $receipt->discount = $renoTreatment->Decrease;
                $receipt->final = '0';
                if (!empty($renoTreatment->Payed)) {
                    $receipt->final = $renoTreatment->Payed;
                }
                $receipt->status = Receipts::STATUS_RECEIPTIONIST;
                if ($receipt->save()) {
                    Loggers::info("Lưu Phiếu thu thành công: ", $receipt->id, __FUNCTION__ . __LINE__);
                    // Update customer's debt
                    $receipt->updateCustomerDebt();
                    $receipt->connectAgent($agentId);
                } else {
                    Loggers::info("Lỗi khi lưu Phiếu thu: ", $detail->id, __FUNCTION__ . __LINE__);
                    Loggers::info(CommonProcess::json_encode_unicode($receipt->getErrors()), '', __FUNCTION__ . __LINE__);
                }

                return $detail->id;
            } else {
                Loggers::info("Lỗi khi lưu Treatment: ", $renoTreatment->Treatment_Id, __FUNCTION__ . __LINE__);
                Loggers::info(CommonProcess::json_encode_unicode($detail->getErrors()), '', __FUNCTION__ . __LINE__);
            }
        } else {
            // Teeth
            if (!empty($renoTreatment->TreatmentTooth)) {
                $detail->description .= 'Răng: ' . $renoTreatment->TreatmentTooth;
            }
            $fields = $detail->createFields();

            return $fields;
        }
    }

    public static function createNewTreatmentDetail($renoTreatmentProfile, $treatmentId) {
        $detail = new TreatmentScheduleDetails();
        $detail->schedule_id = $treatmentId;
        $detail->time_id = 1;
        $detail->start_date = $renoTreatmentProfile->DateOfProfiles;
        $detail->end_date = $renoTreatmentProfile->EndDateOfProfiles;
        $detail->description = 'BS ' . $renoTreatmentProfile->getDoctorName() . ' thực hiện. ';
        $detail->description .= $renoTreatmentProfile->Reason;
        $detail->status = TreatmentScheduleDetails::STATUS_COMPLETED;
        if ($detail->save()) {
            Loggers::info("Lưu Treatment thành công: ", $detail->id, __FUNCTION__ . __LINE__);

            return $detail->id;
        } else {
            Loggers::info("Lỗi khi lưu Treatment: ", $renoTreatmentProfile->TreatmentProfiles_ID, __FUNCTION__ . __LINE__);
            Loggers::info(CommonProcess::json_encode_unicode($detail->getErrors()), '', __FUNCTION__ . __LINE__);
        }
    }

    public static function transferTreatmentProcess($renoTreatmentDetail, $detailId, $agentId, $isValidate = false) {
        $process = new TreatmentScheduleProcess();
        if (!$isValidate) {
            $process->detail_id = $detailId;
        }

        if (!empty($renoTreatmentDetail->Date)) {
            $process->process_date = $renoTreatmentDetail->Date;
        } else {
            if (isset($renoTreatmentDetail->treatmentProfiles)) {
                $process->process_date = $renoTreatmentDetail->treatmentProfiles->DateOfProfiles;
            }
        }

        $process->name = $renoTreatmentDetail->ContentOfWork;
        $process->description = $renoTreatmentDetail->Teeth;
//        $doctor = Users::getDoctorByName($renoTreatmentDetail->getDoctorName(), $agentId);
        $doctor = Users::getUserByName($renoTreatmentDetail->getDoctorName());
        if (!empty($doctor)) {
            $process->doctor_id = $doctor->id;
        }
        $process->note = $renoTreatmentDetail->Note;
        if (!$isValidate) {
            if ($process->save()) {
                Loggers::info("Lưu TreatmentDetail thành công: ", $process->id, __FUNCTION__ . __LINE__);
            } else {
                Loggers::info("Lỗi khi lưu TreatmentDetail: ", $renoTreatmentDetail->Id, __FUNCTION__ . __LINE__);
                Loggers::info(CommonProcess::json_encode_unicode($process->getErrors()), '', __FUNCTION__ . __LINE__);
            }
        } else {
            return $process->createFields();
        }
    }

    public function createFields() {
        $fields = array();

        $fields[] = 'name: ' . $this->name;
        $fields[] = 'gender: ' . $this->gender;
        $fields[] = 'date_of_birth: ' . $this->date_of_birth;
        $fields[] = 'year_of_birth: ' . $this->year_of_birth;
        $fields[] = 'phone: ' . $this->phone;
        $fields[] = 'city: ' . (isset($this->rCity) ? $this->rCity->name : '');
        $fields[] = 'district: ' . (isset($this->rDistrict) ? $this->rDistrict->name : '');
        $fields[] = 'house_numbers: ' . $this->house_numbers;
        $fields[] = 'created_date: ' . $this->created_date;
        $fields[] = 'created_by: ' . (isset($this->rCreatedBy) ? $this->rCreatedBy->first_name : '');

        return $fields;
    }

    //++ BUG0068-IMT (DuongNV 20183108) Add customer info in receipt screen
    public function getCustomerCustomInfo() {
        $recordNumber = '';
        if (isset($this->rMedicalRecord)) {
            $recordNumber = $this->rMedicalRecord->record_number;
        }
        $html = '';
        $html .= '<div class="info-result" style="background:white">'
                . '<div class="title-2">' . DomainConst::CONTENT00172 . '</div>'
                . '<div class="item-search">'
                . '<table class="table table-borderless">'
                . '<tbody>'
                . '<tr>'
                . '<td style="width:35px;">'
                . '<i class="fas fa-user" title="' . DomainConst::CONTENT00100 . '"></i>'
                . '</td>'
                . '<td>' . $this->name . '</td>'
                . '</tr>'
                . '<tr>'
                . '<td>'
                . '<i class="fas fa-map-marker-alt" title="' . DomainConst::CONTENT00045 . '"></i>'
                . '</td>'
                . '<td>' . $this->address . '</td>'
                . '</tr>'
                . '<tr>'
                . '<td>'
                . '<i class="fas fa-birthday-cake" title="' . DomainConst::CONTENT00101 . '"></i>'
                . '</td>'
                . '<td>' . $this->getBirthday() . '</td>'
                . '</tr>'
                . '<tr>'
                . '<td>'
                . '<i class="fas fa-code-branch" title="' . DomainConst::CONTENT00199 . '"></i>'
                . '</td>'
                . '<td>' . $this->getAgentName() . '</td>'
                . '</tr>'
                . '<tr>'
                . '<td>'
                . '<i class="fas fa-id-card" title="' . DomainConst::CONTENT00136 . '"></i>'
                . '</td>'
                . '<td>' . $recordNumber . '</td>'
                . '</tr>'
                . '</tbody>'
                . '</table>'
                . '</div>'
                . '</div>';
        return $html;
    }

    //-- BUG0068-IMT (DuongNV 20183108) Add customer info in receipt screen
    
    /**
     * Check if a user id is a valid patient (customer has medical record)
     * @param String $userId Id of user
     * @return String Id of customer, empty if customer not found
     */
    public static function isValidPatient($userId) {
        $model = self::model()->findByAttributes(array(
            'user_id'   => $userId,
        ));
        if ($model) {
            if (isset($model->rMedicalRecord)) {
                return $model->id;
            }
        }
        return '';
    }
}
