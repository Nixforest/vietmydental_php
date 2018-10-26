<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id                 Id of user
 * @property string $username           Username
 * @property string $email              Email
 * @property string $password_hash      Password hash
 * @property string $temp_password      Temp password
 * @property string $first_name         Full name
 * @property string $last_name          Last name (no use)
 * @property string $birthday           Birthday
 * @property string $identity_number    Identity number
 * @property string $date_of_issue      Date of issue
 * @property integer $place_of_issue    Place of issue (City id)
 * @property string $date_in            Date in
 * @property string $code_account       Code
 * @property string $img_avatar         Avatar image
 * @property string $address            Address
 * @property string $address_vi         Address vi (use for search)
 * @property string $house_numbers      House number
 * @property integer $province_id       City id
 * @property integer $district_id       District id
 * @property integer $ward_id           Ward id
 * @property integer $street_id         Street id
 * @property integer $login_attemp      -
 * @property string $created_date       Created date
 * @property string $last_logged_in     Last logged in time
 * @property string $ip_address         IP address
 * @property integer $role_id           Role id
 * @property integer $application_id    -
 * @property integer $department_id     Department id
 * @property integer $contract_type_id          Id of contract type
 * @property double $base_salary                Base salary
 * @property double $social_insurance_salary    Social insurance salary
 * @property double $responsible_salary         Responsible salary
 * @property double $subvention                 Subvention
 * @property integer $status            Status
 * @property string $gender             Gender
 * @property string $phone              Phone number
 * @property string $verify_code        Verify code
 * @property string $slug               -
 * @property string $address_temp       -
 * @property string $created_by         Created by
 * 
 * The followings are the available model relations:
 * @property Users                  $rCreatedBy         User created this record
 * @property Cities                 $rPlaceIssue        Place of issue
 * @property Roles                  $rRole              Role of user
 * @property ActionsUsers           $rActionsUser       Action of user
 * @property Cities                 $rCity              City of user
 * @property Districts              $rDistrict          District of user
 * @property Wards                  $rWard              Ward of user
 * @property Streets                $rStreet            Street of user
 * @property OneMany[]              $rJoinAgent         Join relation of User-Agent (Will be remove soon)
 * @property TreatmentSchedules[]   $rTreatmentSchedule Treatment schedules of user
 * @property SocialNetworks[]       $rSocialNetwork     Social network information of user
 * @property Files                  $rImgAvatarFile     Avatar of user
 * @property ApiUserTokens[]        $rToken             Token of user
 * @property Agents[]               $rAgents            List of agent of user (replace for rJoinAgent)
 * @property Departments            $rDepartment        Department model
 * @property ContractTypes          $rContractType      Contract type model
 */
