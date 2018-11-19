<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CookieHandler
 *
 * @author nguyenpt
 */
class CookieHandler {

    /**
     * Save cookie
     * @param String $key   Key
     * @param String $value Value
     */
    public static function saveCookie($key, $value) {
        Yii::app()->request->cookies[$key] = new CHttpCookie($key, $value);
    }

    /**
     * Get value of cookie
     * @param String $key   Key
     * @return string Value of cookie
     */
    public static function getCookieValue($key) {
        $retVal = '';
        if (isset(Yii::app()->request->cookies[$key])) {
            $retVal = Yii::app()->request->cookies[$key]->value;
        }
        return $retVal;
    }

}
