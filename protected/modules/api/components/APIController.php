<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of APIController
 *
 * @author NguyenPT
 */
class APIController extends CController {
    /** API request logs */
    public $mRequestLog;
    
    /**
     * Init function
     */
    public function init()
    {
        parent::init();
    }
    
    /**
     * 
     * @param type $DataProvider
     * @return type
     */
    public function dataProviderToArray($DataProvider) {
        if(is_object($DataProvider)) {
            $result = array();
            $data = $DataProvider->data;
            foreach($data as $item){
                $result[] = $item->attributes;
            }
            return $result;
        }
    }
    
    /**
     * Check request.
     */
    public function checkRequest() {
        if (Settings::canLogApiRequest()) {
            $this->writeRequestLog();
        }
        $method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        if ($method == 'POST') {    // Force to developer only use POST method when call API
            if (empty(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST))) {
                $result = ApiModule::$defaultFailedResponse;
                $result[DomainConst::KEY_MESSAGE] = ApiModule::RESP_MSG_MISS_ROOT;
                ApiModule::sendResponse($result, $this);
            } else {
                $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST), true);
                if (!is_array($root)) {
                    $result = ApiModule::$defaultFailedResponse;
                    $result[DomainConst::KEY_MESSAGE] = ApiModule::RESP_MSG_INVALID_REQ;
                    ApiModule::sendResponse($result, $this);
                }
            }
        } else {
            $result[DomainConst::KEY_MESSAGE] = ApiModule::RESP_MSG_INVALID_REQ;
            ApiModule::sendResponse($result, $this);
        }
    }
    
    /**
     * Check required parameters
     * @param type $root Root values
     * @param type $arrayOfFieldNames Array of field names
     */
    public function checkRequiredParam($root, $arrayOfFieldNames) {
        $arrOfInvalidFields = array();
        $isValid = true;
        if (!is_array($root)) {
            foreach ($arrayOfFieldNames as $field) {
                if (!isset($root->$field)) {
                    $isValid = false;
                    $arrOfInvalidFields[] = $field;
                }
            }
        } else {
            foreach ($arrayOfFieldNames as $field) {
                if (!isset($root[$field])) {
                    $isValid = false;
                    $arrOfInvalidFields[] = $field;
                }
            }
        }
        if (!$isValid) {
            $result = ApiModule::$defaultFailedResponse;
            $result[DomainConst::KEY_MESSAGE] = ApiModule::RESP_MSG_MISS_PARAM;
            $result[DomainConst::KEY_RECORD] = json_encode($arrOfInvalidFields);
            ApiModule::sendResponse($result, $this);
        }
    }
    
    /**
     * Get user by token
     * @param String $result Response
     * @param String $token User token
     */
    public function getUserByToken($result, $token) {
        $mUser = ApiUserTokens::getModelUser($token);
        if (is_null($mUser) || ($mUser && $mUser->status == DomainConst::DEFAULT_STATUS_INACTIVE)) {
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00162;
            $result[DomainConst::KEY_CODE]      = DomainConst::API_RESPONSE_CODE_UNAUTHORIZED;
            ApiModule::sendResponse($result, $this);
        }
        $this->setLogUserId($mUser->id);
        return $mUser;
    }
    
    /**
     * Get user model
     * @param String $username Username
     * @return User object
     */
    public function getUserModel($username) {
        $mUser = Users::getUserByUsername($username);
        if ($mUser) {
            $this->setLogUserId($mUser->id);
        }
        return $mUser;
    }
    
    public function setLogUserId($user_id) {
        if ($this->mRequestLog) {
            $this->mRequestLog->user_id = $user_id;
        }
    }
    
    /**
     * Check version of request
     * @param String $root Root array
     * @param Object $model User model
     * @param String $fieldNameAddError
     */
    public function checkVersion($root, &$model, $fieldNameAddError = 'id') {
        $versionServer = Settings::getItem(Settings::KEY_APP_MOBILE_VERSION_IOS);
        $versionClient = isset($root->version_code) ? $root->version_code : 1;
        if ($versionClient < $versionServer && $root->platform == DomainConst::PLATFORM_IOS) {
            $model->addError($fieldNameAddError,
                    DomainConst::CONTENT00164);
        }
    }
    
    public function writeRequestLog() {
        $model = new ApiRequestLogs();
        // Content
        $data = '';
        $method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        switch ($method) {
            case 'POST':
                $data = filter_input_array(INPUT_POST);
                break;
            case 'GET':
                $data = filter_input_array(INPUT_GET);
                break;
            default:
                break;
        }
        $model->content = var_export($data, true);
        // Method
        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $model->method = $method . ': ' . $uri;
        $model->response = '';
        $model->created_date = CommonProcess::getCurrentDateTime();
        if ($model->save()) {
            $this->mRequestLog = $model;
        } else {
            CommonProcess::dumpVariable($model->getErrors());
        }
    }
    
    /**
     * Update log request
     * @param String $response Response value
     */
    public function updateLogResponse($response) {
        if ($this->mRequestLog) {
            $aUpdate = array('response', 'user_id', 'responsed_date');
            $this->mRequestLog->response = $response;
            $this->mRequestLog->responsed_date = CommonProcess::getCurrentDateTime();
            $this->mRequestLog->update($aUpdate);
        }
    }
}