class Users extends BaseActiveRecord {
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $password_confirm, $currentpassword, $newpassword; /* for change pass in admin */
    public $agent;
    //-----------------------------------------------------
    // Autocomplete fields
    //-----------------------------------------------------
    public $autocomplete_name_street;

    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const STATUS_INACTIVE           = 0;
    const STATUS_ACTIVE             = 1;
    const STATUS_NEED_CHANGE_PASS   = 2;
//    const STATUS_COMPLETED              = 3;
    const UPLOAD_FOLDER = 'upload/admin/users/';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//            array('username, password_hash, created_date, ip_address, role_id, application_id, agent', 'required'),
            array('username, password_hash, created_date, ip_address, role_id, application_id', 'required'),
            array('place_of_issue, department_id, contract_type_id, province_id, district_id, ward_id, street_id, login_attemp, role_id, application_id, status', 'numerical', 'integerOnly' => true),
//            array('base_salary, social_insurance_salary, responsible_salary, subvention', 'numerical'),
            array('username, last_name', 'length', 'max' => 50),
            array('email', 'length', 'max' => 80),
            array('first_name', 'length', 'max' => 150),
            array('identity_number', 'length', 'max' => 256),
            array('code_account, ip_address', 'length', 'max' => 30),
            array('img_avatar, address_vi', 'length', 'max' => 255),
            array('gender', 'length', 'max' => 6),
            array('phone', 'length', 'max' => 200),
            array('verify_code', 'length', 'max' => 100),
            array('slug', 'length', 'max' => 300),
            array('created_by', 'length', 'max' => 11),
            array('birthday, date_of_issue, date_in, address, house_numbers, last_logged_in, address_temp, agent', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, email, first_name, last_name, code_account, address, address_vi, house_numbers, department_id, contract_type_id, province_id, district_id, ward_id, street_id, login_attemp, created_date, last_logged_in, ip_address, role_id, application_id, status, gender, phone, verify_code, slug, address_temp, created_by', 'safe', 'on' => 'search'),
            array('currentpassword', 'comparePassword', 'on' => 'changeMyPassword'),
            array('currentpassword, newpassword, password_confirm', 'required', 'on' => "changeMyPassword"),
            array('newpassword', 'length', 'min' => DomainConst::PASSW_LENGTH_MIN, 'max' => DomainConst::PASSW_LENGTH_MAX,
                'tooLong' => 'Mật khẩu mới quá dài (tối đa ' . DomainConst::PASSW_LENGTH_MAX . ' ký tự).',
                'tooShort' => 'Mật khẩu mới quá ngắn (tối thiểu ' . DomainConst::PASSW_LENGTH_MIN . ' ký tự).',
                'on' => 'changeMyPassword'),
            array('password_confirm', 'compare', 'compareAttribute' => 'newpassword', 'message' => 'Xác nhận mật khẩu mới không đúng.', 'on' => 'changeMyPassword'),
            array('newpassword, password_confirm', 'required', 'on' => "resetPassword"),
            array('newpassword', 'length', 'min' => DomainConst::PASSW_LENGTH_MIN, 'max' => DomainConst::PASSW_LENGTH_MAX,
                'tooLong' => 'Mật khẩu mới quá dài (tối đa ' . DomainConst::PASSW_LENGTH_MAX . ' ký tự).',
                'tooShort' => 'Mật khẩu mới quá ngắn (tối thiểu ' . DomainConst::PASSW_LENGTH_MIN . ' ký tự).',
                'on' => 'resetPassword'),
            array('password_confirm', 'compare', 'compareAttribute' => 'newpassword', 'message' => 'Xác nhận mật khẩu mới không đúng.', 'on' => 'resetPassword'),
            array('first_name, province_id, district_id, house_numbers', 'required', 'on' => 'updateProfile'),
            array('img_avatar', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true, 'safe' => true),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rRole' => array(self::BELONGS_TO, 'Roles', 'role_id'),
            'application' => array(self::BELONGS_TO, 'Applications', 'application_id'),
            'rActionsUser' => array(self::HAS_MANY, 'ActionsUsers', 'user_id'),
            'rCity' => array(self::BELONGS_TO, 'Cities', 'province_id'),
            'rDistrict' => array(self::BELONGS_TO, 'Districts', 'district_id'),
            'rWard' => array(self::BELONGS_TO, 'Wards', 'ward_id'),
            'rStreet' => array(self::BELONGS_TO, 'Streets', 'street_id'),
            'rJoinAgent' => array(
                self::HAS_MANY, 'OneMany', 'many_id',
                'on' => 'type = ' . OneMany::TYPE_AGENT_USER,
                'order' => 'id DESC',
            ),
            'rTreatmentSchedule' => array(
                self::HAS_MANY, 'TreatmentSchedules', 'doctor_id',
                'on' => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
                'order' => 'id DESC',
            ),
            'rSocialNetwork' => array(
                self::HAS_MANY, 'SocialNetworks', 'object_id',
                'on' => 'type = ' . SocialNetworks::TYPE_USER,
            ),
            'rImgAvatarFile' => array(
                self::HAS_ONE, 'Files', 'belong_id',
                'on' => 'type=' . Files::TYPE_1_USER_AVATAR,
                'order' => 'id DESC',
            ),
            'rToken' => array(
                self::HAS_MANY, 'ApiUserTokens', 'user_id',
                'order' => 'id DESC',
            ),
            'rAgents' => array(self::MANY_MANY, 'Agents', 'one_many(many_id,one_id)',
                'condition' => 'rAgents_rAgents.type = ' . OneMany::TYPE_AGENT_USER,
                'order' => 'rAgents_rAgents.id DESC'),
            'rPlaceIssue'   => array(self::BELONGS_TO, 'Cities', 'place_of_issue'),
            'rDepartment'   => array(
                self::BELONGS_TO, 'Departments', 'department_id',
                'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
            ),
            'rContractType'   => array(
                self::BELONGS_TO, 'ContractTypes', 'contract_type_id',
                'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'                => 'ID',
            'username'          => DomainConst::CONTENT00195,
            'email'             => DomainConst::CONTENT00040,
            'password_hash'     => DomainConst::CONTENT00041,
            'temp_password'     => DomainConst::CONTENT00196,
            'first_name'        => DomainConst::CONTENT00042,
            'last_name'         => DomainConst::CONTENT00043,
            'birthday'          => DomainConst::CONTENT00101,
            'identity_number'   => DomainConst::CONTENT00421,
            'date_of_issue'     => DomainConst::CONTENT00422,
            'place_of_issue'    => DomainConst::CONTENT00423,
            'date_in'           => DomainConst::CONTENT00424,
            'code_account'      => DomainConst::CONTENT00044,
            'address'           => DomainConst::CONTENT00045,
            'address_vi'        => 'Address Vi',
            'house_numbers'     => DomainConst::CONTENT00106,
            'province_id'       => DomainConst::CONTENT00102,
            'district_id'       => DomainConst::CONTENT00103,
            'ward_id'           => DomainConst::CONTENT00104,
            'street_id'         => DomainConst::CONTENT00105,
            'login_attemp'      => 'Login Attemp',
            'created_date'      => DomainConst::CONTENT00010,
            'last_logged_in'    => 'Last Logged In',
            'ip_address'        => 'Ip Address',
            'role_id'           => DomainConst::CONTENT00046,
            'application_id'    => 'Application',
            'department_id'     => DomainConst::CONTENT00529,
            'contract_type_id'          => DomainConst::CONTENT00531,
            'base_salary'               => DomainConst::CONTENT00532,
            'social_insurance_salary'   => DomainConst::CONTENT00533,
            'responsible_salary'        => DomainConst::CONTENT00534,
            'subvention'                => DomainConst::CONTENT00535,
            'status'            => DomainConst::CONTENT00026,
            'gender'            => DomainConst::CONTENT00047,
            'phone'             => DomainConst::CONTENT00048,
            'img_avatar'        => DomainConst::CONTENT00252,
            'verify_code'       => 'Verify Code',
            'slug'              => 'Slug',
            'address_temp'      => 'Address Temp',
            'created_by'        => DomainConst::CONTENT00054,
            'agent'             => DomainConst::CONTENT00199,
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password_hash', $this->password_hash, true);
        $criteria->compare('temp_password', $this->temp_password, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('birthday', $this->birthday, true);
        $criteria->compare('identity_number', $this->identity_number, true);
        $criteria->compare('date_of_issue', $this->date_of_issue, true);
        $criteria->compare('place_of_issue', $this->place_of_issue, true);
        $criteria->compare('date_in', $this->date_in, true);
        $criteria->compare('code_account', $this->code_account, true);
        $criteria->compare('img_avatar', $this->img_avatar, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('address_vi', $this->address_vi, true);
        $criteria->compare('house_numbers', $this->house_numbers, true);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('district_id', $this->district_id);
        $criteria->compare('ward_id', $this->ward_id);
        $criteria->compare('street_id', $this->street_id);
        $criteria->compare('login_attemp', $this->login_attemp);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('last_logged_in', $this->last_logged_in, true);
        $criteria->compare('ip_address', $this->ip_address, true);
        $criteria->compare('role_id', $this->role_id);
        if (CommonProcess::isUserAdmin()) {
            // Root admin
        } else {
            // The other roles
            $criteria->addCondition('t.role_id !=' . Roles::getRoleByName(Roles::ROLE_ADMIN)->id);
            $criteria->addCondition('t.role_id !=' . Roles::getRoleByName(Roles::ROLE_MANAGER)->id);
        }
        $criteria->compare('application_id', $this->application_id);
        $criteria->compare('department_id', $this->department_id);
        $criteria->compare('contract_type_id', $this->contract_type_id);
        $criteria->compare('base_salary', $this->base_salary);
        $criteria->compare('social_insurance_salary', $this->social_insurance_salary);
        $criteria->compare('responsible_salary', $this->responsible_salary);
        $criteria->compare('subvention', $this->subvention);
        $criteria->compare('status', $this->status);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('verify_code', $this->verify_code, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('address_temp', $this->address_temp, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Settings::getListPageSize(),
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
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
        $this->address = CommonProcess::createAddressString(
                        $this->province_id, $this->district_id, $this->ward_id, $this->street_id, $this->house_numbers);
        $this->address_vi = CommonProcess::removeSign(
                        $this->first_name . ' ' .
                        $this->username . ' ' .
                        $this->phone . ' ' .
                        $this->email . ' ' .
                        $this->address);
        $this->formatDate('birthday');
        $this->formatDate('date_of_issue');
        $this->formatDate('date_in');
//        // Format birthday value
//        $date = $this->birthday;
//        $this->birthday = CommonProcess::convertDateTimeToMySqlFormat(
//                $date, DomainConst::DATE_FORMAT_3);
//        if (empty($this->birthday)) {
//            $this->birthday = CommonProcess::convertDateTimeToMySqlFormat(
//                        $date, DomainConst::DATE_FORMAT_4);
//        }
//        if (empty($this->birthday)) {
//            $this->birthday = $date;
//        }
        if ($this->isNewRecord) {   // Add
            // Handle password
            $this->temp_password = CommonProcess::generateTempPassword();
            $this->password_hash = CommonProcess::hashPassword(
                            $this->password_hash, $this->temp_password);

            // Handle username
            $this->username = self::generateUsername($this->first_name);
            // Handle created by
            if (empty($this->created_by)) {
                $this->created_by = $userId;
            }
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTimeWithMySqlFormat();
        } else {                    // Update
        }
        return parent::beforeSave();
    }

    /**
     * Override before validate method
     * @return Parent result
     */
    public function beforeValidate() {
        return parent::beforeValidate();
    }

    /**
     * Override before delete method
     * @return Parent result
     */
    public function beforeDelete() {
        // Check foreign table treatment_schedules
        $treatmentSchedules = TreatmentSchedules::model()->findByAttributes(array('doctor_id' => $this->id));
        if (count($treatmentSchedules) > 0) {
            return false;
        }
        // Handle Agent relation
        OneMany::deleteAllManyOldRecords($this->id, OneMany::TYPE_AGENT_USER);
        // Handle Social network relation
        SocialNetworks::deleteAllOldRecord($this->id, SocialNetworks::TYPE_USER);

        return parent::beforeDelete();
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Validate password string
     * @param String $password  Password string
     * @return boolean          True if password is matched, false otherwise
     */
    public function validatePassword($password) {
        return CommonProcess::hashPassword($password, $this->temp_password) === $this->password_hash;
    }

    /**
     * Validate password change
     * @param String $password      Password string
     * @param String $new_password  New password string
     * @return String Error message
     */
    public function validatePasswordChange($password, $new_password) {
        $error = '';
        if (!$this->validatePassword($password)) {
            $error = DomainConst::CONTENT00209;
        } else if (strlen($new_password) < Settings::getPasswordLenMin()) {
            $error = 'Mật khẩu mới phải có ít nhất ' . Settings::getPasswordLenMin() . ' ký tự';
        } else if ($new_password == $this->username) {
            $error = DomainConst::CONTENT00210;
        } else if (in_array($new_password, CommonProcess::getSimplePassword())) {
            $error = DomainConst::CONTENT00211;
        }

        if (!empty($error)) {
            $this->addError('password_hash', $error);
        }

        return $error;
    }

    /**
     * Handle change password
     * @param String $new_password New password string
     * @return True if change password success, False otherwise
     */
    public function changePassword($new_password) {
        $this->temp_password = CommonProcess::generateTempPassword();
        $this->password_hash = CommonProcess::hashPassword(
                        $new_password, $this->temp_password);
        $this->status = Users::STATUS_ACTIVE;
        $aUpdate = array('password_hash', 'temp_password', 'status');
        return $this->update($aUpdate);
    }

    /**
     * Handle rule compare password
     * @param type $attribute
     * @param type $params
     */
    public function comparePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            if (trim($this->currentpassword) == '') {
                $this->addError('currentpassword', 'Mật khẩu hiện tại trống.');
            } else {
                if (CommonProcess::hashPassword($this->currentpassword, $this->temp_password) != $this->password_hash) {
                    $this->addError('currentpassword', 'Mật khẩu hiện tại không đúng.');
                }
            }
        }
    }

    /**
     * Get auto complete user name
     * @return String [Full name - Role - Agent name]
     */
    public function getAutoCompleteUserName() {
//        $retVal = $this->username;
//        if (!empty($this->last_name)) {
//            $retVal .= ' - ' . $this->last_name;
//        }
//        if (!empty($this->first_name)) {
//            $retVal .= ' ' . $this->first_name;
//        }
        $arr = array(
            $this->getFullName(),
            $this->getRoleName(),
            $this->getAgentName(),
        );
        $retVal = implode(' - ', $arr);

        return $retVal;
    }

    /**
     * Get full name
     */
    public function getFullName() {
        $retVal = $this->last_name;
        if (!empty($this->last_name)) {
            $retVal .= ' ' . $this->first_name;
        } else {
            $retVal = $this->first_name;
        }
        if (empty($retVal)) {
            $retVal = $this->username;
        }

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
     * Get name of agent
     * @return Name of agent
     */
    public function getAgentNameTest() {
        if (isset($this->rJoinAgent) && count($this->rJoinAgent) > 0) {
//            return count($this->rJoinAgent);
            $retVal = "";
            foreach ($this->rJoinAgent as $agent) {
                $retVal .= $agent->rAgent->name . "<br>";
            }
            return $retVal;
        }
        return '';
    }
    
    /**
     * Get list agent id
     * @return Array List agent id
     */
    public function getAgentIds() {
        $retVal = [];
        foreach ($this->rAgents as $agent) {
            $retVal[] = $agent->id;
        }
        return $retVal;
    }
    
    /**
     * Get list agent in Json format
     * @return Array Json format list agent
     */
    public function getAgentListJson() {
        $retVal = [];
        foreach ($this->rAgents as $agent) {
            $retVal[] = CommonProcess::createConfigJson($agent->id, $agent->name);
        }
        return $retVal;
    }
        
    /**
     * Get agents
     * @return string
     */
    public function getAgents() {
        $strResult = [];
        foreach ($this->rAgents as $value) {
            $strResult[] = $value->name;
        }
        return implode('<br>', $strResult);
    }

    /**
     * Set list agents of model to $agents
     */
    public function setAgents() {
        foreach ($this->rAgents as $value) {
            $this->agent[$value->id] = $value->id;
        }
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
     * Check if user need change pass
     * @return 0 -> Dont need/1 -> Need change
     */
    public function needChangePass() {
        $retVal = DomainConst::NUMBER_ZERO_VALUE;
        if ($this->status == Users::STATUS_NEED_CHANGE_PASS) {
            $retVal = DomainConst::NUMBER_ONE_VALUE;
        }
        return $retVal;
    }

    /**
     * Get list customer of doctor
     * @return Array Array of customer id
     */
    public function getListCustomerOfDoctor($from, $to, $page) {
        $retVal = array();
        // Check relation rTreatmentSchedule is set
        if (isset($this->rTreatmentSchedule)) {
            // Loop for all treatment schedule
            foreach ($this->rTreatmentSchedule as $treatmentSchedule) {
//                if (isset($treatmentSchedule->rDetail)) {
//                    // Loop for all treatment schedule detail
//                    foreach ($treatmentSchedule->rDetail as $detail) {
//                        if ($detail->status == TreatmentScheduleDetails::STATUS_SCHEDULE) {
//                            $date = CommonProcess::convertDateTime($detail,
//                                    DomainConst::DATE_FORMAT_1,
//                                    DomainConst::DATE_FORMAT_4);
//                            $compareFrom = DateTimeExt::compare($date, $from);
//                            $compareTo = DateTimeExt::compare($date, $to);
//                            // Check if treatment schedule is between date range
//                            if (($compareFrom == 1 || $compareFrom == 0)
//                                    && ($compareTo == 0 || $compareTo == -1)) {
//                                // Check relation rMedicalRecord is set
//                                if (isset($treatmentSchedule->rMedicalRecord)) {
//                                    $medicalRecord = $treatmentSchedule->rMedicalRecord;
//                                    // Check relation rCustomer is set
//                                    if (isset($medicalRecord->rCustomer)) {
//                                        $customer = $medicalRecord->rCustomer;
//                                        if ($customer->status != DomainConst::DEFAULT_STATUS_INACTIVE) {
//            //                                $retVal[] = $customer->id;
//                                            $retVal[] = $customer;
//                                        }
//                                    }
//                                }
//                            }
//                        }
//                        
//                    }
//                }
                $date = CommonProcess::convertDateTime($treatmentSchedule->start_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_4);
                $compareFrom = DateTimeExt::compare($date, $from);
                $compareTo = DateTimeExt::compare($date, $to);
                // Check if treatment schedule is between date range
                if (($compareFrom == 1 || $compareFrom == 0) && ($compareTo == 0 || $compareTo == -1)) {
                    // Check relation rMedicalRecord is set
                    if (isset($treatmentSchedule->rMedicalRecord)) {
                        $medicalRecord = $treatmentSchedule->rMedicalRecord;
                        // Check relation rCustomer is set
                        if (isset($medicalRecord->rCustomer)) {
                            $customer = $medicalRecord->rCustomer;
                            if ($customer->status != DomainConst::DEFAULT_STATUS_INACTIVE) {
//                                $retVal[] = $customer->id;
                                $retVal[] = $customer;
                            }
                        }
                    }
                }
            }
        }
        $dataPro = new CActiveDataProvider('Customers', array(
            'data'  => $retVal,
            'pagination' => array(
                'pageSize' => Settings::getAPIListPageSize(),
                'currentPage'   => $page,
            ),
        ));
//        return $retVal;
        return $dataPro;
    }
    
    public function getListCustomersByDoctorAPI($from, $to, $page) {
//        if (!$this->isDoctor()) {
//            Loggers::info('Not doctor', '', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
//            $mCustomers = new Customers('search');
//            return new CActiveDataProvider($mCustomers, array(
//                    'pagination' => array(
//                        'pageSize' => Settings::getAPIListPageSize(),
//                        'currentPage'   => $page,
//                    ),
//                ));
//        }
        $data = array();
        foreach ($this->getAgentIds() as $agentId) {
            $mAgent = Agents::model()->findByPk($agentId);
            if ($mAgent) {
                $mAgent->doctor_id = $this->id;
                $aIdCus = [0];
                $scheduleByTime = $mAgent->getScheduleDetail($from, $to);
                if(empty($scheduleByTime)){
                    $scheduleByTime = [0];
                }
                $strScheduleByTime = implode(',', $scheduleByTime);
                $criteriaNew = new CDbCriteria;
                foreach ($mAgent->rJoinCustomer as $value) {
                    $aIdCus[$value->many_id] = $value->many_id;
                }
                $criteriaNew->select = ('t.*');
                if (!empty($mAgent->created_by)) {
                    $criteria = new CDbCriteria;
                    $criteria->compare('t.first_name', $mAgent->created_by, true);
                    $aUser = Users::model()->findAll($criteria);
                    $aId = [];
                    foreach ($aUser as $key => $value) {
                        $aId[] = $value->id;
                    }
                    $criteriaNew->addInCondition('t.created_by', $aId);
                }
                if (!empty($mAgent->doctor_id)) {
                    $criteria = new CDbCriteria;
                    $criteria->compare('t.first_name', $mAgent->doctor_id, true);
                    $aUser = Users::model()->findAll($criteria);
                    $aIdDoctor = [0];
                    foreach ($aUser as $key => $value) {
                        $aIdDoctor[] = $value->id;
                    }
                    $strDocTor = ' AND tr.doctor_id IN (' . implode(',', $aIdDoctor) . ')';
                }
                
                $criteriaNew->distinct = true;
                $criteriaNew->addInCondition('t.id', $aIdCus);
                //$strScheduleByTime
                $criteriaNew->join = 'JOIN (select re.* FROM medical_records as re JOIN treatment_schedules tr'
                                    . ' ON re.id = tr.record_id'
                                    . ' WHERE tr.id IN ('.$strScheduleByTime.') '.$strDocTor
                        . ' ) as b'
                        . ' ON b.customer_id = t.id';
                $mCustomers = new Customers('search');
                return new CActiveDataProvider($mCustomers, array(
                    'criteria' => $criteriaNew,
                    'pagination' => array(
                        'pageSize' => Settings::getListPageSize(),
                        'currentPage'   => $page,
                    ),
                ));
            }
        }
    }

    /**
     * Check if a user is a test user
     * @return boolean True if user have username is appletest, False otherwise
     */
    public function isTestUser() {
        $retVal = false;

        if (strtolower($this->username) == 'appletest') {
            $retVal = true;
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
     * Get image avatar path
     * @return String upload/admin/user/filename/png
     */
    public function getImageAvatarPath() {
        return self::UPLOAD_FOLDER . $this->img_avatar;
    }

    /**
     * Get full image url
     * @return String http://hostname/upload/admin/user/filename/png
     */
    public function getImageAvatarUrl() {
        return CommonProcess::getHostUrl() . $this->getImageAvatarPath();
    }

    /**
     * Get last token
     * @return ApiUserTokens object, empty if failed
     */
    public function getLastToken() {
        if (isset($this->rToken) && count($this->rToken) > 0) {
            return $this->rToken[0]->gcm_device_token;
        }
        return "";
    }

    /**
     * Check if user is staff role
     * @return True if user is staff, false otherwise
     */
    public function isStaff() {
        return Roles::isStaff($this->role_id);
    }
    
    /**
     * Check if user is doctor
     * @return boolean True if user is doctor, false otherwise
     */
    public function isDoctor() {
        return Roles::isDoctorRole($this->role_id);
    }

    /**
     * Get place issue Identity info
     * @return String City name
     */
    public function getPlaceIssue() {
        return isset($this->rPlaceIssue) ? $this->rPlaceIssue->name : '';
    }

    /**
     * Identity information
     * @return String Html string
     */
    public function getIdentityInfo() {
        $retVal = array();
        $retVal[] = $this->identity_number;
        if (!DateTimeExt::isDateNull($this->date_of_issue)) {
            $retVal[] = DomainConst::CONTENT00422 . ': ' . CommonProcess::convertDateTime($this->date_of_issue, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_3);
        }

        if (isset($this->rPlaceIssue)) {
            $retVal[] = DomainConst::CONTENT00423 . ': ' . $this->getPlaceIssue();
        }

        return implode('<br>', $retVal);
    }
    
    /**
     * Get department name
     * @return String Name of department
     */
    public function getDepartment() {
        if (isset($this->rDepartment)) {
            return $this->rDepartment->getName();
        }
        return '';
    }
    
    /**
     * Get gender
     * @return string Gender
     */
    public function getGender() {
        if (isset(CommonProcess::getGender()[$this->gender])) {
            return CommonProcess::getGender()[$this->gender];
        }
        return '';
    }
    
    /**
     * Get role name
     * @return string Name of role
     */
    public function getRoleName() {
        if (isset($this->rRole)) {
            return $this->rRole->role_short_name;
        }
        return '';
    }
    
    /**
     * Get birthday value
     * @return String Birthday
     */
    public function getBirthDay() {
        $retVal = CommonProcess::convertDateTime($this->birthday, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_BACK_END);
        if (empty($retVal)) {
            return $this->birthday;
        }
        return $retVal;
    }
    
    /**
     * Get date in value
     * @return String Date in
     */
    public function getDateIn() {
        $retVal = CommonProcess::convertDateTime($this->date_in, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_BACK_END);
        if (empty($retVal)) {
            return $this->date_in;
        }
        return $retVal;
    }
    
    /**
     * Get creator
     * @return string Creator name
     */
    public function getCreatedBy() {
        if (isset($this->rCreatedBy)) {
            return $this->rCreatedBy->getFullName();
        }
        return '';
    }
    
    /**
     * Get contract type
     * @return string Name of contract type
     */
    public function getContractType() {
        if (isset($this->rContractType)) {
            return $this->rContractType->name;
        }
        return '';
    }
    
    /**
     * Get email infor
     * @return String Email
     */
    public function getEmail() {
        if (!empty($this->email)) {
            return $this->email;
        }
        return $this->getSocialNetwork(SocialNetworks::TYPE_NETWORK_EMAIL);
    }
    
    /**
     * Check if user is belong to agent
     * @param String $agentId Id of agent
     * @return boolean True if user is belong to agent, false otherwise
     */
    public function isBelongAgent($agentId) {
        foreach ($this->rAgents as $agent) {
            if ($agent->id == $agentId) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Handle change format of data before save
     */
    public function handleBeforeSave() {
        // Convert value of salary from formated value to save value
        $this->base_salary = str_replace(DomainConst::SPLITTER_TYPE_MONEY, '', $_POST['Users']['base_salary']);
        $this->social_insurance_salary = str_replace(DomainConst::SPLITTER_TYPE_MONEY, '', $_POST['Users']['social_insurance_salary']);
        $this->responsible_salary = str_replace(DomainConst::SPLITTER_TYPE_MONEY, '', $_POST['Users']['responsible_salary']);
        $this->subvention = str_replace(DomainConst::SPLITTER_TYPE_MONEY, '', $_POST['Users']['subvention']);
    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------    
    /**
     * Get list status of treatment schedule object
     * @return Array
     */
    public static function getStatus() {
        return array(
            Users::STATUS_INACTIVE => DomainConst::CONTENT00028,
            Users::STATUS_ACTIVE => DomainConst::CONTENT00027,
            Users::STATUS_NEED_CHANGE_PASS => DomainConst::CONTENT00212,
        );
    }

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
            if ($model->status != DomainConst::DEFAULT_STATUS_INACTIVE) {
                $_items[$model->id] = $model->username;
            }
        }
        return $_items;
    }

    /**
     * Get current user object
     * @return Users Model of user
     */
    public static function getCurrentUser() {
        return Users::model()->findByAttributes(array(
                    // [NguyenPT]: TODO - Investigate should use 'username' or 'id'
                    DomainConst::KEY_USERNAME => Yii::app()->user->id
        ));
    }

    /**
     * Get user by user name
     * @param String $username Username value
     * @return User object
     */
    public static function getUserByUsername($username) {
        return Users::model()->findByAttributes(array(
                    DomainConst::KEY_USERNAME => $username
        ));
    }

    /**
     * Get list of user
     * @param String $roleId Id of role
     * @param String $agentId Id of agent
     */
    public static function getListUser($roleId = '', $agentId = '') {
        $criteria = new CDbCriteria();
        $criteria->compare('t.role_id', $roleId);
//        $aModel = self::model()->findAll($criteria);
//        $retVal = array();
//        foreach ($aModel as $model) {
////            if ($model->getAgentId() == $agentId) {
//            if (in_array($agentId, $model->getAgentIds())) {
//                if ($model->status != DomainConst::DEFAULT_STATUS_INACTIVE) {
//                    $retVal[$model->id] = $model->getFullName();
//                }
//            }
//        }
        
        $criteria->addCondition('t.status !='. DomainConst::DEFAULT_STATUS_INACTIVE);
        $tblOneMany = OneMany::model()->tableName();
        $criteria->join = 'JOIN ' .$tblOneMany .' as o ON o.many_id = t.id';
        $criteria->compare('o.type', OneMany::TYPE_AGENT_USER);
        if(is_array($agentId)){
            $criteria->addInCondition('o.one_id', $agentId);
        }else{
            $criteria->compare('o.one_id', $agentId);
        }
        $aModel = self::model()->findAll($criteria);
        $retVal = array();
        foreach ($aModel as $model) {
            $retVal[$model->id] = $model->getFullName();
        }
        return $retVal;
    }
    
    /**
     * Get array users by array id
     * @param Array $aId    Array id
     * @return type
     */
    public static function getArrayModelByArrayId($aId) {
        $criteria = new CDbCriteria();
        if (is_array($aId)) {
            $sParamIn = implode(',', $aId);
            if (!empty($sParamIn)) {
                $criteria->addCondition("t.id IN ($sParamIn)");
            } else {
                return array();
            }
        }

//        $criteria->compare("t.status", DomainConst::DEFAULT_STATUS_ACTIVE);
        $criteria->addCondition("t.status!=" . DomainConst::DEFAULT_STATUS_INACTIVE);
        return Users::model()->findAll($criteria);
    }

    /**
     * Get list user have username start with parameter $username
     * @param String $username Username value
     * @return Array user models
     */
    public static function getListUserHaveUsernameStartWith($username) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.username like '%$username%'");
        $models = Users::model()->findAll($criteria);
        $retVal = array();
        foreach ($models as $model) {
            if (CommonProcess::getUsernameFromFullName($model->first_name) === $username) {
                $retVal[] = $model;
            }
        }
        return $retVal;
    }

    /**
     * Generate username string from fullname and database
     * @param String $fullName
     * @return String
     */
    public static function generateUsername($fullName) {
        $username = CommonProcess::getUsernameFromFullName($fullName);
        $arrUser = self::getListUserHaveUsernameStartWith($username);
        if (empty($arrUser)) {
            return $username;
        }
        return $username . count($arrUser);
    }

    /**
     * Get list of user's emails
     * @param Array $except List of exception condition
     * @return Array List of users
     */
    public static function getListUserEmail($except = array()) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.status=' . Users::STATUS_ACTIVE . ' AND role_id<>' . Roles::getRoleByName(Roles::ROLE_CUSTOMER)->id);
        if (isset($except['roles'])) {
            $sParamsIn = implode(DomainConst::SPLITTER_TYPE_2, $except['roles']);
            $criteria->addCondition("t.role_id NOT IN($sParamsIn)");
        }
        if (isset($except['ids'])) {
            $sParamsIn = implode(DomainConst::SPLITTER_TYPE_2, $except['ids']);
            if (!empty($sParamsIn)) {
                $criteria->addCondition("t.id NOT IN ($sParamsIn)");
            }
        }
        $criteria->addCondition('t.email <> "" AND t.email IS NOT NULL');

        return Users::model()->findAll($criteria);
    }

    /**
     * Get doctor by name (and agent id)
     * @param String $name Name of doctor
     * @param String $agentId Id of agent
     * @return Model Users
     */
    public static function getDoctorByName($name, $agentId) {
        if (empty($name)) {
            return NULL;
        }
        $name = strtolower($name);
        $criteria = new CDbCriteria();
        $criteria->compare('role_id', '6', true);
        $criteria->compare('address_vi', $name, true, 'AND');
        $user = NULL;
        $models = Users::model()->findAll($criteria);
//        $models = self::model()->findAll('LOWER(first_name)="'.  strtolower($name).'"');
        foreach ($models as $model) {
            if ($model->getAgentId() == $agentId) {
                $user = $model;
                break;
            }
        }
        return $user;
    }

    public static function getUserByName($name, $role_id = '') {
        if (empty($name)) {
            return NULL;
        }
        $nameArr = array(
            'Nguyen Dinh Troi'  => 'Nguyễn Đình Trợi',
            'Do Thi Thuy Lieu'  => 'Đỗ Thị Thúy Liễu',
            'Đỗ Văn Bách'       => 'bach',
        );
        if (isset($nameArr[$name])) {
            $name = $nameArr[$name];
        }
        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('t.first_name', $name, true);
        $model = self::model()->find($criteria);
        return $model;
    }
    
    /**
     * Get user full name by id
     * @param String $id Id of user
     * @return string Name of user
     */
    public static function getUserFullNameById($id) {
        $retVal = '';
        $model = self::model()->findByPk($id);
        if ($model) {
            return $model->getFullName();
        }
        
        return $retVal;
    }

}
