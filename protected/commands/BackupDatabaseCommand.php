<?php

//include_once '../config/info.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BackupDatabaseCommand
 *
 * @author namnh
 */
class BackupDatabaseCommand extends CConsoleCommand {
    public function run($arg) {
        try {
            BackupDatabaseCommand::doRun();
        } catch (Exception $ex) {
            CommonProcess::dumpVariable($ex->getMessage());
        }
    }
    
    /**
     * Run command
     */
    public static function doRun() {
        Loggers::info('Run backup: ', 'Start', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        shell_exec('sh /var/www/nkvietmy.com/web/protected/commands/shell/ispc3backup_vietmy.sh &> /dev/null');
        Loggers::info('Run backup: ', 'End', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
    }
}
