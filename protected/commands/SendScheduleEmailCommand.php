<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SendScheduleEmailCommand
 *
 * @author NguyenPT
 */
class SendScheduleEmailCommand extends CConsoleCommand {
    /**
     * Run command
     * @param type $arg
     */
    public function run($arg) {
        try {
            SendScheduleEmailCommand::doRun();
        } catch (Exception $ex) {
            CommonProcess::dumpVariable($ex->getMessage());
        }
    }
    
    /**
     * Run command
     */
    public static function doRun() {
        $countSend = 0;
        // Reset pass
        ScheduleEmail::handleEmailResetPass();
        ScheduleEmail::sendEmail($countSend, ScheduleEmail::MAIL_NORMAL);
    }
}
