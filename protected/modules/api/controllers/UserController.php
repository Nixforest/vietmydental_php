<?php

class UserController extends APIController
{
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            $arr = array(
                DomainConst::KEY_STATUS     => DomainConst::API_RESPONSE_STATUS_FAILED,
                DomainConst::KEY_CODE       => $error[DomainConst::KEY_CODE],
                DomainConst::KEY_MESSAGE    => $error[DomainConst::KEY_MESSAGE]
            );
        }
    }
    
    /**
     * P0003_UserProfile_API
     * Get profile of user
     * - url:  api/user/profile
     * - parameter:
     *  + token: Token
     */
    public function actionProfile() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN
            ));
            // Get user
            $mUser = $this->getUserByToken($result, $root->token);
            CreateResponse::userProfileResp($mUser, $this);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0004_UpdateProfile_API
     * Update user profile information
     * - url:  api/user/update
     * - parameter:
     *  + token:            Token
     *  + name:             Name of user
     *  + city_id:          Id of city
     *  + district_id:      Id of district
     *  + ward_id:          Id of ward
     *  + street_id:        Id of street
     *  + house_numbers:    House number
     *  + email:            Email
     *  + agent_id:         Id of agent
     */
    public function actionUpdate() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_NAME,
                DomainConst::KEY_CITY_ID,
                DomainConst::KEY_DISTRICT_ID,
                DomainConst::KEY_WARD_ID,
                DomainConst::KEY_STREET_ID,
                DomainConst::KEY_HOUSE_NUMBER,
                DomainConst::KEY_EMAIL
            ));
            // Get user
            $mUser = $this->getUserByToken($result, $root->token);
            $this->handleUpdateUser($result, $mUser, $root);
            $result = ApiModule::$defaultSuccessResponse;
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00035;
            ApiModule::sendResponse($result, $this);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0005_UserChangePass_API
     * Update user login password
     * - url:  api/user/changePass
     * - parameter:
     *  + token:            Token
     *  + old_password:     Current password
     *  + new_password:     New password
     */
    public function actionChangePass() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_OLD_PASSWORD,
                DomainConst::KEY_NEW_PASSWORD
            ));
            // Get user
            $mUser = $this->getUserByToken($result, $root->token);
            // Check value of password
            $error = $mUser->validatePasswordChange($root->old_password, $root->new_password);
            if (!empty($error)) {   // Validate failed
                $result[DomainConst::KEY_MESSAGE] = $error;
                ApiModule::sendResponse($result, $this);
            } else {                // Validate success
                if ($mUser->changePassword($root->new_password)) {
                    // Change success
                    $result = ApiModule::$defaultSuccessResponse;
                    $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00213;
                    ApiModule::sendResponse($result, $this);
                } else {    // Change failed
                    $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00214 . ' ' . $mUser->getErrors();
                    ApiModule::sendResponse($result, $this);
                }
            }
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }


    /**
     * Handle update user information
     * @param type $result
     * @param type $mUser
     * @param type $root
     */
    public function handleUpdateUser($result, $mUser, $root) {
        $mUser->scenario    = 'updateProfile';
        $mUser->first_name      = trim($root->name);
        $mUser->email           = trim($root->email);
        $mUser->province_id     = trim($root->city_id);
        $mUser->district_id     = trim($root->district_id);
        $mUser->ward_id         = trim($root->ward_id);
        $mUser->street_id       = trim($root->street_id);
        $mUser->house_numbers   = trim($root->house_numbers);
        $mUser->validate();
        $mUser->setAgents();
        if ($mUser->hasErrors()) {
            $result[DomainConst::KEY_MESSAGE] = CreateResponse::fortmatErrorsModel($mUser->getErrors());
            ApiModule::sendResponse($result, $this);
        }
        
        $aUpdate = array('first_name', 'email', 'province_id', 'district_id', 'ward_id', 'street_id', 'house_numbers', 'address_vi', 'address');
        if ($mUser->update($aUpdate)) {
            // Remove old record
            OneMany::deleteAllManyOldRecords($mUser->id, OneMany::TYPE_AGENT_USER);
            OneMany::insertOne($root->agent_id, $mUser->id, OneMany::TYPE_AGENT_USER);
        }
    }
}