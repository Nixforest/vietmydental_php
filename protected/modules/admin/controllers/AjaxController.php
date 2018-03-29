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
        $criteria->addCondition("t.record_number like '%$keyword%'");
        $criteria->limit = 50;
        $criteria->addCondition('t.status!=' . DomainConst::DEFAULT_STATUS_INACTIVE);
        return MedicalRecords::model()->findAll($criteria);
    }
    
    /**
     * Search customer for receptionist
     */
    public function actionSearchCustomerReception() {
	if (isset($_GET[AjaxController::KEY_AJAX]) && $_GET[AjaxController::KEY_AJAX] == 1) {
            if (isset($_GET[AjaxController::KEY_TERM])) {
                $keyword = trim($_GET[AjaxController::KEY_TERM]);
                $criteria = new CDbCriteria();
                $criteria->addCondition("t.name like '%$keyword%' or t.phone like '%$keyword%'");
                $criteria->limit = 50;
//                $criteria->compare("t.status", DomainConst::DEFAULT_STATUS_ACTIVE);
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
                $retVal = '<div class="scroll-table">';
                $infoSchedule = '';
                if (count($models)) {
                    $retVal .= '<table id="customer-info">';
                    $retVal .=      '<thead>';
                    $retVal .=          '<tr>';
                    $retVal .=          '<th>' . DomainConst::CONTENT00100 . '</th>';
                    $retVal .=          '<th>' . DomainConst::CONTENT00170 . '<br>' . DomainConst::CONTENT00136 . '</br>' . '</th>';
                    $retVal .=          '<th>' . DomainConst::CONTENT00101 . '</th>';
                    $retVal .=          '<th class="col-4">' . DomainConst::CONTENT00045 . '</th>';
                    $retVal .=          '</tr>';
                    $retVal .=      '</thead>';
                    $retVal .=      '<tbody>';
                    foreach ($models as $model) {
                        $recordNumber = '';
                        if (isset($model->rMedicalRecord)) {
                            $recordNumber = $model->rMedicalRecord->record_number;
                        }
                        $retVal .= '<tr id="' . $model->id . '" class="customer-info-tr">';
                        $retVal .= '<td>' . $model->name . '</td>';
                        $retVal .= '<td>' . $model->phone . '<br>' . $recordNumber . '</br>' . '</td>';
                        $retVal .= '<td>' . $model->date_of_birth . '</td>';
                        $retVal .= '<td>' . $model->address . '</td>';
                        $retVal .= '</tr>';
                    }
                    $retVal .=      '</tbody>';
                    $retVal .= '</table>';
                }
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
//                $rightContent = '<div class="info-result">';
//                $rightContent .=    '<div class="title-2">' . DomainConst::CONTENT00173 . '</div>';
//                $rightContent .=    '<div class="item-search">';
//                $rightContent .=        '<table>';
//                $rightContent .=            '<tr>';
//                $rightContent .=                '<td>' . DomainConst::CONTENT00100 . ': ' . '<b>' . $model->name . '<b>' . '</td>';
//                $rightContent .=                '<td>' . DomainConst::CONTENT00101 . ': ' . '<b>' . $model->getBirthday() . '<b>' . '</td>';
//                $rightContent .=            '</tr>';
//                $rightContent .=            '<tr>';
//                $rightContent .=                '<td>' . DomainConst::CONTENT00170 . ': ' . '<b>' . $model->getPhone() . '<b>' . '</td>';
//                $rightContent .=                '<td>' . DomainConst::CONTENT00047 . ': ' . '<b>' . CommonProcess::getGender()[$model->gender] . '<b>' . '</td>';
//                $rightContent .=            '</tr>';
//                $rightContent .=            '<tr>';
//                $rightContent .=                '<td colspan="2">' . DomainConst::CONTENT00045 . ': ' . '<b>' . $model->getAddress() . '<b>' . '</td>';
//                $rightContent .=            '</tr>';
//                $rightContent .=            '<tr>';
//                $rightContent .=                '<td colspan="2">' . '<b>' . $model->getAgentName() . '<b>' . '</td>';
//                $rightContent .=            '</tr>';
//                $pathological = '';
//                if (isset($model->rMedicalRecord)) {
//                    $pathological = $model->rMedicalRecord->generatePathological(", ");
//                    Settings::saveAjaxTempValue($model->rMedicalRecord->id);
//                }
//                if (!empty($pathological)) {
//                    $rightContent .=        '<tr>';
//                    $rightContent .=            '<td colspan="2">' . DomainConst::CONTENT00137 . ': ' . '<b>' . $pathological . '<b>' . '</td>';
//                    $rightContent .=        '</tr>';
//                }                
//                $rightContent .=        '</table>';
//                $rightContent .=    '</div>';
//                $rightContent .=    '<div class="title-2">' . DomainConst::CONTENT00174 . '</div>';
//                $rightContent .=    '<div class="item-search">';                
//                if (isset($model->rMedicalRecord) && isset($model->rMedicalRecord->rTreatmentSchedule)) {
//                    $i = count($model->rMedicalRecord->rTreatmentSchedule);
//                    foreach ($model->rMedicalRecord->rTreatmentSchedule as $schedule) {
//                        if ($schedule->rPathological) {
//                            $rightContent .= '<p>Đợt ' . $i . ': ' . $schedule->rPathological->name . '</p>';
//                        }
//                        $i--;
//                    }
//                }
//                $rightContent .=    '</div>';
//                $rightContent .= '</div>';
                $rightContent = $model->getCustomerAjaxInfo();
//                $infoSchedule = '';
//                $scheduleId = $model->getSchedule();
//                
//                $infoSchedule .= '<div class="group-btn">';
//                $infoSchedule .=    '<a style="cursor: pointer;"'
//                                . ' onclick="{createSchedule(); $(\'#dialogUpdateSchedule\').dialog(\'open\');}">' . DomainConst::CONTENT00179 . '</a>';
//                $infoSchedule .= '</div>';
//                if (!empty($scheduleId)) {
//                    Settings::saveAjaxTempValue($scheduleId);
//                    $mSchedule = TreatmentScheduleDetails::model()->findByPk($scheduleId);
//                    if ($mSchedule) {
//                        $infoSchedule = '<div class="title-2">' . DomainConst::CONTENT00177 . ': </div>';
//                        $infoSchedule .= '<div class="item-search">';
//                        $infoSchedule .=    '<p>' . $mSchedule->start_date . '</p>';
//                        $infoSchedule .=    '<p>Hình thức: ' . $mSchedule->type_schedule . '</p>';
//                        $infoSchedule .=    '<p>Chi Tiết Công Việc: ' . $mSchedule->description . '</p>';
//                        $infoSchedule .= '</div>';
//                        $infoSchedule .= '<div class="group-btn">';
//                        $infoSchedule .=    '<a style="cursor: pointer;"'
//                                . ' onclick="{updateSchedule(); $(\'#dialogUpdateSchedule\').dialog(\'open\');}">' . DomainConst::CONTENT00178 . '</a>';
//                        $infoSchedule .= '</div>';
//                    }
//                }
                $infoSchedule = $model->getCustomerAjaxScheduleInfo();
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
            $rightContent = '';
            $infoSchedule = '';
            if ($model) {
                $rightContent = $model->getAjaxInfo();
                $infoSchedule = '';
            }
            $json = CJavaScript::jsonEncode(array(
                'rightContent'  => $rightContent,
                'infoSchedule' => $infoSchedule,
            ));
            echo $json;
            Yii::app()->end();
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
}