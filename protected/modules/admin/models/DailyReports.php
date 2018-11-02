<?php

/**
 * This is the model class for table "daily_reports".
 *
 * The followings are the available columns in table 'daily_reports':
 * @property string $id                     Id of record
 * @property double $receipt_total          Total money of receipts
 * @property double $agent_id               Id of agent
 * @property double $receipt_total_confirm  Total money doctor was confirmed
 * @property string $approve_id             Id of approved
 * @property integer $status                Status
 * @property string $date_report            Date report
 * @property string $created_date           Created date
 * @property string $created_by             Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property Users                      $rApprove                       User was related with this record
 * @property Agents                     $rAgent                         Agent
 */
class DailyReports extends BaseActiveRecord {

    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const STATUS_NEW                = 1;
    const STATUS_PROCESS            = 2;
    const STATUS_CONFIRM            = 3;
    const STATUS_CANCEL             = 4;
    const STATUS_SHOULD_REVIEW      = 5;
    /** Status not created yet */
    const STATUS_NOT_CREATED_YET    = 6;

    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $doctors, $revenue;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DailyReports the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'daily_reports';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('approve_id, created_by, created_date', 'required', 'on' => 'create,update'),
            array('receipt_total, receipt_total_confirm, approve_id, status, created_by, created_date', 'safe'),
            array('agent_id,date_report,doctors,revenue', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rApprove' => array(self::BELONGS_TO, 'Users', 'approve_id'),
            'rAgent' => array(self::BELONGS_TO, 'Agents', 'agent_id'),
            'rCreatedBy' => array(self::BELONGS_TO, 'Users', 'created_by'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => DomainConst::KEY_ID,
            'receipt_total' => DomainConst::CONTENT00353,
            'receipt_total' => 'Tổng tiền xác thực',
            'approve_id' => 'Người duyệt',
            'status' => DomainConst::CONTENT00026,
            'created_by' => DomainConst::CONTENT00054,
            'created_date' => DomainConst::CONTENT00010,
            'date_report' => 'Ngày báo cáo',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        Loggers::info('', '', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $criteria = new CDbCriteria;

        $criteria->compare('approve_id', $this->approve_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('date_report',
                CommonProcess::convertDateTime($this->date_report,
                        DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_4));
        $agentId = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : 0;
        Loggers::info('Agent id', $agentId, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
//        $criteria->compare('agent_id', $agentId);
        if (!$this->canViewAll()) {
            $criteria->addCondition('status != ' . self::STATUS_NEW);
            $criteria->compare('approve_id', Yii::app()->user->id);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * get array status of record of table
     * @return array array status of record
     */
//    public function getArrayStatus() {
//        return [
//            self::STATUS_NEW                => DomainConst::CONTENT00467,
//            self::STATUS_PROCESS            => DomainConst::CONTENT00505,
//            self::STATUS_CONFIRM            => DomainConst::CONTENT00506,
//            self::STATUS_CANCEL             => DomainConst::CONTENT00477,
//            self::STATUS_SHOULD_REVIEW      => DomainConst::CONTENT00507,
//            self::STATUS_NOT_CREATED_YET    => DomainConst::CONTENT00508,
//        ];
//    }

    /**
     * get list doctor by agent current
     * @return array doctors
     */
    public function getArrayDoctor() {
        $aDoctor = [];
        $agentId = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : '';
        $mAgent = Agents::model()->findByPk($agentId);
        if (!empty($mAgent)) {
            $aDoctor = Users::getListUser(Roles::getRoleByName(Roles::ROLE_DOCTOR)->id, $mAgent->id);
        }
        return $aDoctor;
    }

    /**
     * get data show in view
     * @return array data show in view
     */
    public function getDataReport() {
        $aData = [];
        $date = !empty($this->date_report) ? CommonProcess::convertDateTime($this->date_report, DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_4) : date(DomainConst::DATE_FORMAT_4);
        $agentId = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : '';
        $mAgent = Agents::model()->findByPk($agentId);
        $aData['DOCTOR'] = $this->getArrayDoctor();
        $id_isset = CHtml::listData($this->getDailyReports($date), 'approve_id', 'approve_id');
        //        Load receipts
        $receipts = $mAgent->getReceipts($date, $date, array(Receipts::STATUS_RECEIPTIONIST), true);
        //        $receipts->pagination = false;
        $aReceipts = $receipts->getData();
        foreach ($aReceipts as $key => $mJoinReceipt) {
            $mReceipt = $mJoinReceipt->rReceipt;
            $doctor_id = !empty($mReceipt->getDoctorId()) ? $mReceipt->getDoctorId() : 0;
            if (in_array($doctor_id, $id_isset) || empty($aData['DOCTOR'][$doctor_id])) {
                continue;
            }
            $money = $mJoinReceipt->getReceiptFinal();
            //            $date = CommonProcess::convertDateTime($mReceipt->created_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_4);
            $date = $mReceipt->process_date;
            //            set money RECEIPT
            if (!empty($aData['RECEIPT'][$doctor_id])) {
                $aData['RECEIPT'][$doctor_id] += (int) $money;
            } else {
                $aData['RECEIPT'][$doctor_id] = (int) $money;
            }
        }
        return $aData;
    }

    /**
     * get all daily report in date
     * @param string $date Y-m-d
     */
    public function getDailyReports($date) {
        $criteria = new CDbCriteria;
        $criteria->compare('t.date_report', $date);
        return DailyReports::model()->findAll($criteria);
    }

    /**
     * created daily report
     */
    public function createDailyReport() {
        if (!empty($this->doctors) && is_array($this->doctors)) {
            $agentId = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : 0;
            $aRowInsert = [];
            $status_new = self::STATUS_NEW;
            $date_now = date('Y-m-d H:i:s');
            $current_id = Yii::app()->user->id;
            $date_report = !empty($this->date_report) ? CommonProcess::convertDateTime($this->date_report, DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_4) : date(DomainConst::DATE_FORMAT_4);
            foreach ($this->doctors as $key => $id_doctor) {
                $revenue = !empty($this->revenue[$id_doctor]) ? $this->revenue[$id_doctor] : 0;
                $aRowInsert[] = "(
                        '{$revenue}',
                        '{$revenue}',
                        '{$id_doctor}',
                        '{$status_new}',
                        '{$current_id}',
                        '{$date_report}',
                        '{$date_now}',
                        '{$agentId}'
                        )";
            }
            $tableName = DailyReports::model()->tableName();
            $sql = "insert into $tableName (
                                receipt_total,
                                receipt_total_confirm,
                                approve_id,
                                status,
                                created_by,
                                date_report,
                                created_date,
                                agent_id
                                ) values " . implode(',', $aRowInsert);
            if (count($aRowInsert)) {
                Yii::app()->db->createCommand($sql)->execute();
            }
        }
    }

    /**
     * 
     * @return string
     */
    public function getReceiptTotal() {
        return CommonProcess::formatCurrency($this->receipt_total) . ' ' . DomainConst::CONTENT00134;
    }

    /**
     * 
     * @return string
     */
    public function getReceiptTotalConfirm() {
        return CommonProcess::formatCurrency($this->receipt_total_confirm) . ' ' . DomainConst::CONTENT00134;
    }

    /**
     * 
     * @return string
     */
    public function getApprove() {
        return !empty($this->rApprove) ? $this->rApprove->getFullName() : '';
    }

    /**
     * 
     * @return string
     */
    public function getStatus() {
        if (isset(self::getArrayStatus()[$this->status])) {
            return self::getArrayStatus()[$this->status];
        }
        return '';
    }

    /**
     * 
     * @return string
     */
    public function getDateReport() {
        return !empty($this->date_report) ? CommonProcess::convertDateTime($this->date_report, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_BACK_END) : '';
    }

    /**
     * can send notify report
     * @return boolean
     */
    public function canProcess() {
        switch ($this->status) {
            case self::STATUS_NEW:
                switch (CommonProcess::getCurrentRoleId()) {
                    case Roles::getRoleByName(Roles::ROLE_RECEPTIONIST)->id:
                        return true;

                    case Roles::getRoleByName(Roles::ROLE_ADMIN)->id:
                        return true;

                    case Roles::getRoleByName(Roles::ROLE_DOCTOR)->id:
                        return false;

                    default:
                        break;
                }
                break;

            case self::STATUS_PROCESS:
                break;

            case self::STATUS_CONFIRM:
                break;

            case self::STATUS_CANCEL:
                switch (CommonProcess::getCurrentRoleId()) {
                    case Roles::getRoleByName(Roles::ROLE_RECEPTIONIST)->id:
                        return true;

                    case Roles::getRoleByName(Roles::ROLE_ADMIN)->id:
                        return true;

                    case Roles::getRoleByName(Roles::ROLE_DOCTOR)->id:
                        return false;

                    default:
                        break;
                }
                break;

            case self::STATUS_SHOULD_REVIEW:
                switch (CommonProcess::getCurrentRoleId()) {
                    case Roles::getRoleByName(Roles::ROLE_RECEPTIONIST)->id:
                        return true;

                    case Roles::getRoleByName(Roles::ROLE_ADMIN)->id:
                        return true;

                    case Roles::getRoleByName(Roles::ROLE_DOCTOR)->id:
                        return false;

                    default:
                        break;
                }
                break;
            default :
                break;
        }
        return false;
    }

    /**
     * can update status report
     * @param String $roleId Id of user role
     * @return boolean True if can confirm, false otherwise
     */
    public function canConfirm($roleId = '') {
        if (empty($roleId)) {
            $roleId = CommonProcess::getCurrentRoleId();
        }
        switch ($this->status) {
            case self::STATUS_NEW:
                break;

            case self::STATUS_PROCESS:
                Loggers::info('Current role', $roleId,
                        __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
                switch ($roleId) {
                    case Roles::getRoleByName(Roles::ROLE_RECEPTIONIST)->id:
                        return false;

                    case Roles::getRoleByName(Roles::ROLE_ADMIN)->id:
                        return true;

                    case Roles::getRoleByName(Roles::ROLE_DOCTOR)->id:
                        return true;

                    default:
                        break;
                }
                break;

            case self::STATUS_CONFIRM:
                break;

            case self::STATUS_CANCEL:
                switch ($roleId) {
                    case Roles::getRoleByName(Roles::ROLE_RECEPTIONIST)->id:
                        return false;

                    case Roles::getRoleByName(Roles::ROLE_ADMIN)->id:
                        return true;

                    case Roles::getRoleByName(Roles::ROLE_DOCTOR)->id:
                        return true;

                    default:
                        break;
                }
                break;

            case self::STATUS_SHOULD_REVIEW:
                switch ($roleId) {
                    case Roles::getRoleByName(Roles::ROLE_RECEPTIONIST)->id:
                        return false;

                    case Roles::getRoleByName(Roles::ROLE_ADMIN)->id:
                        return true;

                    case Roles::getRoleByName(Roles::ROLE_DOCTOR)->id:
                        return true;

                    default:
                        break;
                }
                break;
            default :
                break;
        }
        return false;
    }

    /**
     * can cancel daily report
     * @return boolean
     */
    public function canCancel($roleId = '') {
        if (empty($roleId)) {
            $roleId = CommonProcess::getCurrentRoleId();
        }
        switch ($this->status) {
            case self::STATUS_NEW:
                break;

            case self::STATUS_PROCESS:
                switch ($roleId) {
                    case Roles::getRoleByName(Roles::ROLE_RECEPTIONIST)->id:
                        return true;

                    case Roles::getRoleByName(Roles::ROLE_ADMIN)->id:
                        return true;

                    case Roles::getRoleByName(Roles::ROLE_DOCTOR)->id:
                        return true;

                    default:
                        break;
                }
                break;

            case self::STATUS_CONFIRM:
                break;

            case self::STATUS_CANCEL:
                break;

            case self::STATUS_SHOULD_REVIEW:
                switch ($roleId) {
                    case Roles::getRoleByName(Roles::ROLE_RECEPTIONIST)->id:
                        return false;

                    case Roles::getRoleByName(Roles::ROLE_ADMIN)->id:
                        return true;

                    case Roles::getRoleByName(Roles::ROLE_DOCTOR)->id:
                        return true;

                    default:
                        break;
                }
                break;
            default :
                break;
        }
        return false;
    }

    /**
     * can create new daily report
     * @return boolean
     */
    public function canCreateNew() {
        switch (CommonProcess::getCurrentRoleId()) {
            case Roles::getRoleByName(Roles::ROLE_RECEPTIONIST)->id:
                return true;

            case Roles::getRoleByName(Roles::ROLE_ADMIN)->id:
                return true;

            default:
                break;
        }
        return false;
    }

    /**
     * can confirm all dailyreport
     */
    public function canViewAll() {
        switch (CommonProcess::getCurrentRoleId()) {
            case Roles::getRoleByName(Roles::ROLE_RECEPTIONIST)->id:
                return true;

            case Roles::getRoleByName(Roles::ROLE_ADMIN)->id:
                return true;

            default:
                break;
        }
        return false;
    }

    /**
     * can highlight
     * @return boolean
     */
    public function canHighLight() {
        if ($this->receipt_total != $this->receipt_total_confirm) {
            return '<span class=\'highlight\'></span>';
        }
    }

    /**
     * Get agent name
     * @return string Name of agent
     */
    public function getAgent() {
        if (isset($this->rAgent)) {
            return $this->rAgent->name;
        }
        return '';
    }

    /**
     * get report receipts of doctor
     * @return array report PAY, UN_PAY
     */
    public function getDetailReport() {
        $aData = [];
        if (!empty($this->approve_id) && !empty($this->date_report)) {
            $aData['PAY'] = $this->getReceipts($this->date_report, $this->date_report, array(Receipts::STATUS_RECEIPTIONIST));
            $aData['ALL_PAY'] = $this->getReceipts($this->date_report, $this->date_report, array(Receipts::STATUS_RECEIPTIONIST), true);
            $aData['UN_PAY'] = $this->getReceipts($this->date_report, $this->date_report, array(Receipts::STATUS_DOCTOR));
        }
        return $aData;
    }

    public function getReceipts($from, $to, $arrStatus, $allData = false) {
        $mOneMany = new OneMany();
        $criteria = new CDbCriteria;
        $tblReceipts = Receipts::model()->tableName();
        $tblDetail = TreatmentScheduleDetails::model()->tableName();
        $tblSchedule = TreatmentSchedules::model()->tableName();
        $criteria->compare('r.status', Receipts::STATUS_RECEIPTIONIST, false, 'OR');
        $criteria->compare('r.status', Receipts::STATUS_DOCTOR, false, 'OR');
        $criteria->compare('t.type', OneMany::TYPE_AGENT_RECEIPT);
        $criteria->compare('t.one_id', $this->id);
        $criteria->compare('s.doctor_id', $this->approve_id);
        $criteria->addCondition('r.status != ' . Receipts::STATUS_INACTIVE);
        $criteria->addInCondition('r.status', $arrStatus);
        $criteria->addCondition('r.process_date >= \'' . $from . '\'');
        $criteria->addCondition('r.process_date <= \'' . $to . '\'');
        $criteria->order = 'r.process_date ASC';
        $criteria->join = 'JOIN ' . $tblReceipts . ' as r ON r.id = t.many_id';
        $criteria->join .= ' JOIN ' . $tblDetail . ' as d ON r.detail_id = d.id';
        $criteria->join .= ' JOIN ' . $tblSchedule . ' as s ON d.schedule_id = s.id';

        return new CActiveDataProvider($mOneMany, array(
            'criteria' => $criteria,
            'pagination' => $allData ? false : ['pageSize' => Settings::getListPageSize()]
        ));
    }

    /**
     * get url detail
     * @return string
     */
    public function getUrlDetail() {
        $result = '<br>';
        $result .= '<a class = "detailReport" href ="';
        $result .= Yii::app()->createAbsoluteUrl('admin/dailyReports/viewDetailReport', ['date_report' => $this->date_report, 'doctor_id' => $this->approve_id]);
        $result .= '" >' . DomainConst::CONTENT00011;
        $result .= '</a>';
        return $result;
    }
    
    /**
     * Convert object to string
     * @return type
     */
    public function toString() {
        return $this->getInfo(array(
            $this->rApprove->getFullName(),
            $this->date_report,
            $this->rAgent->name,
            $this->getStatus(),
            $this->created_date,
        ));
    }
    
    /**
     * Get created user
     * @return string
     */
    public function getCreatedBy() {
        if (isset($this->rCreatedBy)) {
            return $this->rCreatedBy->getFullName();
        }
        return '';
    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Get list status
     * @return Array List status
     */
    public static function getArrayStatus() {
        return [
//            self::STATUS_NEW                => DomainConst::CONTENT00467,
            self::STATUS_NEW                => DomainConst::CONTENT00509,
            self::STATUS_PROCESS            => DomainConst::CONTENT00505,
            self::STATUS_CONFIRM            => DomainConst::CONTENT00476,
            self::STATUS_CANCEL             => DomainConst::CONTENT00477,
            self::STATUS_SHOULD_REVIEW      => DomainConst::CONTENT00507,
            self::STATUS_NOT_CREATED_YET    => DomainConst::CONTENT00508,
        ];
    }
    
    /**
     * Get Array status json
     * @return String Json type
     */
    public static function getArrayStatusJson() {
        $retVal = array();
        foreach (self::getArrayStatus() as $key => $value) {
            $retVal[] = CommonProcess::createConfigJson($key, $value);
        }
        return $retVal;
    }
    
    /**
     * Check status of daily report
     * @param Users $mApprover User model
     * @param String $date      Date report (Y-m-d)
     * @return type
     */
    public static function checkStatus($mApprover, $date) {
        $retVal = self::STATUS_NOT_CREATED_YET;
        $criteria = new CDbCriteria();
//        $criteria->addInCondition('agent_id', $mApprover->getAgentIds());
        $criteria->compare('approve_id', $mApprover->id);
        $criteria->compare('date_report', $date);
//        $criteria->compare('status', self::STATUS_CONFIRM);
        $criteria->order = 'id desc';
        $models = DailyReports::model()->findAll($criteria);
        Loggers::info('Found Report number at date ' . $date, count($models), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        if ($models && count($models) > 0) {
            $isApproved = true;
            // Loop for all report in this date (maybe have more than 1 agent
            foreach ($models as $model) {
                // If only 1 report's status is not confirm => All is not confirm
                if ($model->status != self::STATUS_CONFIRM) {
                    $isApproved = false;
                    break;
                }
            }
            if ($isApproved) {
                // If all reports was confirmed
                $retVal = self::STATUS_CONFIRM;
            } else {
                // Return first report status
                $retVal = $models[0]->status;
                if ($retVal == self::STATUS_NEW) {
                    $retVal = self::STATUS_NOT_CREATED_YET;
                }
            }
//            $retVal = self::STATUS_CONFIRM;
        } else {
//            $retVal = self::STATUS_NEW;
        }
        return $retVal;
    }
    
    /**
     * Get report information
     * @param String $date Date as format yyyy-mm-dd
     * @param Int $agentId Id of agent
     * @param Users $mUser Model user
     * @return Array List information
     */
    public static function getReport($date, $agentId, $mUser) {
        $criteria = new CDbCriteria();
        $criteria->compare('approve_id', $mUser->id);
        $criteria->compare('agent_id', $agentId);
        $criteria->compare('date_report', $date);
        $criteria->order = 'id desc';
        Loggers::info("Params", "Approve: $mUser->id, Agent: $agentId, Date: $date", __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $model = DailyReports::model()->find($criteria);
        
        // Init return value
//        $id         = DomainConst::NUMBER_ZERO_VALUE;
//        $agentName  = '';
//        $total      = 0;
//        $createdBy  = '';
//        $status     = self::STATUS_NOT_CREATED_YET . '';
//        $statusStr  = self::getArrayStatus()[$status];
//        
//        if ($model) {       // Found
//            $id         = $model->id;
//            $agentName  = $model->getAgent();
//            $total      = $model->receipt_total;
//            $createdBy  = $model->getCreatedBy();
//            $status     = $model->status . '';
//            $statusStr  = self::getArrayStatus()[$status];
//        } else {            // Not created yet
//            $mAgent = Agents::model()->findByPk($agentId);
//            if ($mAgent) {
//                $agentName = $mAgent->name;
//            }
//        }
//        
//        $data = array();
//        $data[] = CommonProcess::createConfigJson(
//                DomainConst::ITEM_TOTAL, DomainConst::CONTENT00353, CommonProcess::formatCurrency($total));
//        $data[] = CommonProcess::createConfigJson(
//                DomainConst::ITEM_RECEIPTIONIST, DomainConst::CONTENT00054, $createdBy);
//        $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_STATUS, '', $status);
//        $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_STATUS_STR, DomainConst::CONTENT00026, $statusStr);
//        $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_AGENT_ID, '', $agentId);
//        $data[] = CommonProcess::createConfigJson(
//                DomainConst::ITEM_AGENT, DomainConst::CONTENT00199, $agentName);
//        return CommonProcess::createConfigJson($id,
//                $agentName, $data);
        return self::getReportJson($model, $agentId);
    }
    
    /**
     * Get daily report as json format
     * @param DailyReports $model   Report model
     * @param String $agentId       Id of agent
     * @return Json 
     */
    public static function getReportJson($model, $agentId) {
        $id         = DomainConst::NUMBER_ZERO_VALUE;
        $agentName  = '';
        $total      = 0;
        $createdBy  = '';
        $status     = self::STATUS_NOT_CREATED_YET . '';
        $statusStr  = self::getArrayStatus()[$status];
        $approver   = '';
        
        if ($model) {       // Found
            $id         = $model->id;
            $agentName  = $model->getAgent();
            $total      = $model->receipt_total;
            $createdBy  = $model->getCreatedBy();
            $status     = $model->status . '';
            $statusStr  = self::getArrayStatus()[$status];
            $approver   = $model->getApprove();
        } else {            // Not created yet
            $mAgent = Agents::model()->findByPk($agentId);
            if ($mAgent) {
                $agentName = $mAgent->name;
            }
        }
        
        $data = array();
        $data[] = CommonProcess::createConfigJson(
                DomainConst::ITEM_TOTAL, DomainConst::CONTENT00353, CommonProcess::formatCurrency($total));
        $data[] = CommonProcess::createConfigJson(
                DomainConst::ITEM_TYPE, DomainConst::CONTENT00054, $createdBy);
        $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_STATUS, '', $status);
        $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_STATUS_STR, DomainConst::CONTENT00026, $statusStr);
        $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_AGENT_ID, '', $agentId);
        $data[] = CommonProcess::createConfigJson(
                DomainConst::ITEM_AGENT, DomainConst::CONTENT00199, $agentName);
        $data[] = CommonProcess::createConfigJson(DomainConst::ITEM_NAME, 'Người duyệt', $approver);
        return CommonProcess::createConfigJson($id,
                $agentName, $data);
    }

}
