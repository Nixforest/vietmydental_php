<?php

class SmsVivasHandler {

    const NAME_COOKIE = 'Set-Cookie';
    const BRAND_NAME = 'NHAKHOAVIETMY';
    const START_PHONE = '84';
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
            "Connection: close",
        );
        $response = $this->executeCurl(VIVAS_URL_LOGIN,$input_xml,$headers);
//        Thực hiện lưu sestion
        if($response == 0){
            $aHeaders = $this->get_headers_from_curl_response($response);
            if(!empty($aHeaders[self::NAME_COOKIE])){
                $_SESSION[self::NAME_COOKIE] = $aHeaders[self::NAME_COOKIE];
            }
        }
        return $response;
    }
    
    /**
     * 
     * @param string  $type 1: CSKH 2:QC
     * @param string $phone remove 0
     * @param string $msg
     */
    public function sendSms($type = 'CSKH',$phone,$msg){
//        Đăng nhập
        $this->login();
        $COOKIE             = $_SESSION[self::NAME_COOKIE];
//        id cần được lưu trử lại để kiểm tra bằng verify
        $REQID              = $phone; // ID của request của hệ thống phía bên đối tác
        $MSGID              = $phone; //ID của SMS phía hệ thống đối tác
        $time               = date('YmdHis');
        $phone              = self::START_PHONE.$phone;
        $BRANDNAME          = self::BRAND_NAME; //Tên Brandname
        $sharekey           = VIVAS_USERNAME;
        $strCheckSum        = 'username='.VIVAS_USERNAME.'&password='.$this->getSha1(VIVAS_PASSWORD).'&brandname='.$BRANDNAME.'&sendtime='.$time.'&msgid='.$MSGID.'&msg='.$msg.'&msisdn='.$phone.'&sharekey='.$sharekey;
        $checkSum           = $this->getMd5($strCheckSum);
        $input_xml  = '<RQST>'
                        . '<REQID>'.$REQID.'</REQID>'
                        . '<BRANDNAME>'.$BRANDNAME.'</BRANDNAME>'
                        . '<TEXTMSG>'.$msg.'</TEXTMSG>'
                        . '<SENDTIME>'.$time.'</SENDTIME>'
                        . '<TYPE>'.$type.'</TYPE>'
                        . '<DESTINATION>'
                            . '<MSGID>'.$MSGID.'</MSGID>'
                            . '<MSISDN>'.$phone.'</MSISDN>'
                            . '<CHECKSUM>'.$checkSum.'</CHECKSUM>'
                        . '</DESTINATION>'
                    . '</RQST>';
        $headers = array(
            "Content-type: text/xml",
            "Content-length: " . strlen($input_xml),
            'Cookie:'.$COOKIE,
            "Connection: close",
        );
        $response = $this->executeCurl(VIVAS_URL_SEND_SMS,$input_xml,$headers);
        return $response;
    }
    
    /**
     * send sms Ext
     * @param string $type 1: CSKH 2:QC
     * @param array $aPhone
     * @param string $msg
     */
    public function sendSmsExt($type = 'CSKH',$aPhone,$msg){
        if(empty($aPhone) || !is_array($aPhone)){
            return;
        }
//        Đăng nhập
        $this->login();
        $COOKIE             = $_SESSION[self::NAME_COOKIE];
//        id cần được lưu trử lại để kiểm tra bằng verify
        $REQID              = 1; // ID của request của hệ thống phía bên đối tác
        
        $time               = date('YmdHis');
        $BRANDNAME          = self::BRAND_NAME; //Tên Brandname
        $sharekey           = VIVAS_USERNAME;
        $input_xml          = '<RQST>'
                                .   '<REQID>'.$REQID.'</REQID>'
                                .   '<BRANDNAME>'.$BRANDNAME.'</BRANDNAME>'
                                .   '<TEXTMSG>'.$msg.'</TEXTMSG>'
                                .   '<SENDTIME>'.$time.'</SENDTIME>'
                                .   '<TYPE>'.$type.'</TYPE>'
                                .   '<DESTINATIONS>';
        foreach ($aPhone as $key => $phone) {
            $phone              = self::START_PHONE.$phone;
            $MSGID              = $phone; //ID của SMS phía hệ thống đối tác
            $strCheckSum        = 'username='.VIVAS_USERNAME.'&password='.$this->getSha1(VIVAS_PASSWORD).'&brandname='.$BRANDNAME.'&sendtime='.$time.'&msgid='.$MSGID.'&msg='.$msg.'&msisdn='.$phone.'&sharekey='.$sharekey;
            $checkSum           = $this->getMd5($strCheckSum);
            $input_xml          .=  '<DESTINATION>'
                                        . '<MSGID>'.$MSGID.'</MSGID>'
                                        . '<MSISDN>'.$phone.'</MSISDN>'
                                        . '<CHECKSUM>'.$checkSum.'</CHECKSUM>'
                                    . '</DESTINATION>';
        }
        $input_xml.=            '</DESTINATIONS>'
                            . '</RQST>';
        $headers = array(
            "Content-type: text/xml",
            "Content-length: " . strlen($input_xml),
            'Cookie:'.$COOKIE,
            "Connection: close",
        );
        $response = $this->executeCurl(VIVAS_URL_SEND_SMS_EXT,$input_xml,$headers);
        return $response;
    }
    
    /**
     * verify msg send
     * @param string $REQID
     * @return $response curl
     */
    public function verify($REQID){
//        Đăng nhập
        $this->login();
        $COOKIE             = $_SESSION[self::NAME_COOKIE];
        $input_xml          = '<RQST>'
                            .       '<REQID>'.$REQID.'</REQID>'
                            . '</RQST>';
        $headers = array(
            "Content-type: text/xml",
            "Content-length: " . strlen($input_xml),
            'Cookie:'.$COOKIE,
            "Connection: close",
        );
        $response = $this->executeCurl(VIVAS_URL_VERIFY,$input_xml,$headers);
        return $response;
    }
    
    /**
     * logout
     * @return response curl
     */
    public function logout(){
        $COOKIE             = $_SESSION[self::NAME_COOKIE];
        $input_xml          = '';
        $headers = array(
            "Content-type: text/xml",
            "Content-length: " . strlen($input_xml),
            'Cookie:'.$COOKIE,
            "Connection: close",
        );
        $response = $this->executeCurl(VIVAS_URL_LOGOUT,$input_xml,$headers);
        return $response;
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
        return base64_encode(md5($strInput, true));
    }
    
    /**
     * get array of headers
     * @param data $response
     * @return array
     */
    public function get_headers_from_curl_response($response)
    {
        $headers = array();

        $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

        foreach (explode("\r\n", $header_text) as $i => $line)
            if ($i === 0)
                $headers['http_code'] = $line;
            else
            {
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
    public function executeCurl($url,$input_xml,$headers){
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
        return curl_exec($ch);
    }
}
