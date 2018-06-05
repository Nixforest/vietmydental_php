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
    public static function createButton($href, $title, $isNewTab = false, $class = self::CLASS_GROUP_BUTTON) {
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
    
    public static function createButtonWithImage($href, $title, $image, $isNewTab = false, $class = self::CLASS_GROUP_BUTTON) {
        $retVal = '';
        $target = '';
        if ($isNewTab) {
            $target = 'target="_blank"';
        }
        
        $retVal .= '<div class="' . $class . '">';
        $retVal .= '<a ' . $target . ' href="' . $href . '">'
                . '<img src="' . Yii::app()->theme->baseUrl . $image . '">'
                . '' . $title . '</a>';
        $retVal .= '</div>';
        return $retVal;
    }
}
