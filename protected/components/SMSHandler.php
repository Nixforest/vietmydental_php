<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SMSHandler
 *
 * @author nguyenpt
 */
class SMSHandler {
    /** SMS provider vivas */
    const SMS_PROVIDER_VIVAS                  = '1';
    
    /**
     * Send SMS
     * @param String $username
     * @param String $password
     * @param String $cpCode
     * @param String $requestId
     * @param String $phone
     * @param String $serviceId
     * @param String $commandCode
     * @param String $content
     * @param String $contentType
     */
    public static function sendSMS($username, $password, $cpCode, $requestId,
            $phone, $serviceId, $commandCode, $content, $contentType) {
        $url = Settings::getSMSServerUrl();
        $userParam = array(
            'User'          => $username,
            'Password'      => $password,
            'CPCode'        => $cpCode,
            'RequestID'     => $requestId,
            'UserID'        => $phone,
            'ReceiverID'    => $phone,
            'ServiceID'     => $serviceId,
            'CommandCode'   => $commandCode,
            'Content'       => $content,
            'ContentType'   => $contentType,
        );
//        CommonProcess::dumpVariable($url);
//        CommonProcess::dumpVariable($userParam);
        if (!empty($url)) {
            $client = CommonProcess::callSoapFunction($userParam, "wsCpMt", $url);
        }
    }
    
    /**
     * Get list SMS provider
     * @return Array List SMS provider
     */
    public static function getListSMSProvider() {
        return array(
            self::SMS_PROVIDER_VIVAS => 'VIVAS SMS System',
        );
    }
    
    /**
     * Send sms
     * @param String $type Type of sms (1: Customer care, 2: Advertising)
     * @param String $phone Phone number
     * @param String $message Message sms
     */
    public static function sendSMSOnce($phone, $message, $type = '1') {
        $provider = Settings::getItem(Settings::KEY_SMS_PROVIDER);
        $formatedPhone = self::formatPhone($phone);
        $formatedMsg = CommonProcess::removeSignOnly($message);
        switch ($provider) {
            case self::SMS_PROVIDER_VIVAS:
                Loggers::info('Start send sms', self::getListSMSProvider()[self::SMS_PROVIDER_VIVAS], __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
                $sms = new SmsVivasHandler();
                $sms->sendSms($type, $formatedPhone, $formatedMsg);
                break;

            default:
                Loggers::error('Send sms error', 'No provider', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
                break;
        }
    }
    
    /**
     * Format phone number
     * @param String $phone Phone value
     * @return String Phone number after format
     *                - Remove first '0' character
     */
    public static function formatPhone($phone) {
        $retVal = $phone;
        $firstCharacter = substr($phone, 0, 1);
        if ($firstCharacter == DomainConst::NUMBER_ZERO_VALUE) {
            $retVal = substr($phone, 1);
        }
        
        return $retVal;
    }
}
