<?php

class CustomerController extends APIController
{
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Group id: Medical record */
    const GROUP_MEDICAL_RECORD              = '1';
    /** Group id: Treatment */
    const GROUP_TREATMENT                   = '2';
    /** Item id: Update data */
    const ITEM_UPDATE_DATE                  = '0';
    /** Item id: Name */
    const ITEM_NAME                         = '1';
    /** Item id: Birthday */
    const ITEM_BIRTHDAY                     = '2';
    /** Item id: Medical history */
    const ITEM_MEDICAL_HISTORY              = '3';
    /** Item id: Gender */
    const ITEM_GENDER                       = '4';
    /** Item id: Age */
    const ITEM_AGE                          = '5';
    /** Item id: Phone */
    const ITEM_PHONE                        = '6';
    /** Item id: Address */
    const ITEM_ADDRESS                      = '7';
    /** Item id: Email */
    const ITEM_EMAIL                        = '8';
    /** Item id: Agent */
    const ITEM_AGENT                        = '9';
    /** Item id: Career */
    const ITEM_CAREER                       = '10';
    /** Item id: Characteristics */
    const ITEM_CHARACTERISTICS              = '11';
    /** Item id: Record number */
    const ITEM_RECORD_NUMBER                = '12';
    /** Item id: Start date */
    const ITEM_START_DATE                   = '13';
    /** Item id: End date */
    const ITEM_END_DATE                     = '14';
    /** Item id: Diagnosis */
    const ITEM_DIAGNOSIS                    = '15';
    /** Item id: Pathological */
    const ITEM_PATHOLOGICAL                 = '16';
    /** Item id: Doctor */
    const ITEM_DOCTOR                       = '17';
    /** Item id: Healthy */
    const ITEM_HEALTHY                      = '18';
    /** Item id: Status */
    const ITEM_STATUS                       = '19';
    /** Item id: Details */
    const ITEM_DETAILS                      = '20';
    /** Item id: Teeth */
    const ITEM_TEETH                        = '21';
    /** Item id: Treatment */
    const ITEM_TREATMENT                    = '22';
    /** Item id: NOTE */
    const ITEM_NOTE                         = '23';
    /** Item id: Type */
    const ITEM_TYPE                         = '24';
    /** Item id: Can update */
    const ITEM_CAN_UPDATE                   = '25';
    /** Item id: Id */
    const ITEM_ID                           = '26';
    /** Item id: Diagnosis Id */
    const ITEM_DIAGNOSIS_ID                 = '27';
    /** Item id: Pathological Id */
    const ITEM_PATHOLOGICAL_ID              = '28';
    /** Item id: Teeth Id */
    const ITEM_TEETH_ID                     = '29';
    /** Item id: Treatment type Id */
    const ITEM_TREATMENT_TYPE_ID            = '30';
    /** Item id: Description */
    const ITEM_DESCRIPTION                  = '31';
    /** Item id: Time id */
    const ITEM_TIME_ID                      = '32';
    /** Item id: Time */
    const ITEM_TIME                         = '33';
    /** Item id: Receipt */
    const ITEM_RECEIPT                      = '34';
    /** Item id: Discount */
    const ITEM_DISCOUNT                     = '35';
    /** Item id: Need approve */
    const ITEM_NEED_APPROVE                 = '36';
    /** Item id: Customer confirmed */
    const ITEM_CUSTOMER_CONFIRMED           = '37';
    /** Item id: Final */
    const ITEM_FINAL                        = '38';
    /** Item id: Insurrance */
    const ITEM_INSURRANCE                   = '39';
    
    
    /**
     * P0007_CustomerList_API
     * Get list customer
     * - url:   api/customer/list
     * - parameter:
     *  + token:        Token
     *  + page:         Index of page
     *  + date_from:    From date (format yyyy/MM/dd)
     *  + date_to:      To date (format yyyy/MM/dd)
     */
    public function actionList() {
        try {
            $resultFailed = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse request to json
            $root = json_decode($_POST[DomainConst::KEY_ROOT_REQUEST]);
            // Check if parameters are exist
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_PAGE,
//                DomainConst::KEY_DATE_FROM,
//                DomainConst::KEY_DATE_TO
            ));
            // Get user by token value
            $mUser = $this->getUserByToken($resultFailed, $root->token);
            // Check version
            $this->checkVersion($root, $mUser);
            
//            $resultSuccess = ApiModule::$defaultSuccessResponse;
//            $resultSuccess[DomainConst::KEY_MESSAGE] = "List";
//            // TODO:
//            $mCustomers = new Customers();
//            $mCustomers->getApiList($resultSuccess, $root, $mUser);
//            ApiModule::sendResponse($resultSuccess, $this);
            CreateResponse::customerListResp($root, $mUser, $this);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0008_CustomerInfo_API
     * Get customer information
     * - url:   api/customer/view
     * - parameter:
     *  + token:    Token
     *  + id:       Id of customer
     */
    public function actionView() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_ID
            ));
            // Get user
            $mUser = $this->getUserByToken($result, $root->token);
            $mCustomer = $this->getCustomerById($result, $root->id);
            CreateResponse::customerViewResp($mUser, $mCustomer, $this);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0017_GetMedicalRecordInfo_API
     * Get customer medical record information
     * - url:   api/customer/medicalRecordInfo
     * - parameter:
     *  + token:    Token
     *  + id:       Id of customer
     */
    public function actionMedicalRecordInfo() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_ID
            ));
            // Get user
            $mUser = $this->getUserByToken($result, $root->token);
            $mCustomer = $this->getCustomerById($result, $root->id);
            CreateResponse::customerMedicalRecordInfoResp($mUser, $mCustomer, $this);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0010_UpdateMedicalRecord_API
     * Update customer medical record information
     * - url:   api/customer/updateMedicalRecord
     * - parameter:
     *  + token:            Token
     *  + id:               Id of customer
     *  + record_number:    Record number
     *  + medical_history:  Medical history
     */
    public function actionUpdateMedicalRecord() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_ID,
                DomainConst::KEY_RECORD_NUMBER,
                DomainConst::KEY_MEDICAL_HISTORY
            ));
            // Get user
            $mUser = $this->getUserByToken($result, $root->token);
            $mCustomer = $this->getCustomerById($result, $root->id);
