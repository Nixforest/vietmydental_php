<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportController
 *
 * @author nguyenpt
 */
class ReportController extends APIController {
    /**
     * P0031_GetStatistic_API
     * Get statistic
     * - url:   api/report/getStatistic
     * - parameter:
     *  + token:        Token
     *  + agentId:      Array of agent id
     *  + date_from:    From date (format yyyy/MM/dd)
     *  + date_to:      To date (format yyyy/MM/dd)
     */
    public function actionGetStatistic() {
        try {
            $resultFailed = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse request to json
            $root = json_decode($_POST[DomainConst::KEY_ROOT_REQUEST]);
            // Check if parameters are exist
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_AGENT_ID,
                DomainConst::KEY_DATE_FROM,
                DomainConst::KEY_DATE_TO
            ));
            // Get user by token value
            $mUser = $this->getUserByToken($resultFailed, $root->token);
            // Check version
            $this->checkVersion($root, $mUser);
            $this->getStatistic($resultFailed, $mUser, $root);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * Get statistic information
     * @param Array $result Result data
     * @param Object $mUser Model user
     * @param Object $root Json object
     */
    public function getStatistic($result, $mUser, $root) {
        $orgFormat = DomainConst::DATE_FORMAT_6;            // Origin date format
        $dateFormat = DomainConst::DATE_FORMAT_4;           // Current date format
        $arrAgentId = $root->agent_id;
        Loggers::info('Agent array', CommonProcess::json_encode_unicode($arrAgentId), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        if (empty($root->agent_id)) {
            $arrAgentId = $mUser->getAgentIds();
            Loggers::info('User', $mUser->getFullName(), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            Loggers::info('Agent array', CommonProcess::json_encode_unicode($arrAgentId), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
        
        $from   = CommonProcess::convertDateTime($root->date_from, $orgFormat, $dateFormat);
        $to     = CommonProcess::convertDateTime($root->date_to, $orgFormat, $dateFormat);
        if (empty($from)) {
            $from = CommonProcess::getCurrentDateTime($dateFormat);
        }
        if (empty($to)) {
            $to = CommonProcess::getCurrentDateTime($dateFormat);
        }
        $allReceipts = Agents::getRevenueMultiAgent($from, $to, array(Receipts::STATUS_RECEIPTIONIST), true, $arrAgentId);
        $result = ApiModule::$defaultSuccessResponse;
        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00194;
        $result[DomainConst::KEY_DATA] = array(
            DomainConst::KEY_DISCOUNT_AMOUNT    => OneMany::getReceiptDiscountTotal($allReceipts->getData()),
            DomainConst::KEY_TOTAL              => OneMany::getReceiptTotalTotal($allReceipts->getData()),
            DomainConst::KEY_FINAL              => OneMany::getReceiptFinalTotal($allReceipts->getData()),
            DomainConst::KEY_DEBT               => OneMany::getReceiptDebitTotal($allReceipts->getData()),
//            DomainConst::KEY_CAN_SELECT_AGENT   => DomainConst::NUMBER_ZERO_VALUE,
            DomainConst::KEY_TOTAL_QTY          => OneMany::getReceiptCustomerTotal($allReceipts->getData()),
        );
        ApiModule::sendResponse($result, $this);
    }
    
    /**
     * P0032_GetListReceipts_API
     * Get statistic
     * - url:   api/report/listReceipts
     * - parameter:
     *  + token:        Token
     *  + page:         Page
     *  + status:       Status of receipt
     *  + agentId:      Array of agent id
     *  + date_from:    From date (format yyyy/MM/dd)
     *  + date_to:      To date (format yyyy/MM/dd)
     */
    public function actionListReceipts() {
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
                DomainConst::KEY_STATUS,
                DomainConst::KEY_AGENT_ID,
                DomainConst::KEY_DATE_FROM,
                DomainConst::KEY_DATE_TO
            ));
            // Get user by token value
            $mUser = $this->getUserByToken($resultFailed, $root->token);
            // Check version
            $this->checkVersion($root, $mUser);
            $this->getListReceipts($resultFailed, $mUser, $root);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * Get list receipts
     * @param Array $result Result data
     * @param Object $mUser Model user
     * @param Object $root Json object
     */
    public function getListReceipts($result, $mUser, $root) {
        $orgFormat = DomainConst::DATE_FORMAT_6;            // Origin date format
        $dateFormat = DomainConst::DATE_FORMAT_4;           // Current date format
//        $arrAgentId = explode(DomainConst::SPLITTER_TYPE_2, $root->agent_id);
        $arrAgentId = $root->agent_id;
        $from   = CommonProcess::convertDateTime($root->date_from, $orgFormat, $dateFormat);
        $to     = CommonProcess::convertDateTime($root->date_to, $orgFormat, $dateFormat);
        if (empty($from)) {
            $from = CommonProcess::getCurrentDateTime($dateFormat);
        }
        if (empty($to)) {
            $to = CommonProcess::getCurrentDateTime($dateFormat);
        }
        $status = isset($root->status) ? $root->status : Receipts::STATUS_RECEIPTIONIST;
        $page = isset($root->page) ? $root->page : '1';
        $receipts = Agents::getRevenueMultiAgent($from, $to, array($status), false, $arrAgentId, $page, true);
        
        $result = ApiModule::$defaultSuccessResponse;
        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00194;
        $listReceipts = array();
        // Get data from list receipts
        foreach ($receipts->getData() as $receipt) {
            $data = array();
            // Receipts information
            if (isset($receipt->rReceipt)) {
                // Customer information
                $customer = $receipt->rReceipt->getCustomer();
                if (isset($customer)) {
                    $customerName       = $customer->name;
                    $customerPhone      = $customer->phone;
                    $customerAddress    = $customer->address;
                    $customerImg        = '';
                    $customerEmail      = $customer->getSocialNetwork(SocialNetworks::TYPE_NETWORK_EMAIL);
                    $customerAgentId    = $customer->getAgentId();
                    $customerAgentName  = $customer->getAgentName();
                }
                // Treatment information
                if (isset($receipt->rReceipt->rTreatmentScheduleDetail)) {
                    $treatmentName      = $receipt->rReceipt->rTreatmentScheduleDetail->getTreatment();
                    $treatmentId        = $receipt->rReceipt->rTreatmentScheduleDetail->treatment_type_id;
                    $doctorName         = $receipt->rReceipt->rTreatmentScheduleDetail->getDoctor();
                }
                // Receipts
                $discount   = $receipt->rReceipt->discount;
                $final      = $receipt->rReceipt->final;
                $id         = $receipt->rReceipt->id;
                $receptionist = $receipt->rReceipt->getReceptionist();
            }
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_NAME,
                DomainConst::CONTENT00100, $customerName);
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_PHONE,
                DomainConst::CONTENT00170, $customerPhone);
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_ADDRESS,
                DomainConst::CONTENT00045, $customerAddress);
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_IMAGE,
                DomainConst::CONTENT00061, $customerImg);
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_EMAIL,
                DomainConst::CONTENT00175, $customerEmail);
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_AGENT_ID,
                DomainConst::CONTENT00438, $customerAgentId);
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_AGENT,
                DomainConst::CONTENT00197, $customerAgentName);
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_TREATMENT,
                DomainConst::CONTENT00128, $treatmentName);
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_TREATMENT_TYPE_ID,
                DomainConst::CONTENT00439, $treatmentId);
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_PRICE,
                    DomainConst::CONTENT00315, $receipt->getReceiptTreatmentTypePriceText());
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_QUANTITY,
                    DomainConst::CONTENT00083, $receipt->getReceiptNumTeeth());
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_TOTAL,
                    DomainConst::CONTENT00353, $receipt->getReceiptTotalText());
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_DISCOUNT,
                    DomainConst::CONTENT00242, $discount);
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_FINAL,
                    DomainConst::CONTENT00259, $final);
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_DEBT,
                    DomainConst::CONTENT00317, $receipt->getReceiptDiscountText());
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_DOCTOR,
                    DomainConst::CONTENT00143, $doctorName);
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_ID,
                    DomainConst::CONTENT00003, $id);
            $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_RECEIPTIONIST,
                    DomainConst::CONTENT00248, $receptionist);
            $listReceipts[] = CommonProcess::createConfigJson(DomainConst::ITEM_ID, '', $data);
        }
        $result[DomainConst::KEY_DATA] = array(
            DomainConst::KEY_TOTAL_RECORD       => $receipts->pagination->itemCount,
            DomainConst::KEY_TOTAL_PAGE         => $receipts->pagination->pageCount,
            DomainConst::KEY_LIST               => $listReceipts,
        );
        ApiModule::sendResponse($result, $this);
    }
}
