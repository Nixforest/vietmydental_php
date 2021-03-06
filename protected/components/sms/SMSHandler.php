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
     * @param string $type      Type send sms Settings::KEY_SMS_SEND_CREATE_SCHEDULE/ Settings::KEY_SMS_SEND_CREATE_RECEIPT/ ...
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

    /**
     * Send sms when create schedule
     * @param String $start_date    Start date of schedule
     * @param String $phone         Phone number
     * @param String $startTime     Start time of schedule
     * @param String $doctor        Name of doctor
     * @param String $customerId    Id of customer
     */
    public static function sendSMSCreateSchedule($start_date, $phone, $startTime, $doctor, $customerId, $type) {
        $dateTime = CommonProcess::getCurrentDateTime();
        if (Settings::getItem($type)) {
            if (DateTimeExt::compare($dateTime, $start_date) == -1) {
                Loggers::info('Prepare to send sms', '',
                        __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
                self::sendSMSSchedule($type, $phone,
                        'Quý Khách hàng đã đặt hẹn trên Hệ thống Nha Khoa Việt Mỹ vào lúc '
                                . $startTime . ' với bác sĩ ' . $doctor
                                . '. Quý Khách hàng vui lòng sắp xếp thời gian đến đúng hẹn',
                        $customerId,
                        $type, $dateTime);
            } else {
                Loggers::info('Not send SMS', 'Schedule on today no need to send sms',
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            }
        } else {
            $msg = 'CREATE';
            switch ($type) {
                case Settings::KEY_SMS_SEND_CREATE_SCHEDULE:
                    $msg = 'CREATE SCHEDULE';
                    break;
                case Settings::KEY_SMS_SEND_UPDATE_SCHEDULE:
                    $msg = 'UPDATE SCHEDULE';
                    break;
                case Settings::KEY_SMS_SEND_CREATE_SCHEDULE_DETAIL:
                    $msg = 'CREATE SCHEDULE DETAIL';
                    break;
                default:
                    break;
            }
            Loggers::info('Can not send SMS', 'Send sms function when ' . $msg . ' is off',
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
        
        // Alarm schedule
        if (Settings::getItem(Settings::KEY_SMS_SEND_ALARM_SCHEDULE)) {
            $startDate = CommonProcess::convertDateTime($start_date,
                    DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_4);
            Loggers::info('StartDate', $startDate,
                        __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $previousDate = CommonProcess::getPreviousDateOfDate($startDate, DomainConst::DATE_FORMAT_4);
            Loggers::info('PreviousDate', $previousDate,
                        __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            if (DateTimeExt::compare($dateTime, $start_date) == -1) {
                Loggers::info('Prepare to send sms alarm schedule', '',
                        __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
                self::sendSMSSchedule($type, $phone,
                        'Quý Khách hàng đã đặt hẹn trên Hệ thống Nha Khoa Việt Mỹ vào lúc '
                                . $startTime . ' với bác sĩ ' . $doctor
                                . '. Quý Khách hàng vui lòng sắp xếp thời gian đến đúng hẹn',
                        $customerId,
                        $type, $previousDate);
            } else {
                Loggers::info('Not send SMS', 'Schedule on today no need to send sms',
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            }
        }
    }
    
    /**
     * Send sms when create receipt
     * @param String $phone         Phone number
     * @param String $amount        Amount of money
     * @param String $date          Date of receipt
     * @param String $customerId    Id of customer
     */
    public static function sendSMSCreateReceipt($phone, $amount, $date, $customerId, $reason) {
        if (Settings::getItem(Settings::KEY_SMS_SEND_CREATE_RECEIPT)) {
            Loggers::info('Prepare to send sms', '',
                        __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $dateTime = CommonProcess::getCurrentDateTime();
            $process_date = CommonProcess::convertDateTime($date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_BACK_END);
            $msg = 'Quý Khách hàng đã thanh toán trên Hệ thống Nha Khoa Việt Mỹ số tiền '
                    . CommonProcess::formatCurrency($amount)
                    . ' vào ngày ' . $process_date
                    . '. Lý do: ' . $reason
                    . '. Xin cảm ơn Quý Khách.'; 
            self::sendSMSSchedule(Settings::KEY_SMS_SEND_CREATE_RECEIPT,
                    $phone, $msg, $customerId,
                    Settings::KEY_SMS_SEND_CREATE_RECEIPT,
                    $dateTime);
            
        } else {
            Loggers::info('Can not send SMS', 'Send sms function when CREATE RECEIPT is off',
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
    }
    
    /**
     * Send SMS OTP
     * @param String $phone Phone number
     * @param String $otp OTP
     */
    public static function sendSMSOTP($phone, $otp) {
        Loggers::info('Prepare to send sms', '',
                        __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $dateTime = CommonProcess::getCurrentDateTime();
        $msg = 'Mã OTP là ' . $otp . '. Đây là mật khẩu để bạn đăng nhập VietMy Dental.'
                . 'Vì lý do bảo mật đừng bao giờ chia sẻ mật khẩu này.';
//        self::sendSMSSchedule('OTP', $phone, $msg, '', 'OTP', $dateTime);
        self::sendSMSOnce($phone, $msg);
    }
}
