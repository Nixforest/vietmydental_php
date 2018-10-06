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
        $this->pageTitle = 'Thử nghiệm các tính năng';
        $arrTabs = array(
            'SQL'       => '_sql',
            'Email'     => '_email',
            'SMS'       => '_email',
            'Other'     => '_email',
        );
        $tabId = isset($_GET['tabId']) ? $_GET['tabId'] : '';
        $result = '';
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
        if (filter_input(INPUT_POST, 'sql_submit_findAll')) {
            Loggers::info('Start sql find all', '', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $result = $this->sql_submit_findAll();
        }
        if (filter_input(INPUT_POST, 'sql_submit_findCondition')) {
            Loggers::info('Start sql find condition', '', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $result = $this->sql_submit_findCondition();
        }
        $this->render('test', array(
            'tabId'                     => $tabId,
            'arrTabs'                   => $arrTabs,
            'result'                    => $result,
            DomainConst::KEY_ACTIONS    => $this->listActionsCanAccess,
        ));
    }
    
    /**
     * sql_submit_findAll
     * @param Array $arrInput Input array
     * @return string Result string
     */
    private function sql_submit_findAll($arrInput = array()) {
        $retVal = '';
        $criteria = new CDbCriteria();
        $models = DailyReports::model()->findAll($criteria);
        if ($models) {
            $retVal = 'Found ' . count($models) . ' records.';
        }
        return $retVal;
    }
    
    /**
     * sql_submit_findCondition
     * @param Array $arrInput Input array
     * @return string Result string
     */
    private function sql_submit_findCondition($arrInput = array()) {
        $retVal = '';
        $criteria = new CDbCriteria();
        $criteria->compare('approve_id', 6);
        $criteria->addInCondition('agent_id', array(1, 2));
//        $criteria->compare('agent_id', 1);
        $criteria->compare('date_report', '2018-08-01');
//        $criteria->limit = 1;
        $criteria->order = 'id desc';
        $models = DailyReports::model()->findAll($criteria);
        if ($models) {
            $retVal['Message'] = 'Found ' . count($models) . ' records.';
            $obj = array();
            foreach ($models as $model) {
                $obj[] = $model->toString();
            }
            $retVal['Object'] = $obj;
        } else {
            $retVal['Message'] = 'Record not found';
            $retVal['Status'] = DailyReports::getArrayStatus()[DailyReports::STATUS_NOT_CREATED_YET];
        }
        return $retVal;
    }
}
