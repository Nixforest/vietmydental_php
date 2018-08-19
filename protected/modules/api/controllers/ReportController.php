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
    
    public function getStatistic($result, $mUser, $root) {
        $orgFormat = DomainConst::DATE_FORMAT_6;
        $dateFormat = DomainConst::DATE_FORMAT_4;
        $mAgent = NULL;
        $arrAgentId = explode(DomainConst::SPLITTER_TYPE_2, $root->agent_id);
        if (isset($arrAgentId[0])) {
            $mAgent = Agents::model()->findByPk($arrAgentId[0]);
        }
        $from   = CommonProcess::convertDateTime($root->date_from, $orgFormat, $dateFormat);
        $to     = CommonProcess::convertDateTime($root->date_to, $orgFormat, $dateFormat);
        if (empty($from)) {
            $from = CommonProcess::getCurrentDateTime($dateFormat);
        }
        if (empty($to)) {
            $to = CommonProcess::getCurrentDateTime($dateFormat);
        }
        $receipts = array();
        $newReceipts = array();
        // Start access db
        if ($mAgent) {
            $allReceipts = $mAgent->getReceipts($from, $to, array(Receipts::STATUS_RECEIPTIONIST),true);
            
            $result = ApiModule::$defaultSuccessResponse;
            $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00194;
            $listReceipts = array();
            foreach ($allReceipts as $receipt) {
                
            }
            $result[DomainConst::KEY_DATA] = array(
                DomainConst::KEY_DISCOUNT_AMOUNT    => OneMany::getReceiptDiscountTotal($allReceipts->getData()),
                DomainConst::KEY_TOTAL              => OneMany::getReceiptTotalTotal($allReceipts->getData()),
                DomainConst::KEY_FINAL              => OneMany::getReceiptFinalTotal($allReceipts->getData()),
                DomainConst::KEY_DEBT               => OneMany::getReceiptDebitTotal($allReceipts->getData()),
                DomainConst::KEY_CAN_SELECT_AGENT   => DomainConst::NUMBER_ZERO_VALUE,
                DomainConst::KEY_LIST_RECEIPTS      => $listReceipts,
            );
            ApiModule::sendResponse($result, $this);
        }
        
        $result[DomainConst::KEY_MESSAGE] = DomainConst::CONTENT00214;
        ApiModule::sendResponse($result, $this);
    }
}
