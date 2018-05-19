<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FirebaseHandler
 *
 * @author nguyenpt
 */
class FirebaseHandler {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const NOTIFY_CATEGORY_NEW_TREATMENT_SCHEDULE    = "1";
    public static function sendCloudMessageToAndroid($deviceToken = "", $title = "", $body = "", $message = "",
            $push_data = array()) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AIzaSyBQi7f8YUgk8U78RDW3tOSDN9mbTPiTUYQ';
        $msg = array(
            DomainConst::KEY_MESSAGE   => $message,
            DomainConst::KEY_DATA      => $push_data,
        );
        $fields = array();
        $fields[DomainConst::KEY_DATA] = $msg;
        if (is_array($deviceToken)) {
            $fields['registration_ids'] = $deviceToken;
        } else {
            $fields[DomainConst::KEY_TO] = $deviceToken;
        }
        $fields['notification'] = array(
            'body' => $body,
            'title' => $title,
            "sound" => "default",
        );
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $serverKey,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
    
    /**
     * Notify for doctor has new customer arrived
     * @param type $customer
     * @param type $doctor
     */
    public static function notifyNewSchedule($customer, $doctor) {
        $deviceToken = "";
        if ($doctor != NULL) {
            $deviceToken = $doctor->getLastToken();
        }
        $body = "Có bệnh nhân mới: ";
        $objectId = '';
        if ($customer != NULL) {
            $body .= $customer->name;
            $objectId = $customer->id;
        }
        if (!empty($deviceToken) && !empty($objectId)) {
            self::sendCloudMessageToAndroid($deviceToken,
                    Settings::getWebsiteName(),
                    $body,
                    $body, 
                    array(
                        DomainConst::KEY_CATEGORY       => FirebaseHandler::NOTIFY_CATEGORY_NEW_TREATMENT_SCHEDULE,
                        DomainConst::KEY_ID             => '1',
                        DomainConst::KEY_OBJECT_ID_NEW  => $objectId,
                    ));
        } else {
            Loggers::info("Lỗi không gửi được notify:", __FILE__, __LINE__);
        }
    }
}
