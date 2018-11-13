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
     * Get value of money
     * @return string Value of money
     */
    public static function getMoneyValue($money) {
        return str_replace(DomainConst::SPLITTER_TYPE_2, '', $money);
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
    
    /**
     * Get type of order: receipt and payment
     * @param boolean $emptyOption Flag need add empty selection to return value
     * @return array Array type of money
     */
    public static function getTypeOfOrder($emptyOption = false) {
        if ($emptyOption) {
            return array(
                '' => '',
                DomainConst::NUMBER_ONE_VALUE => 'Loại đơn hàng 1',
                DomainConst::NUMBER_ZERO_VALUE => 'Loại đơn hàng 2'
            );
        } else {
            return array(
                DomainConst::NUMBER_ONE_VALUE => 'Loại đơn hàng 1',
                DomainConst::NUMBER_ZERO_VALUE => 'Loại đơn hàng 2'
            );
        }
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
        date_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
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
     * Get next date of a date
     * @param String $date Date value (format: Y-m-d)
     * @return type
     */
    public static function getNextDateOfDate($date, $format = DomainConst::DATE_FORMAT_1) {
        date_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
        return date($format, strtotime('+1 day', strtotime($date)));
    }
    
    /**
     * Get plus date value
     * @param Int $numberOfDate Number of date need plus
     * @param String $format Date time format
     * @return Date time string (default is DATE_FORMAT_1 - 'Y-m-d H:i:s')
     */
    public static function getPlusDate($numberOfDate, $format = DomainConst::DATE_FORMAT_1) {
        date_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
        return date($format, strtotime('+' . $numberOfDate . ' day'));
    }
    
    /**
     * Get minus date value
     * @param Int $numberOfDate Number of date need minus
     * @param String $format Date time format
     * @return Date time string (default is DATE_FORMAT_1 - 'Y-m-d H:i:s')
     */
    public static function getMinusDate($numberOfDate, $format = DomainConst::DATE_FORMAT_1) {
        date_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
        return date($format, strtotime('-' . $numberOfDate . ' day'));
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
        date_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
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
        date_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
        return date('Y-m-01', strtotime($date));
    }
    
    /**
     * Get last date of month
     * @param String $date Date time value (format is DATE_FORMAT_4 - 'Y-m-d')
     * @return Date time string (default is DATE_FORMAT_4 - 'Y-m-d')
     */
    public static function getLastDateOfMonth($date) {
        date_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
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
    
    /**
     * Get previous date of a date
     * @param String $date Date value (format: Y-m-d)
     * @return type
     */
    public static function getPreviousDateOfDate($date, $format = DomainConst::DATE_FORMAT_1) {
        date_default_timezone_set(DomainConst::DEFAULT_TIMEZONE);
        return date($format, strtotime('-1 day', strtotime($date)));
    }
    
    /**
     * Get all days in year
     * @param String $year Year value
     * @param Array $aDay List day of week need to get ('Sun','Mon','Tue','Wed','Thu','Fri','Sat')
     * @return Array List of days in year
     */
    public static function getAllDay($year, $aDay = array()) {
        $result = array();
        $begin = new DateTime("{$year}-01-01");
        $end = new DateTime("{$year}-12-31");
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        foreach ($period as $dt) {
            if (in_array($dt->format("D"), $aDay)) {
                $result[] = $dt->format('Y-m-d');
            }
        }
        return $result;
    }
    
    /**
     * Get date period
     * @param Sring $from Date from (format is DATE_FORMAT_4 - 'Y-m-d')
     * @param Sring $to Date to (format is DATE_FORMAT_4 - 'Y-m-d')
     */
    public static function getDatePeriod($from, $to) {
        $begin = new DateTime($from);
        $end = (new DateTime($to))->modify('+1 day');
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        return $period;
    }
    
    /**
     * Convert date to back-end
     * @param String $date Date value as format Y-m-d
     * @return String Date value as dd/mm/yyyy
     */
    public static function convertDateBackEnd($date) {
        return CommonProcess::convertDateTime($date, DomainConst::DATE_FORMAT_DB, DomainConst::DATE_FORMAT_BACK_END);
    }
    
    /**
     * Get list all of week days name
     * @return Array List all of week days name
     */
    public static function getListWeekDayName() {
        return array('CN', 'T2', 'T3', 'T4','T5','T6', 'T7');
    }
    
    /**
     * Get weekday
     * @param Int $idx Index of date
     * @return string Name of weekday
     */
    public static function getWeekDay($idx) {
        $retVal = '';
        if (isset(self::getListWeekDayName()[$idx])) {
            return self::getListWeekDayName()[$idx];
        }
        return $retVal;
    }
    
    /**
     * Check a weekday is a weekend or not
     * @param type $wd
     * @return boolean
     */
    public static function isWeekend($wd) {
        $retVal = false;
        if ($wd == 'CN') {
            return true;
        }
        if (($wd == 'T7') && !Settings::isWorkingOnSaturday()) {
            return true;
        }
        return $retVal;
    }
            
    //-----------------------------------------------------
    // -- Date time process
    //-----------------------------------------------------
    
    /**
     * Get value in array
     * @param Array $array Array of data
     * @param String $key Value of key
     * @param type $defaultValue Default value
     * @return String Value after get from array
     */
    public static function getValue($array, $key, $defaultValue = '') {
        $retVal = $defaultValue;
        if (isset($array[$key])) {
            $retVal = $array[$key];
        }
        return $retVal;
    }
    
    /**
     * Get json value
     * @param Json $json Json object
     * @param String $key Key value
     * @param type $defaultValue Default value
     * @return String Value after get from json
     */
    public static function getValueJson($json, $key, $defaultValue = '') {
        $retVal = $defaultValue;
        if (isset($json->$key)) {
           $retVal = $json->$key;
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
    public static function formatCurrency($price, $maxleft = 2) {
        $number_left = substr(strrchr($price, "."), 1);
        if ($number_left > 0) {
            $res = number_format((double) $price, $maxleft);
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
     * Get current browser
     * @return string Name of browser
     */
    public static function getBrowser() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i'       => 'Internet Explorer',
            '/firefox/i'    => 'Firefox',
            '/safari/i'     => 'Safari',
            '/chrome/i'     => 'Chrome',
            '/edge/i'       => 'Edge',
            '/opera/i'      => 'Opera',
            '/netscape/i'   => 'Netscape',
            '/maxthon/i'    => 'Maxthon',
            '/konqueror/i'  => 'Konqueror',
            '/mobile/i'     => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        return $browser;
    }
    
    /**
     * Get current Operation system
     * @param type $user_agent
     * @return string
     */
    public static function getOS($user_agent = null) {
        if (!isset($user_agent) && isset($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
        }

        // https://stackoverflow.com/questions/18070154/get-operating-system-info-with-php
        $os_array = [
            'windows nt 10' => 'Windows 10',
            'windows nt 6.3' => 'Windows 8.1',
            'windows nt 6.2' => 'Windows 8',
            'windows nt 6.1|windows nt 7.0' => 'Windows 7',
            'windows nt 6.0' => 'Windows Vista',
            'windows nt 5.2' => 'Windows Server 2003/XP x64',
            'windows nt 5.1' => 'Windows XP',
            'windows xp' => 'Windows XP',
            'windows nt 5.0|windows nt5.1|windows 2000' => 'Windows 2000',
            'windows me' => 'Windows ME',
            'windows nt 4.0|winnt4.0' => 'Windows NT',
            'windows ce' => 'Windows CE',
            'windows 98|win98' => 'Windows 98',
            'windows 95|win95' => 'Windows 95',
            'win16' => 'Windows 3.11',
            'mac os x 10.1[^0-9]' => 'Mac OS X Puma',
            'macintosh|mac os x' => 'Mac OS X',
            'mac_powerpc' => 'Mac OS 9',
            'linux' => 'Linux',
            'ubuntu' => 'Linux - Ubuntu',
            'iphone' => 'iPhone',
            'ipod' => 'iPod',
            'ipad' => 'iPad',
            'android' => 'Android',
            'blackberry' => 'BlackBerry',
            'webos' => 'Mobile',
            '(media center pc).([0-9]{1,2}\.[0-9]{1,2})' => 'Windows Media Center',
            '(win)([0-9]{1,2}\.[0-9x]{1,2})' => 'Windows',
            '(win)([0-9]{2})' => 'Windows',
            '(windows)([0-9x]{2})' => 'Windows',
            // Doesn't seem like these are necessary...not totally sure though..
            //'(winnt)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'Windows NT',
            //'(windows nt)(([0-9]{1,2}\.[0-9]{1,2}){0,1})'=>'Windows NT', // fix by bg
            'Win 9x 4.90' => 'Windows ME',
            '(windows)([0-9]{1,2}\.[0-9]{1,2})' => 'Windows',
            'win32' => 'Windows',
            '(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})' => 'Java',
            '(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}' => 'Solaris',
            'dos x86' => 'DOS',
            'Mac OS X' => 'Mac OS X',
            'Mac_PowerPC' => 'Macintosh PowerPC',
            '(mac|Macintosh)' => 'Mac OS',
            '(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}' => 'SunOS',
            '(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}' => 'BeOS',
            '(risc os)([0-9]{1,2}\.[0-9]{1,2})' => 'RISC OS',
            'unix' => 'Unix',
            'os/2' => 'OS/2',
            'freebsd' => 'FreeBSD',
            'openbsd' => 'OpenBSD',
            'netbsd' => 'NetBSD',
            'irix' => 'IRIX',
            'plan9' => 'Plan9',
            'osf' => 'OSF',
            'aix' => 'AIX',
            'GNU Hurd' => 'GNU Hurd',
            '(fedora)' => 'Linux - Fedora',
            '(kubuntu)' => 'Linux - Kubuntu',
            '(ubuntu)' => 'Linux - Ubuntu',
            '(debian)' => 'Linux - Debian',
            '(CentOS)' => 'Linux - CentOS',
            '(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)' => 'Linux - Mandriva',
            '(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)' => 'Linux - SUSE',
            '(Dropline)' => 'Linux - Slackware (Dropline GNOME)',
            '(ASPLinux)' => 'Linux - ASPLinux',
            '(Red Hat)' => 'Linux - Red Hat',
            // Loads of Linux machines will be detected as unix.
            // Actually, all of the linux machines I've checked have the 'X11' in the User Agent.
            //'X11'=>'Unix',
            '(linux)' => 'Linux',
            '(amigaos)([0-9]{1,2}\.[0-9]{1,2})' => 'AmigaOS',
            'amiga-aweb' => 'AmigaOS',
            'amiga' => 'Amiga',
            'AvantGo' => 'PalmOS',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1}-([0-9]{1,2}) i([0-9]{1})86){1}'=>'Linux',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1} i([0-9]{1}86)){1}'=>'Linux',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1})'=>'Linux',
            '[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3})' => 'Linux',
            '(webtv)/([0-9]{1,2}\.[0-9]{1,2})' => 'WebTV',
            'Dreamcast' => 'Dreamcast OS',
            'GetRight' => 'Windows',
            'go!zilla' => 'Windows',
            'gozilla' => 'Windows',
            'gulliver' => 'Windows',
            'ia archiver' => 'Windows',
            'NetPositive' => 'Windows',
            'mass downloader' => 'Windows',
            'microsoft' => 'Windows',
            'offline explorer' => 'Windows',
            'teleport' => 'Windows',
            'web downloader' => 'Windows',
            'webcapture' => 'Windows',
            'webcollage' => 'Windows',
            'webcopier' => 'Windows',
            'webstripper' => 'Windows',
            'webzip' => 'Windows',
            'wget' => 'Windows',
            'Java' => 'Unknown',
            'flashget' => 'Windows',
            // delete next line if the script show not the right OS
            //'(PHP)/([0-9]{1,2}.[0-9]{1,2})'=>'PHP',
            'MS FrontPage' => 'Windows',
            '(msproxy)/([0-9]{1,2}.[0-9]{1,2})' => 'Windows',
            '(msie)([0-9]{1,2}.[0-9]{1,2})' => 'Windows',
            'libwww-perl' => 'Unix',
            'UP.Browser' => 'Windows CE',
            'NetAnts' => 'Windows',
        ];

        // https://github.com/ahmad-sa3d/php-useragent/blob/master/core/user_agent.php
        $arch_regex = '/\b(x86_64|x86-64|Win64|WOW64|x64|ia64|amd64|ppc64|sparc64|IRIX64)\b/ix';
        $arch = preg_match($arch_regex, $user_agent) ? '64' : '32';

        foreach ($os_array as $regex => $value) {
            if (preg_match('{\b(' . $regex . ')\b}i', $user_agent)) {
                return $value . ' x' . $arch;
            }
        }

        return 'Unknown';
    }
    
    /**
     * Get session id
     * @return string Id of session
     */
    public static function getSessionId() {
        return Yii::app()->getSession()->getSessionId();
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