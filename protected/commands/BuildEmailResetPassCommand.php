<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BuildEmailResetPassCommand
 *
 * @author nguyenpt
 */
class BuildEmailResetPassCommand extends CConsoleCommand {
    /**
     * Run command
     * @param type $arg
     */
    public function run($arg) {
        try {
            self::doRun();
        } catch (Exception $ex) {
            CommonProcess::dumpVariable($ex->getMessage());
        }
    }
    
    /**
     * Run command
     */
    public static function doRun() {
        Loggers::info(__METHOD__, __LINE__, get_class());
        // Reset pass
        ScheduleEmail::handleBuildEmailResetPass();
    }
}
