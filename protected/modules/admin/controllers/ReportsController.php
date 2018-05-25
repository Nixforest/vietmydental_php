<?php

class ReportsController extends AdminController
{
	public $layout='//layouts/column2';
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
            $agentId = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : '';
            $mAgent = Agents::model()->findByPk($agentId);
            $receipts = array();
            if ($mAgent) {
                $receipts = $mAgent->getReceipts();
            }
		$this->render('revenue', array(
                        'receipts' => $receipts,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
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
}