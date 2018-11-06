<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HrModule
 *
 * @author nguyenpt
 */
class HrModule extends BaseModule {
    /** User class name */
    const USER_CLASS_NAME           = 'UserHrs';

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'hr.models.*',
            'hr.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            $listMenu = array();
            $listMenu[] = self::createAdditionMenuItem($controller->module, 'hrHolidays', 'index');
            $listMenu[] = self::createAdditionMenuItem($controller->module, 'hrWorkPlans', 'viewAll');
            $listMenu[] = self::createAdditionMenuItem($controller->module, 'hrLeaves', 'index');
            $listMenu[] = self::createAdditionMenuItem($controller->module, 'hrParameters', 'index');
            $listMenu[] = self::createAdditionMenuItem($controller->module, 'hrCoefficients', 'index');
            $listMenu[] = self::createAdditionMenuItem($controller->module, 'hrFunctions', 'indexSetup');
            $listMenu[] = self::createAdditionMenuItem($controller->module, 'hrFunctions', 'createSetup');
            $listMenu[] = self::createAdditionMenuItem($controller->module, 'hrSalaryReports', 'index');
            
            $controller->moduleMenus[DomainConst::CONTENT00559] = $listMenu;
            return true;
        } else {
            return false;
        }
    }

}
