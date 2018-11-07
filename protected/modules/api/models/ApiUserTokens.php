<?php

/**
 * This is the model class for table "api_user_tokens".
 *
 * The followings are the available columns in table 'api_user_tokens':
 * @property string $id
 * @property integer $type
 * @property string $user_id
 * @property string $username
 * @property integer $role_id
 * @property string $token
 * @property string $gcm_device_token
 * @property string $apns_device_token
 * @property string $last_active
 * @property string $created_date
 */
class ApiUserTokens extends BaseActiveRecord
{   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ApiUserTokens the static model class
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
		return 'api_user_tokens';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('user_id, token', 'required', 'on'=> 'makeNewToken'),
			array('user_id, username, token, created_date', 'required'),
			array('type, role_id', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('username, token', 'length', 'max'=>50),
			array('gcm_device_token', 'length', 'max'=>350),
			array('apns_device_token', 'length', 'max'=>255),
			array('last_active', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, user_id, username, role_id, token, gcm_device_token, apns_device_token, last_active, created_date', 'safe', 'on'=>'search'),
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
                    'rUser' => array(self::BELONGS_TO, 'Users', 'user_id'),
                    'rRole' => array(self::BELONGS_TO, 'Roles', 'role_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'user_id' => 'User',
			'username' => 'Username',
			'role_id' => 'Role',
			'token' => 'Token',
			'gcm_device_token' => 'Gcm Device Token',
			'apns_device_token' => 'Apns Device Token',
			'last_active' => 'Last Active',
			'created_date' => 'Created Date',
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
		$criteria->compare('type',$this->type);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('gcm_device_token',$this->gcm_device_token,true);
		$criteria->compare('apns_device_token',$this->apns_device_token,true);
		$criteria->compare('last_active',$this->last_active,true);
		$criteria->compare('created_date',$this->created_date,true);
                $criteria->order = 'created_date DESC';

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
        if ($this->isNewRecord) {   // Add
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        } else {                    // Update
            
        }
        return parent::beforeSave();
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Check token is exist
     * @param String $username User name
     * @param String $token User token
     * @return boolean True if token is exist, false otherwise
     */
    public function checkToken($username, $token) {
        $criterial = new CDbCriteria;
        $criterial->compare('t.username', $username);
        $criterial->compare('t.token', $token);
        if (self::model()->count($criterial) > 0) {
            return true;
        }
        return false;
    }
    
    public function saveLoginLog() {
        LoginLogs::insertOne(
                $this->type,
                "",
                $this->user_id,
                $this->role_id);
    }
    
    /**
     * Get model user by token
     * @param String $token
     * @return User model
     */
    public static function getModelUser($token) {
        $token = trim($token);
        if (empty($token)) {
            return null;
        }
        $criteria = new CDbCriteria;
        $criteria->compare('token', $token);
        $model = self::model()->find($criteria);
        if ($model) {
            return $model->rUser;
        }
        return null;
    }
    
    /**
     * Delete all tokens
     * @param String $token Token value
     */
    public static function deleteTokens($token) {
        if (empty($token)) {
            return;
        }
        $criteria = new CDbCriteria;
        $criteria->compare('token', $token);
        self::model()->deleteAll($criteria);
    }
    
    /**
     * Check login is valid
     * @param type $objController
     * @param type $mUser
     * @param type $result
     * @param type $root
     */
    public static function validateLogin($objController, $mUser, $result, $root) {
        if (!$mUser) {  // User not exist
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00183;
            ApiModule::sendResponse($result, $objController);
        } else if (!$mUser->validatePassword($root->password)) {    // Wrong password
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00184;
            ApiModule::sendResponse($result, $objController);
        } else if ($mUser->status == DomainConst::DEFAULT_STATUS_INACTIVE) {  // Inactive user
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00183;
            ApiModule::sendResponse($result, $objController);
        } else if (empty($root->gcm_device_token) && empty($root->apns_device_token)) { // Empty device token
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00185;
            ApiModule::sendResponse($result, $objController);
        }
    }
    /**
     * Check login is valid
     * @param DefaultController $objController
     * @param Users $mUser
     * @param Array $result
     */
    public static function validateCustomerLogin($objController, $mUser, $result) {
        if (!$mUser) {  // User not exist
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00183;
            ApiModule::sendResponse($result, $objController);
        } else if ($mUser->status == DomainConst::DEFAULT_STATUS_INACTIVE) {  // Inactive user
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00183;
            ApiModule::sendResponse($result, $objController);
        }
    }
    
    public static function makeNewTokenSaveData($mUser, $token, $gcm, $apns, $type) {
        $mUserToken = new ApiUserTokens('makeNewToken');
        // Get data from model User
        $mUserToken->user_id    = $mUser->id;
        $mUserToken->role_id    = $mUser->role_id;
        $mUserToken->username   = $mUser->username;
        
        // Create token
        if (empty($token)) {
            $mUserToken->token = CommonProcess::generateSessionIdByModel('ApiUserTokens', 'token');
        } else {
            $mUserToken->token = $token;
        }
        // Create device token
        $mUserToken->gcm_device_token = $gcm;
        $mUserToken->apns_device_token = $apns;
        if (!empty($gcm)) {
            $mUserToken->type = DomainConst::PLATFORM_ANDROID;
        } else if (!empty($apns)) {
            $mUserToken->type = DomainConst::PLATFORM_IOS;
        } else {
            if (!empty($type)) {
                $mUserToken->type = $type;
            }
        }
        
        // Handle time
        $currentTime = CommonProcess::getCurrentDateTime();
        $mUserToken->last_active = $currentTime;
        $mUserToken->created_date = $currentTime;
//        $mUserToken->save();
        if ($mUserToken->save()) {
            $mUserToken->saveLoginLog();
        } else {
            CommonProcess::dumpVariable($mUserToken->getErrors());
        }
        // TODO - Save track login
        return $mUserToken;
    }
    
    public static function makeNewToken($mUser, $root) {
        $token = '';
        $gcm = '';
        $apns = '';
        $type = '';
        if (!empty($root->gcm_device_token)) {
            $gcm = $root->gcm_device_token;
            $type = DomainConst::PLATFORM_ANDROID;
        } else if (!empty($root->apns_device_token)) {
            $apns = $root->apns_device_token;
            $type = DomainConst::PLATFORM_IOS;
        }
        return ApiUserTokens::makeNewTokenSaveData($mUser, $token, $gcm, $apns, $type);
    }
}