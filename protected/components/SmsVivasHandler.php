<?php

class SmsVivasHandler {

    const NAME_COOKIE                       = 'Set-Cookie';
    const BRAND_NAME                        = 'NK.VIET-MY'; // Brandname for Viettel, Vinaphone, Mobiphone
    const BRAND_NAME_VIETNAM_MOBILE         = 'NKVIETMY';   // Brandname for Vietnam Mobile
    const START_PHONE                       = '84';
    
    const PROTOCOL                          = 'HTTP';
    const METHOD                            = 'POST';
    
    const STATUS_SUCCESS                    = '0';
    const RESP_LOGIN_SUCCESS                = self::STATUS_SUCCESS;
    const RESP_LOGIN_USERNAME_ERR           = '1';
    const RESP_LOGIN_PWD_ERR                = '2';
    const RESP_LOGIN_REFUSE                 = '21';
    const RESP_SEND_SUCCESS                 = self::STATUS_SUCCESS;
    const RESP_SEND_BRANDNAME_ERR           = '3';
    const RESP_SEND_TEMPLATE_ERR            = '4';
    const RESP_SEND_CHECKSUM_ERR            = '5';
    const RESP_SEND_ID_ERR                  = '6';
    const RESP_SEND_OVER_QUOTA_ERR          = '8';
    const RESP_SEND_TYPE_ERR                = '9';
    const RESP_SEND_TIME_ERR                = '10';
    const RESP_SEND_MSGID_ERR               = '12';
    const RESP_SEND_OVER_QUOTA_PHONE_ERR    = '13';
    const RESP_SEND_PHONE_FORMAT_ERR        = '14';
    const RESP_SEND_LOGIN_ERR               = '20';
    const RESP_SEND_OVER_QUOTA_REQ_ERR      = '21';
    const RESP_VERIFY_REQ_ID_ERR            = '7';
    const RESP_ERR_50                       = '50';
    const RESP_ERR_51                       = '51';
    const RESP_ERR_52                       = '52';
    const RESP_PROTOCOL_ERR                 = '98';
    const RESP_MISS_PARAM_ERR               = '99';
    
    const SMS_STT_SUCCESS                   = self::STATUS_SUCCESS;
    const SMS_STT_WAITING                   = '1';
    const SMS_STT_SENDING                   = '2';
    const SMS_STT_SEND_FAILED               = '3';
    const SMS_STT_SEND_CANCEL               = '4';
    const SMS_STT_WAITING_RESEND            = '5';
    const SMS_STT_SEND_NO_RESP              = '6';
    const SMS_STT_SMS_INVALID               = '7';
    const SMS_STT_SMS_OVER_QUOTA            = '8';
    const SMS_STT_SMS_GATE_NOT_FOUND        = '9';
    const SMS_STT_ERR_OTHER                 = '10';
    const SMS_STT_WAITING_OUT_NETWORK       = '11';
    
    const CONNECTION_QUOTA                  = 20;
    const SMS_QUOTA                         = 1000;
    
