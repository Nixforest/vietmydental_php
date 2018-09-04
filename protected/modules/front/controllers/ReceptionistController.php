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
                        DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
                        DomainConst::KEY_CONTENT => DomainConst::CONTENT00180,
                        DomainConst::KEY_RIGHT_CONTENT  => $customer->getCustomerAjaxInfo(),
                        DomainConst::KEY_INFO_SCHEDULE => $customer->getCustomerAjaxScheduleInfo(),
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
            DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
            DomainConst::KEY_CONTENT => $this->renderPartial('_form_create_customer',
                    array(
                        'customer' => $customer,
                        'medicalRecord' => $medicalRecord,
                        'error'         => $errMsg,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                    ),
                    true, true)
        ));
        exit;
    }
    
    /**
     * Validate update url
     * @param Sring $id Id of customer
     * @param Sring $key Key value
     */
    public function validateUpdateUrl(&$id, $key) {
        if (isset($_POST[DomainConst::KEY_ID]) && $_POST[DomainConst::KEY_ID] !== '[object Object]') {
            $id = $_POST[DomainConst::KEY_ID];
            Settings::saveAjaxTempValue($id, $key);
        } else {
            $id = Settings::getAjaxTempValue($key);
        }
    }

    /**
     * Handle update customer.
     */
    public function actionUpdateCustomer() {
        $id = '';
        $this->validateUpdateUrl($id, DomainConst::KEY_CUSTOMER_ID);
        Loggers::info("Id param value is " . $id, __FUNCTION__, __LINE__);
        $customer = Customers::model()->findByPk($id);
        $errMsg = '';
        if ($customer) {
            $customer->agent = $customer->getAgentId();
            $medicalRecord = new MedicalRecords();
            if (isset($customer->rMedicalRecord)) {
                $medicalRecord = $customer->rMedicalRecord;
            }
            if (isset($_POST['Customers'], $_POST['MedicalRecords'])) {
                $customer->attributes = $_POST['Customers'];
                $medicalRecord->attributes = $_POST['MedicalRecords'];
                // Try save customer
                if ($customer->save()) {
                    $referCode = $_POST['Customers']['referCode'];
                    // Handle save refer code
                    if (!empty($referCode)) {
                        ReferCodes::connect($referCode, $customer->id, ReferCodes::TYPE_CUSTOMER);
                    }
                    // Handle save social network information
                    SocialNetworks::deleteAllOldRecord($customer->id, SocialNetworks::TYPE_CUSTOMER);
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
//                CommonProcess::dumpVariable($medicalRecord->id);
                    if ($medicalRecord->isValidRecordNumber() && $medicalRecord->save()) {
                        echo CJavaScript::jsonEncode(array(
                            DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
                            DomainConst::KEY_CONTENT => DomainConst::CONTENT00035,
                            DomainConst::KEY_RIGHT_CONTENT  => $customer->getCustomerAjaxInfo(),
                            DomainConst::KEY_INFO_SCHEDULE => $customer->getCustomerAjaxScheduleInfo(),
                        ));
                        exit;
                    } else {
                        if (!$medicalRecord->isValidRecordNumber()) {
                            $errMsg = "Hồ sơ số $medicalRecord->record_number tại chi nhánh " . $customer->getAgentName() . " đã tồn tại.";
                        } else {
                            $errMsg = CommonProcess::json_encode_unicode($medicalRecord->getErrors());
                        }
                    }
                } else {
                    $errMsg = CommonProcess::json_encode_unicode($customer->getErrors());
                }
            }
            echo CJSON::encode(array(
                DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
                DomainConst::KEY_CONTENT => $this->renderPartial('_form_create_customer',
                        array(
                            'customer' => $customer,
                            'medicalRecord' => $medicalRecord,
                            'error'         => $errMsg,
                            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                        ),
                        true, true)
            ));
            exit;
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
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
                        // Inform for doctor
                        FirebaseHandler::notifyNewSchedule(
                                $mMedicalRecord->rCustomer,
                                $schedule->rDoctor);
                        // Inform for customer
                        SMSHandler::sendSMSCreateSchedule($schedule->start_date,
                                $mMedicalRecord->rCustomer->getPhone(),
                                $detail->getStartTime(),
                                $schedule->rDoctor->first_name,
                                $mMedicalRecord->rCustomer->id,
                                Settings::KEY_SMS_SEND_CREATE_SCHEDULE);
                    }
                    echo CJavaScript::jsonEncode(array(
                        DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
                        DomainConst::KEY_CONTENT => DomainConst::CONTENT00205,
                        DomainConst::KEY_RIGHT_CONTENT  => $rightContent,
                        DomainConst::KEY_INFO_SCHEDULE => $infoSchedule,
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
            DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
            DomainConst::KEY_CONTENT => $this->renderPartial('_form_create_schedule',
                    array(
                        'schedule' => $schedule,
                        'detail' => $detail,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                    ),
                    true, true),
        ));
        exit;
    }

    /**
     * Handle update schedule
     */
    public function actionUpdateSchedule() {
        $id = '';
        $this->validateUpdateUrl($id, 'treatment_schedule_detail_id');
        Loggers::info("Id param value is " . $id, __FUNCTION__, __LINE__);
        $model = TreatmentScheduleDetails::model()->findByPk($id);
        if ($model) {
            $model->start_date = CommonProcess::convertDateTime(
                    $model->start_date,
                    DomainConst::DATE_FORMAT_1,
                    DomainConst::DATE_FORMAT_4);
            $schedule = $model->rSchedule;
            if (isset($_POST['TreatmentScheduleDetails']) && isset($_POST['TreatmentSchedules'])
                    && isset($schedule)) {
                $model->attributes = $_POST['TreatmentScheduleDetails'];
                $schedule->attributes = $_POST['TreatmentSchedules'];
                if ($schedule->save()) {
                    // Update time and start date of treatment schedule detail
                    $model->time_id = $schedule->time_id;
                    $model->start_date = $schedule->start_date;
                    $model->save();
                    
                    $rightContent = '';
                    $infoSchedule = '';
                    $customer = $schedule->getCustomerModel();
                    $mMedicalRecord = $schedule->rMedicalRecord;
                    if (($customer != NULL) && isset($mMedicalRecord)) {
                        $rightContent = $customer->getCustomerAjaxInfo();
                        $infoSchedule = $customer->getCustomerAjaxScheduleInfo();
                        // Inform for customer
                        SMSHandler::sendSMSCreateSchedule($schedule->start_date,
                                $mMedicalRecord->rCustomer->getPhone(),
                                $model->getStartTime(),
                                $schedule->rDoctor->first_name,
                                $mMedicalRecord->rCustomer->id,
                                Settings::KEY_SMS_SEND_UPDATE_SCHEDULE);
                    }
                    echo CJSON::encode(array(
                        DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
                        DomainConst::KEY_CONTENT => DomainConst::CONTENT00181,
                        DomainConst::KEY_RIGHT_CONTENT  => $rightContent,
                        DomainConst::KEY_INFO_SCHEDULE => $infoSchedule,
                    ));
                    exit;
                }
            }
            echo CJSON::encode(array(
                DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
                DomainConst::KEY_CONTENT => $this->renderPartial('_form_create_schedule',
                        array(
                            'detail' => $model,
                            'schedule' => $schedule,
                            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                        ),
                        true, true)
            ));
            exit;
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }
    
    /**
     * Action get all customers have birthday is today
     */
    public function actionBirthday() {
        $criteria = new CDbCriteria();
        $criteria->compare('DAY(t.date_of_birth)',date('d'));
        $criteria->compare('MONTH(t.date_of_birth)',date('m'));
        $models = Customers::model()->findAll($criteria);
        $retVal = array();
        $agentId = isset(Yii::app()->user) ? Yii::app()->user->agent_id : '';
//        foreach ($models as $model) {
//            if (DateTimeExt::isBirthday($model->date_of_birth, DomainConst::DATE_FORMAT_4)
//                    && ($model->getAgentId() == $agentId)) {
//                $retVal[$model->id] = $model;
//            }
//        }
        foreach ($models as $model) {
            if (($model->getAgentId() == $agentId)) {
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
        $date = '';
        $dateFormat = DomainConst::DATE_FORMAT_4;
        // Get data from url
        $this->validateScheduleUrl($date);
        // If url have not parameter -> Set date value is today
        if (empty($date)) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
        }
        // Date value is today
        if (DateTimeExt::isToday($date, DomainConst::DATE_FORMAT_4)) {
            // Old logic
            $arrCustomerId = TreatmentScheduleDetails::getListCustomerIdHaveScheduleToday();
            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $arrCustomerId);
            $models = Customers::model()->findAll($criteria);
            $todayModels = TreatmentScheduleDetails::getListCustomerHaveScheduleTodayCreatedToday();
        } else {
            // New logic
            $arrCustomerId = TreatmentScheduleDetails::getListCustomerIdHaveScheduleToday($date);
            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $arrCustomerId);
            $models = Customers::model()->findAll($criteria);
            $todayModels = array();
        }
        // Start search
        if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT)) {
            $this->redirect(array('schedule',
                'dateValue'  => CommonProcess::convertDateTime($_POST['date'], DomainConst::DATE_FORMAT_BACK_END, $dateFormat),
                ));
        }
        $this->render('schedule', array(
            'model' => $models,
            'array' => $arrCustomerId,
            'todayModels'   => $todayModels,
            'dateValue'     => $date,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }
    
    /**
     * Validate schedule url
     * @param String $date Date value
     */
    public function validateScheduleUrl(&$date) {
        $date = isset($_GET['dateValue']) ? $_GET['dateValue'] : '';
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
        $msg = '';
        $agent = '';
        $result = '';
        if (isset($_POST['agent'])) {
            $agent = $_POST['agent'];
        }
        if (filter_input(INPUT_POST, 'import')) {
            $msg = "Import";
            $msg .= "\nĐang chọn chi nhánh: " . $agent;
            $result = Renodcm3TbPatient::import($agent, false);
        }
        if (filter_input(INPUT_POST, 'validate')) {
            $msg = "Validate";
            $msg .= "\nĐang chọn chi nhánh: " . $agent;
            $result = Renodcm3TbPatient::import($agent);
        }
        $this->render('test', array(
            'message'   => $msg,
            'agentId'   => $agent,
            'result'    => $result,
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
//            'aAgent'        => $customer->rAgents,
            'mAgent'        => CommonProcess::getUserAgent(),
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Handle create customer.
     */
    public function actionPrintMore() {
        $id = '';
        $this->validateUpdateUrl($id, DomainConst::KEY_CUSTOMER_ID);
        Loggers::info("Id param value is " . $id, __FUNCTION__, __LINE__);
        $customer = Customers::model()->findByPk($id);
        if (isset($_POST[DomainConst::KEY_RECEIPT])) {
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
            DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
            DomainConst::KEY_CONTENT => $this->renderPartial('_form_print_receipt',
                    array(
                        'customer' => $customer,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                    ), true, true)
        ));
        exit;
    }
    
    /**
     * Action create prescription.
     */
    public function actionCreatePrescription() {
        $id = '';
        $this->validateUpdateUrl($id, 'TreatmentScheduleDetails');
        Loggers::info("Id of treatment schedule detail is " . $id, __FUNCTION__, __LINE__);
        $mTreatmentDetail = TreatmentScheduleDetails::model()->findByPk($id);
        if ($mTreatmentDetail) {
            if (isset($mTreatmentDetail->rPrescription)) {
                $model = $mTreatmentDetail->rPrescription;
                if (isset($model->rDetail) && count($model->rDetail) > 0) {
                    $listDetail = $model->rDetail;
                } else {
                    $mDetail = new PrescriptionDetails();
                    $listDetail = array($mDetail);
                }
            } else {
                $model = new Prescriptions();
                $mDetail = new PrescriptionDetails();
                $listDetail = array($mDetail);
            }
            $customer = $mTreatmentDetail->getCustomerModel();
            if (isset($_POST['Prescriptions'])) {
                $model->attributes = $_POST['Prescriptions'];
                $model->process_id = $mTreatmentDetail->id;
                if ($model->save()) {
                    // Detail info
                    foreach ($listDetail as $detail) {
                        if (!$detail->isNewRecord) {
                            $detail->delete();
                        }
                    }
                    for ($i = 0; $i < 50; $i++) {
                        if (isset($_POST['PrescriptionDetails'][$i])) {
                            Loggers::info('Detail information: ' . CommonProcess::json_encode_unicode($_POST['PrescriptionDetails'][$i]),
                                    __FUNCTION__, __LINE__);
                            $newDetail = new PrescriptionDetails();
                            $newDetail->attributes = $_POST['PrescriptionDetails'][$i];
                            $newDetail->prescription_id = $model->id;
                            if (!$newDetail->save()) {
                                Loggers::info('Error when save detail: ' . CommonProcess::json_encode_unicode($newDetail->getErrors()),
                                        __FUNCTION__, __LINE__);
                            }
                        }
                    }
                    
                    $customer = $mTreatmentDetail->getCustomerModel();
                    if (isset($customer)) {
                        $rightContent = $customer->getCustomerAjaxInfo();
                        $infoSchedule = $customer->getCustomerAjaxScheduleInfo();
                    }
                    echo CJavaScript::jsonEncode(array(
                        DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
                        DomainConst::KEY_CONTENT => DomainConst::CONTENT00035,
                        DomainConst::KEY_RIGHT_CONTENT  => $rightContent,
                        DomainConst::KEY_INFO_SCHEDULE => $infoSchedule,
                    ));
                    exit;
                }
            }
            echo CJSON::encode(array(
            DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
            DomainConst::KEY_CONTENT => $this->renderPartial('_form_create_prescription',
                array(
                    'model'     => $model,
                    'customer'  => $customer,
                    'details'   => $listDetail,
                    DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                ), true, true)
            ));
            exit;
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }
    
    //++ BUG0017-IMT (NguyenPT 20170717) Add new action updatrTreatmentStatus
    /**
     * Action update treatment status
     */
    public function actionUpdateTreatmentStatus() {
        $ajax = filter_input(INPUT_GET, DomainConst::KEY_AJAX);
        $error = '';
	if ($ajax == 1) {
            // Get parameters value
            $id = filter_input(INPUT_GET, DomainConst::KEY_ID);
            $status = filter_input(INPUT_GET, DomainConst::KEY_STATUS);
            $model = TreatmentScheduleDetails::model()->findByPk($id);
            if ($model) {
                $model->status = $status;
                $model->changeStatus();
                if ($model->save()) {   // Save success
                    $customer = $model->getCustomerModel();
                    if (isset($customer)) {
                        // Get customer information
                        $rightContent = $customer->getCustomerAjaxInfo();
                        $infoSchedule = $customer->getCustomerAjaxScheduleInfo();
                    }
                    echo CJavaScript::jsonEncode(array(
                        DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
                        DomainConst::KEY_CONTENT => DomainConst::CONTENT00035,
                        DomainConst::KEY_RIGHT_CONTENT  => $rightContent,
                        DomainConst::KEY_INFO_SCHEDULE => $infoSchedule,
                    ));
                    exit;
                } else {
                    $error = CommonProcess::json_encode_unicode($model->getErrors());
                }
            }
        }
        echo CJavaScript::jsonEncode(array(
            DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
            DomainConst::KEY_CONTENT => $error,
        ));
        exit;
    }
    //-- BUG0017-IMT (NguyenPT 20170717) Add new action updatrTreatmentStatus
    
    /**
     * Action update treatment
     */
    public function actionUpdateTreatment() {
        $id = '';
        $this->validateUpdateUrl($id, 'TreatmentScheduleDetails');
        Loggers::info("Id of treatment schedule detail is " . $id, __FUNCTION__, __LINE__);
        $model = TreatmentScheduleDetails::model()->findByPk($id);
        if ($model) {
            if (isset($_POST['TreatmentScheduleDetails'])) {
                $model->attributes = $_POST['TreatmentScheduleDetails'];
                if ($model->save()) {
                    // Remove old record
                    OneMany::deleteAllOldRecords($model->id, OneMany::TYPE_TREATMENT_DETAIL_TEETH);
                    //++ BUG0043-IMT (DuongNV 20180727) Update UI select tooth
//                    $index = 0;
                    $aTeethData = [];
                    if (!empty($_POST['teethData'])) {
                        $strDataRaw = $_POST['teethData'];
                        $strData = implode(',', array_unique(explode(',', $strDataRaw)));
                        $aTeethData = explode(',', rtrim($strData, ','));
                    }
                    $arrTeeth = CommonProcess::getListTeeth(false, '');
                    foreach ($arrTeeth as $key => $teeth) {
                        $arrTeeth[$key] = str_replace(' - ', '', $teeth);
                    }
                    foreach ($aTeethData as $t) {
                        $idInsert = array_search($t, $arrTeeth);
                        OneMany::insertOne($model->id, $idInsert, OneMany::TYPE_TREATMENT_DETAIL_TEETH);
                    }
//                    foreach (CommonProcess::getListTeeth() as $teeth) {
//                        if (isset($_POST['teeth'][$index]) && ($_POST['teeth'][$index] == DomainConst::CHECKBOX_STATUS_CHECKED)) {
//                            OneMany::insertOne($model->id, $index, OneMany::TYPE_TREATMENT_DETAIL_TEETH);
//                        }
//                        $index++;
//                    }
//                    //-- BUG0043-IMT (DuongNV 20180727) Update UI select tooth
//                    if (isset($_POST[DomainConst::KEY_SUBMIT])) {
                    if (isset($_POST['TreatmentScheduleDetails']['isFinish']) && $_POST['TreatmentScheduleDetails']['isFinish'] == 1) {
                        $model->status = TreatmentScheduleDetails::STATUS_COMPLETED;
                        $model->save();
                    }
                    $rightContent = '';
                    $infoSchedule = '';
                    $customer = $model->getCustomerModel();
                    if (isset($customer)) {
                        $rightContent = $customer->getCustomerAjaxInfo();
                        $infoSchedule = $customer->getCustomerAjaxScheduleInfo();
                    }
                    echo CJavaScript::jsonEncode(array(
                        DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
                        DomainConst::KEY_CONTENT => DomainConst::CONTENT00035,
                        DomainConst::KEY_RIGHT_CONTENT  => $rightContent,
                        DomainConst::KEY_INFO_SCHEDULE => $infoSchedule,
                    ));
                    exit;
                }
            }
        }
        echo CJSON::encode(array(
            DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
            DomainConst::KEY_CONTENT => $this->renderPartial('_form_update_treatment_schedule',
                    array(
                        'model' => $model,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                    ),
                    true, true),
        ));
        exit;
    }

    /**
     * Handle create receipt
     */
    public function actionCreateReceipt() {
        $id = '';
        $this->validateUpdateUrl($id, 'treatment_schedule_detail_id');
        Loggers::info("Id param value is " . $id, __FUNCTION__, __LINE__);
        $mDetail = TreatmentScheduleDetails::model()->findByPk($id);
        $agentId = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : '';
        $userId = isset(Yii::app()->user->id) ? Yii::app()->user->id : '';
        $total = 0;
        $customer = NULL;
        if ($mDetail) {
            if (isset($mDetail->rReceipt)) {
                $model = $mDetail->rReceipt;
            } else {
                $model   = new Receipts();
            }
            //++ BUG0045-IMT (DuongNV 20180721) Handle show total money when update receipt
            //$total = $mDetail->getTotalMoney();
            $total = $model->total;
            if (empty($total) && $model->isNewRecord) {
                $total = $mDetail->getTotalMoney();
//                $model->final = $total;
            }
            //-- BUG0045-IMT (DuongNV 20180721) Handle show total money when update receipt

            $customer = $mDetail->getCustomerModel();
        } else {
            $model   = new Receipts();
            $customer = new Customers();
        }
        
        //++ BUG0024-IMT (NamNH 201807) set promotion
        $model->setPromotion($customer, $mDetail, $total);
        //-- BUG0024-IMT (NamNH 201807) set promotion
        if (isset($_POST['Receipts'])) {
            $model->attributes = $_POST['Receipts'];
            
            //++ BUG0045-IMT (DuongNV 20180721) Format money when save
            $splitter = DomainConst::SPLITTER_TYPE_MONEY;
            $model->total = str_replace($splitter, '', $_POST['Receipts']['total']);
            $model->discount = str_replace($splitter, '', $_POST['Receipts']['discount']);
            $model->final = str_replace($splitter, '', $_POST['Receipts']['final']);
            //-- BUG0045-IMT (DuongNV 20180721) Format money when save
            
            $model->detail_id = $id;
            $model->need_approve = 0;
            $model->customer_confirm = 0;
            $model->receiptionist_id = $userId;
            $model->status = Receipts::STATUS_DOCTOR;

            if ($model->save()) {
                $model->connectAgent($agentId);
                if (isset($customer)) {
                    $rightContent = $customer->getCustomerAjaxInfo();
                    $infoSchedule = $customer->getCustomerAjaxScheduleInfo();
                }
                echo CJavaScript::jsonEncode(array(
                    DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
                    DomainConst::KEY_CONTENT => DomainConst::CONTENT00387,
                    DomainConst::KEY_RIGHT_CONTENT  => $rightContent,
                    DomainConst::KEY_INFO_SCHEDULE => $infoSchedule,
                ));
                exit;
            }
        }
        echo CJSON::encode(array(
            DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
            DomainConst::KEY_CONTENT => $this->renderPartial('_form_create_receipt',
                array(
                    'model' => $model,
                    'total' => $total,
                    'detail' => $mDetail,
                    'customer'  => $customer,
                    DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                ),
                true, true),
        ));
        exit;
    }
    
    /**
     * Action create new treatment
     */
    public function actionCreateNewTreatment() {
        $id = '';
        $this->validateUpdateUrl($id, 'TreatmentScheduleDetails');
        Loggers::info("Id of treatment schedule detail is " . $id, __FUNCTION__, __LINE__);
        $model = new TreatmentScheduleDetails();
        $model->schedule_id = $id;
        $mSchedule = TreatmentSchedules::model()->findByPk($id);
        if ($mSchedule) {
            if (isset($_POST['TreatmentScheduleDetails'])) {
                $model->attributes = $_POST['TreatmentScheduleDetails'];
                if ($model->save()) {
                    //++ BUG0043-IMT (DuongNV 20180727) Update UI select tooth
//                    $index = 0;
                    $aTeethData = [];
                    if(!empty($_POST['teethData'])){
                        $aTeethData = explode(',', rtrim($_POST['teethData'], ','));
                    }
                    $arrTeeth = CommonProcess::getListTeeth(false, '');
                    foreach ($arrTeeth as $key => $teeth) {
                        $arrTeeth[$key] = str_replace(' - ', '', $teeth);
                    }
                    foreach ($aTeethData as $t) {
                        $idInsert = array_search($t, $arrTeeth);
                        OneMany::insertOne($model->id, $idInsert, OneMany::TYPE_TREATMENT_DETAIL_TEETH);
                    }
//                    foreach (CommonProcess::getListTeeth() as $teeth) {
//                        if (isset($_POST['teeth'][$index]) && ($_POST['teeth'][$index] == DomainConst::CHECKBOX_STATUS_CHECKED)) {
//                            OneMany::insertOne($model->id, $index, OneMany::TYPE_TREATMENT_DETAIL_TEETH);
//                        }
//                        $index++;
//                    }
                    //-- BUG0043-IMT (DuongNV 20180727) Update UI select tooth
                    if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT)) {
                        $model->status = TreatmentScheduleDetails::STATUS_COMPLETED;
                        $model->save();
                    }
                    $rightContent = '';
                    $infoSchedule = '';
                    $customer = $model->getCustomerModel();
                    if (isset($customer)) {
                        $rightContent = $customer->getCustomerAjaxInfo();
                        $infoSchedule = $customer->getCustomerAjaxScheduleInfo();
                        // Inform for customer
                        if (DateTimeExt::compare(CommonProcess::getCurrentDateTime(), $model->start_date) == -1) {
                            SMSHandler::sendSMSOnce($customer->getPhone(),
                                'Quý Khách hàng đã đặt hẹn trên Hệ thống Nha Khoa Việt Mỹ vào lúc '
                                . $model->getStartTime() . ' với bác sĩ ' . $mSchedule->rDoctor->first_name
                                . '. Quý Khách hàng vui lòng sắp xếp thời gian đến đúng hẹn');
                        }
                    }
                    
                    echo CJavaScript::jsonEncode(array(
                        DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
                        DomainConst::KEY_CONTENT => DomainConst::CONTENT00035,
                        DomainConst::KEY_RIGHT_CONTENT  => $rightContent,
                        DomainConst::KEY_INFO_SCHEDULE => $infoSchedule,
                    ));
                    exit;
                }
            }
            echo CJSON::encode(array(
                DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
                DomainConst::KEY_CONTENT => $this->renderPartial('_form_update_treatment_schedule',
                    array(
                        'model' => $model,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                    ),
                    true, true),
            ));
            exit;
        }
    }
    
    /**
     * Action create labo request.
     */
    public function actionCreateLaboRequest() {
        $id = '';
        $this->validateUpdateUrl($id, 'LaboRequest');
        $mTreatmentDetail = TreatmentScheduleDetails::model()->findByPk($id);
        if ($mTreatmentDetail) {
            if (isset($mTreatmentDetail->rLaboRequest)) {
                $model = $mTreatmentDetail->rLaboRequest;
                $model->handleSearch();
            } else {
                $model = new LaboRequests('create');
                $model->date_request = date(DomainConst::DATE_FORMAT_3);
                $model->treatment_detail_id = $id;
            }
            
            if (isset($_POST['LaboRequests'])) {
                $model->attributes = $_POST['LaboRequests'];
                if (isset($_POST['teethData'])) {
                    $model->teeths = $_POST['teethData'];
                }
                $model->handleBeforeSave();
                $model->validate();
                if (!$model->hasErrors()) {
                    $model->Handlesave();
                    $customer = $mTreatmentDetail->getCustomerModel();
                    if (isset($customer)) {
                        $rightContent = $customer->getCustomerAjaxInfo();
                        $infoSchedule = $customer->getCustomerAjaxScheduleInfo();
                    }
                    echo CJavaScript::jsonEncode(array(
                        DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
                        DomainConst::KEY_CONTENT => DomainConst::CONTENT00035,
                        DomainConst::KEY_RIGHT_CONTENT  => $rightContent,
                        DomainConst::KEY_INFO_SCHEDULE => $infoSchedule,
                    ));
                    exit;
                }
            }
            echo CJSON::encode(array(
            DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
            DomainConst::KEY_CONTENT => $this->renderPartial('_form_create_labo_request',
                array(
                    'model'     => $model,
                    DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                ), true, true)
            ));
            exit;
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
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
    
    /*
     * Update treatment schedule process
     */
    public function actionUpdateProcess($id = '')
    {
        TreatmentScheduleProcess::model()->validateUpdateUrl($id, 'id');
        $model=TreatmentScheduleProcess::model()->findByPk($id);
        if(isset($_POST['TreatmentScheduleProcess']))
        {
            $model->attributes = $_POST['TreatmentScheduleProcess'];
            if($model->save()){
                $customer = $model->getCustomerModel();
                if (isset($customer)) {
                    $rightContent = $customer->getCustomerAjaxInfo();
                    $infoSchedule = $customer->getCustomerAjaxScheduleInfo();
                }
                echo CJavaScript::jsonEncode(array(
                    DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
                    DomainConst::KEY_CONTENT => DomainConst::CONTENT00035,
                    DomainConst::KEY_RIGHT_CONTENT  => $rightContent,
                    DomainConst::KEY_INFO_SCHEDULE => $infoSchedule,
                ));
                exit;
            }
        }
        echo CJSON::encode(array(
            DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
            DomainConst::KEY_CONTENT => $this->renderPartial('_form_update_treatment_schedule_process',array(
                    'model'=>$model,
                    DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                ), true, true),
        ));
        exit;
    }
    
    /*
     * Todo Delete treatment schedule process
     */
    public function actionDeleteProcess($id)
    {
        $model=TreatmentScheduleProcess::model()->findByPk($id);
        $customer = $model->getCustomerModel();
        $model->delete();
        if (isset($customer)) {
            $rightContent = $customer->getCustomerAjaxInfo();
            $infoSchedule = $customer->getCustomerAjaxScheduleInfo();
        }
        echo CJavaScript::jsonEncode(array(
            DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
            DomainConst::KEY_CONTENT => DomainConst::CONTENT00035,
            DomainConst::KEY_RIGHT_CONTENT  => $rightContent,
            DomainConst::KEY_INFO_SCHEDULE => $infoSchedule,
        ));
        exit;
    }
}