<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DateTime
 *
 * @author nguyenpt
 */
class DateTimeExt extends DateTime {
    /**
     * Check a string (date time string) is today
     * @param String $date Date time string
     * @param String $format Date time format
     * @return True if date time string have:
     *          - Day value is equal today's day value
     *          - Month value is equal today's month value
     *          - Year value is equal today's year value
     *         False otherwise
     */
    public static function isToday($date, $format) {
        $todayFormat = DomainConst::DATE_FORMAT_3;
        $today = CommonProcess::getCurrentDateTime($todayFormat);
        $currentM = CommonProcess::convertDateTime(
                $today, $todayFormat, 'm');
        $currentD = CommonProcess::convertDateTime(
                $today, $todayFormat, 'd');
        $currentY = CommonProcess::convertDateTime(
                $today, $todayFormat, 'y');
        
        $retVal = (($currentM === CommonProcess::convertDateTime($date, $format, 'm'))
                    && ($currentD === CommonProcess::convertDateTime($date, $format, 'd'))
                    && ($currentY === CommonProcess::convertDateTime($date, $format, 'y')));
        return $retVal;
    }
    
    /**
     * Check a string (date time string) is today
     * @param String $date Date time string
     * @param String $format Date time format
     * @return True if date time string have:
     *          - Day value is equal today's day value
     *          - Month value is equal today's month value
     *         False otherwise
     */
    public static function isBirthday($date, $format) {
        $todayFormat = DomainConst::DATE_FORMAT_3;
        $today = CommonProcess::getCurrentDateTime($todayFormat);
        $currentM = CommonProcess::convertDateTime(
                $today, $todayFormat, 'm');
        $currentD = CommonProcess::convertDateTime(
                $today, $todayFormat, 'd');
        
        $retVal = (($currentM === CommonProcess::convertDateTime($date, $format, 'm'))
                    && ($currentD === CommonProcess::convertDateTime($date, $format, 'd')));
        return $retVal;
    }
    
    /**
     * Get year by date
     * @param String $date Date string
     * @param Array $needMore $needMore['format']: can be: m, d...
     * @return type
     */
    public static function getYearByDate($date, $needMore = array()) {
        $dateObj = new DateTime($date);
        if (isset($needMore['format'])) {
            return $dateObj->format($needMore['format']);
        }
        return $dateObj->format('Y');
    }
    
    /**
     * Compare 2 date value
     * @param String $date1 Date value 1
     * @param String $date2 Date value 2
     * @param String $format Format date
     * @return True if 
     */
    public static function compare($date1, $date2, $format = "") {
        return strtotime($date1) > strtotime($date2) ? '1' : (strtotime($date1) == strtotime($date2) ? '0' : '-1');
    }
    
    /**
     * Check if a date value from database (mysql) is null
     * @param String $date Date value
     * @return True if date is '0000-00-00', False otherwise
     */
    public static function isDateNull($date) {
        return (!isset($date) || $date == DomainConst::DATE_DEFAULT_NULL || $date == DomainConst::DATE_DEFAULT_NULL_FULL);
    }
    
    /**
     * Check if a year value from database (mysql) is null
     * @param String $year Year value
     * @return True if year is '0000', False otherwise
     */
    public static function isYearNull($year) {
        return (!isset($year) || $year == DomainConst::DATE_DEFAULT_YEAR_NULL);
    }
}
