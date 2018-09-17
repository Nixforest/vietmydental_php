<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminMenuManager
 *
 * @author NguyenPT
 */
class AdminMenuManager {
    
    /**
     * Check if a menu has child
     * @param Int $id       id of menu
     * @param type $arrObj
     * @return int
     */
    public function hasChild($id, $arrObj) {
        $session = Yii::app()->session;
        foreach ($arrObj as $obj) {
            if ($obj->parent_id == $id) {
                if ($obj->link == '#') {
                    continue;
                }
//                $aLinks = explode('/', $obj->link);
//                $c = '';
//                $a = '';
//                if (count($aLinks) == 2) {
//                    $c = $aLinks[1];
//                    $a = 'index';
//                } else if (count($aLinks) > 2) {
//                    $c = $aLinks[1];
//                    $a = ucfirst($aLinks[2]);
//                }
                $c = isset($obj->rController) ? $obj->rController->name : '';
                $a = $obj->action;
                if ($session[DomainConst::KEY_ALLOW_SESSION_MENU]) {
                    if (!isset($session[DomainConst::KEY_MENU_CONTROLLER_ACTION])) {   // If not exist => create
                        $session[DomainConst::KEY_MENU_CONTROLLER_ACTION] = array();
                    }
                    $sessionTemp = $session[DomainConst::KEY_MENU_CONTROLLER_ACTION];
                    if (!isset($sessionTemp[$c])) {
                        $sessionTemp[$c] = ActionsUsers::getActionArrAllowForCurrentUserByControllerName($c);
                        $session[DomainConst::KEY_MENU_CONTROLLER_ACTION] = $sessionTemp;
                    }
                    $aActionAllowed = $session[DomainConst::KEY_MENU_CONTROLLER_ACTION][$c];
                } else {
                    $aActionAllowed = ActionsUsers::getActionArrAllowForCurrentUserByControllerName($c);
                }
                if (in_array($a, $aActionAllowed)) {
                    return 1;
                }
            }
        } // end foreach($arrObj as $object)
        return 0;
    }
    
