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
        $this->render('test', array(
            'tabId'                     => $tabId,
            'arrTabs'                   => $arrTabs,
            DomainConst::KEY_ACTIONS    => $this->listActionsCanAccess,
        ));
    }

}
