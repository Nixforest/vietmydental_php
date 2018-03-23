<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestCommand
 *
 * @author nguyenpt
 */
class TestCommand extends CConsoleCommand {
    public function run($arg) {
        try {
           // print_r(stream_get_transports());
//            print_r(openssl_get_cert_locations ());
            TestCommand::doRun();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public static function doRun() {
        // Test send email
        EmailHandler::sendManual('Subject', 'Body', 'nixforest@live.com');
//        $controller = new Controller();
//        $controller->mailsend('nixforest@live.com', 'nguyenpt@spj.vn', 'NguyenPT', 'Subject', 'Bory');
//        EmailHandler::mailsend('nixforest@live.com', 'nguyenpt@spj.vn', 'NguyenPT', 'Subject', 'Bory');
    }
}
