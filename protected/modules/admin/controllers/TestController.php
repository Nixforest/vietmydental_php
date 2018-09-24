<?php

class TestController extends AdminController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * Displays a particular model.
     */
    public function actionTest() {
        $arrTabs = array(
            'Email',
            'SMS',
            'Other',
        );
        $tabId = isset($_GET['tabId']) ? $_GET['tabId'] : '';
        if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT)) {
            Loggers::info('Start submit', '', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            EmailHandler::sendManual('Subject', 'Body', 'nixforest@live.com');
        }
        if (filter_input(INPUT_POST, 'submit_email')) {
            Loggers::info('Start submit email', '', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            EmailHandler::sendMail1();
        }
        if (filter_input(INPUT_POST, 'submit_email_pa')) {
            Loggers::info('Start submit email PA', '', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            EmailHandler::sendMailByGmail();
        }
        if (filter_input(INPUT_POST, 'submit_test_fsocket')) {
            $fp = fsockopen('localhost', 25, $errno, $errstr, 10);
            if (!$fp) {
                print_r("$errstr ($errno)\n");
            } else {
                $out = "QUIT\r\n";
                fwrite($fp, $out);
                while (!feof($fp)) {
                    print_r(fgets($fp, 128));
                }
                fclose($fp);
            }
        }
        if (filter_input(INPUT_POST, 'submit_send_grid')) {
            Loggers::info('Start send grid', '', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            EmailHandler::sendEmailOnce('nixforest21991920@gmail.com', 'info@nhakhoavietmy.com', 'Chủ đề email', 'Nội dung email');
        }
        $this->render('test', array(
            'tabId'                     => $tabId,
            'arrTabs'                   => $arrTabs,
            DomainConst::KEY_ACTIONS    => $this->listActionsCanAccess,
        ));
    }

}
