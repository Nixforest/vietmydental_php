<?php

/**
 * API module
 */
class ApiModule extends CWebModule {

    /** Default failed response */
    public static $defaultFailedResponse = array(
        DomainConst::KEY_STATUS => DomainConst::API_RESPONSE_STATUS_FAILED,
        DomainConst::KEY_CODE => DomainConst::API_RESPONSE_CODE_BAD_REQUEST,
        DomainConst::KEY_MESSAGE => 'Invalid request. Please check your http verb, action url and param',
    );

    /** Default success response */
    public static $defaultSuccessResponse = array(
        DomainConst::KEY_STATUS => DomainConst::API_RESPONSE_STATUS_SUCCESS,
        DomainConst::KEY_CODE => DomainConst::API_RESPONSE_CODE_SUCCESS,
        DomainConst::KEY_MESSAGE => 'Success',
    );

    /** Response messages */
    const RESP_MSG_MISS_ROOT = 'Missing q as a param. Ex: user/loginFirstTime?q={"username":"0909456789"}';
    const RESP_MSG_INVALID_JSON = 'Invalid JSON encode format';
    const RESP_MSG_INVALID_REQ = 'Invalid request. Please check your http verb';
    const RESP_MSG_MISS_PARAM = 'Missing param. Reference in record';

    /** Max row per page in list */
    const MAX_ROW_PER_PAGE = 20;

    /** Login flag */
//    const LOGIN_ANDROID = 1;
//    const LOGIN_WINDOW  = 2;
//    const LOGIN_IOS     = 3;
//    const LOGIN_WEB     = 4;

    /**
     * Send response
     * @param type $data
     * @param type $objController
     */
    public static function sendResponse($data, $objController) {
        echo $json = CommonProcess::json_encode_unicode($data);
        $objController->updateLogResponse($json);
        Yii::app()->end();
    }

    /**
     * Catch error when exception occur.
     * @param Exception $ex
     * @param APIController $objController
     */
    public static function catchError($ex, $objController) {
        $result = ApiModule::$defaultFailedResponse;
        $result[DomainConst::KEY_MESSAGE] = "" . $ex->getMessage();
        ApiModule::sendResponse($result, $objController);
    }

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'api.models.*',
            'api.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else {
            return false;
        }
    }

}
