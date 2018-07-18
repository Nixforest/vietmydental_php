<?php
class SmsVivasHandler {
    const USERNAME          = '';
    const PASSWORD          = '';
    const URL_LOGIN         = 'http://mkt.vivas.vn:9080/SMSBNAPI/login';
    const URL_SEND_SMS      = 'http://mkt.vivas.vn:9080/SMSBNAPI/send_sms';
    const URL_SEND_SMS_EXT  = 'http://mkt.vivas.vn:9080/SMSBNAPI/send_sms_ext';
    const URL_VERIFY        = 'http://mkt.vivas.vn:9080/SMSBNAPI/verify';
    const URL_LOGOUT        = 'http://mkt.vivas.vn:9080/SMSBNAPI/logout';
    
    /**
     * login to server sms vivas
     */
    public function login(){
        $input_xml = '&lt;RQST&gt;'
                        .'&lt;USERNAME&gt;'.SmsVivasHandler::USERNAME.'&lt;/USERNAME&gt;'
                        .'&lt;PASSWORD&gt;'.$this->getSha1(SmsVivasHandler::PASSWORD).'&lt;/PASSWORD&gt;'
                    .'&lt;/RQST&gt;';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, SmsVivasHandler::URL_LOGIN);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'XML='.$input_xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        if(curl_errno($ch)){
            print curl_error($ch);
        }
        $data = curl_exec($ch);
//        echo '<pre>';
//        print_r(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
//        echo '</pre>';
//        die;
        curl_close($ch);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die;
    }
    
    /**
     * convert to sha1
     * @param string $strInput
     * @return string
     */
    public function getSha1($strInput){
//        return sha1($strInput,true);
        return sha1($strInput);
    }
    
    /**
     * convert to md5
     * @param string $strInput
     * @return string
     */
    public function getMd5($strInput){
//        return md5($strInput, true);
        return md5($strInput);
    }
}
