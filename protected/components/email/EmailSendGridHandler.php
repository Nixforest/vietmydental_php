<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmailSendGridHandler
 *
 * @author nguyenpt
 */
class EmailSendGridHandler {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Content type */
    const CONTENT_TYPE                      = "Content-type: application/json";
    /** Authorization */
    const AUTHOR_STATEMENT                  = "authorization: Bearer ";
    /** Message is valid, but it is not queued to be delivered */
    const STATUS_OK                         = '200';
    /** Message is both valid, and queued to be delivered */
    const STATUS_ACCEPTED                   = '202';
    /** Bad request */
    const STATUS_BAD_REQUEST                = '400';
    /** You do not have authorization to make the request */
    const STATUS_UNAUTHORIZED               = '401';
    /** Forbidden */
    const STATUS_FORBIDDEN                  = '403';
    /** The resource you tried to locate could not be found or does not exist */
    const STATUS_NOT_FOUND                  = '404';
    /** METHOD NOT ALLOWED */
    const STATUS_METHOD_NOT_ALLOWED         = '405';
    /** The JSON payload you have included in your request is too large */
    const STATUS_PAYLOAD_TOO_LARGE          = '413';
    /** UNSUPPORTED MEDIA TYPE */
    const STATUS_UNSUPPORTED_MEDIA_TYPE     = '415';
    /** The number of requests you have made exceeds SendGrid’s rate limitations */
    const STATUS_TOO_MANY_REQUESTS          = '429';
    /** An error occurred on a SendGrid server. */
    const STATUS_SERVER_UNAVAILABLE         = '500';
    /** The SendGrid v3 Web API is not available */
    const STATUS_SERVICE_NOT_AVAILABLE      = '503';
    
    /**
     * Get array status
     * @return Array Status array
     */
    public static function getArrStatus() {
        return array(
            self::STATUS_OK                     => "Message is valid, but it is not queued to be delivered",
            self::STATUS_ACCEPTED               => "Message is both valid, and queued to be delivered",
            self::STATUS_BAD_REQUEST            => "Bad request",
            self::STATUS_UNAUTHORIZED           => "You do not have authorization to make the request",
            self::STATUS_FORBIDDEN              => "Forbidden",
            self::STATUS_NOT_FOUND              => "The resource you tried to locate could not be found or does not exist",
            self::STATUS_METHOD_NOT_ALLOWED     => "METHOD NOT ALLOWED",
            self::STATUS_PAYLOAD_TOO_LARGE      => "The JSON payload you have included in your request is too large",
            self::STATUS_UNSUPPORTED_MEDIA_TYPE => "UNSUPPORTED MEDIA TYPE",
            self::STATUS_TOO_MANY_REQUESTS      => "The number of requests you have made exceeds SendGrid’s rate limitations",
            self::STATUS_SERVER_UNAVAILABLE     => "An error occurred on a SendGrid server",
            self::STATUS_SERVICE_NOT_AVAILABLE  => "The SendGrid v3 Web API is not available",
        );
    }
    
    /**
     * Get status string
     * @param Int $statusId Value of status id
     * @return string Value of status as String
     */
    public static function getStatus($statusId) {
        if (isset(self::getArrStatus()[$statusId])) {
            return self::getArrStatus()[$statusId];
        }
        
        return $statusId . '';
    }
    
    /**
     * Get API url
     * @return string
     */
    public static function getUrl() {
        return 'https://api.sendgrid.com/v3/mail/send';
    }
    
    /**
     * Send email by SendGrid
     * @param String $to        To email
     * @param String $from      From email
     * @param String $subject   Subject of email
     * @param String $content   Content of email
     */
    public static function sendEmailGrid($to, $from, $subject, $content, $format = '0') {
        $ch = curl_init();
        $key = Settings::getSendGridAPIKey();
        $headers = array(self::CONTENT_TYPE, self::AUTHOR_STATEMENT . $key,
        );
        Loggers::error('SendGrid key', $key, 
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $content = '"content": [{"type": "text/html", "value": "' . $content . '"}]}';
        if ($format == DomainConst::NUMBER_ONE_VALUE) {
            $content = '"content": [{"type": "text/plain", "value": "' . $content . '"}]}';
        }
        $input_xml = '{"personalizations": [{'
                . '"to": [{"email": "' . $to . '"}]}],'
                . '"from": {"email": "' . $from . '"},'
                . '"subject": "' . $subject . '",'
                . $content;
        Loggers::error('Data', $input_xml, 
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        curl_setopt($ch, CURLOPT_URL, self::getUrl());
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            Loggers::error('Error when send email', '', 
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        } else {
            Loggers::info('Response', CommonProcess::json_encode_unicode($response), 
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            
            $info           = curl_getinfo($ch);
            $status         = CommonProcess::getValue($info, 'http_code');
            $header_size    = CommonProcess::getValue($info, 'header_size');
            $body           = json_decode(substr($response, $header_size));
            $error          = CommonProcess::getValueJson($body, 'errors');
            $message        = '';
            if (isset($error[0])) {
                $message        = CommonProcess::getValueJson($error[0], 'message');
            }
            
            Loggers::info('Status: ' . $status, $message, 
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
//            Loggers::info('Status: ' . $status, CommonProcess::getValueJson(CommonProcess::getValueJson($body, 'errors'), 'message'), 
//                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            curl_close($ch);
        }
    }
}
