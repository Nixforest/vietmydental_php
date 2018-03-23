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
}
