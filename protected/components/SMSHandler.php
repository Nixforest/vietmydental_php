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
    const SMS_PROVIDER_VIVAS = '1';

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
    public static function sendSMS($username, $password, $cpCode, $requestId, $phone, $serviceId, $commandCode, $content, $contentType) {
        $url = Settings::getSMSServerUrl();
        $userParam = array(
            'User' => $username,
            'Password' => $password,
            'CPCode' => $cpCode,
            'RequestID' => $requestId,
            'UserID' => $phone,
            'ReceiverID' => $phone,
            'ServiceID' => $serviceId,
            'CommandCode' => $commandCode,
            'Content' => $content,
            'ContentType' => $contentType,
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
        if (!Settings::canSendSMS()) {
            Loggers::info('Can not send SMS', 'Send sms function is off', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            return;
        }
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
     * Send sms by cron
     * @param string $title     Title of sms
     * @param string $phone     Phone number to send
     * @param string $message   Message of sms
     * @param int $user_id      Id of user
     * @param string $type      Type send sms Settings::KEY_SMS_SEND_NORMAL/ Settings::KEY_SMS_SEND_RECEIPT/ ...
     * @param date $time_send   Y-m-d H:i:s
     * @param int $content_type 0: Nội dung không dấu, 1: Nội dung có dấu
     * @param int $count_run    Lần gửi tin nhắn thứ mấy
     */
    public static function sendSMSSchedule($title, $phone, $message, $user_id,
            $type, $time_send, $content_type = 1, $count_run = 1) {
        if (!Settings::canSendSMS()) {
            Loggers::info('Can not send SMS', 'Send sms function is off', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            return;
        }
        // Insert new record to schedule_sms
        $mScheduleSms = new ScheduleSms();
        $mScheduleSms->title        = $title;
        $mScheduleSms->phone        = $phone;
        $mScheduleSms->content      = $message;
        $mScheduleSms->user_id      = $user_id;
        $mScheduleSms->type         = $type;
        $mScheduleSms->count_run    = $count_run;
        $mScheduleSms->time_send    = $time_send;
        $mScheduleSms->content_type = $content_type;
        $mScheduleSms->created_date = date('Y-m-d H:i:s');
        $mScheduleSms->created_by   = !empty(Yii::app()->user->id) ? Yii::app()->user->id : 0;
        $mScheduleSms->save();
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