//            $this->handleUpdateUser($result, $mUser, $root);
            $this->handleUpdateMedicalRecord($result, $mCustomer, $root);
            $result = ApiModule::$defaultSuccessResponse;
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00035;
            ApiModule::sendResponse($result, $this);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0016_GetTreatmentInfo_API
     * Get treatment information
     * - url:   api/customer/treatmentInfo
     * - parameter:
     *  + token:            Token
     *  + id:               Id of treatment
     */
    public function actionTreatmentInfo() {
        try {
            $resultFailed = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse request to json
            $root = json_decode($_POST[DomainConst::KEY_ROOT_REQUEST]);
            // Check if parameters are exist
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_ID
            ));
            // Get user by token value
            $mUser = $this->getUserByToken($resultFailed, $root->token);
            // Check version
            $this->checkVersion($root, $mUser);
            
            CreateResponse::treatmentInfoResp($root, $mUser, $this);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0018_GetListTreatment_API
     * Get list treatment of customer
     * - url:   api/customer/listTreatment
     * - parameter:
     *  + token:            Token
     *  + id:               Id of customer
     *  + page:             Index of page
     */
    public function actionListTreatment() {
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
            
            CreateResponse::treatmentListResp($root, $mUser, $this);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0009_CreateSchedule_API
     * Create new schedule for customer
     * - url:   api/customer/createSchedule
     * - parameter:
     *  + token:            Token
     *  + customer_id:      Id of customer
     *  + time:             Id of schedule time
     *  + date:             Schedule date (format: yyy/MM/dd)
     *  + doctor_id:        Id of doctor
     *  + type:             Type of schedule
     *  + note:             Description of schedule
     */
    public function actionCreateSchedule() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_CUSTOMER_ID,
                DomainConst::KEY_TIME,
                DomainConst::KEY_DATE,
                DomainConst::KEY_DOCTOR_ID,
                DomainConst::KEY_TYPE,
                DomainConst::KEY_NOTE
            ));
            // Get user
            $mUser          = $this->getUserByToken($result, $root->token);
            $mCustomer      = $this->getCustomerById($result, $root->customer_id);
            $mMedicalRecord = $this->getMedicalRecordByCustomer($result, $mCustomer);
            $this->handleCreateSchedule($result, $mMedicalRecord, $root);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0011_UpdateTreatmentSchedule_API
     * Update treatment schedule
     * - url:   api/customer/updateTreatmentSchedule
     * - parameter:
     *  + token:            Token
     *  + id:               Id of treatment schedule
     *  + diagnosis_id:     Id of diagnosis
     *  + pathological_id:  Id of pathological
     *  + healthy:          Healthy condition
     *  + status:           Status
     */
    public function actionUpdateTreatmentSchedule() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_ID,
                DomainConst::KEY_DIAGNOSIS_ID,
                DomainConst::KEY_PATHOLOGICAL_ID,
                DomainConst::KEY_HEALTHY,
                DomainConst::KEY_STATUS
            ));
            // Get user
            $mUser          = $this->getUserByToken($result, $root->token);
            
            // Check treatment schedule id
            $isValid        = (new TreatmentSchedules())->isIdExist($root->id);
            if (!$isValid) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00215;
                ApiModule::sendResponse($result, $this);
            }
            // Check diagnosis id
            $isValid        = (new Diagnosis())->isIdExist($root->diagnosis_id);
            if (!$isValid) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00219;
                ApiModule::sendResponse($result, $this);
            }
            // Check pathological id
            $isValid        = (new Pathological())->isIdExist($root->pathological_id);
            if (!$isValid) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00220;
                ApiModule::sendResponse($result, $this);
            }
            if (!array_key_exists($root->status, TreatmentSchedules::getStatus())) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00222;
                ApiModule::sendResponse($result, $this);
            }
            
            // Check healthy id
            foreach ($root->healthy as $value) {
                $isValid    = (new Pathological())->isIdExist($value);
                if (!$isValid) {
                    $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00221;
                    ApiModule::sendResponse($result, $this);
                }
            }
            $this->handleUpdateTreatmentSchedule($result, $root);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0012_CreateTreatmentScheduleDetail_API
     * Create new treatment schedule detail
     * - url:   api/customer/createTreatmentScheduleDetail
     * - parameter:
     *  + token:                Token
     *  + schedule_id:          Id treatment schedule
     *  + time:                 Id of schedule time
     *  + date:                 Schedule date (format: yyy/MM/dd)
     *  + teeth_id:             Id of teeth
     *  + diagnosis_id:         Id of diagnosis
     *  + treatment_type_id:    Id of treatment type
     *  + note:                 Description of schedule [removed]
     *  + status:               Status [removed]
     *  + type:                 Type of schedule [removed]
     */
    public function actionCreateTreatmentScheduleDetail() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_SCHEDULE_ID,
                DomainConst::KEY_TIME,
                DomainConst::KEY_DATE,
                DomainConst::KEY_TEETH_ID,
                DomainConst::KEY_DIAGNOSIS_ID,
                DomainConst::KEY_TREATMENT_TYPE_ID,
