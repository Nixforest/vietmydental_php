<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateResponse
 *
 * @author NguyenPT
 */
class CreateResponse {
    /**
     * Create login response
     * @param Object $token Token string
     * @param Object $mUser User model
     * @param Object $objController Controller
     */
    public static function loginResponse($token, $mUser, $objController) {
        $result = ApiModule::$defaultSuccessResponse;
        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00186;
        // Create data
        $menu = CreateResponse::getMenuByUser($mUser);
        $result[DomainConst::KEY_DATA] = array(
            DomainConst::KEY_TOKEN              => $token,
            DomainConst::KEY_ID                 => $mUser->id,
            DomainConst::KEY_ROLE_ID            => $mUser->role_id,
            DomainConst::KEY_NEED_CHANGE_PASS   => $mUser->needChangePass(),
            DomainConst::KEY_MENU               => $menu,
            DomainConst::KEY_PATHOLOGICAL       => Pathological::getJsonList(),
//            DomainConst::KEY_STATUS_TREATMENT   => TreatmentSchedules::getJsonListStatus(),
            DomainConst::KEY_ADDRESS_CONFIG     => Cities::getJsonAddressConfig(),
            DomainConst::KEY_DIAGNOSIS          => Diagnosis::getJsonList(),
            DomainConst::KEY_TREATMENT          => TreatmentGroup::getJsonList(),
//            DomainConst::KEY_STATUS_TREATMENT_DETAIL    => TreatmentScheduleDetails::getJsonListStatus(),
//            DomainConst::KEY_STATUS_TREATMENT_PROCESS   => TreatmentScheduleProcess::getJsonListStatus(),
            DomainConst::KEY_TEETH              => CommonProcess::getListConfigTeeth(),
            DomainConst::KEY_TIMER              => ScheduleTimes::getJsonList(),
            DomainConst::KEY_DIAGNOSIS_OTHER_ID => Diagnosis::getOtherDiagnosisId(),
        );
        ApiModule::sendResponse($result, $objController);
    }
    
    /**
     * Create menu array base on role of user
     * @param Users $mUser Model User
     * @return Array
     */
    public static function getMenuByUser($mUser) {
        $aMenu = array(
            array(
                DomainConst::KEY_ID     => DomainConst::KEY_HOME,
                DomainConst::KEY_NAME   => DomainConst::CONTENT00188,
            ),
            array(
                DomainConst::KEY_ID     => DomainConst::KEY_ACCOUNT,
                DomainConst::KEY_NAME   => DomainConst::CONTENT00008,
            ),
        );
        $mRole = Roles::model()->findByPk($mUser->role_id);
        if ($mRole) {
            $roleName = $mRole->role_name;
            switch ($roleName) {
                case Roles::ROLE_ADMIN:

                    break;
                case Roles::ROLE_DOCTOR:
                    $aMenu[] = array(
                        DomainConst::KEY_ID     => DomainConst::KEY_CUSTOMER_LIST,
                        DomainConst::KEY_NAME   => DomainConst::CONTENT00135,
                    );
                    break;
                case Roles::ROLE_ASSISTANT:
                    $aMenu[] = array(
                        DomainConst::KEY_ID     => DomainConst::KEY_CUSTOMER_LIST,
                        DomainConst::KEY_NAME   => DomainConst::CONTENT00088,
                    );
                    break;
                default:
                    break;
            }
        }
        
        return $aMenu;
    }
    
    /**
     * Create user profile response
     * @param Object $mUser User model
     * @param Object $objController Controller
     */
    public static function userProfileResp($mUser, $objController) {
        $result = ApiModule::$defaultSuccessResponse;
        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00194;
        // Create data
        $result[DomainConst::KEY_DATA] = array(
            DomainConst::KEY_NAME               => $mUser->getFullName(),
            DomainConst::KEY_PHONE              => $mUser->phone,
            DomainConst::KEY_ADDRESS            => $mUser->address,
            DomainConst::KEY_IMAGE              => '',
            DomainConst::KEY_EMAIL              => $mUser->email,
            DomainConst::KEY_CITY_ID            => $mUser->province_id,
            DomainConst::KEY_DISTRICT_ID        => $mUser->district_id,
            DomainConst::KEY_WARD_ID            => $mUser->ward_id,
            DomainConst::KEY_STREET_ID          => $mUser->street_id,
            DomainConst::KEY_HOUSE_NUMBER       => $mUser->house_numbers,
            
        );
        ApiModule::sendResponse($result, $objController);
    }
    
