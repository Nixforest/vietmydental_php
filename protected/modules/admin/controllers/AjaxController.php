<?php

class AjaxController extends AdminController
{
    /** String 'term' */
    const KEY_TERM                  = 'term';
    /** String 'ajax' */
    const KEY_AJAX                  = 'ajax';
    /** String 'city_id' */
    const KEY_CITY_ID               = 'city_id';
    /** String 'district_id' */
    const KEY_DISTRICT_ID           = 'district_id';
    /** String 'customer_id' */
    const KEY_CUSTOMER_ID           = DomainConst::KEY_CUSTOMER_ID;
    /**
     * action search user
     * @throws CHttpException
     * @return JSON Json object
     */
    public function actionSearchUser() {
        $retVal = array();
        if (!isset($_GET[AjaxController::KEY_TERM])) {
            throw new CHttpException(404, "Uid: " . Yii::app()->user->id . " cố gắng truy cập link không phải ajax");
        }
        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('t.username', trim($_GET['term']), true);  // true => LIKE '%...%'
        $sParamsIn = isset($_GET['role']) ? $_GET['role'] : '';
        if (!empty($sParamsIn)) {
            $criteria->addCondition("t.role_id IN ($sParamsIn)");
        }
        $criteria->limit = 20;
        $models = Users::model()->findAll($criteria);
        $cmsFormat = new CmsFormatter();
        $session = Yii::app()->session;
        foreach ($models as $model) {
            $label = $model->username;
            if ($model->last_name != '') {
                $label .= ' - ' . $model->last_name;
            }
            if ($model->first_name != '') {
                $label .= ' ' . $model->first_name;
            }
            $retVal[] = array(      // Key tương ứng với giá trị ui.item
                'label' => $label,
                'value' => $label,
                'id'    => $model->id,
                'address' => $model->address,
                'phone' => $model->phone,
            );
        }
        echo CJSON::encode($retVal);
        Yii::app()->end();
    }
    
    /**
     * Search street from database
     * @throws CHttpException
     * @return JSON Json object
     */
    public function actionSearchStreet() {
        $retVal = array();
        if (!isset($_GET[AjaxController::KEY_TERM])) {
            throw new CHttpException(404, "Uid: " . Yii::app()->user->id . " cố gắng truy cập link không phải ajax");
        }
        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('t.name', trim($_GET[AjaxController::KEY_TERM]), true);
        $criteria->addSearchCondition('t.short_name', trim($_GET[AjaxController::KEY_TERM]), true);
        $criteria->limit = 50;
        $criteria->compare("t.status", DomainConst::DEFAULT_STATUS_ACTIVE);
        $models = Streets::model()->findAll($criteria);
        foreach ($models as $model) {
            $label = $model->name . " - " . $model->rCity->name;
            $retVal[] = array(
                'label' => $label,
                'value' => $label,
                'id'    => $model->id,
                'short_name'    => $model->short_name,
                'city_id'       => $model->city_id,
            );
        }
        echo CJSON::encode($retVal);
        Yii::app()->end();   
    }
    
    /**
     * Get list streets by city id
     */
    public function actionSearchStreetsByCity() {
        if (isset($_GET[AjaxController::KEY_AJAX]) && $_GET[AjaxController::KEY_AJAX] == 1) {
            $city_id = (int)$_GET[AjaxController::KEY_CITY_ID];
            $session = Yii::app()->session;
            $session[DomainConst::KEY_SESSION_CITY_ID] = $city_id;
            $streets = Cities::getListStreetsData($city_id);
            $html = '<option value="">Select</option>';
            if (count($streets) > 0) {
                foreach ($streets as $key => $value) {
                    $selected = '';
                    $html .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                }
            }
            $json = CJavaScript::jsonEncode(array('html_street'=>$html));
            echo $json;
            Yii::app()->end();  
        }
    }
    
    /**
     * Get list districts from city id
     */
    public function actionSearchDistrictsByCity() {
        if (isset($_GET[AjaxController::KEY_AJAX]) && $_GET[AjaxController::KEY_AJAX] == 1) {
            $city_id = (int)$_GET[AjaxController::KEY_CITY_ID];
            $session = Yii::app()->session;
            $session[DomainConst::KEY_SESSION_CITY_ID] = $city_id;
            $districts = Cities::getListDistrictsData($city_id);
            $html = '<option value="">Select</option>';
            if (count($districts) > 0) {
                foreach ($districts as $key => $value) {
                    $selected = '';
                    $html .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                }
            }
            $json = CJavaScript::jsonEncode(array('html_district'=>$html));
            echo $json;
            Yii::app()->end();  
        }
    }
    
