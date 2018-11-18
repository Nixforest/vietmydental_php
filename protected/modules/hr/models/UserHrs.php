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
        Loggers::info('Date', $date, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
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
}
