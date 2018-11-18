<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserHrs
 *
 * @author nguyenpt
 */
class UserHrs extends Users {
    
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    /** Data when calculating in hr module */
    public $data = array();
    
    /**
     * Save data
     * @param String $key   Key
     * @param String $value Value
     */
    public function saveData($key, $value) {
        $this->data[$key] = $value;
        CookieHandler::saveCookie($key, $value);
    }
    
    /**
     * Get data value
     * @param String $key Key
     * @return string Value of data
     */
    public function getDataValue($key) {
        $value = CookieHandler::getCookieValue($key);
        if (empty($value)) {
            $value = isset($this->data[$key]) ? $this->data[$key] : '';
        }
        return $value;
    }

    /**
     * Get base salary
     * @param String $from  Date from value
     * @param String $to    Date to value
     * @return Number       Base salary value
     */
    public function getBaseSalary($from = '', $to = '') {
        return $this->base_salary;
    }
    
    /**
     * Get social insurance salary
     * @param String $from  Date from value
     * @param String $to    Date to value
     * @return Number       Social insurance salary value
     */
    public function getSocialInsuranceSalary($from = '', $to = '') {
        return $this->social_insurance_salary;
    }
    
    /**
     * Get responsible salary salary
     * @param String $from  Date from value
     * @param String $to    Date to value
     * @return Number       Responsible salary value
     */
    public function getResponsibleSalary($from = '', $to = '') {
        return $this->responsible_salary;
    }
    
    /**
     * Get subvention
     * @param String $from  Date from value
     * @param String $to    Date to value
     * @return Number       Subvention value
     */
    public function getSubvention($from = '', $to = '') {
        return $this->subvention;
    }
    
    /**
     * Get revenue of agent
     * @param String $from  Date from value
     * @param String $to    Date to value
     * @return Number       Revenue of agent value
     */
    public function getAgentRevenue($from = '', $to = '') {
        return 0;
    }
    
    /**
     * Get revenue from fan-page customer
     * @param String $from  Date from value
     * @param String $to    Date to value
     * @return Number       Revenue from fan-page customer value
     */
    public function getFanpageRevenue($from = '', $to = '') {
        return 0;
    }
    
    /**
     * Get revenue from customer of user
     * @param String $from  Date from value
     * @param String $to    Date to value
     * @return Number       Revenue from customer of user value
     */
    public function getSelfRevenue($from = '', $to = '') {
        return 0;
    }
    
    /**
     * Get cost of agent
     * @param String $from  Date from value
     * @param String $to    Date to value
     * @return Number       Cost of agent value
     */
    public function getAgentCost($from = '', $to = '') {
        return 0;
    }
    
    /**
     * Get Total of working day number
     * @param String $from  Date from value
     * @param String $to    Date to value
     * @return Number       Total of working day number
     */
    public function getWorkingDayNumber($from = '', $to = '') {
        return 0;
    }
    
    /**
     * Get working record
     * @param String $from  Date from value
     * @param String $to    Date to value
     * @return Number       Number of working record
     */
    public function getWorkingRecord($from = '', $to = '') {
        return 0;
    }
    /**
     * Check if a date is working date (HrWorkSchedules)
     * @param String $date Date value (format is DATE_FORMAT_4 - 'Y-m-d')
     * @return int  0 - Date is not working date (not scheduled)
     *              1 - Date is a working date (scheduled)
     */
    public function isWorkingDate($date) {
        $criteria = new CDbCriteria; 
        $criteria->compare('employee_id', $this->id);
        $criteria->compare('work_day', $date);
        $model = HrWorkSchedules::model()->findAll($criteria);
        $retVal = empty($model) ? 0 : 1;
        return $retVal;
    }

    /**
     * Check if a date is holiday date (HrHolidays)
     * @param String $date Date value (format is DATE_FORMAT_4 - 'Y-m-d')
     * @return int  0 - Date is not holiday date
     *              1 - Date is a holiday date
     */
    public function isHolidayDate($date) {
        $retVal = 0;
        if(HrHolidays::isHoliday($date)){
            $retVal = 1;
        }
        return $retVal;
    }
    
    /**
     * Get working date factor
     * @param type $date
     * @return type
     */
    public function getWorkingDateFactor($date) {
        $workShift = HrWorkSchedules::getWorkShift($this->id, $date);
        if ($workShift != NULL) {
            return $workShift->factor;
        }
        return 1;
    }
    
    /**
     * Make data to normal day
     * @param Number $factor        Factor of working date value
     * @param Number $cellValue     Value of cell
     * @param String $cellText      Text of cell
     */
    public function makeNormalDate($factor, &$cellValue, &$cellText) {
        $arrMapping = HrProcess::getArrayTimeSheetValue();
        if ($factor == $arrMapping[HrProcess::TIMESHEET_UNIT_HALF]) {
            $cellText = HrProcess::TIMESHEET_UNIT_HALF;
        } else if ($factor > $arrMapping[HrProcess::TIMESHEET_UNIT_ONE]) {
            $cellText = HrProcess::TIMESHEET_UNIT_MULTI;
        } else if ($factor == $arrMapping[HrProcess::TIMESHEET_UNIT_ONE]) {
            $cellText = HrProcess::TIMESHEET_UNIT_ONE;
        }
        $cellValue = $factor;
    }
    