//                DomainConst::KEY_NOTE,
//                DomainConst::KEY_STATUS,
//                DomainConst::KEY_TYPE
            ));
            // Get user
            $mUser          = $this->getUserByToken($result, $root->token);
            // Check treatment schedule id
            $isValid        = (new TreatmentSchedules())->isIdExist($root->schedule_id);
            if (!$isValid) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00215;
                ApiModule::sendResponse($result, $this);
            }
            // Check date
            if (empty($root->time)) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00235;
                ApiModule::sendResponse($result, $this);
            }
            // Check teeth id
            if (!array_key_exists($root->teeth_id, CommonProcess::getListTeeth())) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00223;
                ApiModule::sendResponse($result, $this);
            }
            // Check diagnosis id
            $isValid        = (new Diagnosis())->isIdExist($root->diagnosis_id);
            if (!$isValid) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00219;
                ApiModule::sendResponse($result, $this);
            }
            // Check treatment type id
            $isValid        = (new TreatmentTypes())->isIdExist($root->treatment_type_id);
            if (!$isValid) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00224;
                ApiModule::sendResponse($result, $this);
            }
//            if (!array_key_exists($root->status, TreatmentScheduleDetails::getStatus())) {
//                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00222;
//                ApiModule::sendResponse($result, $this);
//            }
            $this->handleCreateTreatmentScheduleDetail($result, $root);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0013_UpdateTreatmentScheduleDetail_API
     * Update treatment schedule detail
     * - url:   api/customer/updateTreatmentScheduleDetail
     * - parameter:
     *  + token:                Token
     *  + id:                   Id treatment schedule detail
     *  + time:                 Schedule time (format: dd/MM/yyyy hh:mm:ss) [removed]
     *  + teeth_id:             Id of teeth
     *  + diagnosis_id:         Id of diagnosis
     *  + treatment_type_id:    Id of treatment type
     *  + note:                 Description of schedule [removed]
     *  + status:               Status
     *  + type:                 Type of schedule [removed]
     */
    public function actionUpdateTreatmentScheduleDetail() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_ID,
