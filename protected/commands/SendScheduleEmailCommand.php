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
    public function run($arg) {
        try {
            echo "Run send schedule email command success";
            die;
            SendScheduleEmailCommand::doRun();
        } catch (Exception $ex) {
            CommonProcess::dumpVariable($ex->getMessage());
        }
    }
    
    public static function doRun() {
        $countSend = 0;
        ScheduleEmail::sendEmail($countSend, ScheduleEmail::MAIL_NORMAL);
    }
}