    /**
     * Get list wards from district id
     */
    public function actionSearchWardsByDistrict() {
        if (isset($_GET[AjaxController::KEY_AJAX]) && $_GET[AjaxController::KEY_AJAX] == 1) {
            $district = (int)$_GET[AjaxController::KEY_DISTRICT_ID];
            $session = Yii::app()->session;
            $session[DomainConst::KEY_SESSION_DISTRICT_ID] = $district;
            $wards = CHtml::listData(Districts::model()->findByPk($district)->rWard, 'id', 'name');
            $html = '<option value="">Select</option>';
            if (count($wards) > 0) {
                foreach ($wards as $key => $value) {
                    $selected = '';
                    $html .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                }
            }
            $json = CJavaScript::jsonEncode(array('html_ward'=>$html));
            echo $json;
            Yii::app()->end();  
        }
    }
    
    /**
     * Search customer from database
     * @throws CHttpException
     * @return JSON Json object
     */
    public function actionSearchCustomer() {
        $retVal = array();
        if (!isset($_GET[AjaxController::KEY_TERM])) {
            throw new CHttpException(404, "Uid: " . Yii::app()->user->id . " cố gắng truy cập link không phải ajax");
        }
        $keyword = trim($_GET[AjaxController::KEY_TERM]);
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.name like '%$keyword%' or t.phone like '%$keyword%'");
        $criteria->limit = 50;
        $criteria->compare("t.status", DomainConst::DEFAULT_STATUS_ACTIVE);
        $models = Customers::model()->findAll($criteria);
        foreach ($models as $model) {
            $label = $model->getAutoCompleteCustomerName();
            $retVal[] = array(
                'label' => $label,
                'value' => $label,
                'id'    => $model->id,
            );
        }
        echo CJSON::encode($retVal);
        Yii::app()->end();   
    }
    
    /**
     * Search medical record from database
     * @throws CHttpException
     * @return JSON Json object
     */
    public function actionSearchMedicalRecord() {
        $retVal = array();
        if (!isset($_GET[AjaxController::KEY_TERM])) {
            throw new CHttpException(404, "Uid: " . Yii::app()->user->id . " cố gắng truy cập link không phải ajax");
        }
        $keyword = trim($_GET[AjaxController::KEY_TERM]);
        $idKeyword = str_replace('0', '', $keyword);
        $idKeyword = str_replace(DomainConst::MEDICAL_RECORD_ID_PREFIX,
                '', $idKeyword);
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.id like '%$idKeyword%' or t.record_number like '%$keyword%'");
        $criteria->limit = 50;
        $criteria->compare("t.status", DomainConst::DEFAULT_STATUS_ACTIVE);
        $models = MedicalRecords::model()->findAll($criteria);
        if (empty($models)) {
            $models = MedicalRecords::model()->findAll();
        }
        foreach ($models as $model) {
            $label = $model->getAutoCompleteMedicalRecord();
            $retVal[] = array(
                'label' => $label,
                'value' => $label,
                'id'    => $model->id,
            );
        }
        echo CJSON::encode($retVal);
        Yii::app()->end();   
    }
    
    /**
     * Search medicine record from database
     * @throws CHttpException
     * @return JSON Json object
     */
    public function actionSearchMedicine() {
        $retVal = array();
        if (!isset($_GET[AjaxController::KEY_TERM])) {
            throw new CHttpException(404, "Uid: " . Yii::app()->user->id . " cố gắng truy cập link không phải ajax");
        }
        $keyword = trim($_GET[AjaxController::KEY_TERM]);
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.name like '%$keyword%' or t.code like '%$keyword%'");
        $criteria->limit = 50;
        $criteria->compare("t.status", DomainConst::DEFAULT_STATUS_ACTIVE);
        $models = Medicines::model()->findAll($criteria);
        if (empty($models)) {
            $models = Medicines::model()->findAll();
        }
        foreach ($models as $model) {
            $label = $model->getAutoCompleteMedicine();
            $retVal[] = array(
                'label' => $label,
                'value' => $label,
                'id'    => $model->id,
            );
        }
        echo CJSON::encode($retVal);
        Yii::app()->end(); 
    }
    
