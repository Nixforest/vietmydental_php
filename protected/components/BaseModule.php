<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * This class contain base method for all modules
 *
 * @author nguyenpt
 */
class BaseModule extends CWebModule {
    /**
     * Create addition menu item
     * @param String $module        Name of module
     * @param String $controller    Name of controller
     * @param String $action        Name of action
     * @param Array $param          List parameters
     * @return Array Menu item
     */
    public static function createAdditionMenuItem($module, $controller, $action, $param = array()) {
        return array(
            'label'     => ControllersActions::getActionNameByController($controller, $action, $module),
            'url'       => Yii::app()->createAbsoluteUrl("$module/$controller/$action", $param),
            'visible'   => Controller::isAllowAccess(Controllers::getByName($controller, $module)->id, $action),
        );
    }
}