//                DomainConst::KEY_TIME,
                DomainConst::KEY_TEETH_ID,
                DomainConst::KEY_DIAGNOSIS_ID,
                DomainConst::KEY_TREATMENT_TYPE_ID,
//                DomainConst::KEY_NOTE,
                DomainConst::KEY_STATUS,
//                DomainConst::KEY_TYPE
            ));
            // Get user
            $mUser          = $this->getUserByToken($result, $root->token);
            // Check teeth id
            if ($root->teeth_id != 0 && !array_key_exists($root->teeth_id, CommonProcess::getListTeeth())) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00223;
                ApiModule::sendResponse($result, $this);
            }
            // Check diagnosis id
            $isValid        = (new Diagnosis())->isIdExist($root->diagnosis_id);
            if (!$isValid) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00219;
                ApiModule::sendResponse($result, $this);
            }
            // Check treatment type id
            $isValid        = (new TreatmentTypes())->isIdExist($root->treatment_type_id);
            if (!$isValid) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00224;
                ApiModule::sendResponse($result, $this);
            }
            if (!array_key_exists($root->status, TreatmentScheduleDetails::getStatus())) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00222;
                ApiModule::sendResponse($result, $this);
            }
            $this->handleUpdateTreatmentScheduleDetail($result, $root);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0014_CreateTreatmentScheduleProcess_API
     * Create new treatment schedule process
     * - url:   api/customer/createTreatmentScheduleProcess
     * - parameter:
     *  + token:                Token
     *  + detail_id:            Id treatment schedule detail
     *  + date:                 Proccess date (format: yyyy/MM/dd)
     *  + teeth_id:             Id of teeth
     *  + name:                 Name of process
     *  + content:              Content of process
     *  + doctor_id:            Id of doctor (remove)
     *  + status:               Status
     *  + note:                 Note
     */
    public function actionCreateTreatmentScheduleProcess() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_DETAIL_ID,
                DomainConst::KEY_DATE,
                DomainConst::KEY_TEETH_ID,
                DomainConst::KEY_NAME,
                DomainConst::KEY_CONTENT,
//                DomainConst::KEY_DOCTOR_ID,
//                DomainConst::KEY_STATUS,
                DomainConst::KEY_NOTE
            ));
            // Get user
            $mUser          = $this->getUserByToken($result, $root->token);
            // Check treatment schedule id
            $isValid        = (new TreatmentScheduleDetails())->isIdActiveExist($root->detail_id);
            if (!$isValid) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00226;
                ApiModule::sendResponse($result, $this);
            }
            // Check date
            if (empty($root->date)) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00234;
                ApiModule::sendResponse($result, $this);
            }
            // Check teeth id
//            if (!array_key_exists($root->teeth_id, CommonProcess::getListTeeth())) {
//                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00223;
//                ApiModule::sendResponse($result, $this);
//            }
            // Check diagnosis id
