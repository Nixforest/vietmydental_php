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
}