    // Properties
    public $response                        = NULL;
    public $curl_info                       = NULL;
    public $body                            = NULL;    
    /**
     * Check if request is success.
     * @return True if response code is '0', False otherwise
     */
    public function isSuccess() {
        if ($this->response == self::STATUS_SUCCESS) {
            return true;
        } else {
            if (!empty($this->body->STATUS) && $this->body->STATUS == self::STATUS_SUCCESS) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Get error message
     * @return string Error message
     */
    public function getErrorMsg() {
        if (!empty($this->body->STATUS)) {
            switch ($this->body->STATUS) {
                case self::STATUS_SUCCESS:
                    return 'Thực hiện request thành công';
                case self::RESP_LOGIN_USERNAME_ERR:
                    return 'Sai tên đăng nhập';
                case self::RESP_LOGIN_PWD_ERR:
                    return 'Sai mật khẩu';
                case self::RESP_LOGIN_REFUSE:
                    return 'Request bị từ chối vì quá số lượng request đồng thời đến hệ thống';
                case self::RESP_ERR_50:
                case self::RESP_ERR_51:
                case self::RESP_ERR_52:
                    return 'Lỗi xử lý';
                case self::RESP_PROTOCOL_ERR:
                    return 'Lỗi sai protocol gọi request';
                case self::RESP_MISS_PARAM_ERR:
                    return 'Lỗi thiếu tham số gọi request';
                case self::RESP_SEND_BRANDNAME_ERR:
                    return 'Request bị từ chối vì Brandname không tồn tại hoặc không thuộc sở hữu';
                case self::RESP_SEND_TEMPLATE_ERR:
                    return 'Request bị từ chối vì không tìm thấy template hoặc không đúng template';
                case self::RESP_SEND_CHECKSUM_ERR:
                    return 'Request bị từ chối vì chứa một checksum sai';
                case self::RESP_SEND_ID_ERR:
                    return 'Request bị từ chối vì trùng ID';
                case self::RESP_SEND_OVER_QUOTA_ERR:
                    return 'Request bị từ chối vì vượt hạn mức gửi tin';
                case self::RESP_SEND_TYPE_ERR:
                    return 'Request bị từ thối vì thiếu loại SMS';
                case self::RESP_SEND_TIME_ERR:
                    return 'Request bị từ chối vì thiếu thời gian gửi';
                case self::RESP_SEND_MSGID_ERR:
                    return 'Request bị từ chối vì trùng msgid';
                case self::RESP_SEND_OVER_QUOTA_PHONE_ERR:
                    return 'Request bị từ chối vì vượt quá số lượng số điện thoại trong request';
                case self::RESP_SEND_PHONE_FORMAT_ERR:
                    return 'Request bị từ chối vì chứa số điện thoại sai';
                case self::RESP_SEND_LOGIN_ERR:
                    return 'Request bị từ chối vì chưa đăng nhập hoặc mất session';
                case self::RESP_SEND_OVER_QUOTA_REQ_ERR:
                    return 'Request bị từ chối vì quá số lượng request đồng thời đến hệ thống';
                default:
                    break;
            }
        }
        return '';
    }
    
    /**
     * login to server sms vivas
     */
    public function login() {
        $input_xml = '<RQST>'
                . '<USERNAME>' . VIVAS_USERNAME . '</USERNAME>'
                . '<PASSWORD>' . $this->getSha1(VIVAS_PASSWORD) . '</PASSWORD>'
                . '</RQST>';
        $headers = array(
            "Content-type: text/xml",
            "Content-length: " . strlen($input_xml),
//            'Cookie:' . $this->getSessionId(),
            "Connection: close",
        );
        $this->executeCurl(VIVAS_URL_LOGIN, $input_xml, $headers);
        // Thực hiện lưu sestion
        if ($this->isSuccess()) {
            Loggers::info('Loggin success', __FILE__ . '::' . __FUNCTION__, __LINE__);
            $this->saveCookie();
        } else if (is_numeric($this->response)) {
            Loggers::info('Loggin error: ' . $this->getErrorMsg(), __FILE__ . '::' . __FUNCTION__, __LINE__);
        } else {
            Loggers::info('Loggin success before', __FILE__ . '::' . __FUNCTION__, __LINE__);
            $this->saveCookie();
        }
    }
    
    /**
     * Save cookie
     */
    public function saveCookie() {
        $aHeaders = $this->get_headers_from_curl_response($this->response);
        if (!empty($aHeaders[self::NAME_COOKIE])) {
            $_SESSION[self::NAME_COOKIE] = $aHeaders[self::NAME_COOKIE];
            Loggers::info('Save cookie: ' . $aHeaders[self::NAME_COOKIE], __FILE__ . '::' . __FUNCTION__, __LINE__);
        }
    }

    /**
     * Send SMS
     * @param string  $type 1: CSKH 2:QC
     * @param string $phone remove 0
     * @param string $msg
     */
    public function sendSms($type = 'CSKH', $phone, $msg) {
        // Đăng nhập
//        $this->login();
        // id cần được lưu trử lại để kiểm tra bằng verify
//        $REQID = $phone;    // ID của request của hệ thống phía bên đối tác
        $REQID = CommonProcess::generateUniqId();    // ID của request của hệ thống phía bên đối tác
//        $MSGID = $phone;    // ID của SMS phía hệ thống đối tác
        $MSGID = CommonProcess::generateUniqId();    // ID của SMS phía hệ thống đối tác
        Loggers::info('Message id send sms: ', $MSGID, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
//        $time = date('YmdHis');
        $time = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_9);
        Loggers::info('Time send sms: ', $time, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $phone = self::START_PHONE . $phone;
        $BRANDNAME = self::BRAND_NAME;  //Tên Brandname
        $sharekey = VIVAS_SHARE_KEY;
        $strCheckSum = 'username=' . VIVAS_USERNAME . '&password=' . $this->getSha1(VIVAS_PASSWORD) . '&brandname=' . $BRANDNAME . '&sendtime=' . $time . '&msgid=' . $MSGID . '&msg=' . $msg . '&msisdn=' . $phone . '&sharekey=' . $sharekey;
//        $strCheckSum = 'username=' . VIVAS_USERNAME . '&password=' . $this->getSha1(VIVAS_PASSWORD) . '&brandname=' . $BRANDNAME . '&sendtime=' . $time . '&msgid=' . $MSGID . '&msg=' . $msg . '&msisdn=' . $phone;
        Loggers::info('Viewable checksum send sms: ', $strCheckSum, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $checkSum = $this->getMd5($strCheckSum);
        Loggers::info('Checksum send sms: ', $checkSum, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $input_xml = '<RQST>'
                . '<REQID>' . $REQID . '</REQID>'
                . '<BRANDNAME>' . $BRANDNAME . '</BRANDNAME>'
                . '<TEXTMSG>' . $msg . '</TEXTMSG>'
                . '<SENDTIME>' . $time . '</SENDTIME>'
                . '<TYPE>' . $type . '</TYPE>'
                . '<DESTINATION>'
                    . '<MSGID>' . $MSGID . '</MSGID>'
                    . '<MSISDN>' . $phone . '</MSISDN>'
                    . '<CHECKSUM>' . $checkSum . '</CHECKSUM>'
                . '</DESTINATION>'
                . '</RQST>';
        Loggers::info('Message input send sms: ', $input_xml, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
//        CommonProcess::dumpVariable($input_xml);
        $headers = array(
            "Content-type: text/xml",
            "Content-length: " . strlen($input_xml),
            'Cookie:' . $this->getSessionId(),
            "Connection: close",
        );
        $this->executeCurl(VIVAS_URL_SEND_SMS, $input_xml, $headers);
        if ($this->isSuccess()) {
            Loggers::info('Send sms success', __FILE__ . '::' . __FUNCTION__, __LINE__);
//            $this->saveCookie();
        } else {
            Loggers::info('Send sms error: ' . $this->getErrorMsg(), __FILE__ . '::' . __FUNCTION__, __LINE__);
//            $this->saveCookie();
        }
    }

    /**
     * send sms Ext
     * @param string $type 1: CSKH 2:QC
     * @param array $aPhone
     * @param string $msg
     */
    public function sendSmsExt($type = 'CSKH', $aPhone, $msg) {
        if (empty($aPhone) || !is_array($aPhone)) {
            return;
        }
        // Đăng nhập
        $this->login();
        // id cần được lưu trử lại để kiểm tra bằng verify
        $REQID = 1; // ID của request của hệ thống phía bên đối tác

        $time = date('YmdHis');
        $BRANDNAME = self::BRAND_NAME; //Tên Brandname
        $sharekey = VIVAS_USERNAME;
        $input_xml = '<RQST>'
                . '<REQID>' . $REQID . '</REQID>'
                . '<BRANDNAME>' . $BRANDNAME . '</BRANDNAME>'
                . '<TEXTMSG>' . $msg . '</TEXTMSG>'
                . '<SENDTIME>' . $time . '</SENDTIME>'
                . '<TYPE>' . $type . '</TYPE>'
                . '<DESTINATIONS>';
        foreach ($aPhone as $key => $phone) {
            $phone = self::START_PHONE . $phone;
            $MSGID = $phone; //ID của SMS phía hệ thống đối tác
            $strCheckSum = 'username=' . VIVAS_USERNAME . '&password=' . $this->getSha1(VIVAS_PASSWORD) . '&brandname=' . $BRANDNAME . '&sendtime=' . $time . '&msgid=' . $MSGID . '&msg=' . $msg . '&msisdn=' . $phone . '&sharekey=' . $sharekey;
            $checkSum = $this->getMd5($strCheckSum);
            $input_xml .= '<DESTINATION>'
                    . '<MSGID>' . $MSGID . '</MSGID>'
                    . '<MSISDN>' . $phone . '</MSISDN>'
                    . '<CHECKSUM>' . $checkSum . '</CHECKSUM>'
                    . '</DESTINATION>';
        }
        $input_xml .= '</DESTINATIONS>'
                . '</RQST>';
        $headers = array(
            "Content-type: text/xml",
            "Content-length: " . strlen($input_xml),
            'Cookie:' . $this->getSessionId(),
            "Connection: close",
        );
        $response = $this->executeCurl(VIVAS_URL_SEND_SMS_EXT, $input_xml, $headers);
        return $response;
    }

    /**
     * verify msg send
     * @param string $REQID
     * @return $response curl
     */
    public function verify($REQID) {
        // Đăng nhập
        $this->login();
        $input_xml = '<RQST>'
                . '<REQID>' . $REQID . '</REQID>'
                . '</RQST>';
        $headers = array(
            "Content-type: text/xml",
            "Content-length: " . strlen($input_xml),
            'Cookie:' . $this->getSessionId(),
            "Connection: close",
        );
        $this->executeCurl(VIVAS_URL_VERIFY, $input_xml, $headers);
        return $response;
    }

    /**
     * logout
     * @return response curl
     */
    public function logout() {
        $input_xml = '';
//        $sesionId = '08EF672E31E090A9B6C2122E17CE46CF';
        $headers = array(
            "Content-type: text/xml",
            "Content-length: " . strlen($input_xml),
            'Cookie:' . $this->getSessionId(),
//            'Cookie:' . $sesionId,
            "Connection: close",
        );
        $this->executeCurl(VIVAS_URL_LOGOUT, $input_xml, $headers);
        if ($this->isSuccess()) {
            Loggers::info('Logout success', __FILE__ . '::' . __FUNCTION__, __LINE__);
//            $this->saveCookie();
        } else {
            Loggers::info('Logout error: ' . $this->getErrorMsg(), __FILE__ . '::' . __FUNCTION__, __LINE__);
//            $this->saveCookie();
        }
    }
    
    public function getSessionId() {
        $COOKIE = '';
        if (!empty($_SESSION[self::NAME_COOKIE])) {
            $COOKIE = $_SESSION[self::NAME_COOKIE];
        }
//        if (!empty($COOKIE)) {
//            $arr = explode(';', $COOKIE);
//            if (count($arr) == 2) {
//                $arrSession = explode('=', $arr[0]);
//                if (count($arrSession)) {
//                    return $arrSession[1];
//                }
//            }
//        }
//        return '';
        return $COOKIE;
    }

    /**
     * convert to sha1
     * @param string $strInput
     * @return string
     */
    public function getSha1($strInput) {
        return base64_encode(sha1($strInput, true));
    }

    /**
     * convert to md5
     * @param string $strInput
     * @return string
     */
    public function getMd5($strInput) {
//        return base64_encode(md5($strInput, true));
        return (md5($strInput, false));
    }

    /**
     * get array of headers
     * @param data $response
     * @return array
     */
    public function get_headers_from_curl_response($response) {
        $headers = array();

        $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

        foreach (explode("\r\n", $header_text) as $i => $line)
            if ($i === 0)
                $headers['http_code'] = $line;
            else {
                list ($key, $value) = explode(': ', $line);

                $headers[$key] = $value;
            }

        return $headers;
    }

    /**
     * execute curl
     * @param string $url
     * @param string $input_xml
     * @param array $headers
     * @return response
     */
    public function executeCurl($url, $input_xml, $headers) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $this->response = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        } else {
            Loggers::info('Request: ' . $url, __FILE__ . '::' . __FUNCTION__, __LINE__);
            Loggers::info('Response: ' . $this->response, __FILE__ . '::' . __FUNCTION__, __LINE__);
            $this->curl_info = curl_getinfo($ch);
            curl_close($ch);
            $header_size = $this->curl_info['header_size'];
            $header = substr($this->response, 0, $header_size);
            $body = substr($this->response, $header_size);
            Loggers::info('Header: ' . $header, __FILE__ . '::' . __FUNCTION__, __LINE__);
            Loggers::info('Body: ' . $body, __FILE__ . '::' . __FUNCTION__, __LINE__);
            $this->body = simplexml_load_string($body);
            Loggers::info('Status: ' . $this->body->STATUS, __FILE__ . '::' . __FUNCTION__, __LINE__);
        }
    }

}
