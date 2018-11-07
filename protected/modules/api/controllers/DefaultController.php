<?php

class DefaultController extends APIController
{
    /**
     * Index action.
     */
    public function actionIndex()
    {
		$this->render('index',array(
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
    }
    
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
     * P0001_Login_API
     * Login system
     * - url:  api/default/login
     * - parameter:
     *  + username: Username
     *  + password: Password
     */
    public function actionLogin() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_USERNAME,
                DomainConst::KEY_PASSWORD
            ));
            // Get user login
            $mUser = $this->getUserModel($root->username);
            ApiUserTokens::validateLogin($this, $mUser, $result, $root);
            
            $mUserToken = ApiUserTokens::makeNewToken($mUser, $root);
            CreateResponse::loginResponse($mUserToken->token, $mUser, $this);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0002_Logout_API
     * Logout system
     * - url:  api/default/logout
     * - parameter:
     *  + token: Token
     */
    public function actionLogout() {
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
            // Remove all tokens
            ApiUserTokens::deleteTokens($root->token);
            
            $result = ApiModule::$defaultSuccessResponse;
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00187;
            ApiModule::sendResponse($result, $this);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }    
    
    /**
     * P0006_ConfigData_API
     * Logout system
     * - url:  api/default/updateConfig
     * - parameter:
     *  + token: Token
     */
    public function actionUpdateConfig() {
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
            
            CreateResponse::loginResponse($root->token, $mUser, $this);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0019_GetListStreets_API
     * Get list street
     * - url:   api/default/listStreets
     * - parameter:
     *  + token:            Token
     *  + id:               Id of city
     *  + page:             Index of page (-1: get all records)
     */
    public function actionListStreets() {
        try {
            $resultFailed = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse request to json
            $root = json_decode($_POST[DomainConst::KEY_ROOT_REQUEST]);
            // Check if parameters are exist
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_ID,
                DomainConst::KEY_PAGE
            ));
            // Get user by token value
            $mUser = $this->getUserByToken($resultFailed, $root->token);
            // Check version
            $this->checkVersion($root, $mUser);
            
            CreateResponse::streetsListResp($root, $mUser, $this);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0021_CreatePathological_API
     * Create pathological
     * - url:   api/default/createPathological
     * - parameter:
     *  + token:            Token
     *  + name:             Name
     *  + description:      Description
     */
    public function actionCreatePathological() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse request to json
            $root = json_decode($_POST[DomainConst::KEY_ROOT_REQUEST]);
            // Check if parameters are exist
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_NAME,
                DomainConst::KEY_DESCRIPTION
            ));
            // Get user by token value
            $mUser = $this->getUserByToken($result, $root->token);
            // Check version
            $this->checkVersion($root, $mUser);
            
            $this->handleCreatePathological($result, $mUser, $root);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * Handle create pathological
     * @param type $result
     * @param type $mUser
     * @param type $root
     */
    public function handleCreatePathological($result, $mUser, $root) {
        $name = $root->name;
        if (!Pathological::isNameExist($name)) {
            $model = new Pathological();
            $model->name = $name;
            $model->description = $root->description;
            if ($model->save()) {
                // Success
                $result = ApiModule::$defaultSuccessResponse;
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00292;
                $result[DomainConst::KEY_DATA] = CommonProcess::createConfigJson(
                        $model->id, $name);
                ApiModule::sendResponse($result, $this);
            } else {
                // Finnaly send failed response with error detail
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00214
                        . '<br>'
                        . CommonProcess::json_encode_unicode($model->getErrors());
                ApiModule::sendResponse($result, $this);
            }
        } else {
            // Pathological is exist -> can not create
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00291;
            ApiModule::sendResponse($result, $this);
        }
    }
    
    /**
     * P0022_CreateDiagnosis_API
     * Create diagnosis
     * - url:   api/default/createDiagnosis
     * - parameter:
     *  + token:            Token
     *  + name:             Name
     *  + description:      Description
     */
    public function actionCreateDiagnosis() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse request to json
            $root = json_decode($_POST[DomainConst::KEY_ROOT_REQUEST]);
            // Check if parameters are exist
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_NAME,
                DomainConst::KEY_DESCRIPTION
            ));
            // Get user by token value
            $mUser = $this->getUserByToken($result, $root->token);
            // Check version
            $this->checkVersion($root, $mUser);
            
            $this->handleCreateDiagnosis($result, $mUser, $root);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * Handle create diagnosis.
     * @param type $result
     * @param type $mUser
     * @param type $root
     */
    public function handleCreateDiagnosis($result, $mUser, $root) {
        $name = CommonProcess::getValueFromJson($root, DomainConst::KEY_NAME);
        $otherGroupId = Diagnosis::getOtherDiagnosisId();
        if (!Diagnosis::isNameExist($name) && !empty($otherGroupId)) {
            $model = new Diagnosis();
            $model->code = "-";
            $model->name = $name;
            $model->name_en = $name;
            $model->description = $name;
            $model->parent_id = $otherGroupId;
            if ($model->save()) {
                // Success
                $result = ApiModule::$defaultSuccessResponse;
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00334;
                $result[DomainConst::KEY_DATA] = CommonProcess::createConfigJson(
                        $model->id, $name);
                ApiModule::sendResponse($result, $this);
            }
        } else if (Diagnosis::isNameExist($name)) {
            // Diagnosis is exist -> can not create
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00332;
            ApiModule::sendResponse($result, $this);
        } else if (empty($otherGroupId)) {
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00333;
            ApiModule::sendResponse($result, $this);
        }
    }
    
    /**
     * P0025_CustomerLogin_API
     * Login system
     * - url:  api/default/loginCustomer
     * - parameter:
     *  + phone: Phone number
     */
    public function actionLoginCustomer() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_PHONE
            ));
            $model = ApiSigninRequests::createNew($root->{DomainConst::KEY_PHONE});
            if ($model != NULL) {
                // Send OTP sms
                SMSHandler::sendSMSOTP($model->phone, $model->code);
                $result = ApiModule::$defaultSuccessResponse;
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00194;
                ApiModule::sendResponse($result, $this);
            } else {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00214;
                ApiModule::sendResponse($result, $this);
            }
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0026_CustomerLoginConfirm_API
     * Login system
     * - url:  api/default/loginCustomerConfirm
     * - parameter:
     *  + phone: Phone number
     *  + otp: OTP code
     */
    public function actionLoginCustomerConfirm() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_PHONE,
                DomainConst::KEY_OTP
            ));
            $phone = $root->{DomainConst::KEY_PHONE};
            $otp = $root->{DomainConst::KEY_OTP};
            // Validate phone and otp
            if (!ApiSigninRequests::validateOTP($phone, $otp)) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00563;
                ApiModule::sendResponse($result, $this);
            }
            // Get user login
            $mUser = $this->getUserModel($root->{DomainConst::KEY_PHONE});
            if (!isset($mUser)) {
                Loggers::info('User not found', $phone, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
                // Not found user
                $mUser = Users::createNewCustomerUser($root->{DomainConst::KEY_PHONE});
            }
            ApiUserTokens::validateCustomerLogin($this, $mUser, $result);
            $mUserToken = ApiUserTokens::makeNewToken($mUser, $root);
            CreateResponse::loginResponse($mUserToken->token, $mUser, $this);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
}