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
        Loggers::info('Agent array', CommonProcess::json_encode_unicode($arrAgentId),
                __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        if (empty($root->agent_id)) {
            $arrAgentId = $mUser->getAgentIds();
            Loggers::info('User', $mUser->getFullName(),
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            Loggers::info('Agent array', CommonProcess::json_encode_unicode($arrAgentId),
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
        
        Loggers::info('Date from', $root->date_from, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $from   = CommonProcess::convertDateTime($root->date_from, $orgFormat, $dateFormat);
        $to     = CommonProcess::convertDateTime($root->date_to, $orgFormat, $dateFormat);
        if (empty($from)) {
            $from = CommonProcess::getCurrentDateTime($dateFormat);
        }
        if (empty($to)) {
            $to = CommonProcess::getCurrentDateTime($dateFormat);
        }
        switch ($mUser->role_id) {
            case Roles::getRoleByName(Roles::ROLE_DOCTOR)->id:
                $sql = 'SELECT count(r.id) as count_id, sum(total) as sum_total, sum(final) as sum_final, sum(discount) as sum_discount
                        FROM ' . Receipts::model()->tableName() . ' as r
                        INNER JOIN ' . OneMany::model()->tableName() . ' as om ON om.many_id=r.id
                        WHERE r.detail_id IN (SELECT id FROM ' . TreatmentScheduleDetails::model()->tableName() . ' as td
                                                WHERE td.schedule_id IN (SELECT id FROM ' . TreatmentSchedules::model()->tableName() . ' as t
                                                                        WHERE t.doctor_id=' . $mUser->id . '))
                        AND r.process_date>\'' . CommonProcess::getPreviousDateOfDate($from, DomainConst::DATE_FORMAT_4) . '\'
                        AND r.process_date<\'' . CommonProcess::getNextDateOfDate($to, DomainConst::DATE_FORMAT_4) . '\'
                        AND om.type=' . OneMany::TYPE_AGENT_RECEIPT . ' AND om.one_id IN (' . implode(',', $arrAgentId) . ')';
                break;
            case Roles::getRoleByName(Roles::ROLE_DIRECTOR)->id:
                $sql = 'SELECT count(r.id) as count_id, sum(total) as sum_total, sum(final) as sum_final, sum(discount) as sum_discount
                        FROM ' . Receipts::model()->tableName() . ' as r
                        INNER JOIN ' . OneMany::model()->tableName() . ' as om ON om.many_id=r.id
                        WHERE r.detail_id IN (SELECT id FROM ' . TreatmentScheduleDetails::model()->tableName() . ' as td
                                                WHERE td.schedule_id IN (SELECT id FROM ' . TreatmentSchedules::model()->tableName() . ' as t))
                        AND r.process_date>\'' . CommonProcess::getPreviousDateOfDate($from, DomainConst::DATE_FORMAT_4) . '\'
                        AND r.process_date<\'' . CommonProcess::getNextDateOfDate($to, DomainConst::DATE_FORMAT_4) . '\'
                        AND om.type=' . OneMany::TYPE_AGENT_RECEIPT . ' AND om.one_id IN (' . implode(',', $arrAgentId) . ')';
                break;

            default:
                break;
        }
//        $allReceipts = Agents::getRevenueMultiAgent($from, $to, array(Receipts::STATUS_RECEIPTIONIST), true, $arrAgentId, '', true);
        // Create SQL statement
        // SELECT * FROM receipts as r WHERE r.detail_id
        //  IN (SELECT id FROM treatment_schedule_details as td WHERE td.schedule_id
        //          IN (SELECT id FROM treatment_schedules as t WHERE t.doctor_id=6))
        //  AND process_date>'2018-08-31' AND process_date<'2018-10-01'
//        $sql = 'SELECT count(id) as count_id, sum(total) as sum_total, sum(final) as sum_final, sum(discount) as sum_discount FROM ' . Receipts::model()->tableName() . ' as r WHERE r.detail_id IN '
//                . '(SELECT id FROM ' . TreatmentScheduleDetails::model()->tableName() . ' as td WHERE td.schedule_id IN '
//                . '(SELECT id FROM ' . TreatmentSchedules::model()->tableName() . ' as t WHERE t.doctor_id=' . $mUser->id . ')) '
//                . 'AND process_date>\'' . CommonProcess::getPreviousDateOfDate($from, DomainConst::DATE_FORMAT_4)
//                . '\' AND process_date<\'' . CommonProcess::getPreviousDateOfDate($to, DomainConst::DATE_FORMAT_4) . '\'';
        $list = Yii::app()->db->createCommand($sql)->queryAll();
        $countId    = $list[0]['count_id'];
        $total      = $list[0]['sum_total'];
        $final      = $list[0]['sum_final'];
        $discount   = $list[0]['sum_discount'];
        $result = ApiModule::$defaultSuccessResponse;
        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00194;
        $result[DomainConst::KEY_DATA] = array(
//            DomainConst::KEY_DISCOUNT_AMOUNT    => OneMany::getReceiptDiscountTotal($allReceipts->getData()),
//            DomainConst::KEY_TOTAL              => OneMany::getReceiptTotalTotal($allReceipts->getData()),
//            DomainConst::KEY_FINAL              => OneMany::getReceiptFinalTotal($allReceipts->getData()),
//            DomainConst::KEY_DEBT               => OneMany::getReceiptDebitTotal($allReceipts->getData()),
//            DomainConst::KEY_CAN_SELECT_AGENT   => DomainConst::NUMBER_ZERO_VALUE,
//            DomainConst::KEY_TOTAL_QTY          => OneMany::getReceiptCustomerTotal($allReceipts->getData()),
            DomainConst::KEY_TOTAL              => CommonProcess::formatCurrency($total),
            DomainConst::KEY_FINAL              => CommonProcess::formatCurrency($final),
            DomainConst::KEY_DISCOUNT_AMOUNT    => CommonProcess::formatCurrency($discount),
            DomainConst::KEY_DEBT               => CommonProcess::formatCurrency($total - $discount - $final),
            DomainConst::KEY_TOTAL_QTY          => $countId,
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
    
    /**
     * P0033_DailyReportList_API
     * Get list daily report
     * - url:   api/report/dailyReportList
     * - parameter:
     *  + token:        Token
     *  + month:        Month(format yyyy-mm)
     */
    public function actionDailyReportList() {
        try {
            $resultFailed = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse request to json
            $root = json_decode($_POST[DomainConst::KEY_ROOT_REQUEST]);
            // Check if parameters are exist
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_MONTH,
            ));
            // Get user by token value
            $mUser = $this->getUserByToken($resultFailed, $root->token);
            // Check version
            $this->checkVersion($root, $mUser);
            $this->getDailyReportList($resultFailed, $mUser, $root);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * Get list daily report
     * @param Array $result Result data
     * @param Object $mUser Model user
     * @param Object $root Json object
     */
    private function getDailyReportList($result, $mUser, $root) {
        $retVal = array();
        $monthValue = $root->month . '-01';
        Loggers::info('Month value', $monthValue, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $firstDate      = CommonProcess::getFirstDateOfMonth($monthValue);
        $currentDate    = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
        $lastDate       = CommonProcess::getLastDateOfMonth($monthValue);
        Loggers::info('First date of month', $firstDate, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        Loggers::info('Current date of month', $currentDate, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        Loggers::info('Last date of month', $lastDate, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $period = CommonProcess::getDatePeriod($firstDate, $currentDate);
        if (DateTimeExt::compare($currentDate, $lastDate) == 1) {
            $period = CommonProcess::getDatePeriod($firstDate, $lastDate);
        }
        foreach ($period as $dt) {
            $childData = array();
            // Get value of date
            $date = $dt->format(DomainConst::DATE_FORMAT_4);
            $dateAsId = $dt->format(DomainConst::DATE_FORMAT_10);
            $dateAsName = $dt->format(DomainConst::DATE_FORMAT_BACK_END);
            $status = DailyReports::checkStatus($mUser, $date);
            $statusStr = isset(DailyReports::getArrayStatus()[$status]) ? DailyReports::getArrayStatus()[$status] : '';
            $childData[] = CommonProcess::createConfigJson(DomainConst::ITEM_STATUS, '',
                    $status);
            $childData[] = CommonProcess::createConfigJson(DomainConst::ITEM_STATUS_STR, '',
                    $statusStr);
            $data = CommonProcess::createConfigJson($dateAsId, $dateAsName,
                    $childData);
            array_unshift($retVal, $data);
        }
        $result = ApiModule::$defaultSuccessResponse;
        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00194;
        $result[DomainConst::KEY_DATA]  = $retVal;
        ApiModule::sendResponse($result, $this);
    }
    
    /**
     * P0034_DailyReport_API
     * Get daily report information
     * - url:   api/report/dailyReport
     * - parameter:
     *  + token:        Token
     *  + date:         Date(format yyyy-mm-dd)
     */
    public function actionDailyReport() {
        try {
            $resultFailed = ApiModule::$defaultFailedResponse;
            // Check format of request
            $this->checkRequest();
            // Parse request to json
            $root = json_decode($_POST[DomainConst::KEY_ROOT_REQUEST]);
            // Check if parameters are exist
            $this->checkRequiredParam($root, array(
                DomainConst::KEY_TOKEN,
                DomainConst::KEY_DATE,
            ));
            // Get user by token value
            $mUser = $this->getUserByToken($resultFailed, $root->token);
            // Check version
            $this->checkVersion($root, $mUser);
            $this->getDailyReport($resultFailed, $mUser, $root);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * Get daily report
     * @param Array $result Result data
     * @param Object $mUser Model user
     * @param Object $root Json object
     */
    private function getDailyReport($result, $mUser, $root) {
        $retVal = array();
        foreach ($mUser->getAgentIds() as $agentId) {
            $retVal[] = DailyReports::getReport($root->date, $agentId);
        }
        $result = ApiModule::$defaultSuccessResponse;
        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00194;
        $result[DomainConst::KEY_DATA]  = $retVal;
        ApiModule::sendResponse($result, $this);
    }
    
    /**
     * P0035_UpdateDailyReport_API
     * Update daily report status
     * - url:   api/report/updateDailyReport
     * - parameter:
     *  + token:        Token
     *  + id:           Id of report
     *  + status:       Status of daily report
     */
    public function actionUpdateDailyReport() {
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
                DomainConst::KEY_STATUS,
            ));
            // Get user by token value
            $mUser = $this->getUserByToken($resultFailed, $root->token);
            // Check version
            $this->checkVersion($root, $mUser);
            $this->updateDailyReport($resultFailed, $mUser, $root);
        } catch (Exception $exc) {
            ApiModule::catchError($exc, $this);
        }
    }
    
    /**
     * Update daily report
     * @param Array $result Result data
     * @param Object $mUser Model user
     * @param Object $root Json object
     */
    private function updateDailyReport($result, $mUser, $root) {
        $mReport = DailyReports::model()->findByPk($root->id);
        if ($mReport) {
            // Request status is confirm
            if ($root->status == DailyReports::STATUS_CONFIRM) {
                if ($mReport->canConfirm($mUser->role_id)) {
                    $mReport->status = $root->status;
                    if ($mReport->save()) { // Success
                        $result = ApiModule::$defaultSuccessResponse;
                        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00035;
                        ApiModule::sendResponse($result, $this);
                    } else {                // Failed
                        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00214 . ': '
                                . CommonProcess::json_encode_unicode($mReport->getErrors());
                        ApiModule::sendResponse($result, $this);
                    }
                } else {                    // Failed
                    $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00511;
                    ApiModule::sendResponse($result, $this);
                }
            } else if ($root->status == DailyReports::STATUS_CANCEL) {
                // Request status is cancel
                if ($mReport->canCancel($mUser->role_id)) {
                    $mReport->status = $root->status;
                    if ($mReport->save()) { // Success
                        $result = ApiModule::$defaultSuccessResponse;
                        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00035;
                        ApiModule::sendResponse($result, $this);
                    } else {                // Failed
                        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00214 . ': '
                                . CommonProcess::json_encode_unicode($mReport->getErrors());
                        ApiModule::sendResponse($result, $this);
                    }
                } else {                    // Failed
                    $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00511;
                    ApiModule::sendResponse($result, $this);
                }
            } else {
                $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00511;
                ApiModule::sendResponse($result, $this);
            }
        } else {
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00510;
            ApiModule::sendResponse($result, $this);
        }
    }
}