    /**
     * Check data to compensatory leave date
     * @param HrHolidays $mHoliday  Holiday model
     * @param Number $factor        Factor of working date value
     * @param Number $cellValue     Value of cell
     * @param String $cellText      Text of cell
     */
    public function checkCompensatoryDate($mHoliday, $factor, &$cellValue, &$cellText) {
        if ($mHoliday->type_id == Settings::getHolidayCompensatoryId()) {
            $compensatoryDate = $mHoliday->compensatory_date;
            // Check user working on holiday
            $status = $this->isWorkingDate($compensatoryDate) . $this->isHolidayDate($compensatoryDate);
            if ($status == '11') {   // User work on holiday
                // So compensatory is normal date
                $this->makeNormalDate($factor, $cellValue, $cellText);
            }
        }
    }
    
    /**
     * Get holiday factor value
     * @param String $date Date value (format is DATE_FORMAT_4 - 'Y-m-d')
     * @return Int Value of factor field if date is a holiday date, 1 otherwise
     */
    public function getHolidayFactor($date) {
        $retVal = 1;
        // Check holiday
        $mHoliday = HrHolidays::getHolidayByDate($date);
        if ($mHoliday !== null) {
            // Date is holiday
            $retVal = $mHoliday->getFactorValue();
        }
        return $retVal;
    }
    
    /**
     * Get Timesheet value total
     * @param String $fromDate  Date from value
     * @param String $toDate    Date to value
     * @return Number       Total value
     */
    public function getTimesheetValueTotal($fromDate, $toDate) {
        $retVal = 0;
        $period         = CommonProcess::getDatePeriod($fromDate, $toDate);
        foreach ($period as $dt) {
            $fullDate   = $dt->format(DomainConst::DATE_FORMAT_DB);
            $value = $this->getDataValue("$this->id" . "_" . "$fullDate");
            if (!empty($value)) {
                $retVal += $value;
            }
        }
        return $retVal;
    }
    
    /**
     * Get Timesheet value to show on gridview
     * @param String $date Date value (format is DATE_FORMAT_4 - 'Y-m-d')
     * @return string Value of cell text
     */
    public function getTimesheetValueCell($date) {
        $cellValue  = '';
        $cellText   = '';
        $this->getTimesheetValue($date, $cellValue, $cellText);
        $this->saveData("$this->id" . "_" . "$date", $cellValue);
        Loggers::info('Cell value of date: ' . $date, $cellValue, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        // Save to return array
        switch ($cellText) {
            case HrProcess::TIMESHEET_UNIT_HOLIDAY:             // Current date is holiday
                if ($cellValue > 1) {
                    $cellText = HrProcess::TIMESHEET_UNIT_ONE . $cellValue;
                } else {
                    $cellText = HrProcess::TIMESHEET_UNIT_ONE;
                }

                break;
            case HrProcess::TIMESHEET_UNIT_MULTI:               // Current date user worked overtime
                if ($cellValue > 1) {
                    $cellText = $cellValue . HrProcess::TIMESHEET_UNIT_ONE;
                } else {
                    $cellText = HrProcess::TIMESHEET_UNIT_ONE;
                }

                break;
        }
        return $cellText;
    }
    
    /**
     * Get timesheet value of user
     * @param String $date Date value (format is DATE_FORMAT_4 - 'Y-m-d')
     * @param String $cellValue Output - Value of timesheet
     * @param String $cellText Output - Value printable of timesheet
     */
    public function getTimesheetValue($date, &$cellValue, &$cellText) {
        $arrayValue = array(
            '000'   => '0',     '001'   => 'X', '002'   => '0',
            '010'   => 'X',     '011'   => 'X', '012'   => 'X',
            '100'   => 'X',     '101'   => 'P', '102'   => '0',
            '110'   => 'Xn',    '111'   => 'P', '112'   => '0',
        );
        // Check if date is working date (user have work shift on date)
        $isWorkingDate  = $this->isWorkingDate($date);
        $isHoliday      = $this->isHolidayDate($date);
        $isLeaveDate    = HrLeaves::isLeaveDay($this->id, $date);
        $workingFactor  = $this->getWorkingDateFactor($date);
        if (isset($arrayValue[$isWorkingDate . $isHoliday . $isLeaveDate])) {
            $cellText  = $arrayValue[$isWorkingDate . $isHoliday . $isLeaveDate];
        }
        $arrMapping = HrProcess::getArrayTimeSheetValue();
        if (isset($arrMapping[$cellText])) {
            $cellValue = $arrMapping[$cellText];
        }
        switch ($cellText) {
            case HrProcess::TIMESHEET_UNIT_ONE:
                if ($isWorkingDate) {
                    $this->makeNormalDate($workingFactor, $cellValue, $cellText);
                } else {
                    $cellValue = 1;
                }
                
                break;
            case HrProcess::TIMESHEET_UNIT_HOLIDAY:
                $cellValue = $workingFactor * $this->getHolidayFactor($date);
                // Check holiday
                $mHoliday = HrHolidays::getHolidayByDate($date);
                if ($mHoliday) {
                    $this->checkCompensatoryDate($mHoliday, $workingFactor, $cellValue, $cellText);
                }
                break;
            default:
                break;
        }
    }
}
