<?php

class CustomerController extends Controller {
    /**
     * Handle receiving patient in agent.
     */
    public function actionView($code) {
        $referCode = ReferCodes::model()->findByAttributes(array(
            'code' => $code,
        ));
        if ($referCode) {
            $customer = $referCode->rCustomer;
        } else {
            $customer = Customers::model()->findByPk($code);
            if (!$customer) {
                $customer = new Customers();
            }
        }
        $scheduleId = $customer->getSchedule(false);
        if (!empty($scheduleId)) {
            $schedule = TreatmentScheduleDetails::model()->findByPk($scheduleId);
        } else {
            $schedule = new TreatmentScheduleDetails();
        }
        
        $arrTreatmentSchedule = $customer->getListTreatmentSchedule();
        
        $this->render('view', array(
            'model' => $customer,
            'schedule' => $schedule,
            'treatment' => $arrTreatmentSchedule,
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