//            $isValid        = (new Users())->isIdActiveExist($root->doctor_id);
//            if (!$isValid) {
//                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00218;
//                ApiModule::sendResponse($result, $this);
//            }
//            if (!array_key_exists($root->status, TreatmentScheduleProcess::getStatus())) {
//                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00222;
//                ApiModule::sendResponse($result, $this);
//            }
            $this->handleCreateTreatmentScheduleProcess($result, $root, $mUser);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * P0015_UpdateTreatmentScheduleProcess_API
     * Update treatment schedule process
     * - url:   api/customer/updateTreatmentScheduleProcess
     * - parameter:
     *  + token:                Token
     *  + id:                   Id treatment schedule process
     *  + date:                 Proccess date (format: yyyy/MM/dd)
     *  + teeth_id:             Id of teeth
     *  + name:                 Name of process
     *  + content:              Content of process
     *  + doctor_id:            Id of doctor
     *  + status:               Status
     *  + note:                 Note
     */
    public function actionUpdateTreatmentScheduleProcess() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_ID,
//                DomainConst::KEY_DATE,
                DomainConst::KEY_TEETH_ID,
                DomainConst::KEY_NAME,
                DomainConst::KEY_CONTENT,
//                DomainConst::KEY_DOCTOR_ID,
                DomainConst::KEY_STATUS,
                DomainConst::KEY_NOTE
            ));
            // Get user
            $mUser          = $this->getUserByToken($result, $root->token);
            // Check teeth id
            if ($root->teeth_id != 0 && !array_key_exists($root->teeth_id, CommonProcess::getListTeeth())) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00223;
                ApiModule::sendResponse($result, $this);
            }
            // Check diagnosis id
