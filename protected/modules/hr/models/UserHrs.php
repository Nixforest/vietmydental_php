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
}