    /**
     * Create customer list response
     * @param type $mUser
     * @param Object $mUser User model
     * @param Object $objController Controller
     */
    public static function customerListResp($root, $mUser, $objController) {
        $result = ApiModule::$defaultSuccessResponse;
        $mCustomer = new Customers();
        $data = $mCustomer->apiList($root, $mUser);
        $pagination = $data->pagination;
        $list = array();
        foreach ($data->data as $customer) {
//            $list[] = CommonProcess::createConfigJson(
//                    $customer->id,
//                    $customer->name);
            $list[] = array(
                DomainConst::KEY_ID => $customer->id,
                DomainConst::KEY_NAME => $customer->name,
                DomainConst::KEY_GENDER => CommonProcess::getGender()[$customer->gender],
                DomainConst::KEY_AGE => $customer->getAge(),
                DomainConst::KEY_PHONE => $customer->getPhone(),
                DomainConst::KEY_ADDRESS => $customer->getAddress()
            );
        }
        $result[DomainConst::KEY_DATA] = array(
            DomainConst::KEY_TOTAL_RECORD => $pagination->itemCount,
            DomainConst::KEY_TOTAL_PAGE => $pagination->pageCount,
            DomainConst::KEY_LIST => $list,
        );
        ApiModule::sendResponse($result, $objController);
    }
    
    /**
     * Create customer view response
     * @param Object $mUser User model
     * @param Object $mCustomer Customer model
     * @param Object $objController Controller
     */
    public static function customerViewResp($mUser, $mCustomer, $objController) {
        $result = ApiModule::$defaultSuccessResponse;
        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00194;
        // Create data
        $medicalRecord = CommonProcess::createConfigJson(
                CustomerController::GROUP_MEDICAL_RECORD,
                DomainConst::CONTENT00138,
                array(
                    CommonProcess::createConfigJson(
                        CustomerController::ITEM_NAME,
                        $mCustomer->name,
                        $mCustomer->address),
                    CommonProcess::createConfigJson(
                        CustomerController::ITEM_BIRTHDAY,
                        $mCustomer->getBirthday(),
                        $mCustomer->getAge()),
                    CommonProcess::createConfigJson(
                        CustomerController::ITEM_MEDICAL_HISTORY,
                        DomainConst::CONTENT00202,
                        $mCustomer->getMedicalHistory()),
                    CommonProcess::createConfigJson(
                        CustomerController::ITEM_UPDATE_DATE,
                        DomainConst::CONTENT00229)
                ));
        
        $treatment = CommonProcess::createConfigJson(
                CustomerController::GROUP_TREATMENT,
                DomainConst::CONTENT00201,
                $mCustomer->getTreatmentHistory());
        $result[DomainConst::KEY_DATA] = array(
            $medicalRecord,
            $treatment,
        );
        ApiModule::sendResponse($result, $objController);
    }
    
    /**
     * Create customer medical record information response
     * @param Object $mUser User model
     * @param Object $mCustomer Customer model
     * @param Object $objController Controller
     */
    public static function customerMedicalRecordInfoResp($mUser, $mCustomer, $objController) {
        $result = ApiModule::$defaultSuccessResponse;
        $data = array();
        $data[] = CommonProcess::createConfigJson(CustomerController::ITEM_NAME, $mCustomer->name);
        $data[] = CommonProcess::createConfigJson(CustomerController::ITEM_GENDER, CommonProcess::getGender()[$mCustomer->gender]);
        $data[] = CommonProcess::createConfigJson(CustomerController::ITEM_AGE, $mCustomer->getAge());
        $data[] = CommonProcess::createConfigJson(CustomerController::ITEM_PHONE, $mCustomer->getPhone());
        $data[] = CommonProcess::createConfigJson(CustomerController::ITEM_ADDRESS, $mCustomer->getAddress());
        $data[] = CommonProcess::createConfigJson(CustomerController::ITEM_BIRTHDAY, $mCustomer->getBirthday());
        $data[] = CommonProcess::createConfigJson(CustomerController::ITEM_EMAIL, $mCustomer->getEmail());
        $data[] = CommonProcess::createConfigJson(CustomerController::ITEM_AGENT, $mCustomer->getAgentName());
        $data[] = CommonProcess::createConfigJson(CustomerController::ITEM_CAREER, $mCustomer->getCareer());
        $data[] = CommonProcess::createConfigJson(CustomerController::ITEM_CHARACTERISTICS, $mCustomer->getCharacteristics());
        $data[] = CommonProcess::createConfigJson(CustomerController::ITEM_RECORD_NUMBER, $mCustomer->getMedicalRecordNumber());
        $data[] = CommonProcess::createConfigJson(
                CustomerController::ITEM_MEDICAL_HISTORY,
                DomainConst::CONTENT00202,
                $mCustomer->getMedicalHistory());
        $result[DomainConst::KEY_DATA] = $data;
//        $result[DomainConst::KEY_DATA] = array(
//            DomainConst::KEY_ID         => $mCustomer->id,
//            DomainConst::KEY_NAME       => $mCustomer->name,
//            DomainConst::KEY_GENDER     => CommonProcess::getGender()[$mCustomer->gender],
//            DomainConst::KEY_AGE        => $mCustomer->getAge(),
//            DomainConst::KEY_PHONE      => $mCustomer->getPhone(),
//            DomainConst::KEY_ADDRESS    => $mCustomer->getAddress(),
//            DomainConst::KEY_BIRTH_DAY  => $mCustomer->getBirthday(),
//            DomainConst::KEY_EMAIL      => $mCustomer->getEmail(),
//            DomainConst::KEY_AGENT      => $mCustomer->getAgentName(),
//            DomainConst::KEY_CAREER     => $mCustomer->getCareer(),
//            DomainConst::KEY_CHARACTERISTICS => $mCustomer->getCharacteristics(),
//            DomainConst::KEY_RECORD_NUMBER => $mCustomer->getMedicalRecordNumber(),
//            DomainConst::KEY_MEDICAL_HISTORY => $mCustomer->getMedicalHistory()
//        );
        ApiModule::sendResponse($result, $objController);
        
    }
    
