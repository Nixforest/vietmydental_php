<?php

class SendScheduleSmsCommand extends CConsoleCommand {

    public function run($arg) {
        try {
            Loggers::info('Run cron SendScheduleSmsCommand', '', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $mScheduleSms = new ScheduleSms();
            $mScheduleSms->runCronBig();
        } catch (Exception $exc) {
            GasCheck::CatchAllExeptiong($exc);
        }
    }

}
