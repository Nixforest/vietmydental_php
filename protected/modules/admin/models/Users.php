<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $temp_password
 * @property string $first_name
 * @property string $last_name
 * @property string $code_account
 * @property string $img_avatar
 * @property string $address
 * @property string $address_vi
 * @property string $house_numbers
 * @property integer $province_id
 * @property integer $district_id
 * @property integer $ward_id
 * @property integer $street_id
 * @property integer $login_attemp
 * @property string $created_date
 * @property string $last_logged_in
 * @property string $ip_address
 * @property integer $role_id
 * @property integer $application_id
 * @property integer $status
 * @property string $gender
 * @property string $phone
 * @property string $verify_code
 * @property string $slug
 * @property string $address_temp
 * @property string $created_by
 */
class Users extends BaseActiveRecord
{
    public $password_confirm, $currentpassword, $newpassword; /* for change pass in admin */
    public $agent;
    
    //-----------------------------------------------------
    // Autocomplete fields
    //-----------------------------------------------------
    public $autocomplete_name_street;
    
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const STATUS_INACTIVE               = 0;
    const STATUS_ACTIVE                 = 1;
    const STATUS_NEED_CHANGE_PASS       = 2;
//    const STATUS_COMPLETED              = 3;
    const UPLOAD_FOLDER                 = 'upload/admin/users/';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password_hash, created_date, ip_address, role_id, application_id', 'required'),
			array('province_id, district_id, ward_id, street_id, login_attemp, role_id, application_id, status', 'numerical', 'integerOnly'=>true),
			array('username, last_name', 'length', 'max'=>50),
			array('email', 'length', 'max'=>80),
			array('first_name', 'length', 'max'=>150),
			array('code_account, ip_address', 'length', 'max'=>30),
			array('img_avatar, address_vi', 'length', 'max'=>255),
			array('gender', 'length', 'max'=>6),
			array('phone', 'length', 'max'=>200),
			array('verify_code', 'length', 'max'=>100),
			array('slug', 'length', 'max'=>300),
			array('created_by', 'length', 'max'=>11),
			array('address, house_numbers, last_logged_in, address_temp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, email, first_name, last_name, code_account, address, address_vi, house_numbers, province_id, district_id, ward_id, street_id, login_attemp, created_date, last_logged_in, ip_address, role_id, application_id, status, gender, phone, verify_code, slug, address_temp, created_by', 'safe', 'on'=>'search'),
                        array('currentpassword', 'comparePassword', 'on'=>'changeMyPassword'),
                        array('currentpassword, newpassword, password_confirm', 'required','on' => "changeMyPassword"),
                        array('newpassword','length', 'min'=>DomainConst::PASSW_LENGTH_MIN, 'max'=>DomainConst::PASSW_LENGTH_MAX,
                            'tooLong'=>'Mật khẩu mới quá dài (tối đa '.DomainConst::PASSW_LENGTH_MAX.' ký tự).',
                            'tooShort'=>'Mật khẩu mới quá ngắn (tối thiểu '.DomainConst::PASSW_LENGTH_MIN.' ký tự).',
                            'on'=>'changeMyPassword'),
                        array('password_confirm', 'compare', 'compareAttribute'=>'newpassword','message'=>'Xác nhận mật khẩu mới không đúng.' ,'on'=>'changeMyPassword'),
                        array('newpassword, password_confirm', 'required','on' => "resetPassword"),
                        array('newpassword','length', 'min'=>DomainConst::PASSW_LENGTH_MIN, 'max'=>DomainConst::PASSW_LENGTH_MAX,
                            'tooLong'=>'Mật khẩu mới quá dài (tối đa '.DomainConst::PASSW_LENGTH_MAX.' ký tự).',
                            'tooShort'=>'Mật khẩu mới quá ngắn (tối thiểu '.DomainConst::PASSW_LENGTH_MIN.' ký tự).',
                            'on'=>'resetPassword'),
                        array('password_confirm', 'compare', 'compareAttribute'=>'newpassword','message'=>'Xác nhận mật khẩu mới không đúng.' ,'on'=>'resetPassword'),
                        array('first_name, province_id, district_id, house_numbers', 'required','on'=>'updateProfile'),
                        array('img_avatar', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true, 'safe' => true),
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
                    'rRole' => array(self::BELONGS_TO, 'Roles', 'role_id'),
                    'application' => array(self::BELONGS_TO, 'Applications', 'application_id'),
                    'rActionsUser'  => array(self::HAS_MANY, 'ActionsUsers', 'user_id'),
                    'rCity' => array(self::BELONGS_TO, 'Cities', 'province_id'),
                    'rDistrict' => array(self::BELONGS_TO, 'Districts', 'district_id'),
                    'rWard' => array(self::BELONGS_TO, 'Wards', 'ward_id'),
                    'rStreet' => array(self::BELONGS_TO, 'Streets', 'street_id'),
                    'rJoinAgent' => array(
                        self::HAS_MANY, 'OneMany', 'many_id',
                        'on'    => 'type = ' . OneMany::TYPE_AGENT_USER,
                        'order' => 'id DESC',
                    ),
                    'rTreatmentSchedule' => array(
                        self::HAS_MANY, 'TreatmentSchedules', 'doctor_id',
                        'on'    => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
                        'order' => 'id DESC',
                    ),
                    'rSocialNetwork' => array(
                        self::HAS_MANY, 'SocialNetworks', 'object_id',
                        'on'    => 'type = ' . SocialNetworks::TYPE_USER,
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
                    'rAgents' =>array(self::MANY_MANY, 'Agents', 'one_many(many_id,one_id)',
                        'condition' => 'rAgents_rAgents.type = ' . OneMany::TYPE_AGENT_USER,
                        'order'=> 'rAgents_rAgents.id DESC') ,
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => DomainConst::CONTENT00195,
			'email' => DomainConst::CONTENT00040,
			'password_hash' => DomainConst::CONTENT00041,
			'temp_password' => DomainConst::CONTENT00196,
			'first_name' => DomainConst::CONTENT00042,
			'last_name' => DomainConst::CONTENT00043,
			'code_account' => DomainConst::CONTENT00044,
			'address' => DomainConst::CONTENT00045,
			'address_vi' => 'Address Vi',
			'house_numbers' => DomainConst::CONTENT00106,
			'province_id' => DomainConst::CONTENT00102,
			'district_id' => DomainConst::CONTENT00103,
			'ward_id' => DomainConst::CONTENT00104,
			'street_id' => DomainConst::CONTENT00105,
			'login_attemp' => 'Login Attemp',
			'created_date' => DomainConst::CONTENT00010,
			'last_logged_in' => 'Last Logged In',
			'ip_address' => 'Ip Address',
			'role_id' => DomainConst::CONTENT00046,
			'application_id' => 'Application',
			'status' => DomainConst::CONTENT00026,
			'gender' => DomainConst::CONTENT00047,
			'phone' => DomainConst::CONTENT00048,
                        'img_avatar' => DomainConst::CONTENT00252,
			'verify_code' => 'Verify Code',
			'slug' => 'Slug',
			'address_temp' => 'Address Temp',
			'created_by' => 'Created By',
                        'agent' => DomainConst::CONTENT00199,
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password_hash',$this->password_hash,true);
		$criteria->compare('temp_password',$this->temp_password,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('code_account',$this->code_account,true);
		$criteria->compare('img_avatar',$this->img_avatar,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('address_vi',$this->address_vi,true);
		$criteria->compare('house_numbers',$this->house_numbers,true);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('district_id',$this->district_id);
		$criteria->compare('ward_id',$this->ward_id);
		$criteria->compare('street_id',$this->street_id);
		$criteria->compare('login_attemp',$this->login_attemp);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('last_logged_in',$this->last_logged_in,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('role_id',$this->role_id);
                if (CommonProcess::isUserAdmin()) {
                    // Root admin
                    
                } else {
                    // The other roles
                    $criteria->addCondition('t.role_id !=' . Roles::getRoleByName(Roles::ROLE_ADMIN)->id);
                    $criteria->addCondition('t.role_id !=' . Roles::getRoleByName(Roles::ROLE_MANAGER)->id);
                }
		$criteria->compare('application_id',$this->application_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('verify_code',$this->verify_code,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('address_temp',$this->address_temp,true);
		$criteria->compare('created_by',$this->created_by,true);
                $criteria->order = 'id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
	public static function model($className=__CLASS__)
	{
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
                $this->province_id, $this->district_id,
                $this->ward_id, $this->street_id,
                $this->house_numbers);
        $this->address_vi = CommonProcess::removeSign(
                $this->first_name . ' ' .
                $this->username . ' ' .
                $this->phone . ' ' .
                $this->email . ' ' .
                $this->address);
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
     * Get autocomplete user name
     * @return String [username - last_name first_name]
     */
    public function getAutoCompleteUserName() {
        $retVal = $this->username;
        if (!empty($this->last_name)) {
            $retVal .= ' - ' . $this->last_name;
        }
        if (!empty($this->first_name)) {
            $retVal .= ' ' . $this->first_name;
        }
        
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
    public function getListCustomerOfDoctor($from, $to) {
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
                if (($compareFrom == 1 || $compareFrom == 0)
                        && ($compareTo == 0 || $compareTo == -1)) {
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
        
        return $retVal;
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
        if (isset($this->rToken)
                && count($this->rToken) > 0) {
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

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------    
    /**
     * Get list status of treatment schedule object
     * @return Array
     */
    public static function getStatus() {
        return array(
            Users::STATUS_INACTIVE          => DomainConst::CONTENT00028,
            Users::STATUS_ACTIVE            => DomainConst::CONTENT00027,
            Users::STATUS_NEED_CHANGE_PASS  => DomainConst::CONTENT00212,
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
        $aModel = self::model()->findAll($criteria);
        $retVal = array();
        foreach ($aModel as $model) {
            if ($model->getAgentId() == $agentId) {
                if ($model->status != DomainConst::DEFAULT_STATUS_INACTIVE) {
                    $retVal[$model->id] = $model->getFullName();
                }
            }
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
        $criteria = new CDbCriteria();
        $criteria->compare('role_id', '6', true);
        $criteria->compare('address_vi', $name, true, 'AND');
        $user = NULL;
        $models = Users::model()->findAll($criteria);
        foreach ($models as $model) {
            if ($model->getAgentId() == $agentId) {
                $user = $model;
                break;
            }
        }
        return $user;
    }
}
