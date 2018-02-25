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
}