//            $isValid        = (new Users())->isIdActiveExist($root->doctor_id);
//            if (!$isValid) {
//                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00218;
//                ApiModule::sendResponse($result, $this);
//            }
            if (!array_key_exists($root->status, TreatmentScheduleProcess::getStatus())) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00222;
                ApiModule::sendResponse($result, $this);
            }
            $this->handleUpdateTreatmentScheduleProcess($result, $root);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * Get customer by id
     * @param type $result
     * @param type $id
     * @return type
     */
    public function getCustomerById($result, $id) {
        $mCustomer = Customers::model()->findByPk($id);
        if (!$mCustomer || $mCustomer->status == DomainConst::DEFAULT_STATUS_INACTIVE) {
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00200;
            ApiModule::sendResponse($result, $this);
        }
        return $mCustomer;
    }
    
    /**
     * Get medical record object
     * @param Array $result
     * @param Obj $mCustomer
     * @return type
     */
    public function getMedicalRecordByCustomer($result, $mCustomer) {
        if (isset($mCustomer->rMedicalRecord)) {
            $mMedicalRecord = MedicalRecords::model()->findByPk($mCustomer->rMedicalRecord->id);
            if (!$mMedicalRecord || $mMedicalRecord->status == DomainConst::DEFAULT_STATUS_INACTIVE) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00217;
                ApiModule::sendResponse($result, $this);
            } else {
                return $mMedicalRecord;
            }
        } else {
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00216;
            ApiModule::sendResponse($result, $this);
        }
    }

    /**
     * Handle update medical record information
     * @param type $result
     * @param type $mCustomer
     * @param type $root
     */
    public function handleUpdateMedicalRecord($result, $mCustomer, $root) {
        $mMedicalRecord = $mCustomer->rMedicalRecord;
        if ($mMedicalRecord) {
            if (empty($mMedicalRecord->record_number)) {
                $mMedicalRecord->record_number = $root->record_number;
            }
            $aUpdate = array(
                'record_number'
            );
            if ($mMedicalRecord->update($aUpdate)) {
                // Remove old record
                OneMany::deleteAllOldRecords($mMedicalRecord->id, OneMany::TYPE_MEDICAL_RECORD_PATHOLOGICAL);
                foreach ($root->medical_history as $value) {
                    OneMany::insertOne($mMedicalRecord->id, $value, OneMany::TYPE_MEDICAL_RECORD_PATHOLOGICAL);
                }
            } else {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00203;
                ApiModule::sendResponse($result, $this);
            }
        } else {
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00203;
            ApiModule::sendResponse($result, $this);
        }
    }

    /**
     * Handle create schedule
     * @param type $result
     * @param type $mCustomer
     * @param type $root
     */
    public function handleCreateSchedule($result, $mMedicalRecord, $root) {
        $schedule   = new TreatmentSchedules();
        $detail     = new TreatmentScheduleDetails();
        $schedule->record_id    = $mMedicalRecord->id;
        $schedule->status       = TreatmentSchedules::STATUS_SCHEDULE;
        $schedule->time_id      = $root->time;
        $schedule->start_date   = CommonProcess::convertDateTime(
                $root->date,
                DomainConst::DATE_FORMAT_6,
                DomainConst::DATE_FORMAT_1);
        $schedule->doctor_id    = $root->doctor_id;
        $mDoctor = Users::model()->findByPk($root->doctor_id);
        if (!$mDoctor || $mDoctor->status == DomainConst::DEFAULT_STATUS_INACTIVE) {
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00218;
            ApiModule::sendResponse($result, $this);
        }
        if ($schedule->save()) {
            // Save detail field
            $detail->schedule_id    = $schedule->id;
            $detail->time_id        = $root->time;
            $detail->start_date     = $schedule->start_date;
            $detail->end_date       = $schedule->end_date;
            $detail->type_schedule  = $root->type;
            $detail->description    = $root->note;
            $detail->status         = TreatmentScheduleDetails::STATUS_SCHEDULE;
            // Save success, start create detail
            if ($detail->save()) {
                $result = ApiModule::$defaultSuccessResponse;
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00205;
                ApiModule::sendResponse($result, $this);
            } else {
                $schedule->delete();
            }
        }
        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00214;
        ApiModule::sendResponse($result, $this);
    }

    /**
     * Handle update treatment schedule information
     * @param type $result
     * @param type $mCustomer
     * @param type $root
     */
    public function handleUpdateTreatmentSchedule($result, $root) {
        $mTreatmentSchedule = TreatmentSchedules::model()->findByPk($root->id);
        if ($mTreatmentSchedule) {
            $mTreatmentSchedule->diagnosis_id    = $root->diagnosis_id;
            $mTreatmentSchedule->pathological_id = $root->pathological_id;
            $mTreatmentSchedule->status          = $root->status;
            $aUpdate = array('diagnosis_id', 'pathological_id', 'status');
            if ($mTreatmentSchedule->update($aUpdate)) {
                // Remove old record
                OneMany::deleteAllOldRecords($mTreatmentSchedule->id,
                        OneMany::TYPE_TREATMENT_SCHEDULES_PATHOLOGICAL);
                foreach ($root->healthy as $value) {
                    OneMany::insertOne($mTreatmentSchedule->id, $value,
                            OneMany::TYPE_TREATMENT_SCHEDULES_PATHOLOGICAL);
                }
                $result = ApiModule::$defaultSuccessResponse;
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00035;
                ApiModule::sendResponse($result, $this);
            } else {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00203;
                ApiModule::sendResponse($result, $this);
            }
        } else {
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00203;
            ApiModule::sendResponse($result, $this);
        }
    }
    
    /**
     * Handle create treatment schedule detail
     * @param type $result
     * @param type $root
     */
    public function handleCreateTreatmentScheduleDetail($result, $root) {
        $model = new TreatmentScheduleDetails();
        $model->schedule_id         = $root->schedule_id;
        $model->time_id             = $root->time;
        $model->start_date          = CommonProcess::convertDateTime(
                $root->date,
                DomainConst::DATE_FORMAT_6,
                DomainConst::DATE_FORMAT_1);
        $model->end_date            = $model->start_date;
        $model->teeth_id            = $root->teeth_id;
        $model->diagnosis_id        = $root->diagnosis_id;
        $model->treatment_type_id   = $root->treatment_type_id;
//        $model->type_schedule       = $root->type;
//        $model->description         = $root->note;
        $model->status              = TreatmentScheduleDetails::STATUS_SCHEDULE;
        if ($model->save()) {
            $result = ApiModule::$defaultSuccessResponse;
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00225;
            $result[DomainConst::KEY_DATA] = CommonProcess::createConfigJson(
                        CommonProcess::convertDateTimeWithFormat($model->start_date),
                        $model->getTreatment(),
                        $model->getJsonInfo());
            ApiModule::sendResponse($result, $this);
        }
        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00214 . '<br>' . CommonProcess::json_encode_unicode($model->getErrors());
        ApiModule::sendResponse($result, $this);
    }
    
    /**
     * Handle update treatment schedule detail
     * @param type $result
     * @param type $root
     */
    public function handleUpdateTreatmentScheduleDetail($result, $root) {
        $model = TreatmentScheduleDetails::model()->findByPk($root->id);
        if ($model) {
//            $model->start_date          = $root->time;
//            $model->end_date            = $model->start_date;
            $model->teeth_id            = $root->teeth_id;
            $model->diagnosis_id        = $root->diagnosis_id;
            $model->treatment_type_id   = $root->treatment_type_id;
//            $model->type_schedule       = $root->type;
//            $model->description         = $root->note;
            $model->status              = $root->status;
            if ($model->status == TreatmentScheduleDetails::STATUS_COMPLETED) {
                $model->end_date        = CommonProcess::getCurrentDateTimeWithMySqlFormat();
            }
//            $aUpdate = array('start_date', 'end_date', 'teeth_id',
            $aUpdate = array('teeth_id',
                'diagnosis_id', 'treatment_type_id',
//                'type_schedule',
//                'description',
                'status');
            if ($model->update($aUpdate)) {
                $result = ApiModule::$defaultSuccessResponse;
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00035;
                $result[DomainConst::KEY_DATA] = $model->getJsonInfo();
                ApiModule::sendResponse($result, $this);
            } else {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00214;
                ApiModule::sendResponse($result, $this);
            }
        } else {
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00226;
            ApiModule::sendResponse($result, $this);
        }        
    }
    
    /**
     * Handle create treatment schedule process
     * @param type $result
     * @param type $root
     */
    public function handleCreateTreatmentScheduleProcess($result, $root, $mUser) {
        $model = new TreatmentScheduleProcess();
        $model->detail_id           = $root->detail_id;
        $model->process_date        = CommonProcess::convertDateTime($root->date,
            DomainConst::DATE_FORMAT_6, DomainConst::DATE_FORMAT_3);
//        $model->teeth_id            = $root->teeth_id;
        $model->teeth_id            = TreatmentScheduleDetails::getTeethById($root->detail_id);
        $model->name                = $root->name;
        $model->description         = $root->content;
        $model->doctor_id           = $mUser->id;
        $model->note                = $root->note;
        $model->status              = TreatmentScheduleProcess::STATUS_ACTIVE;
        if ($model->save()) {
            $result = ApiModule::$defaultSuccessResponse;
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00227;            
            $model->process_date        = CommonProcess::convertDateTime($root->date,
                DomainConst::DATE_FORMAT_3, DomainConst::DATE_FORMAT_4);
            $info = $model->getJsonInfo();
            $info[1] = CommonProcess::createConfigJson(CustomerController::ITEM_START_DATE,
                DomainConst::CONTENT00147,
                CommonProcess::convertDateTime($root->date,
                DomainConst::DATE_FORMAT_6, DomainConst::DATE_FORMAT_3));
            $result[DomainConst::KEY_DATA] = CommonProcess::createConfigJson(
                        $model->id, $model->name, $info);
            ApiModule::sendResponse($result, $this);
        }
        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00214;
        ApiModule::sendResponse($result, $this);
    }
    
    /**
     * Handle update treatment schedule process
     * @param type $result
     * @param type $root
     */
    public function handleUpdateTreatmentScheduleProcess($result, $root) {
        $model = TreatmentScheduleProcess::model()->findByPk($root->id);
        if ($model) {
//            $model->process_date        = $root->date;
            $model->teeth_id            = $root->teeth_id;
            $model->name                = $root->name;
            $model->description         = $root->content;
//            $model->doctor_id           = $root->doctor_id;
            $model->note                = $root->note;
            $model->status              = $root->status;
            $aUpdate = array(/*'process_date', */'teeth_id', 'name',
                'description', /*'doctor_id', */'note', 'status');
            if ($model->update($aUpdate)) {
                $result = ApiModule::$defaultSuccessResponse;
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00035;
                $result[DomainConst::KEY_DATA] = $model->getJsonInfo();
                ApiModule::sendResponse($result, $this);
            } else {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00214;
                ApiModule::sendResponse($result, $this);
            }
        } else {
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00228;
            ApiModule::sendResponse($result, $this);
        }
    }
    
    /**
     * P0020_CreateReceipt_API
     * Create new receipt for customer
     * - url:   api/customer/createReceipt
     * - parameter:
     *  + token:            Token
     *  + detail_id:        Id of Treatment schedule detail
     *  + date:             Date (format: yyy/MM/dd)
     *  + discount:         Discount
     *  + final:            Final money value need to receive from customer
     *  + customer_confirm: Customer confirm
     *  + receiptionist_id: Id of receiptionist
     *  + note:             Note
     * 
     */
    public function actionCreateReceipt() {
        try {
            $result = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse json
            $root = json_decode(filter_input(INPUT_POST, DomainConst::KEY_ROOT_REQUEST));
            // Check required parameters
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_DETAIL_ID,
                DomainConst::KEY_DATE,
                DomainConst::KEY_DISCOUNT,
                DomainConst::KEY_FINAL,
                DomainConst::KEY_CUSTOMER_CONFIRM,
                DomainConst::KEY_RECEIPTIONIST_ID,
                DomainConst::KEY_NOTE
            ));
            // Get user
            $mUser          = $this->getUserByToken($result, $root->token);
            // Check treatment schedule id
            $isValid        = (new TreatmentScheduleDetails())->isIdActiveExist($root->detail_id);
            if (!$isValid) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00226;
                ApiModule::sendResponse($result, $this);
            }
            // Check date
            if (empty($root->date)) {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00234;
                ApiModule::sendResponse($result, $this);
            }
            $this->handleCreateReceipt($result, $mUser, $root);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }

    /**
     * Handle create receipt
     * @param type $result
     * @param type $mUser
     * @param type $root
     */
    public function handleCreateReceipt($result, $mUser, $root) {
        $mDetail = TreatmentScheduleDetails::model()->findByPk($root->detail_id);
        if ($mDetail && isset($mDetail->rReceipt)) {
            $model = $mDetail->rReceipt;
        } else {
            $model   = new Receipts();
        }
        
        $model->detail_id           = $root->detail_id;
        $model->process_date        = CommonProcess::convertDateTime(
                $root->date,
                DomainConst::DATE_FORMAT_6,
                DomainConst::DATE_FORMAT_3);
        $model->discount            = $root->discount;
        $model->final               = $root->final;
        $model->customer_confirm    = $root->customer_confirm;
        $model->description         = $root->note;
        $model->created_by          = $mUser->id;
        $model->created_date        = CommonProcess::getCurrentDateTime();
        $model->receiptionist_id    = $root->receiptionist_id;
//        if (isset($mUser->rRole)) {
//            $model->setStatusByCreatedUserRole($mUser->rRole->role_name);
//        }
        $model->status = Receipts::STATUS_DOCTOR;
        
        // Handle agent
        $model->connectAgent($mUser->getAgentId());
        
        if ($model->save()) {
            $result = ApiModule::$defaultSuccessResponse;
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00245;
            $result[DomainConst::KEY_DATA] = CommonProcess::createConfigJson(
                    CustomerController::ITEM_RECEIPT,
                    DomainConst::CONTENT00251,
                    $model->getJsonInfo());
            ApiModule::sendResponse($result, $this);
        }
        
        // Finnaly send failed response with error detail
        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00214
                . '<br>'
                . CommonProcess::json_encode_unicode($model->getErrors());
        ApiModule::sendResponse($result, $this);
    }

    // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}