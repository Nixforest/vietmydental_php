<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HrProcess
 *
 * @author nguyenpt
 */
class HrProcess {
    /**
     * Get number of working days
     * @param String $from Date from
     * @param String $to Date to
     * @return int Number of working days
     */
    public static function getNumWorkingDays($from, $to) {
        $retVal = 0;
        $begin = new DateTime($from);
        $end   = (new DateTime($to))->modify('+1 day');
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        foreach ($period as $dt) {
            if (true) {
                $retVal += 1;
            }
        }
        return $retVal;
    }
    
    /**
     * Get number of working days of month
     * @param Int $month Month value
     * @return int Number of working days
     */
    public static function getNumberWorkingDaysOfMonth($date) {
        $retVal = 0;
        $retVal = self::getNumWorkingDays(
                CommonProcess::getFirstDateOfMonth($date),
                CommonProcess::getLastDateOfMonth($date));
        return $retVal;
    }
}
