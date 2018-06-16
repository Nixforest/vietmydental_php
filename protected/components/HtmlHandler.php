<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Handle echo html string
 *
 * @author nguyenpt
 */
class HtmlHandler {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Default class of button */
    const CLASS_GROUP_BUTTON                             = "group-btn";
    
    /**
     * Create button
     * @param String $href Link
     * @param String $title Title of button
     * @param String $isNewTab Want to open in new tab?
     * @param String $class Class of button
     * @return String Html string generate button
     */
    public static function createButton($href, $title, $isNewTab = true, $class = self::CLASS_GROUP_BUTTON) {
        $retVal = '';
        $target = '';
        if ($isNewTab) {
            $target = 'target="_blank"';
        }
        $retVal .= '<div class="' . $class . '">';
        $retVal .= '<a ' . $target . ' href="' . $href . '">' . $title . '</a>';
        $retVal .= '</div>';
        return $retVal;
    }
    
    /**
     * Create button with image icon
     * @param String $href Link
     * @param String $title Title of button
     * @param String $image Image path
     * @param String $isNewTab Want to open in new tab?
     * @param String $class Class of button
     * @return String Html string generate button
     */
    public static function createButtonWithImage($href, $title, $image, $isNewTab = false, $class = self::CLASS_GROUP_BUTTON, $tagAId = '') {
        $retVal = '';
        $target = '';
        if ($isNewTab) {
            $target = 'target="_blank"';
        }
        
        $retVal .= '<div class="' . $class . '">';
        $retVal .= '<a ' . $target . ' href="' . $href . '" id="' . $tagAId . '">'
                . '<img src="' . Yii::app()->theme->baseUrl . DomainConst::IMG_BASE_PATH . $image . '"> '
                . '' . $title . '</a>';
        $retVal .= '</div>';
        return $retVal;
    }
    
    public static function createAjaxButtonWithImage($title, $image, $onClick, $style, $class = self::CLASS_GROUP_BUTTON) {
        $retVal = '';
        $retVal .= '<div class="' . $class . '">';
        $retVal .= '<a style="' . $style . '" onclick="' . $onClick . '" href="#">'
                . '<img src="' . Yii::app()->theme->baseUrl . DomainConst::IMG_BASE_PATH . $image . '"> '
                . '' . $title . '</a>';
        $retVal .= '</div>';
        return $retVal;
    }
    
    /**
     * Create table for customer information
     * @param Array $arrCustomer List of customer
     * @return string Html string
     */
    public static function createTableCustomer($arrCustomer, $title = DomainConst::CONTENT00201) {
        $retVal =    '<div class="title-2">' . $title . '</div>';
        $retVal .=   '<div class="scroll-table">';
        $retVal .=       '<table id="customer-info">';
        $retVal .=           '<thead>';
        $retVal .=               '<tr>';
        $retVal .=                   '<th>' . DomainConst::CONTENT00135 . '</th>';
        $retVal .=                   '<th>' . DomainConst::CONTENT00101 . '/' . DomainConst::CONTENT00045 . '</th>';
        $retVal .=                   '<th>' . DomainConst::CONTENT00240 . '</th>';
        $retVal .=                   '<th>' . DomainConst::CONTENT00143 . '</th>';
        $retVal .=               '</tr>';
        $retVal .=           '</thead>';
        $retVal .=           '<tbody>';
        foreach ($arrCustomer as $customer) {
            $retVal .=           '<tr id="' . $customer->id . '" class="customer-info-tr">';
            $retVal .=               '<td>';
            $retVal .=                   $customer->name . '<br>' . $customer->phone . '<br>';
            $retVal .=               '</td>';
            $retVal .=               '<td>';
            $retVal .=                   $customer->getBirthDay()  . '<br>'. $customer->address;
            $retVal .=               '</td>';
            $retVal .=               '<td>';
            $retVal .=                   $customer->getScheduleTime();
            $retVal .=               '</td>';
            $retVal .=               '<td>';
            $retVal .=                   $customer->getScheduleDoctor();
            $retVal .=               '</td>';
            $retVal .=           '</tr>';
        }
        
        $retVal .=           '</tbody>';
        $retVal .=       '</table>';
        $retVal .=  '</div>';
        return $retVal;
    }
}
