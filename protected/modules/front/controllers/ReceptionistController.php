<?php

class ReceptionistController extends FrontController {
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
        $errMsg = '';
        if (isset($_POST['Customers'], $_POST['MedicalRecords'])) {
            $customer->attributes = $_POST['Customers'];
            $medicalRecord->attributes = $_POST['MedicalRecords'];
            // Try save customer
            if ($customer->save()) {
                // Save agent id
                OneMany::insertOne(
                        Yii::app()->user->agent_id,
                        $customer->id, OneMany::TYPE_AGENT_CUSTOMER);
                // Handle save social network information
                foreach (SocialNetworks::TYPE_NETWORKS as $key => $value) {
                    $value = $_POST['Customers']["social_network_$key"];
                    if (!empty($value)) {
                        SocialNetworks::insertOne($value, $customer->id, SocialNetworks::TYPE_CUSTOMER, $key);
                    }
                }
                // Save success -> start create medical record
                $medicalRecord->customer_id = $customer->id;
                
                // Try to save medical record
                if ($medicalRecord->isValidRecordNumber() && $medicalRecord->save()) {
                    echo CJavaScript::jsonEncode(array(
                        DomainConst::KEY_STATUS => 'success',
                        'div' => DomainConst::CONTENT00180,
                        'rightContent'  => $customer->getCustomerAjaxInfo(),
                        'infoSchedule' => $customer->getCustomerAjaxScheduleInfo(),
                    ));
                    exit;
                } else {
                    if (!$medicalRecord->isValidRecordNumber()) {
                        $errMsg = "Hồ sơ số $medicalRecord->record_number tại chi nhánh " . $customer->getAgentName() . " đã tồn tại.";
                    } else {
                        $errMsg = CommonProcess::json_encode_unicode($medicalRecord->getErrors());
                    }
                    $customer->delete();
                }
            } else {
                $errMsg = CommonProcess::json_encode_unicode($customer->getErrors());
            }
        }
        echo CJSON::encode(array(
            DomainConst::KEY_STATUS => 'failure',
            'div' => $this->renderPartial('_form_create_customer',
                    array(
                        'customer' => $customer,
                        'medicalRecord' => $medicalRecord,
                        'error'         => $errMsg,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                    ),
                    true)
        ));
        exit;
    }
    
    /**
     * Action create schedule extend
     * Deleted
     */
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
        $schedule->start_date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
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
                        FirebaseHandler::notifyNewSchedule(
                                $mMedicalRecord->rCustomer,
                                $schedule->rDoctor);
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
        if ($model) {
            $model->start_date = CommonProcess::convertDateTime(
                    $model->start_date,
                    DomainConst::DATE_FORMAT_1,
                    DomainConst::DATE_FORMAT_4);
            $schedule = $model->rSchedule;
            if (isset($_POST['TreatmentScheduleDetails']) && isset($_POST['TreatmentSchedules'])) {
                $model->attributes = $_POST['TreatmentScheduleDetails'];
                $schedule->attributes = $_POST['TreatmentSchedules'];
                if ($model->save()) {
                    // Update treatment schedule info
                    if (isset($model->rSchedule)) {
//                        $schedule = $model->rSchedule;
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
                            'schedule' => $schedule,
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
        $agentId = isset(Yii::app()->user) ? Yii::app()->user->agent_id : '';
        foreach ($models as $model) {
            if (DateTimeExt::isBirthday($model->date_of_birth, DomainConst::DATE_FORMAT_4)
                    && ($model->getAgentId() == $agentId)) {
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
        $todayModels = TreatmentScheduleDetails::getListCustomerHaveScheduleTodayCreatedToday();
        
        $this->render('schedule', array(
            'model' => $models,
            'array' => $arrCustomerId,
            'todayModels'   => $todayModels,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }
    
    /**
     * Action handle receipt
     */
    public function actionReceipt() {
        Loggers::info("Load receipt", "actionReceipt", __CLASS__);
        $arrModels = Receipts::getReceiptsToday();
        $models=new Receipts('search');
	$models->unsetAttributes();  // clear any default values
        $models->process_date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
        if(isset($_GET['Receipts']))
			$models->attributes=$_GET['Receipts'];
        
//        $dataProvider = new CActiveDataProvider('Receipts', array(
//            'pagination' => array(
//                'pageSize' => Settings::getListPageSize(),
//            )
//        ));
        $dataProvider = $models->search();
        $dataProvider->setData($arrModels);
        
        $this->render('receipt', array(
            'models' => $models->search(), 
            'arrModels' => $arrModels,
            'isToday'   => true,
            'dataProvider'  => $dataProvider,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }
    
    /**
     * Action handle receipt old
     */
    public function actionReceiptOld() {
        Loggers::info("Load receipt", "actionReceiptOld", __CLASS__);
        $arrModels = Receipts::getReceiptsOld();
        $models = new Receipts('searchOld');
        $models->unsetAttributes();  // clear any default values
        if (isset($_GET['Receipts']))
            $models->attributes = $_GET['Receipts'];
        
//        $dataProvider = new CActiveDataProvider('Receipts', array(
//            'pagination' => array(
//                'pageSize' => Settings::getListPageSize(),
//            )
//        ));
        $dataProvider = $models->searchOld();
        $dataProvider->setData($arrModels);
        
        $this->render('receipt', array(
            'models' => $models->searchOld(),
            'arrModels' => $arrModels,
            'isToday'   => false,
            'dataProvider'  => $dataProvider,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Update receipt
     * @param String $id Id of receipt
     */
    public function actionUpdate($id, $action) {
        Loggers::info("Update receipt with id = $id", "actionUpdate", __CLASS__);
        $model = Receipts::model()->findByPk($id);
        if ($model) {
//            $model->receiptionist_id = isset(Yii::app()->user) ? Yii::app()->user->id : '';
            $model->status = Receipts::STATUS_RECEIPTIONIST;
            if ($model->save()) {
                Loggers::info("Update receipt with id = $id", "save()", __CLASS__);
                // Update customer's debt
                $model->updateCustomerDebt();
                // Confirm finish Treatment schedule detail
                $model->finishTreatmentScheduleDetail();
            } else {
                Loggers::info("Update receipt failed: " . CommonProcess::json_encode_unicode($model->getErrors()),
                        __FUNCTION__, __CLASS__);
            }
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array($action));
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
    


    /**
     * Handle print receipt.
     * @param Array List array id
     */
    public function actionPrintReceipt($id) {
        $this->layout = '//layouts/front/print';
        $arrId = explode('-', $id);
        $model = array();
        if (is_array($arrId)) {
            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $arrId, 'OR');
            $model = Receipts::model()->findAll($criteria);
        } else {
            $model[] = Receipts::model()->findByPk($id);
        }
        $receiptId = '';
        $customer = NULL;
        if (count($model) > 0) {
            $receiptId = $model[0]->getId();
            $customer = $model[0]->getCustomer();
        }
        foreach ($model as $receipt) {
            
        }
        $this->render('printReceipt', array(
            'model'         => $model,
            'receiptId'     => $receiptId,
            'customer'      => $customer,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Handle create customer.
     */
    public function actionPrintMore() {
        $customerId = Settings::getAjaxTempValue1();
        $customer = Customers::model()->findByPk($customerId);
        if (isset($_POST[DomainConst::KEY_RECEIPT])) {
//        if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT)) {
//            CommonProcess::dumpVariable('hoho');
            $nameArr = DomainConst::KEY_RECEIPT;
            $selected = array();
            if (isset($customer->rMedicalRecord) && isset($customer->rMedicalRecord->rTreatmentSchedule)) {
                foreach ($customer->rMedicalRecord->rTreatmentSchedule as $schedule) {
                    if (isset($schedule->rDetail)) {
                        foreach ($schedule->rDetail as $detail) {
                            if (isset($detail->rReceipt)) {
                                if (isset($_POST[DomainConst::KEY_RECEIPT][$schedule->id][$detail->rReceipt->id])
                                        && ($_POST[DomainConst::KEY_RECEIPT][$schedule->id][$detail->rReceipt->id] == DomainConst::CHECKBOX_STATUS_CHECKED)) {
                                    $selected[] = $detail->rReceipt->id;
                                }
                            }
                        }
                    }
                }
            }
            $this->redirect(array('printReceipt','id'=> implode('-', $selected)));
//            echo CJavaScript::jsonEncode(array(
//                DomainConst::KEY_STATUS => 'success',
//                'div' => DomainConst::CONTENT00180,
//                'rightContent'  => '',
//                'infoSchedule' => '',
//            ));
//            exit;
        }
        echo CJSON::encode(array(
            DomainConst::KEY_STATUS => 'failure',
            'div' => $this->renderPartial('_form_print_receipt',
                    array(
                        'customer' => $customer,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                    ), true)
        ));
        exit;
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