    /**
     * Find customer by record number
     * @param String $keyword Keyword
     * @return List medical record objects
     */
    private function findCustomerByRecordNumber($keyword) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.record_number like '%$keyword%' or t.id like '%$keyword%'");
        $criteria->limit = 50;
        $criteria->addCondition('t.status!=' . DomainConst::DEFAULT_STATUS_INACTIVE);
        return MedicalRecords::model()->findAll($criteria);
    }
    
    /**
     * Find customer by keyword
     * @param String $keyword Keyword
     * @return List Customer object
     */
    private function findCustomerByKeyword($keyword) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.name like '%$keyword%' or t.phone like '%$keyword%' or YEAR(t.date_of_birth) like '%$keyword%' or t.year_of_birth like '%$keyword%'");
        $criteria->limit = 50;
        $criteria->addCondition('t.status!=' . DomainConst::DEFAULT_STATUS_INACTIVE);
        $models = Customers::model()->findAll($criteria);

        $medicalRecords = $this->findCustomerByRecordNumber($keyword);
        foreach ($medicalRecords as $record) {
            if (isset($record->rCustomer)) {
                if (!in_array($record->rCustomer, $models)) {
                    array_push($models, $record->rCustomer);
                }
            }
        }
        return $models;
    }
    
    /**
     * Search customer for receptionist
     */
    public function actionSearchCustomerReception() {
	if (isset($_GET[AjaxController::KEY_AJAX]) && $_GET[AjaxController::KEY_AJAX] == 1) {
            if (isset($_GET[AjaxController::KEY_TERM])) {
//                $keyword = trim($_GET[AjaxController::KEY_TERM]);
                $keyword = '';
                $keywordArr = ($_GET[AjaxController::KEY_TERM]);
                if (isset($keywordArr["customer_find"])) {
                    $keyword = $keywordArr["customer_find"];
                }
                $arrKeyword = explode(",", $keyword);
                $models = array();
                if (is_array($arrKeyword) && count($arrKeyword) > 1) {
                    // Loop for all keyword
//                    foreach ($arrKeyword as $keyVal) {
//                        array_push($models, findCustomerByKeyword(trim($keyVal)));
//                    }
                    $keyVal1 = trim($arrKeyword[0]);
                    $keyVal2 = trim($arrKeyword[1]);
                    $criteria = new CDbCriteria();
                    $criteria->addCondition("t.name like '%$keyVal1%' and (YEAR(t.date_of_birth) like '%$keyVal2%' or t.year_of_birth like '%$keyVal2%')");
                    $criteria->limit = 50;
                    $criteria->addCondition('t.status!=' . DomainConst::DEFAULT_STATUS_INACTIVE);
                    if (isset($keywordArr["customer_find_phone"])) {
                        $phone = $keywordArr["customer_find_phone"];
                        $criteria->addCondition("t.phone like'%$phone%'");
                    }
                    if (isset($keywordArr["customer_find_address"])) {
                        $address = $keywordArr["customer_find_address"];
                        $criteria->addCondition("t.address like'%$address%'");
                    }
                    $agentId = '';
                    if (isset($keywordArr["customer_find_agent"])) {
                        $agentId = $keywordArr["customer_find_agent"];
                    }
                    
                    $models = Customers::model()->findAll($criteria);

                    $medicalRecords = $this->findCustomerByRecordNumber($keyword);
                    foreach ($medicalRecords as $record) {
                        if (isset($record->rCustomer)) {
                            if (!in_array($record->rCustomer, $models)) {
                                array_push($models, $record->rCustomer);
                            }
                        }
                    }
                    // Search by agent
                    if (!empty($agentId)) {
                        $result = array();
                        foreach ($models as $model) {
                            if ($model->getAgentId() == $agentId) {
                                $result[] = $model;
                            }
                        }
                        $models = $result;
                    }
                } else {
                    $criteria = new CDbCriteria();
//                    $criteria->addCondition("t.name like '%$keyword%' or t.phone like '%$keyword%'");
//                    $criteria->addCondition("t.name like '%$keyword%' or t.phone like '%$keyword%' or YEAR(t.date_of_birth) like '%$keyword%' or t.year_of_birth like '%$keyword%'");
                    $criteria->limit = 50;
    //                $criteria->compare("t.status", DomainConst::DEFAULT_STATUS_ACTIVE);
                    $criteria->addCondition('t.status!=' . DomainConst::DEFAULT_STATUS_INACTIVE);
                    if (isset($keywordArr["customer_find"])) {
                        $name = $keywordArr["customer_find"];
                        $criteria->addCondition("t.name like'%$name%'");
                    }
                    if (isset($keywordArr["customer_find_phone"])) {
                        $phone = $keywordArr["customer_find_phone"];
                        $criteria->addCondition("t.phone like'%$phone%'");
                    }
                    if (isset($keywordArr["customer_find_address"])) {
                        $address = $keywordArr["customer_find_address"];
                        $criteria->addCondition("t.address like'%$address%'");
                    }
                    $agentId = '';
                    if (isset($keywordArr["customer_find_agent"])) {
                        $agentId = $keywordArr["customer_find_agent"];
                    }
                    $models = Customers::model()->findAll($criteria);

                    $medicalRecords = $this->findCustomerByRecordNumber($keyword);
                    foreach ($medicalRecords as $record) {
                        if (isset($record->rCustomer)) {
                            if (!in_array($record->rCustomer, $models)) {
                                array_push($models, $record->rCustomer);
                            }
                        }
                    }
                    // Search by agent
                    if (!empty($agentId)) {
                        $result = array();
                        foreach ($models as $model) {
                            if ($model->getAgentId() == $agentId) {
                                $result[] = $model;
                            }
                        }
                        $models = $result;
                    }
                }
                //++ BUG0037_1-IMT  (DuongNV 201807) Update UI schedule
//                $retVal = '<div class="scroll-table">';
                $retVal = '<div>';
                $infoSchedule = '';
                
                $retVal .= '<table id="customer-info" class="table table-striped lp-table">';
                //-- BUG0037_1-IMT  (DuongNV 201807) Update UI schedule
                $retVal .=      '<thead>';
                $retVal .=          '<tr>';
                $retVal .=          '<th>' . DomainConst::CONTENT00100 . '</th>';
                $retVal .=          '<th>' . DomainConst::CONTENT00170 . '<br>' . DomainConst::CONTENT00136 . '</th>';
                $retVal .=          '<th>' . DomainConst::CONTENT00101 . '</th>';
                $retVal .=          '<th class="col-4">' . DomainConst::CONTENT00199 . '<br>' . DomainConst::CONTENT00045 . '</th>';
                $retVal .=          '</tr>';
                $retVal .=      '</thead>';
                $retVal .=      '<tbody>';
                
                if (count($models)) {
                    foreach ($models as $model) {
                        $recordNumber = '';
                        if (isset($model->rMedicalRecord)) {
                            $recordNumber = $model->rMedicalRecord->record_number;
                        }
                        $retVal .= '<tr id="' . $model->id . '" class="customer-info-tr">';
                        $retVal .= '<td>' . $model->name . '</td>';
                        $retVal .= '<td>' . $model->phone . '<br>' . $recordNumber . '</td>';
                        $retVal .= '<td>' . $model->getBirthday() . '</td>';
                        $retVal .= '<td>' . $model->getAgentName() . '<br>' . $model->address . '</td>';
                        $retVal .= '</tr>';
                    }
                } else {
                    
                }
                $retVal .=          '</tbody>';
                $retVal .=      '</table>';
                $retVal .= '</div>';
                $json = CJavaScript::jsonEncode(array(
                    'rightContent'  => $retVal,
                    'count' => count($models),
                    'infoSchedule' => $infoSchedule
                ));
                echo $json;
                Yii::app()->end();
            }
        }
    }
    
    /**
     * Get customer information.
     */
    public function actionGetCustomerInfo() {
        $ajax = filter_input(INPUT_GET, AjaxController::KEY_AJAX);
	if ($ajax == 1) {
            $id = filter_input(INPUT_GET, AjaxController::KEY_TERM);
            $model = Customers::model()->findByPk($id);
            if ($model) {
                Settings::saveAjaxTempValue1($model->id);
                $rightContent = $model->getCustomerAjaxInfo();
                $infoSchedule = $model->getCustomerAjaxScheduleInfo();
            } else {
                $id = Settings::getAjaxTempValue1();
                $model = Customers::model()->findByPk($id);
                if ($model) {
                    $rightContent = $model->getCustomerAjaxInfo();
                    $infoSchedule = $model->getCustomerAjaxScheduleInfo();
                }
            }
            $json = CJavaScript::jsonEncode(array(
                'rightContent'  => $rightContent,
                'infoSchedule' => $infoSchedule,
            ));
            echo $json;
            Yii::app()->end();
        }
    }
    
    /**
     * Get receipt information.
     */
    public function actionGetReceiptInfo() {
        $ajax = filter_input(INPUT_GET, AjaxController::KEY_AJAX);
	if ($ajax == 1) {
            $id = $_GET[AjaxController::KEY_TERM][0];
            $model = Receipts::model()->findByPk($id);
            $customer = $model->getCustomer();
            if (isset($customer)) {
                // Save temp value to use at ReceptionistController::actionPrintMore()
                Settings::saveAjaxTempValue1($customer->id);
            }
            $rightContent = '';
            $infoSchedule = '';
            if ($model) {
                // Save ajax temp value for print receipt
                Settings::saveAjaxTempValue($id);
                $rightContent = $model->getAjaxInfo();
                $infoSchedule = '';
            }
            //++ BUG0043-IMT (DuongNV 20180730) Show tooth in receipt screen
            $aData = array(
                'model' => $model->rTreatmentScheduleDetail
                    );
            $tooth = $this->widget('ext.SelectToothExt.SelectToothExt',
                    array('data' => $aData, 'canEdit' => false), true);
            $json = CJavaScript::jsonEncode(array(
                'rightContent'  => $tooth.$rightContent,
                'infoSchedule' => $infoSchedule,
            ));
            //-- BUG0043-IMT (DuongNV 20180730) Show tooth in receipt screen
            echo $json;
            Yii::app()->end();
        }
        
    }
    /**
     * action search refer code
     * @throws CHttpException
     * @return JSON Json object
     */
    public function actionSearchReferCode() {
        $retVal = array();
        if (!isset($_GET[AjaxController::KEY_TERM])) {
            throw new CHttpException(404, "Uid: " . Yii::app()->user->id . " cố gắng truy cập link không phải ajax");
        }
        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('t.code', trim($_GET['term']), true);  // true => LIKE '%...%'
        $criteria->addCondition('t.type = ' . ReferCodes::TYPE_PRINTED);
        $criteria->limit = 20;
        $models = ReferCodes::model()->findAll($criteria);
        foreach ($models as $model) {
            $label = $model->code;
            $retVal[] = array(      // Key tương ứng với giá trị ui.item
                'label' => $label,
                'value' => $label,
                'id'    => $model->code,
            );
        }
        echo CJSON::encode($retVal);
        Yii::app()->end();
    }
    
    /**
     * Get customer information.
     */
    public function actionGetTreatmentScheduleDetailInfo() {
        $ajax = filter_input(INPUT_GET, AjaxController::KEY_AJAX);
	if ($ajax == 1) {
            $id = filter_input(INPUT_GET, AjaxController::KEY_TERM);
            $model = TreatmentScheduleDetails::model()->findByPk($id);
            if ($model) {
                $retVal = $model->getAjaxScheduleInfo_1();
            }
            $json = CJavaScript::jsonEncode(array(
                'data'  => $retVal,
            ));
            echo $json;
            Yii::app()->end();
        }
    }
    
    public function actionGetTreatmentScheduleInfo() {
        $ajax = filter_input(INPUT_GET, AjaxController::KEY_AJAX);
	if ($ajax == 1) {
            $id = filter_input(INPUT_GET, AjaxController::KEY_TERM);
            $model = TreatmentSchedules::model()->findByPk($id);
            if ($model) {
                $retVal = $model->getHtmlTreatmentDetail();
            }
            $json = CJavaScript::jsonEncode(array(
                'data'  => $retVal,
            ));
            echo $json;
            Yii::app()->end();
        }
    }
    
    /**
     * Get money type information
     */
    public function actionGetMoneyTypeInfo() {
        if (isset($_GET[AjaxController::KEY_AJAX]) && $_GET[AjaxController::KEY_AJAX] == 1) {
            $type_id = (int)$_GET[AjaxController::KEY_TERM];
            $model = MoneyType::model()->findByPk($type_id);
            $name = '';
            $description = '';
            $amount = '';
            if ($model) {
                $name = $model->name;
                $description = $model->description;
                $amount = $model->amount;
            }
            
            $json = CJavaScript::jsonEncode(array(
                'name'          => $name,
                'description'   => $description,
                'amount'        => $amount,
            ));
            echo $json;
            Yii::app()->end();  
        }
    }
    
    /**
     * Search treatment type from database
     * @throws CHttpException
     * @return JSON Json object
     */
    public function actionSearchTreatmentType() {
        $retVal = array();
        if (!isset($_GET[AjaxController::KEY_TERM])) {
            throw new CHttpException(404, "Uid: " . Yii::app()->user->id . " cố gắng truy cập link không phải ajax");
        }
        $keyword = trim($_GET[AjaxController::KEY_TERM]);
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.name like '%$keyword%'");
        $criteria->limit = 50;
        $criteria->compare("t.status", DomainConst::DEFAULT_STATUS_ACTIVE);
        $criteria->order = 'name ASC';
        $models = TreatmentTypes::model()->findAll($criteria);
        if (empty($models)) {
            $models = TreatmentTypes::model()->findAll();
        }
        foreach ($models as $model) {
            $label = $model->getAutoCompleteView();
            $retVal[] = array(
                'label' => $label,
                'value' => $label,
                'id'    => $model->id,
            );
        }
        echo CJSON::encode($retVal);
        Yii::app()->end();   
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
