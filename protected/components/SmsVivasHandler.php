<?php

class SmsVivasHandler {

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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, VIVAS_URL_LOGIN);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        } else {
            curl_close($ch);
        }
        
        echo '<pre>';
        echo 'Result: ';
        print_r($data);
        echo '</pre>';
        die;
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
        return md5($strInput);
    }

}
