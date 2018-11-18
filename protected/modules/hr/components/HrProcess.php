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
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Zero */
    const TIMESHEET_UNIT_ZERO           = '0';
    /** Half */
    const TIMESHEET_UNIT_HALF           = '/';
    /** One */
    const TIMESHEET_UNIT_ONE            = 'X';
    /** Off */
    const TIMESHEET_UNIT_OFF            = 'P';
    /** Xn */
    const TIMESHEET_UNIT_HOLIDAY        = 'Xn';
    /** nX */
    const TIMESHEET_UNIT_MULTI          = 'nX';
    
    /**
     * Get array timesheet values
     * @return Array Timesheet values
     */
    public static function getArrayTimeSheetValue() {
        return array(
            self::TIMESHEET_UNIT_HALF       => '0.5',
            self::TIMESHEET_UNIT_ONE        => '1',
            self::TIMESHEET_UNIT_OFF        => '1',
            self::TIMESHEET_UNIT_HOLIDAY    => 'Xn',
            self::TIMESHEET_UNIT_ZERO       => '0',
        );
    }
    /**
     * Get array timesheet map keys
     * @return Array Timesheet map keys
     */
    public static function getArrayMapKey() {
        return array(
            self::TIMESHEET_UNIT_HALF,
            self::TIMESHEET_UNIT_ONE,
            self::TIMESHEET_UNIT_OFF,
            self::TIMESHEET_UNIT_HOLIDAY,
        );
                
    }
    
    /**
     * Get number of working days
     * @param String $from Date from
     * @param String $to Date to
     * @return int Number of working days
     */
    public static function getNumWorkingDays($from, $to) {
        $retVal     = 0;
        $begin      = new DateTime($from);
        $end        = (new DateTime($to))->modify('+1 day');
        $interval   = DateInterval::createFromDateString('1 day');
        $period     = new DatePeriod($begin, $interval, $end);
        // Loop for all date between range - Only count the day is not Sunday
        foreach ($period as $dt) {
            if ($dt->format('w') != 0) {
                $retVal += 1;
            }
        }
        return $retVal;
    }
    
    /**
     * Get number of working days of month
     * @param String $date Date value
     * @return int Number of working days
     */
    public static function getNumberWorkingDaysOfMonth($date) {
        $retVal = self::getNumWorkingDays(
                CommonProcess::getFirstDateOfMonth($date),
                CommonProcess::getLastDateOfMonth($date));
        return $retVal;
    }
}