    /**
     * Create treatment list response
     * @param type $mUser
     * @param Object $mUser User model
     * @param Object $objController Controller
     */
    public static function treatmentListResp($root, $mUser, $objController) {
        $result = ApiModule::$defaultSuccessResponse;
        $mTreatment = new TreatmentSchedules();
        $data = $mTreatment->apiList($root, $mUser);
        $pagination = $data->pagination;
        $list = array();
        foreach ($data->data as $schedule) {
            $list[] = $schedule->getJsonTreatmentInfo();
        }
        $result[DomainConst::KEY_DATA] = array(
            DomainConst::KEY_TOTAL_RECORD => $pagination->itemCount,
            DomainConst::KEY_TOTAL_PAGE => $pagination->pageCount,
            DomainConst::KEY_LIST => $list,
        );
        ApiModule::sendResponse($result, $objController);
    }
    
    /**
     * Create treatment information response
     * @param type $mUser
     * @param Object $mUser User model
     * @param Object $objController Controller
     */
    public static function treatmentInfoResp($root, $mUser, $objController) {
        $result = ApiModule::$defaultSuccessResponse;
        $treatmentInfo = '';
        $mTreatment = TreatmentSchedules::model()->findByPk($root->id);
        if ($mTreatment && $mTreatment->status != TreatmentSchedules::STATUS_INACTIVE) {
            $mRole = Roles::model()->findByPk($mUser->role_id);
            $roleName = '';
            if ($mRole) {
                $roleName = $mRole->role_name;
            }
            $treatmentInfo = $mTreatment->getJsonTreatmentDetail($roleName);
        } else {
            $result = ApiModule::$defaultFailedResponse;
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00215;
            ApiModule::sendResponse($result, $objController);
        }
        $result[DomainConst::KEY_DATA] = $treatmentInfo;
        ApiModule::sendResponse($result, $objController);
    }
    
    /**
     * Create streets list response
     * @param type $mUser
     * @param Object $mUser User model
     * @param Object $objController Controller
     */
    public static function streetsListResp($root, $mUser, $objController) {
        $result = ApiModule::$defaultSuccessResponse;
        $data = Streets::getJsonList($root, $mUser);
        $pagination = $data->pagination;
        $list = array();
        foreach ($data->data as $street) {
            $list[] = CommonProcess::createConfigJson($street->id, $street->name);
        }
        $result[DomainConst::KEY_DATA] = array(
            DomainConst::KEY_TOTAL_RECORD => $pagination->itemCount,
            DomainConst::KEY_TOTAL_PAGE => $pagination->pageCount,
            DomainConst::KEY_LIST => $list,
        );
        ApiModule::sendResponse($result, $objController);
    }


    /**
     * handle format error of model to one message
     */
    public static function fortmatErrorsModel($errors) {
        $res = array();
        foreach($errors as $oneFieldError){
            foreach($oneFieldError as $err){
                $res[] = $err;
            }
        }
        return "<br>- ".implode('<br>- ', $res);
    }
}
