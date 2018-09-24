<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Common process
 *
 * @author NguyenPT
 */
class CommonProcess {

    /**
     * Create random string.
     * @param Int $len          Length of result
     * @param String $charset   Default string
     * @return String           Random string
     */
    public static function randString($len = 6, $charset = 'ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnpqrstuvwxyz123456789') {
        $str = '';
        $count = strlen($charset);
        while ($len--) {
            $str .= $charset[mt_rand(0, $count - 1)];
        }
        return $str;
    }

    /**
     * Create hash password.
     * @param String $password  Password string
     * @param String $temp      Temp string
     * @return String           Hash password string
     */
    public static function hashPassword($password, $temp) {
        return md5($temp.$password);
    }
    
    /**
     * Create temp password string
     * @return String   Temp password string
     */
    public static function generateTempPassword() {
        return uniqid(' ', true);
    }
    
    /**
     * Generate uniq id
     * @param Int $len Length of return value
     * @return String
     */
    public static function generateUniqId($len = 13) {
        $retVal = '';
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($len / 2));
        } else if (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($len / 2));
        } else {
            $retVal = self::generateTempPassword();
        }
        
        $retVal = substr(bin2hex($bytes), 0, $len);
        return strtoupper($retVal);
    }
    
    /**
     * Get string of status: Active and Inactive
     * @param boolean $emptyOption Flag need add empty selection to return value
     * @return array Array string of status
     */
    public static function getDefaultStatus($emptyOption = false) {
        if ($emptyOption) {
            return array(
                '' => '',
                DomainConst::DEFAULT_STATUS_ACTIVE => DomainConst::CONTENT00027,
                DomainConst::DEFAULT_STATUS_INACTIVE => DomainConst::CONTENT00028
            );
        } else {
            return array(
                DomainConst::DEFAULT_STATUS_ACTIVE => DomainConst::CONTENT00027,
                DomainConst::DEFAULT_STATUS_INACTIVE => DomainConst::CONTENT00028
            );
        }
    }
    
    /**
     * Get string of gender: Male, Female and Other
     * @param boolean $emptyOption Flag need add empty selection to return value
     * @return array Array string of gender
     */
    public static function getGender($emptyOption = false) {
        if ($emptyOption) {
            return array(
                '' => '',
                DomainConst::GENDER_MALE => DomainConst::CONTENT00029,
                DomainConst::GENDER_FEMALE => DomainConst::CONTENT00030,
                DomainConst::GENDER_OTHER => DomainConst::CONTENT00031
            );
        } else {
            return array(
                DomainConst::GENDER_MALE => DomainConst::CONTENT00029,
                DomainConst::GENDER_FEMALE => DomainConst::CONTENT00030,
                DomainConst::GENDER_OTHER => DomainConst::CONTENT00031
            );
        }
    }
    
    /**
     * Get type of money: receipt and payment
     * @param boolean $emptyOption Flag need add empty selection to return value
     * @return array Array type of money
     */
    public static function getTypeOfMoney($emptyOption = false) {
        if ($emptyOption) {
            return array(
                '' => '',
                DomainConst::NUMBER_ZERO_VALUE => DomainConst::CONTENT00002,
                DomainConst::NUMBER_ONE_VALUE => DomainConst::CONTENT00001
            );
        } else {
            return array(
                DomainConst::NUMBER_ZERO_VALUE => DomainConst::CONTENT00002,
                DomainConst::NUMBER_ONE_VALUE => DomainConst::CONTENT00001
            );
        }
    }
    
    /**
     * Get string of status: Active and Inactive
     * @param boolean $emptyOption Flag need add empty selection to return value
     * @return array Array string of status
     */
    public static function getDefaultAccessStatus($emptyOption = false) {
        if ($emptyOption) {
            return array(
                '' => '',
                DomainConst::DEFAULT_ACCESS_ALLOW => DomainConst::CONTENT00032,
                DomainConst::DEFAULT_ACCESS_DENY => DomainConst::CONTENT00033
            );
        } else {
            return array(
                DomainConst::DEFAULT_ACCESS_ALLOW => DomainConst::CONTENT00032,
                DomainConst::DEFAULT_ACCESS_DENY => DomainConst::CONTENT00033
            );
        }
    }
    
    /**
     * Get list actions
     * @param boolean $emptyOption Flag need add empty selection to return value
     * @return array Array string of actions
     */
    public static function getListActions($emptyOption = false) {
        if ($emptyOption) {
            return array(
                '' => '',
                DomainConst::KEY_ACTION_INDEX => DomainConst::KEY_ACTION_INDEX,
                DomainConst::KEY_ACTION_ADMIN => DomainConst::KEY_ACTION_ADMIN,
                DomainConst::KEY_ACTION_VIEW => DomainConst::KEY_ACTION_VIEW,
                DomainConst::KEY_ACTION_CREATE => DomainConst::KEY_ACTION_CREATE,
                DomainConst::KEY_ACTION_UPDATE => DomainConst::KEY_ACTION_UPDATE,
                DomainConst::KEY_ACTION_DELETE => DomainConst::KEY_ACTION_DELETE,
                DomainConst::KEY_ACTION_SEARCH_USER => DomainConst::KEY_ACTION_SEARCH_USER,
                DomainConst::KEY_ACTION_GROUP => DomainConst::KEY_ACTION_GROUP,
                DomainConst::KEY_ACTION_USER => DomainConst::KEY_ACTION_USER,
                DomainConst::KEY_ACTION_CHANGE_PASSWORD => DomainConst::KEY_ACTION_CHANGE_PASSWORD,
                DomainConst::KEY_ACTION_RESET_PASSWORD => DomainConst::KEY_ACTION_RESET_PASSWORD,
                DomainConst::KEY_ACTION_SEARCH_STREET => DomainConst::KEY_ACTION_SEARCH_STREET,
                DomainConst::KEY_ACTION_SEARCH_DISTRICT => DomainConst::KEY_ACTION_SEARCH_DISTRICT,
                DomainConst::KEY_ACTION_SEARCH_WARD => DomainConst::KEY_ACTION_SEARCH_WARD,
                DomainConst::KEY_ACTION_SEARCH_CUSTOMER => DomainConst::KEY_ACTION_SEARCH_CUSTOMER,
                DomainConst::KEY_ACTION_SEARCH_MEDICAL_RECORD => DomainConst::KEY_ACTION_SEARCH_MEDICAL_RECORD,
                DomainConst::KEY_ACTION_SEARCH_MEDICINE => DomainConst::KEY_ACTION_SEARCH_MEDICINE,
            );
        } else {
            return array(
                DomainConst::KEY_ACTION_INDEX => DomainConst::KEY_ACTION_INDEX,
                DomainConst::KEY_ACTION_ADMIN => DomainConst::KEY_ACTION_ADMIN,
                DomainConst::KEY_ACTION_VIEW => DomainConst::KEY_ACTION_VIEW,
                DomainConst::KEY_ACTION_CREATE => DomainConst::KEY_ACTION_CREATE,
                DomainConst::KEY_ACTION_UPDATE => DomainConst::KEY_ACTION_UPDATE,
                DomainConst::KEY_ACTION_DELETE => DomainConst::KEY_ACTION_DELETE,
                DomainConst::KEY_ACTION_SEARCH_USER => DomainConst::KEY_ACTION_SEARCH_USER,
                DomainConst::KEY_ACTION_GROUP => DomainConst::KEY_ACTION_GROUP,
                DomainConst::KEY_ACTION_USER => DomainConst::KEY_ACTION_USER,
                DomainConst::KEY_ACTION_CHANGE_PASSWORD => DomainConst::KEY_ACTION_CHANGE_PASSWORD,
                DomainConst::KEY_ACTION_RESET_PASSWORD => DomainConst::KEY_ACTION_RESET_PASSWORD,
                DomainConst::KEY_ACTION_SEARCH_STREET => DomainConst::KEY_ACTION_SEARCH_STREET,
                DomainConst::KEY_ACTION_SEARCH_DISTRICT => DomainConst::KEY_ACTION_SEARCH_DISTRICT,
                DomainConst::KEY_ACTION_SEARCH_WARD => DomainConst::KEY_ACTION_SEARCH_WARD,
                DomainConst::KEY_ACTION_SEARCH_CUSTOMER => DomainConst::KEY_ACTION_SEARCH_CUSTOMER,
                DomainConst::KEY_ACTION_SEARCH_MEDICAL_RECORD => DomainConst::KEY_ACTION_SEARCH_MEDICAL_RECORD,
                DomainConst::KEY_ACTION_SEARCH_MEDICINE => DomainConst::KEY_ACTION_SEARCH_MEDICINE,
            );
        }
    }
    
    /**
     * Get string of status: Active and Inactive
     * @param boolean $emptyOption Flag need add empty selection to return value
     * @return array Array string of status
     */
    public static function getPlatforms($emptyOption = false) {
        if ($emptyOption) {
            return array(
                '' => '',
                DomainConst::PLATFORM_IOS       => DomainConst::CONTENT00190,
                DomainConst::PLATFORM_ANDROID   => DomainConst::CONTENT00191,
                DomainConst::PLATFORM_WINDOW    => DomainConst::CONTENT00192,
                DomainConst::PLATFORM_WEB       => DomainConst::CONTENT00193
            );
        } else {
            return array(
                DomainConst::PLATFORM_IOS       => DomainConst::CONTENT00190,
                DomainConst::PLATFORM_ANDROID   => DomainConst::CONTENT00191,
                DomainConst::PLATFORM_WINDOW    => DomainConst::CONTENT00192,
                DomainConst::PLATFORM_WEB       => DomainConst::CONTENT00193
            );
        }
    }
    
    /**
     * Convert teeth to index
     * @param String $teeth Teeth value ("11")
     * @return string Index of teeth
     */
    public static function convertTeethIndex($teeth) {
        $retVal = str_split($teeth);
        if (count($retVal) == 2) {
            $retVal = $retVal[0] . ' - ' . $retVal[1];
            $index = array_search($retVal, self::getListTeeth(FALSE, ''));
            if ($index != false) {
                return $index;
            }
        }
        
        return '';
    }
    
    /**
     * Get list of teeth
     * @param type $emptyOption
     * @return string
     */
    public static function getListTeeth($emptyOption = false, $prefix = DomainConst::CONTENT00284) {
        $retVal = array();
        if ($emptyOption) {
            $retVal[''] = '';
        }
        for ($index = 0; $index < 52; $index++) {
//            $retVal[$index] = "Răng số " . $index;
            if ($index >= 0 && $index <= 7) {
                $i = 1;
                $n = 8 - $index;
            } else if ($index >= 8 && $index <= 15) {
                $i = 2;
                $n = $index - 7;
            } else if ($index >= 16 && $index <= 23) {
                $i = 3;
                $n = 8 - $index % 8;
            } else if ($index >= 24 && $index <= 31) {
                $i = 4;
                $n = $index - 23;
            } else if ($index >= 32 && $index <= 36) {
                $i = 5;
                $n = 37 - $index;
            } else if ($index >= 37 && $index <= 41) {
                $i = 6;
                $n = $index - 36;
            } else if ($index >= 42 && $index <= 46) {
                $i = 7;
                $n = 5 - ($index - 32) % 5;
            } else {
                $i = 8;
                $n = $index - 46;
            }
            $retVal[$index] = $prefix . $i . " - " . $n;
        }
        
//        $retVal[52] = DomainConst::CONTENT00285;
//        $retVal[53] = DomainConst::CONTENT00286;
//        $retVal[54] = DomainConst::CONTENT00287;
        return $retVal;
    }
    
    /**
     * Get list config teeth
     * @return Array
     * [
     *      {
     *          id:"0",
     *          name:"Răng số 0",
     *      },
     *      ...
     * ]
     */
    public static function getListConfigTeeth() {
        $retVal = array();
        for ($index = 0; $index < 52; $index++) {
//            $retVal[] = CommonProcess::createConfigJson($index, "Răng số " . $index);
            if ($index >= 0 && $index <= 7) {
                $i = 1;
                $n = 8 - $index;
                
            } else if ($index >= 8 && $index <= 15) {
                $i = 2;
                $n = $index - 7;
            } else if ($index >= 16 && $index <= 23) {
                $i = 3;
                $n = 8 - $index % 8;
            } else if ($index >= 24 && $index <= 31) {
                $i = 4;
                $n = $index - 23;
            } else if ($index >= 32 && $index <= 36) {
                $i = 5;
                $n = 37 - $index;
            } else if ($index >= 37 && $index <= 41) {
                $i = 6;
                $n = $index - 36;
            } else if ($index >= 42 && $index <= 46) {
                $i = 7;
                $n = 5 - ($index - 32) % 5;
            } else {
                $i = 8;
                $n = $index - 46;
            }
            $retVal[] = CommonProcess::createConfigJson($index,
                    DomainConst::CONTENT00284 . $i . " - " . $n);
        }
//        $retVal[] = CommonProcess::createConfigJson(52, DomainConst::CONTENT00285);
//        $retVal[] = CommonProcess::createConfigJson(53, DomainConst::CONTENT00286);
//        $retVal[] = CommonProcess::createConfigJson(54, DomainConst::CONTENT00287);
        return $retVal;
    }

    /**
     * Get current user id
     * @return User id or blank when error
     */
    public static function getCurrentUserId() {
        return isset(Yii::app()->user) ? Yii::app()->user->id : '';
    }

    /**
     * Get current role id
     * @return string Id of role
     */
    public static function getCurrentRoleId() {
        if (isset(Yii::app()->user->role_id)) {
            return Yii::app()->user->role_id;
        }
        return '';
    }
    
    /**
     * Get current agent id
     * @return String Id of agent
     */
    public static function getCurrentAgentId() {
        return isset(Yii::app()->user) ? Yii::app()->user->agent_id : '';
    }
    
    /**
     * Get current agent id array
     * @return Array List id of agents
     */
    public static function getCurrentAgentIdArray() {
        return isset(Yii::app()->user) ? Yii::app()->user->agent_id_array : [];
    }
    
    /**
     * Get current agent array
     * @return Array List of model agent
     */
    public static function getCurrentAgentArray() {
        $retVal = array();
        $listAgentId = self::getCurrentAgentIdArray();
        Loggers::info('User\'s agent list', implode('-', $listAgentId), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        if (count($listAgentId) > 1) {
            $retVal[] = 'Tất cả';
        }
        foreach ($listAgentId as $id) {
            $agent = Agents::model()->findByPk($id);
            if (isset($agent)) {
                Loggers::info('Agent name', $agent->name, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
                $retVal[$id] = $agent->name;
            }
        }
        
        return $retVal;
    }
    
    /**
     * Check user was logged in
     * @return boolean True if user logged in, False otherwise
     */
    public static function checkUserIsLoggedIn() {
        if (Yii::app()->user->isGuest) {
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * Get host url
     * @return string Current host url
     */
    public static function getHostUrl() {
        return str_replace("index.php", "", Yii::app()->createAbsoluteUrl(DIRECTORY_SEPARATOR));
    }
    
    /**
     * Check if current user is admin
     * @return boolean True if role name of current user is ROLE_ADMIN, False otherwise
     */
    public static function isUserAdmin() {
        if (isset(Yii::app()->user->role_name)) {
            return (Yii::app()->user->role_name == 'ROLE_ADMIN');
        }
        return false;
    }
    
    //-----------------------------------------------------
    // ++ Date time process
    //-----------------------------------------------------
    /**
     * Get value of current date time
     * @param String $format Date time format
     * @return Date time string (default is DATE_FORMAT_1 - 'Y-m-d H:i:s')
     */
    public static function getCurrentDateTime($format = DomainConst::DATE_FORMAT_1) {
        date_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
        return date($format);
    }
    
    /**
     * Convert a datetime value to another format for save to my sql
     * @param String $datetime Input date timme string
     * @return String Date time string after format
     */
    public static function convertDateTimeToMySqlFormat($datetime, $format) {
//        $retVal = DateTime::createFromFormat($format, $datetime)->format(DomainConst::DATE_FORMAT_1);
        $retVal = CommonProcess::convertDateTime($datetime, $format, DomainConst::DATE_FORMAT_1);
        return $retVal;
    }
    
    /**
     * Get current date time string with format for save to my sql
     * @return String Date time string
     */
    public static function getCurrentDateTimeWithMySqlFormat() {
        return CommonProcess::getCurrentDateTime();
    }
    
    /**
     * Convert date time with format
     * @param type $datetime
     * @param type $format
     * @return type
     */
    public static function convertDateTimeWithFormat($datetime, $format = DomainConst::DATE_FORMAT_3) {
//        $time = DateTime::createFromFormat(DomainConst::DATE_FORMAT_1, $datetime)->format($format);
        $time = self::convertDateTime($datetime, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_3);
        return $time;
    }
    
    /**
     * Convert date time
     * @param String $datetime Date time value to convert
     * @param String $fromFormat Convert from this format
     * @param String $toFormat Convert to this format
     * @return String Date time value after convert
     */
    public static function convertDateTime($datetime, $fromFormat, $toFormat) {
        if (DateTimeExt::isDateNull($datetime)) {
            return '';
        }
        $converter = DateTime::createFromFormat($fromFormat, $datetime);
        if ($converter) {
            return $converter->format($toFormat);
        }
        return '';
    }
    
    /**
     * Get tommorow day
     * @param String $format Date time format
     * @return Date time string (default is DATE_FORMAT_1 - 'Y-m-d H:i:s')
     */
    public static function getNextDateTime($format = DomainConst::DATE_FORMAT_1) {
        date_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
        return date($format, strtotime('+1 day'));
    }
    
    /**
     * Get yesterday
     * @param String $format Date time format
     * @return Date time string (default is DATE_FORMAT_1 - 'Y-m-d H:i:s')
     */
    public static function getPreviousDateTime($format = DomainConst::DATE_FORMAT_1) {
        date_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
        return date($format, strtotime('-1 day'));
    }
    
    /**
     * Get the date before yesterday
     * @param String $format Date time format
     * @return Date time string (default is DATE_FORMAT_1 - 'Y-m-d H:i:s')
     */
    public static function getDateBeforeYesterdayDateTime($format = DomainConst::DATE_FORMAT_1) {
        date_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
        return date($format, strtotime('-2 day'));
    }
    
    /**
     * Get tomorrow
     * @param String $format Date time format
     * @return Date time string (default is DATE_FORMAT_1 - 'Y-m-d H:i:s')
     */
    public static function getTomorrowDateTime($format = DomainConst::DATE_FORMAT_1) {
        ate_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
        return date($format, strtotime('1 day'));
    }
    
    /**
     * Get previous month
     * @param String $format Date time format
     * @return Date time string (default is DATE_FORMAT_1 - 'Y-m-d H:i:s')
     */
    public static function getPreviousMonth($format = DomainConst::DATE_FORMAT_1) {
        date_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
        return date($format, strtotime('-1 month'));
    }
    
    /**
     * Get first day of current month
     * @param String $format Date time format
     * @return Date time string (default is DATE_FORMAT_1 - 'Y-m-d H:i:s')
     */
    public static function getFirstDateOfCurrentMonth($format = DomainConst::DATE_FORMAT_1) {
        date_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
        $formatFirst = str_replace("d", "01", $format);
        return date($formatFirst);
    }
    
    /**
     * Get first date of month
     * @param String $date Date time value (format is DATE_FORMAT_4 - 'Y-m-d')
     * @return Date time string (default is DATE_FORMAT_4 - 'Y-m-d')
     */
    public static function getFirstDateOfMonth($date) {
        return date('Y-m-01', strtotime($date));
    }
    
    /**
     * Get last date of month
     * @param String $date Date time value (format is DATE_FORMAT_4 - 'Y-m-d')
     * @return Date time string (default is DATE_FORMAT_4 - 'Y-m-d')
     */
    public static function getLastDateOfMonth($date) {
        return date('Y-m-t', strtotime($date));
    }
    
    /**
     * Check if a datetime has format in param
     * @param String $datetime  Date time string
     * @param String $format    Format to check
     * @return boolean  True if date time string has format in param, False otherwise
     */
    public static function checkFormat($datetime, $format) {
        $converter = DateTime::createFromFormat($format, $datetime);
        if ($converter) {
            return true;
        }
        return false;
    }
            
    //-----------------------------------------------------
    // -- Date time process
    //-----------------------------------------------------
    
    /**
     * Get value in array
     * @param Array $array Array of data
     * @param String $key Value of key
     * @param type $defaultValue Default value
     * @return Value after get from array
     */
    public static function getValue($array, $key, $defaultValue = '') {
        $retVal = $defaultValue;
        if (isset($array[$key])) {
            $retVal = $array[$key];
        }
        return $retVal;
    }
    
    /**
     * Generate Id string
     * @param String $prefix Prefix of id
     * @param Int $id Id value
     * @return String Id string
     */
    public static function generateID($prefix, $id) {
        $retVal = $prefix;
        $retVal .= sprintf('%011d', $id);
        return $retVal;
    }
    
    /**
     * Create address string
     * @param String $cityId      Id of city
     * @param String $districtId  Id of district
     * @param String $wardId      Id of ward
     * @param String $streetId    Id of street
     * @param String $house       House number
     * @return String
     */
    public static function createAddressString(
            $cityId, $districtId,
            $wardId, $streetId, $house) {
        $ADDRESS_SPLITTER = " ";           // Splitter
        
        // ----- Append house number ------
        $retVal = $house;
        
        // ----- Append street name ------
        if (!empty($streetId)) {            // Check street id is not null
            // Get street model
            $street = Streets::model()->findByPk($streetId);
            if ($street) {                  // Found street model
                if (empty($house)) {        // If house number is empty
                    $retVal .= $street->name;
                } else {                    // House number is not empty
                    $retVal .= $ADDRESS_SPLITTER . $street->name;
                }
            }
        }
        // ----- Append ward name ------
        if (!empty($wardId)) {              // Check ward id is not null
            // Get ward model
            $ward = Wards::model()->findByPk($wardId);
            if ($ward) {                    // Found ward model
                if (empty($retVal)) {       // If house number and street is empty
                    $retVal .= $ward->name;
                } else {                    // If house number or street is not null
                    $retVal .= $ADDRESS_SPLITTER . $ward->name;
                }
            }
        }
        // ----- Append district name ------
        if (!empty($districtId)) {              // Check district id is not null
            // Get district model
            $district = Districts::model()->findByPk($districtId);
            if ($district) {                    // Found district model
                if (empty($retVal)) {           // If house number, street and ward is empty
                    $retVal .= $district->name;
                } else {                        // If house number, street and ward is not null
                    $retVal .= $ADDRESS_SPLITTER . $district->name;
                }
            }
        }
        // ----- Append city name ------
        if (!empty($cityId)) {                  // Check city id is not null
            // Get city model
            $city = Cities::model()->findByPk($cityId);
            if ($city) {                        // Found city model
                if (empty($retVal)) {           // If house number, street, ward and district is empty
                    $retVal .= $city->name;
                } else {                        // If house number, street, ward and district is not null
                    $retVal .= $ADDRESS_SPLITTER . $city->name;
                }
            }
        }
        return $retVal;
    }
    
    /**
     * Format currency value
     * @param type $price Price value
     * @return String Price after format
     */
    public static function formatCurrency($price) {
        $number_left = substr(strrchr($price, "."), 1);
        if ($number_left > 0) {
            $res = number_format((double) $price, 2);
        } else {
            $res = number_format((double) $price, 0);
        }
        return $res;
    }
    
    /**
     * Format currency value (include unit 'VND')
     * @param type $price Price value
     * @return String Price after format
     */
    public static function formatCurrencyWithUnit($price) {
        return self::formatCurrency($price) . ' ' . DomainConst::CONTENT00134;
    }
    
    //-----------------------------------------------------
    // ++ Connection process
    //-----------------------------------------------------
    /**
     * Get User ip address
     * @return String
     */
    public static function getUserIP() {
        return Yii::app()->request->getUserHostAddress();
    }
    
    /**
     * Get user country
     * @param String $ip_address    IP address
     * @return string
     */
    public static function getUserCountry($ip_address) {
        $retVal = '';
        if ($ip_address != '::1' && $ip_address != '127.0.0.1') {
            $location = Yii::app()->geoip->lookupLocation($ip_address);
            if (!is_null($location)) {
                $retVal = $location->countryName;
                $retVal .= " - $location->region - $location->regionName"
                        . " - $location->city - PostalCode: $location->postalCode";
            }
        }
        return $retVal;
    }
    
    /**
     * Get user agent
     * @return Agent model or NULL
     */
    public static function getUserAgent() {
        $mUser = Users::model()->findByPk(self::getCurrentUserId());
        if ($mUser && !empty($mUser->rAgents)) {
            return $mUser->rAgents[0];
        }
        return NULL;
    }
    
    //-----------------------------------------------------
    // -- Connection process
    //-----------------------------------------------------
    
    /**
     * Generate sessin id
     * @param type $className
     * @param type $fieldName
     * @return type
     */
    public static function generateSessionIdByModel($className, $fieldName) {
//        $retVal = md5(time() . StringHelper::getRandomString(16));
        $retVal = md5(time() . CommonProcess::randString(16));
        $model = call_user_func(array($className, 'model'));
//        $count = $model->count("$fieldName='$retVal'");
//        if ($count > 0) {
//            $retVal = 
//        }
        return $retVal;
    }
    
    //-----------------------------------------------------
    // ++ Handle json string
    //-----------------------------------------------------
    public static function json_encode_unicode($data) {
        if (defined('JSON_UNESCAPED_UNICODE')) {
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        return preg_replace_callback('/(?<!\\\\)\\\\u([0-9a-f]{4})/i',
            function ($m) {
                $d = pack("H*", $m[1]);
                $r = mb_convert_encoding($d, "UTF8", "UTF-16BE");
                return $r!=="?" && $r!=="" ? $r : $m[0];
            }, json_encode($data)
        );
    }
    
    /**
     * Create config json
     * @param String $id Id value
     * @param String $name Name value
     * @param Object $data Data value
     * @return String
     *  {
     *      id: "$id",
     *      name: "$name",
     *      data: $data
     *  }
     */
    public static function createConfigJson($id, $name, $data = '') {
        if ($data === '') {
            return array(
                DomainConst::KEY_ID     => $id,
                DomainConst::KEY_NAME   => isset($name) ? $name : '',
            );
        }
        return array(
            DomainConst::KEY_ID     => $id,
            DomainConst::KEY_NAME   => isset($name) ? $name : '',
            DomainConst::KEY_DATA   => isset($data) ? $data : ''
        );
    }
    //-----------------------------------------------------
    // -- Handle json string
    //-----------------------------------------------------
    
    /**
     * Remove sign of string
     * @param String $str String to remove sign
     * @return String
     */
    public static function removeSignOnly($str) {
        $retVal = $str;
        $unicode = array(
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd'=>'đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i'=>'í|ì|ỉ|ĩ|ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D'=>'Đ',
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        foreach ($unicode as $nonUnicode => $uni) {
            $retVal = preg_replace("/($uni)/i", $nonUnicode, $retVal);
        }
        $retVal = str_replace("đ", "d", $retVal);
        $retVal = str_replace("Đ", "d", $retVal);
        return $retVal;
    }
    
    /**
     * Remove sign of string
     * @param String $str String to remove sign
     * @return String
     */
    public static function removeSign($str) {
        $retVal = strtolower($str);
        $unicode = array(
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd'=>'đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i'=>'í|ì|ỉ|ĩ|ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
//        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
//        'D'=>'Đ',
//        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
//        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
//        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
//        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
//        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        foreach ($unicode as $nonUnicode => $uni) {
            $retVal = preg_replace("/($uni)/i", $nonUnicode, $retVal);
        }
        $retVal = str_replace("đ", "d", $retVal);
        $retVal = str_replace("Đ", "d", $retVal);
        return $retVal;
    }
    
    /**
     * Get short string (remove sign, make lowercase)
     * @param String $str Source string
     * @return String after remove sign, make lowercase
     */
    public static function getShortString($str) {
        $retVal = strtolower($str);
        return self::removeSign($retVal);
    }

    /**
     * Get slug string
     * @param String $str Source string
     * @return Slug string
     */
    public static function getSlugString($str) {
        $retVal = self::getShortString($str);
        return str_replace(" ", "-", $retVal);
    }
    
    /**
     * Get username from fullname
     * @param String $fullName
     * @return type
     */
    public static function getUsernameFromFullName($fullName) {
        // Remove sign and make lower case
        $retVal = self::getShortString($fullName);
        
        // Split all words to array
        $arrStr = explode(" ", $retVal);
        // Get length of array
        $len = count($arrStr);
        // Check if full name have up to 2 words
        if ($len > 1) {
            // Get name word
            $name = $arrStr[$len - 1];
            $retVal = $name;
            // Loop for all first name and sub name
            for ($index = 0; $index < $len - 1; $index++) {
                // Take first character and append to return value
                if (isset($arrStr[$index][0])) {
                    $retVal .= $arrStr[$index][0];
                }
            }
        }
        
        return $retVal;
    }

    /**
     * Generate array of simple password
     * @return Array
     */
    public static function getSimplePassword() {
        return array(
            'Qwe456789',
            '123456',
            '111111'
        );
    }
    
    /**
     * Remove empty item from array
     * @param Array $arr Array being checked
     */
    public static function removeEmptyItemFromArray(&$arr) {
        foreach ($arr as $key => $value) {
            if (is_null($value)) {
                unset($arr[$key]);
            }
        }
    }
    
    /**
     * Get max file size
     * @return Int
     */
    public static function getMaxFileSize() {
        return 10 * 1024 * 1000;
    }
    
    /**
     * Get min file size
     * @return Int
     */
    public static function getMinFileSize() {
        return 2 * 1024;
    }
    
    /**
     * Make slug from text
     * @param String $text Text value
     * @return string
     */
    public static function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
    
    /**
     * Build order number array
     * @param Int $size Array size
     * @return Array
     */
    public static function buildOrderNumberArray($size) {
        $retVal = array();
        for ($i = 1; $i <= $size; $i++) {
            $retVal[$i] = $i;
        }
        return $retVal;
    }
    
    /**
     * Call soap function
     * @param Array $userParam Parameter list
     * @param String $functionCall Function name
     * @param String $url Server url
     * @return \SoapClient
     */
    public static function callSoapFunction($userParam, $functionCall, $url) {
        $client = new SoapClient($url, array(
            "soap_version"  => SOAP_1_1,
            "trace"         => 1
        ));
        $client->__soapCall($functionCall, array($userParam));
        return $client;
    }
    
    /**
     * Get value from json object root
     * @param Array $root Root json object
     * @param String $fieldName Field name
     * @return String
     */
    public static function getValueFromJson($root, $fieldName) {
        if (isset($root->$fieldName)) {
            return $root->$fieldName;
        }
        return "";
    }
    
    /**
     * Breakdown and array by page
     * @param Array $array Array value
     * @param Int $page Page index
     * @return array Array after breakdown
     */
    public static function breakArray($array, $page) {
        $retVal = array();
        $retVal = array_splice($array, $page * Settings::getApiListPageSize(), Settings::getApiListPageSize());
        return $retVal;
    }
    
    /**
     * Generate URL
     * @param String $code Code value
     * @return String
     */
    public static function generateQRCodeURL($code) {
        return 'http://' . Settings::getDomain() . "/index.php/front/customer/view/code/" . $code;
    }
    
    /**
     * Echo test string
     * @param String $message Message
     * @param String $data Data
     */
    public static function echoTest($message, $data) {
        if (is_array($data)) {
            $sData = '[' . implode(", ", $data) . ']';
            echo '<b>' . $message . '</b>' . '<i>' . $sData . '</i>';
        } else {
            echo '<b>' . $message . '</b>' . '<i>' . $data . '</i>';
        }
        echo '<br/>';
    }
    
    /**
     * Echo test string
     * @param String $message Message
     * @param String $data Data
     */
    public static function echoArrayKeyValue($message, $data) {
        if (is_array($data)) {
            $aData = array();
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    
                } else {
                    $aData[] = '(' . $key . ' - ' . $value . ')';
                }
            }
            $sData = '[' . implode(", ", $aData) . ']';
            echo '<b>' . $message . '</b>' . '<i>' . $sData . '</i>';
            echo '<br/>';
        }
    }

    /**
     * Print to show value of variable
     * @param Any $variable Variable to show value
     */
    public static function dumpVariable($variable) {
        if (YII_DEBUG) {
//            echo "<pre>";
            var_dump($variable);
//            echo "<pre>";
            die;
        }
    }
}
//======================================================================
// CATEGORY LARGE FONT
//======================================================================

//-----------------------------------------------------
// Sub-Category Smaller Font
//-----------------------------------------------------

/* Title Here Notice the First Letters are Capitalized */

# Option 1
# Option 2
# Option 3

/*
* This is a detailed explanation
* of something that should require
* several paragraphs of information.
*/

// This is a single line quote.