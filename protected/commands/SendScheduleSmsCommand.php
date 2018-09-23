<?php

class SendScheduleSmsCommand extends CConsoleCommand {

    public function run($arg) {
        try {
            $mScheduleSms = new ScheduleSms();
            $mScheduleSms->runCronBig();
        } catch (Exception $exc) {
            GasCheck::CatchAllExeptiong($exc);
        }
    }

}
