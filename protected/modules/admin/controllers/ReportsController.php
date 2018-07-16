<?php

class ReportsController extends AdminController
{
	public $layout='//layouts/column1';
        /**
         * Index action.
         */
	public function actionIndex()
	{
		$this->render('index',array(
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}
        /**
         * Revenue action.
         */
	public function actionRevenue()
	{
            $dateFormat = DomainConst::DATE_FORMAT_4;
            $agentId = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : '';
            $mAgent = Agents::model()->findByPk($agentId);
            $from = '';
            $to = '';
            // Get data from url
            $this->validateRevenueUrl($from, $to);
            if (empty($from)) {
                $from = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
            }
            if (empty($to)) {
                $to = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
            }
            $receipts = array();
            $newReceipts = array();
            // Start access db
            if ($mAgent) {
                $receipts = $mAgent->getReceipts($from, $to, array(Receipts::STATUS_RECEIPTIONIST));
                $newReceipts = $mAgent->getReceipts($from, $to, array(Receipts::STATUS_DOCTOR));
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT)) {
                $this->redirect(array('revenue',
                    'from'  => CommonProcess::convertDateTime($_POST['from_date'], DomainConst::DATE_FORMAT_BACK_END, $dateFormat),
                    'to'    => CommonProcess::convertDateTime($_POST['to_date'], DomainConst::DATE_FORMAT_BACK_END, $dateFormat)
                    ));
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_MONTH)) {
                $from = CommonProcess::getFirstDateOfCurrentMonth($dateFormat);
                $this->redirect(array('revenue',
                    'from'  => $from,
                    'to'    => CommonProcess::getLastDateOfMonth($from)
                    ));
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_LAST_MONTH)) {
                $from = CommonProcess::getPreviousMonth($dateFormat);
                $this->redirect(array('revenue',
                    'from'  => CommonProcess::getFirstDateOfMonth($from),
                    'to'    => CommonProcess::getLastDateOfMonth($from)
                    ));
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_TODATE)) {
                $from = CommonProcess::getCurrentDateTime($dateFormat);
                $this->redirect(array('revenue',
                    'from'  => $from,
                    'to'    => $from
                    ));
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_DATE_YESTERDAY)) {
                $from = CommonProcess::getPreviousDateTime($dateFormat);
                $this->redirect(array('revenue',
                    'from'  => $from,
                    'to'    => $from
                    ));
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_DATE_BEFORE_YESTERDAY)) {
                $from = CommonProcess::getDateBeforeYesterdayDateTime($dateFormat);
                $this->redirect(array('revenue',
                    'from'  => $from,
                    'to'    => $from
                    ));
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_EXCEL)) {
                $from = CommonProcess::convertDateTime($_POST['from_date'], DomainConst::DATE_FORMAT_BACK_END, $dateFormat);
                $to = CommonProcess::convertDateTime($_POST['to_date'], DomainConst::DATE_FORMAT_BACK_END, $dateFormat);
                ExcelHandler::summaryReportMoney($mAgent, $from, $to);
            }
            $this->render('revenue', array(
                    'receipts'  => $receipts,
                    'newReceipts'  => $newReceipts,
                    'from'      => $from,
                    'to'        => $to,
                    DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
            ));
	}
        
        /**
         * Validate revenue url
         * @param String $from From
         * @param String $to To
         */
        public function validateRevenueUrl(&$from, &$to) {
            $from = isset($_GET['from']) ? $_GET['from'] : '';
            $to = isset($_GET['to']) ? $_GET['to'] : '';
        }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
        
        public function actionReportMoney() {
            $isExport = false;
            $dateFormat = DomainConst::DATE_FORMAT_4;
            $agentId = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : '';
            $mAgent = Agents::model()->findByPk($agentId);
            $from = '';
            $to = '';
            // Get data from url
            $this->validateRevenueUrl($from, $to);
            if (empty($from)) {
                $from = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
            }
            if (empty($to)) {
                $to = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
            }
            $receipts = array();
            $aMoney = array();

            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT)) {
                $isExport = true;
                $from = CommonProcess::convertDateTime($_POST['from_date'], DomainConst::DATE_FORMAT_BACK_END, $dateFormat);
                $to = CommonProcess::convertDateTime($_POST['to_date'], DomainConst::DATE_FORMAT_BACK_END, $dateFormat);
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_MONTH)) {
                $isExport = true;
                $from = CommonProcess::getFirstDateOfCurrentMonth($dateFormat);
                $to = CommonProcess::getLastDateOfMonth($from);
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_LAST_MONTH)) {
                $isExport = true;
                $from = CommonProcess::getPreviousMonth($dateFormat);
                $from = CommonProcess::getFirstDateOfMonth($from);
                $to = CommonProcess::getLastDateOfMonth($from);
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_TODATE)) {
                $isExport = true;
                $from = CommonProcess::getCurrentDateTime($dateFormat);
                $to = $from;
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_DATE_YESTERDAY)) {
                $isExport = true;
                $from = CommonProcess::getPreviousDateTime($dateFormat);
                $to = $from;
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_DATE_BEFORE_YESTERDAY)) {
                $isExport = true;
                $from = CommonProcess::getDateBeforeYesterdayDateTime($dateFormat);
                $to = $from;
            }
            if ($isExport) {
                // Start access db
                if (!empty($mAgent)) {
                    ExcelHandler::summaryReportMoney($mAgent, $from, $to);
                }
            }

            $this->render('report_money', array(
                'from' => $from,
                'to' => $to,
                DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
            ));
        }
        
        /**
         * report Customer
         */
        public function actionCustomer()
	{
            $dateFormat = DomainConst::DATE_FORMAT_4;
            $agentId = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : '';
            $mAgent = Agents::model()->findByPk($agentId);
            $from = '';
            $to = '';
            $old = null;
            $new = null;
            // Get data from url
            $this->validateRevenueUrl($from, $to);
            if (empty($from)) {
                $from = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
            }
            if (empty($to)) {
                $to = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
            }
            // Start access db
            if ($mAgent) {
                $data = $mAgent->getCustomers($from, $to);
                $old = !empty($data['OLD']) ? $data['OLD'] : null;
                $new = !empty($data['NEW']) ? $data['NEW'] : null;
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT)) {
                $this->redirect(array('customer',
                    'from'  => CommonProcess::convertDateTime($_POST['from_date'], DomainConst::DATE_FORMAT_BACK_END, $dateFormat),
                    'to'    => CommonProcess::convertDateTime($_POST['to_date'], DomainConst::DATE_FORMAT_BACK_END, $dateFormat)
                    ));
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_MONTH)) {
                $from = CommonProcess::getFirstDateOfCurrentMonth($dateFormat);
                $this->redirect(array('customer',
                    'from'  => $from,
                    'to'    => CommonProcess::getLastDateOfMonth($from)
                    ));
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_LAST_MONTH)) {
                $from = CommonProcess::getPreviousMonth($dateFormat);
                $this->redirect(array('customer',
                    'from'  => CommonProcess::getFirstDateOfMonth($from),
                    'to'    => CommonProcess::getLastDateOfMonth($from)
                    ));
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_TODATE)) {
                $from = CommonProcess::getCurrentDateTime($dateFormat);
                $this->redirect(array('customer',
                    'from'  => $from,
                    'to'    => $from
                    ));
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_DATE_YESTERDAY)) {
                $from = CommonProcess::getPreviousDateTime($dateFormat);
                $this->redirect(array('customer',
                    'from'  => $from,
                    'to'    => $from
                    ));
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_DATE_BEFORE_YESTERDAY)) {
                $from = CommonProcess::getDateBeforeYesterdayDateTime($dateFormat);
                $this->redirect(array('customer',
                    'from'  => $from,
                    'to'    => $from
                    ));
            }
            if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_EXCEL)) {
                $from = CommonProcess::convertDateTime($_POST['from_date'], DomainConst::DATE_FORMAT_BACK_END, $dateFormat);
                $to = CommonProcess::convertDateTime($_POST['to_date'], DomainConst::DATE_FORMAT_BACK_END, $dateFormat);
                ExcelHandler::summaryReportMoney($mAgent, $from, $to);
            }
            $this->render('customers', array(
                    'old'  => $old,
                    'new'  => $new,
                    'from'      => $from,
                    'to'        => $to,
                    DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
            ));
	}

}