    /**
     * Create main menu array
     * @return string Menu array in html form
     */
    public function createMenu() {
        Loggers::info('Start create Admin menu', '', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $retVal = '';
        $session = Yii::app()->session;
        // If session was saved menu string, just return it
        if (isset($session[DomainConst::KEY_STRING_MENU]) && $session[DomainConst::KEY_STRING_MENU] != '') {
            return $session[DomainConst::KEY_STRING_MENU];
        }
        // Check if user is logged in
        if (Yii::app()->session[DomainConst::KEY_LOGGED_USER] != NULL && !is_null(Yii::app()->user->id)) {
            $menusTemp = Menus::model()->findAll(
                array(
                    'condition' => 'show_in_menu = "1"',
                    'order'     => 'display_order asc'
                )
            );
            $session[DomainConst::KEY_ALLOW_SESSION_MENU] = 1;
            $menus = array();
            // Loop for all menu items
            foreach ($menusTemp as $menuTemp) {
                if ($menuTemp->link == '#') {           // Parent menu
                    $menus[] = $menuTemp;
                    continue;
                }
                if ($menuTemp->rModule->name == 'front') {  // Front end
                    continue;
                }
                $c = isset($menuTemp->rController) ? $menuTemp->rController->name : '';
                $a = $menuTemp->action;
                $module = isset($menuTemp->rModule) ? $menuTemp->rModule->name : '';
                Loggers::info('Module/Controller/Action', $module . '/' . $c . '/' . $a, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
                // If allow menu session
                if ($session[DomainConst::KEY_ALLOW_SESSION_MENU]) {
                    // If not exist => create
                    if (!isset($session[DomainConst::KEY_MENU_CONTROLLER_ACTION])) {
                        $session[DomainConst::KEY_MENU_CONTROLLER_ACTION] = array();
                    }
                    // Save current value
                    $sessionTemp = $session[DomainConst::KEY_MENU_CONTROLLER_ACTION];
                    if (!isset($sessionTemp[$c])) {
                        // Get list all actions of current controller data from db
                        $sessionTemp[$c] = ActionsUsers::getActionArrAllowForCurrentUserByControllerName($c, $module);
                        $session[DomainConst::KEY_MENU_CONTROLLER_ACTION] = $sessionTemp;
                    }
                    $aActionAllowed = $session[DomainConst::KEY_MENU_CONTROLLER_ACTION][$c];
                } else {
                    // Reset action
                    $session[DomainConst::KEY_MENU_CONTROLLER_ACTION] = array();
                    $aActionAllowed = ActionsUsers::getActionArrAllowForCurrentUserByControllerName($c, $module);
                }
                // Check if current action is allowed
                if (in_array($a, $aActionAllowed)) {
                    // Append value to $menus
                    $menus[] = $menuTemp;
                }
            }
            
            foreach ($menus as $menuItem) {
                // If current item is subitem => ignore
                if ($menuItem->parent_id != '') {
                    continue;
                }
                // Menu have subitem
                if ($menuItem->link == '#') {
                    if ($this->hasChild($menuItem->id, $menus) == 1) {                    
                        $retVal .= '<div class="dropdownX">';
                        $retVal .=      '<button class="dropbtnX">';
                        $retVal .=          $menuItem->name;                    
                        $retVal .=      '</button>';
                        $retVal .=      '<div class="dropdown-contentX">';
                        foreach ($menus as $subItem) {
                            // This is a subitem
                            if ($subItem->parent_id == $menuItem->id) {
//                                $retVal .= AdminMenuManager::createMenuItem($subItem->name, $subItem->link);
                                $retVal .= AdminMenuManager::createMenuItem($subItem->name, $subItem->getLink());
                            }
                        }
                        $retVal .=      '</div>';    // Close <div class="dropdown-contentX">
                        $retVal .= '</div>';        // Close <div class="dropdownX">
                    }
                } else {    // Just menu item, have not subitem
//                    $retVal .= AdminMenuManager::createMenuItem($menuItem->name, $menuItem->link);
                    $retVal .= AdminMenuManager::createMenuItem($menuItem->name, $menuItem->getLink());
                }
            }
            if ($session[DomainConst::KEY_ALLOW_SESSION_MENU]) {
                if (!isset($session[DomainConst::KEY_STRING_MENU])) {
                    $session[DomainConst::KEY_STRING_MENU] = $retVal;
                }
            } else {
                $session[DomainConst::KEY_STRING_MENU] = '';
            }
            if (Yii::app()->user->id) {
//                if (isset(Yii::app()->user->application_id) && Yii::app()->user->application_id == 1) {
//                    return $this->_menu;
//                } else {
//                    return '';
//                }
                return $retVal;
            } else {
                return '';
            }
        }
        return '';
    }
    
    /**
     * Create a menu item by write an [a] tag
     * @param type $label
     * @param type $link
     * @return string
     */
    public static function createMenuItem($label, $link) {
        $retVal = '';
        $retVal .= "<a href='" . Yii::app()->createAbsoluteUrl($link) . "'>" . $label . "</a>";
        return $retVal;
    }
    
    public static function createFrontEndMenuItem($label, $link, $icon) {
        $aTitle = explode('/', $label);
        $retVal = '';
        $retVal .= "<a href='" . Yii::app()->createAbsoluteUrl($link) . "'></a>";
        $retVal .= "<span class='" . $icon . "'></span>";
        $retVal .= "<div class='info-menu'>";
        $retVal .= "<h4>" . $aTitle[0] . "</h4>";
        $retVal .= "<p>" . $aTitle[1] . "</p>";
        $retVal .= "</div>";
        return $retVal;
    }
    
    /**
     * Create main menu array for front end
     * @return string Menu array in html form
     */
    public function createFrontEndMenu() {
        $retVal = '';
        $session = Yii::app()->session;
        // If session was saved menu string, just return it
        if (isset($session[DomainConst::KEY_FE_STRING_MENU]) && $session[DomainConst::KEY_FE_STRING_MENU] != '') {
            return $session[DomainConst::KEY_FE_STRING_MENU];
        }
        // Check if user is logged in
        if (Yii::app()->session[DomainConst::KEY_LOGGED_USER] != NULL && !is_null(Yii::app()->user->id)) {
            $menusTemp = Menus::model()->findAll(
                array(
                    'condition' => 'show_in_menu = "1"',
                    'order'     => 'display_order asc'
                )
            );
            
            $session[DomainConst::KEY_FE_ALLOW_SESSION_MENU] = 1;
            $menus = array();
            foreach ($menusTemp as $menuTemp) {
                if ($menuTemp->rModule->name != 'front') {
                    continue;
                }
                
                $c = isset($menuTemp->rController) ? $menuTemp->rController->name : '';
                $a = $menuTemp->action;
                // If allow menu session
                if ($session[DomainConst::KEY_FE_ALLOW_SESSION_MENU]) {
                    // If not exist => create
                    if (!isset($session[DomainConst::KEY_FE_MENU_CONTROLLER_ACTION])) {
                        $session[DomainConst::KEY_FE_MENU_CONTROLLER_ACTION] = array();
                    }
                    // Save current value
                    $sessionTemp = $session[DomainConst::KEY_FE_MENU_CONTROLLER_ACTION];
                    if (!isset($sessionTemp[$c])) {
                        // Get list all actions of current controller data from db
                        $sessionTemp[$c] = ActionsUsers::getActionArrAllowForCurrentUserByControllerName($c, 'front');
                        $session[DomainConst::KEY_FE_MENU_CONTROLLER_ACTION] = $sessionTemp;
                    }
                    $aActionAllowed = $session[DomainConst::KEY_FE_MENU_CONTROLLER_ACTION][$c];
                } else {
                    // Reset action
                    $session[DomainConst::KEY_FE_MENU_CONTROLLER_ACTION] = array();
                    $aActionAllowed = ActionsUsers::getActionArrAllowForCurrentUserByControllerName($c, 'front');
                }
                // Check if current action is allowed
                if (in_array($a, $aActionAllowed)) {
                    // Append value to $menus
                    $menus[] = $menuTemp;
                }
            }
            
            foreach ($menus as $menuItem) {
                // If current item is subitem => ignore
                if ($menuItem->parent_id != '') {
                    continue;
                }
                // Menu have subitem
                if ($menuItem->link == '#') {
                } else {    // Just menu item, have not subitem    
                    $retVal .= '<div class="item-menu">';
                    $retVal .= AdminMenuManager::createFrontEndMenuItem($menuItem->name, $menuItem->getLink(), $menuItem->link);
                    $retVal .= '</div>';        // Close <div class="item-menu">
                }
            }
            if ($session[DomainConst::KEY_FE_ALLOW_SESSION_MENU]) {
                if (!isset($session[DomainConst::KEY_FE_STRING_MENU])) {
                    $session[DomainConst::KEY_FE_STRING_MENU] = $retVal;
                }
            } else {
                $session[DomainConst::KEY_FE_STRING_MENU] = '';
            }
            if (Yii::app()->user->id) {
//                if (isset(Yii::app()->user->application_id) && Yii::app()->user->application_id == 1) {
//                    return $this->_menu;
//                } else {
//                    return '';
//                }
                return $retVal;
            } else {
                return '';
            }
        }
        return '';
    }
}