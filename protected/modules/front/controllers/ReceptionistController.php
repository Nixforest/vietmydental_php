<?php

class ReceptionistController extends Controller {
    /**
     * Handle receiving patient in agent.
     */
    public function actionReceivingPatient() {
        $this->render('receivingPatient', array(
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Handle receiving patient by phone.
     */
    public function actionReceivingPatientPhone() {
        $this->render('receivingPatientPhone', array(
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Handle create customer.
     */
    public function actionCreateCustomer() {
        $customer = new Customers();
        $medicalRecord = new MedicalRecords();
        if (isset($_POST['Customers'], $_POST['MedicalRecords'])) {
            $customer->attributes = $_POST['Customers'];
            $medicalRecord->attributes = $_POST['MedicalRecords'];
            // Try save customer
            if ($customer->save()) {
                // Save agent id
                OneMany::insertOne(
                        Yii::app()->user->agent_id,
                        $customer->id, OneMany::TYPE_AGENT_CUSTOMER);
                // Save success -> start create medical record
                $medicalRecord->customer_id = $customer->id;
                
                // Try to save medical record
                if ($medicalRecord->save()) {
                    echo CJavaScript::jsonEncode(array(
                        DomainConst::KEY_STATUS => 'success',
                        'div' => DomainConst::CONTENT00180,
                        'rightContent'  => $customer->getCustomerAjaxInfo(),
                        'infoSchedule' => $customer->getCustomerAjaxScheduleInfo(),
                    ));
                    exit;
                } else {
                    $customer->delete();
                }
            } else {
                CommonProcess::dumpVariable($customer->getErrors());
            }
        }
        echo CJSON::encode(array(
            DomainConst::KEY_STATUS => 'failure',
            'div' => $this->renderPartial('_form_create_customer',
                    array(
                        'customer' => $customer,
                        'medicalRecord' => $medicalRecord,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                    ),
                    true)
        ));
        exit;
    }
    
    public function actionCreateScheduleExt() {
        // Test commit
        $schedule = new TreatmentSchedules();
        $detail = new TreatmentScheduleDetails();
        // Temp value saved at Customers::getCustomerAjaxInfo()
        $recordId = Settings::getAjaxTempValue();
        $schedule->record_id = $recordId;
        $mMedicalRecord = MedicalRecords::model()->findByPk($recordId);
        if (isset($_POST['TreatmentSchedules'], $_POST['TreatmentScheduleDetails']) && $mMedicalRecord) {
            $schedule->attributes = $_POST['TreatmentSchedules'];
            $detail->attributes = $_POST['TreatmentScheduleDetails'];
            
            // Set status for schedule
            $schedule->status = TreatmentSchedules::STATUS_SCHEDULE;
            
            // Try to save Schedule
            if ($schedule->save()) {
                // Save detail field
                $detail->schedule_id = $schedule->id;
                $detail->start_date = $schedule->start_date;
                $detail->end_date   = $schedule->end_date;
                // Save success, start create detail
                if ($detail->save()) {
                    $rightContent = '';
                    $infoSchedule = '';
                    if (isset($mMedicalRecord->rCustomer)) {
                        $rightContent = $mMedicalRecord->rCustomer->getCustomerAjaxInfo();
                        $infoSchedule = $mMedicalRecord->rCustomer->getCustomerAjaxScheduleInfo();
                    }
//                    echo CJavaScript::jsonEncode(array(
//                        DomainConst::KEY_STATUS => 'success',
//                        'div' => DomainConst::CONTENT00205,
//                        'rightContent'  => $rightContent,
//                        'infoSchedule' => $infoSchedule,
//                    ));
//                    exit;
                } else {
                    $schedule->delete();
                    CommonProcess::dumpVariable($detail->getErrors());
                }
            } else {
                CommonProcess::dumpVariable($schedule->getErrors());
            }
        }
        $this->render('_form_create_schedule', array(
            
                        'schedule' => $schedule,
                        'detail' => $detail,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }


    /**
     * Handle create schedule
     */
    public function actionCreateSchedule() {
        $schedule = new TreatmentSchedules();
        $detail = new TreatmentScheduleDetails();
        // Temp value saved at Customers::getCustomerAjaxInfo()
        $recordId = Settings::getAjaxTempValue();
        $schedule->record_id = $recordId;
        $mMedicalRecord = MedicalRecords::model()->findByPk($recordId);
        if (isset($_POST['TreatmentSchedules'], $_POST['TreatmentScheduleDetails']) && $mMedicalRecord) {
            $schedule->attributes = $_POST['TreatmentSchedules'];
            $detail->attributes = $_POST['TreatmentScheduleDetails'];
            
            // Set status for schedule
            $schedule->status = TreatmentSchedules::STATUS_SCHEDULE;
            
            // Try to save Schedule
            if ($schedule->save()) {
                // Save detail field
                $detail->schedule_id    = $schedule->id;
                $detail->time_id        = $schedule->time_id;
                $detail->start_date     = $schedule->start_date;
                $detail->end_date       = $schedule->end_date;
                $detail->status         = TreatmentScheduleDetails::STATUS_SCHEDULE;
                // Save success, start create detail
                if ($detail->save()) {
                    $rightContent = '';
                    $infoSchedule = '';
                    if (isset($mMedicalRecord->rCustomer)) {
                        $rightContent = $mMedicalRecord->rCustomer->getCustomerAjaxInfo();
                        $infoSchedule = $mMedicalRecord->rCustomer->getCustomerAjaxScheduleInfo();
                    }
                    echo CJavaScript::jsonEncode(array(
                        DomainConst::KEY_STATUS => 'success',
                        'div' => DomainConst::CONTENT00205,
                        'rightContent'  => $rightContent,
                        'infoSchedule' => $infoSchedule,
                    ));
                    exit;
                } else {
                    $schedule->delete();
                    CommonProcess::dumpVariable($detail->getErrors());
                }
            } else {
                CommonProcess::dumpVariable($schedule->getErrors());
            }
        }
        echo CJSON::encode(array(
            DomainConst::KEY_STATUS => 'failure',
            'div' => $this->renderPartial('_form_create_schedule',
                    array(
                        'schedule' => $schedule,
                        'detail' => $detail,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                    ),
                    true)
        ));
        exit;
    }

    /**
     * Handle update schedule
     */
    public function actionUpdateSchedule() {
        // Temp value saved at Customers::getCustomerAjaxScheduleInfo()
        $detailId = Settings::getAjaxTempValue();
        $model = TreatmentScheduleDetails::model()->findByPk($detailId);
        $model->start_date = CommonProcess::convertDateTime(
                $model->start_date,
                DomainConst::DATE_FORMAT_1,
                DomainConst::DATE_FORMAT_4);
        if ($model) {
            if (isset($_POST['TreatmentScheduleDetails'])) {
                $model->attributes = $_POST['TreatmentScheduleDetails'];
                if ($model->save()) {
                    // Update treatment schedule info
                    if (isset($model->rSchedule)) {
                        $schedule = $model->rSchedule;
                        // Schedule have only 1 detail
                        if (isset($schedule->rDetail) && count($schedule->rDetail) == 1) {
                            // Update time and start date of treatment schedule
                            $schedule->time_id = $model->time_id;
                            $schedule->start_date = $model->start_date;
                            $schedule->save();
                        }
                    }
                    $rightContent = '';
                    $infoSchedule = '';
                    if (isset($model->rSchedule)
                            && isset($model->rSchedule->rMedicalRecord)
                            && isset($model->rSchedule->rMedicalRecord->rCustomer)) {
                        $customer = $model->rSchedule->rMedicalRecord->rCustomer;
                        $rightContent = $customer->getCustomerAjaxInfo();
                        $infoSchedule = $customer->getCustomerAjaxScheduleInfo();
//                        $infoSchedule = $model->getAjaxScheduleInfo();
                    }
                    echo CJSON::encode(array(
                        DomainConst::KEY_STATUS => 'success',
                        'div' => DomainConst::CONTENT00181,
                        'rightContent'  => $rightContent,
                        'infoSchedule' => $infoSchedule,
                    ));
                    exit;
                }
            }
            echo CJSON::encode(array(
                'status' => 'failure',
                'div' => $this->renderPartial('_form_update_schedule',
                        array(
                            'model' => $model,
                            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                        ),
                        true)
            ));
            exit;
        }
    }
    
    /**
     * Action get all customers have birthday is today
     */
    public function actionBirthday() {
        $criteria = new CDbCriteria();
        $models = Customers::model()->findAll($criteria);
        $retVal = array();
        foreach ($models as $model) {
            if (DateTimeExt::isBirthday($model->date_of_birth, DomainConst::DATE_FORMAT_4)) {
                $retVal[$model->id] = $model;
            }
        }
        $this->render('birthday', array(
            'model' => $retVal,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Action get all customers have schedule on today
     */
    public function actionSchedule() {
        $arrCustomerId = TreatmentScheduleDetails::getListCustomerIdHaveScheduleToday();
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $arrCustomerId);
        $models = Customers::model()->findAll($criteria);
        
        $this->render('schedule', array(
            'model' => $models,
            'array' => $arrCustomerId,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }
    
    /**
     * Action handle receipt
     */
    public function actionReceipt() {
        $arrModels = Receipts::getReceiptsToday();
        $models=new Receipts('search');
	$models->unsetAttributes();  // clear any default values
        $models->process_date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
        if(isset($_GET['Receipts']))
			$models->attributes=$_GET['Receipts'];
        $this->render('receipt', array(
            'models' => $models, 
            'arrModels' => $arrModels, 
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }
    
    /**
     * Update receipt
     * @param String $id Id of receipt
     */
    public function actionUpdate($id) {
        $model = Receipts::model()->findByPk($id);
        if ($model) {
            $model->status = Receipts::STATUS_RECEIPTIONIST;
            $model->save();
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('receipt'));
        }
    }
    
    /**
     * Action handle test
     */
    public function actionTest() {
        $this->render('test', array(
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