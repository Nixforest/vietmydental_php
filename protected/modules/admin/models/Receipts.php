<?php

/**
 * This is the model class for table "receipts".
 *
 * The followings are the available columns in table 'receipts':
 * @property string $id
 * @property string $detail_id
 * @property string $process_date
 * @property string $total
 * @property string $discount
 * @property string $final
 * @property integer $need_approve
 * @property integer $customer_confirm
 * @property string $description
 * @property string $created_date
 * @property string $created_by
 * @property string $receiptionist_id
 * @property integer $status
 */
class Receipts extends CActiveRecord
{
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const STATUS_INACTIVE               = 0;
    const STATUS_ACTIVE                 = 1;
    const STATUS_DOCTOR                 = 2;
    const STATUS_RECEIPTIONIST          = 3;
    public $agent;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Receipts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'receipts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('detail_id, process_date, final, created_date', 'required'),
			array('need_approve, customer_confirm, status', 'numerical', 'integerOnly'=>true),
			array('detail_id, discount, created_by, receiptionist_id', 'length', 'max'=>11),
			array('total, final', 'length', 'max'=>10),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, detail_id, process_date, total, discount, final, need_approve, customer_confirm, description, created_date, created_by, receiptionist_id, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'rTreatmentScheduleDetail' => array(
                        self::BELONGS_TO, 'TreatmentScheduleDetails',
                        'detail_id'
                    ),
                    'rJoinAgent' => array(
                        self::HAS_ONE, 'OneMany', 'many_id',
                        'on'    => 'type = ' . OneMany::TYPE_AGENT_RECEIPT,
                    ),
                    'rUser' => array(
                        self::BELONGS_TO, 'Users', 'created_by'
                    ),
                    'rReceiptionist' => array(
                        self::BELONGS_TO, 'Users', 'receiptionist_id'
                    )
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'detail_id' => DomainConst::CONTENT00146,
			'process_date' => DomainConst::CONTENT00241,
			'total' => DomainConst::CONTENT00254,
			'discount' => DomainConst::CONTENT00242,
			'final' => DomainConst::CONTENT00259,
			'need_approve' => DomainConst::CONTENT00243,
			'customer_confirm' => DomainConst::CONTENT00244,
			'description' => DomainConst::CONTENT00091,
			'created_date' => DomainConst::CONTENT00010,
			'created_by' => DomainConst::CONTENT00054,
			'receiptionist_id' => DomainConst::CONTENT00246,
			'status' => DomainConst::CONTENT00026,
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('detail_id',$this->detail_id,true);
		$criteria->compare('process_date',$this->process_date,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('final',$this->final,true);
		$criteria->compare('need_approve',$this->need_approve);
		$criteria->compare('customer_confirm',$this->customer_confirm);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('receiptionist_id',$this->receiptionist_id,true);
		$criteria->compare('status',$this->status);
                $criteria->order = 'id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => Settings::getListPageSize(),
                        ),
		));
	}
        
    //-----------------------------------------------------
    // Parent override methods
    //-----------------------------------------------------
    /**
     * Override before save method
     * @return Parent result
     */
    public function beforeSave() {
        $userId = isset(Yii::app()->user) ? Yii::app()->user->id : '';
//        CommonProcess::dumpVariable($this->process_date);
        // Format start date value
        $date = $this->process_date;
        $this->process_date = CommonProcess::convertDateTimeToMySqlFormat(
                $date, DomainConst::DATE_FORMAT_3);
        
        if (empty($this->process_date)) {
            $this->process_date = CommonProcess::convertDateTimeToMySqlFormat(
                            $date, DomainConst::DATE_FORMAT_4);
        }
        
        // Calculate total money
//        if (isset($this->rTreatmentScheduleDetail)) {
//            $this->total = $this->rTreatmentScheduleDetail->getTotalMoney();
//        }
        if ($this->isNewRecord) {   // Add
            // Handle created by
            if (empty($this->created_by)) {
                $this->created_by = $userId;
            }
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        } else {                    // Update
            if (isset(Yii::app()->user->role_name)) {
                if (Yii::app()->user->role_name == Roles::ROLE_RECEPTIONIST) {
                    $this->receiptionist_id = $userId;
                }
            }
        }
        return parent::beforeSave();
    }
    
    /**
     * Override before delete method
     */
    public function beforeDelete() {
        // Handle Agent relation
        OneMany::deleteAllManyOldRecords($this->id, OneMany::TYPE_AGENT_RECEIPT);
        
        Loggers::info("Deleted " . get_class($this) . " with id = $this->id.", __FUNCTION__, __LINE__);
        return parent::beforeDelete();
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Check model can update
     * @return boolean
     */
    public function canUpdate() {
        if ($this->status == self::STATUS_RECEIPTIONIST) {
            return false;
        }
        
        return true;
    }

    /**
     * Connect receipt with current agent
     * @param String $agentId Id of agent
     */
    public function connectAgent($agentId) {
        OneMany::deleteAllManyOldRecords($this->id, OneMany::TYPE_AGENT_RECEIPT);
        OneMany::insertOne($agentId, $this->id, OneMany::TYPE_AGENT_RECEIPT);
    }
    
    /**
     * Set status base on created user role
     * @param String $roleName Name of role (can empty)
     */
    public function setStatusByCreatedUserRole($roleName) {
        switch ($roleName) {
            case Roles::ROLE_DOCTOR:
                $this->status = self::STATUS_DOCTOR;
                break;
            case Roles::ROLE_RECEPTIONIST:
                $this->status = self::STATUS_RECEIPTIONIST;
                break;
            default:
                break;
        }
        $this->status = self::STATUS_ACTIVE;
    }
    
    /**
     * Get customer model
     * @return Customer model, or NULL
     */
    public function getCustomer() {
        if (isset($this->rTreatmentScheduleDetail)) {
            return $this->rTreatmentScheduleDetail->getCustomerModel();
        }
        return NULL;
    }
    
    /**
     * Get customer name
     * @return Customer name, or empty
     */
    public function getCustomerName() {
        $model = $this->getCustomer();
        if ($model != NULL) {
            return $model->name;
        }
        return '';
    }
    
    /**
     * Get customer record number
     * @return Customer record number, or empty
     */
    public function getCustomerRecordNumber() {
        $model = $this->getCustomer();
        if ($model != NULL) {
            if (isset($model->rMedicalRecord)) {
                return $model->rMedicalRecord->record_number;
            }
        }
        return '';
    }
    
    /**
     * Get receptionist name
     * @return type
     */
    public function getReceptionist() {
        if ($this->status == self::STATUS_RECEIPTIONIST) {
            if (isset($this->rReceiptionist)) {
                return $this->rReceiptionist->getFullName();
            }
        }
        return '';
    }
    
    /**
     * Get receptionist status
     * @return type
     */
    public function getReceptionistStatus() {
        if ($this->status == self::STATUS_RECEIPTIONIST) {
            if (isset($this->rReceiptionist)) {
                return $this->rReceiptionist->getFullName() . " " . DomainConst::CONTENT00266;
            }
        }
        return DomainConst::CONTENT00267;
    }
    
    /**
     * Get treatment type
     * @return Treatment type model, or NULL
     */
    public function getTreatmentType() {
        if (isset($this->rTreatmentScheduleDetail)) {
            return $this->rTreatmentScheduleDetail->rTreatmentType;
        }
        return NULL;
    }
    
    /**
     * Get treatment type name
     * @return Treatment type name, or empty
     */
    public function getTreatmentTypeName() {
        $model = $this->getTreatmentType();
        if ($model != NULL) {
            return $model->name;
        }
        return '';
    }
    
    /**
     * Get insurrence amount (include unit 'VND')
     * @return String Insurrence amount
     */
    public function getInsuranceAmount() {
        $retVal = 0;
        if (isset($this->rTreatmentScheduleDetail)
                && isset($this->rTreatmentScheduleDetail->rSchedule)) {
            $retVal = $this->rTreatmentScheduleDetail->rSchedule->insurrance;
        }
        return CommonProcess::formatCurrencyWithUnit($retVal);
    }
    
    /**
     * Get ajax information
     * @return string
     */
    public function getAjaxInfo() {
        // Get treatment schedule detail information
        if (isset($this->rTreatmentScheduleDetail)) {
            // Teeth info
            $teeth = $this->rTreatmentScheduleDetail->generateTeethInfo(", ");
            // Diagnosis
            $diagnosis = $this->rTreatmentScheduleDetail->getDiagnosis();
            // Treatment type
            $treatmentType = $this->rTreatmentScheduleDetail->getTreatment() . " - " . $this->rTreatmentScheduleDetail->getTreatmentPriceText();
            // Money
            $money = $this->getTotal();
            if (isset($this->rTreatmentScheduleDetail->rSchedule)) {
                $insurance = $this->rTreatmentScheduleDetail->rSchedule->getInsurrance();
            }
        }
        $rightContent = '<div class="info-result">';
        $rightContent .=    '<div class="title-2">' . DomainConst::CONTENT00174 . '</div>';
        $rightContent .=    '<div class="item-search">';
        $rightContent .=        '<table class="table table-borderless">';
        $rightContent .=            '<tr>';
        $rightContent .=                '<td>' . DomainConst::CONTENT00145 . ': </td>';
        $rightContent .=                '<td><b>' . $teeth . '</b>' . '</td>';
        $rightContent .=            '</tr>';
        $rightContent .=            '<tr>';
        $rightContent .=                '<td>' . DomainConst::CONTENT00231 . ': </td>';
        $rightContent .=                '<td><b>' . $diagnosis . '</b>' . '</td>';
        $rightContent .=            '</tr>';
        $rightContent .=            '<tr>';
        $rightContent .=                '<td>' . DomainConst::CONTENT00128 . ': </td>';
        $rightContent .=                '<td><b>' . $treatmentType . '</b>' . '</td>';
        $rightContent .=            '</tr>';
        $rightContent .=        '</table>';
        $rightContent .=    '</div>';
        $rightContent .=    '<div class="title-2">' . DomainConst::CONTENT00251 . '</div>';
        $rightContent .=    '<div class="item-search">'; 
        $rightContent .=        '<table>';
        $rightContent .=            '<tr>';
        $rightContent .=                '<td>' . DomainConst::CONTENT00254 . ': </td>';
        $rightContent .=                '<td align="right"><b>' . CommonProcess::formatCurrency($money) . '</b>' . '</td>';
        $rightContent .=            '</tr>';
        $rightContent .=            '<tr>';
        $rightContent .=                '<td>' . DomainConst::CONTENT00257 . ': </td>';
        $rightContent .=                '<td align="right"><b>' . CommonProcess::formatCurrency($this->discount) . '</b>' . '</td>';
        $rightContent .=            '</tr>';
        $rightContent .=            '<tr>';
        $rightContent .=                '<td>' . DomainConst::CONTENT00259 . ': </td>';
        $rightContent .=                '<td align="right"><b>' . CommonProcess::formatCurrency($this->final) . '</b>' . '</td>';
        $rightContent .=            '</tr>';
        if (!empty($insurance)) {
            $rightContent .=            '<tr>';
            $rightContent .=                '<td>' . DomainConst::CONTENT00260 . ': </td>';
            $rightContent .=                '<td align="right"><b>' . $insurance . '</b>' . '</td>';
            $rightContent .=            '</tr>';
        }
        $rightContent .=            '<tr>';
        $rightContent .=                '<td>' . DomainConst::CONTENT00091 . ': </td>';
        $rightContent .=                '<td align="right"><b>' . $this->description . '</b>' . '</td>';
        $rightContent .=            '</tr>';
        $rightContent .=        '</table>';
        $rightContent .=    '</div>';
        
        $rightContent .=        '<table>';
        $rightContent .=            '<tr>';
        if ($this->status == self::STATUS_DOCTOR) {
            $rightContent .=                '<td>';
            $rightContent .= HtmlHandler::createButtonWithImage(
                    Yii::app()->createAbsoluteUrl("front/receptionist/update", array(
                        "id" => $this->id,
                        'action'    => DateTimeExt::isToday($this->process_date, DomainConst::DATE_FORMAT_4) ? 'receipt' : 'receiptOld',
                    )),
                    '<br>' . DomainConst::CONTENT00265,
                    DomainConst::IMG_COMPLETED_ICON);
            $rightContent .=                '</td>';
        }
        
        $rightContent .=                '<td>';
        $rightContent .= HtmlHandler::createButtonWithImage(
                Yii::app()->createAbsoluteUrl("front/receptionist/printReceipt", array(
                    "id" => $this->id,
                )),
                '<br>' . DomainConst::CONTENT00264,
                DomainConst::IMG_PRINT_ICON, false);
        $rightContent .=                '</td>';
        $rightContent .=                '<td>';
        
        $rightContent .= HtmlHandler::createAjaxButtonWithImage(
                '<br>' . DomainConst::CONTENT00373, DomainConst::IMG_PRINT_ALL_ICON,
                '{createPrintDialog(); $(\'#dialogPrintReceipt\').dialog(\'open\');}',
                'cursor: pointer;');
        $rightContent .=                '</td>';
        $rightContent .=            '</tr>';
        $rightContent .=        '</table>';
        
        $rightContent .= '</div>';
        return $rightContent;
    }
    
    /**
     * Get json information
     * @return type String json
     */
    public function getJsonInfo() {
        $info = array();
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_START_DATE,
                DomainConst::CONTENT00241,
                CommonProcess::convertDateTime($this->process_date,
                        DomainConst::DATE_FORMAT_4,
                        DomainConst::DATE_FORMAT_3));
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_DISCOUNT,
                DomainConst::CONTENT00242,
                $this->discount);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_FINAL,
                DomainConst::CONTENT00259,
                $this->final);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_NEED_APPROVE,
                DomainConst::CONTENT00243,
                $this->need_approve);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_CUSTOMER_CONFIRMED,
                DomainConst::CONTENT00244,
                $this->customer_confirm);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_DESCRIPTION,
                DomainConst::CONTENT00091,
                $this->description);
        $info[] = CommonProcess::createConfigJson(CustomerController::ITEM_CAN_UPDATE,
                DomainConst::CONTENT00232,
                $this->status != self::STATUS_RECEIPTIONIST
                ? DomainConst::NUMBER_ONE_VALUE : DomainConst::NUMBER_ZERO_VALUE);
        return $info;
    }
    
    /**
     * Get current status
     * @return String
     */
    public function getCurrentStatus() {
        return self::getStatus()[$this->status];
    }
    
    /**
     * Get value of id
     * @return String
     */
    public function getId() {
        $retVal = CommonProcess::generateID(DomainConst::RECEIPT_ID_PREFIX, $this->id);
        return $retVal;
    }
    
    /**
     * Get discount value
     * @return String
     */
    public function getDiscount() {
        return CommonProcess::formatCurrency($this->discount) . ' ' . DomainConst::CONTENT00134;
    }
    
    /**
     * Get final value
     * @return String
     */
    public function getFinal() {
        return CommonProcess::formatCurrency($this->final) . ' ' . DomainConst::CONTENT00134;
    }
    
    /**
     * Get total money
     * @return Int Total money
     */
    public function getTotal() {
        $retVal = 0;
//        $treatment = $this->getTreatmentType();
//        if ($this->total == 0) {
//            if ($treatment != NULL) {
//                $retVal = $treatment->price;
//            }
//        } else {
//            $retVal = $this->total;
//        }
        $retVal = $this->total;
        return $retVal;
    }
    
    /**
     * Get number of teeth of receipt
     * @return Number of teeth, or "0"
     */
    public function getNumTeeth() {
        if (isset($this->rTreatmentScheduleDetail)) {
            return $this->rTreatmentScheduleDetail->getTeethCount();
        }
        return 0;
    }
    
    public function getDebit() {
        $money = $this->getTotal() - $this->discount;                 // Money after discount
        $final = $this->final;      // Final money doctor decide take from customer
        $treatment = $this->getTreatmentType();
        if ($treatment != NULL) {
//            $money = $treatment->price - $this->discount;
        }
//        if (isset($this->rTreatmentScheduleDetail)) {
//            $money = $this->rTreatmentScheduleDetail->getTotalMoney() - $this->discount;
//        }
        $debt = $money - $final;
        return $debt;
    }
    
    /**
     * Get debit (in text)
     * @return type
     */
    public function getDebitText() {
        $debit = $this->getDebit();
        if ($debit > 0) {
            return CommonProcess::formatCurrency($debit) . ' ' . DomainConst::CONTENT00134;
        }
        return '';
//            return CommonProcess::formatCurrency($debit) . ' ' . DomainConst::CONTENT00134;
    }
    
    /**
     * Confirm finish Treatment schedule detail
     */
    public function finishTreatmentScheduleDetail() {
        if (isset($this->rTreatmentScheduleDetail)) {
            $this->rTreatmentScheduleDetail->status = TreatmentScheduleDetails::STATUS_COMPLETED;
            $this->rTreatmentScheduleDetail->save();
        }
    }
    
    /**
     * Update customer debt
     */
    public function updateCustomerDebt() {
        $debt = $this->getDebit();
        $customer = $this->getCustomer();
        if ($customer != NULL) {
            $customer->debt = $customer->debt + $debt;
            $customer->save();
        }
    }
    
    /**
     * Rollback customer debt
     */
    public function rollbackCustomerDebt() {
        $debt = $this->getDebit();
        $customer = $this->getCustomer();
        if ($customer != NULL) {
            $customer->debt = $customer->debt - $debt;
            $customer->save();
        }
    }
    
    /**
     * Get id of agent
     * @return Id of agent
     */
    public function getAgentId() {
        if (isset($this->rJoinAgent)) {
            if (isset($this->rJoinAgent->rAgent)) {
                return $this->rJoinAgent->rAgent->id;
            }
        }
        return '';
    }
    
    /**
     * Get name of agent
     * @return Name of agent
     */
    public function getAgentName() {
        if (isset($this->rJoinAgent)) {
            if (isset($this->rJoinAgent->rAgent)) {
                return $this->rJoinAgent->rAgent->name;
            }
        }
        return '';
    }
    
    /**
     * Get process date
     * @return type
     */
    public function getProcessDate() {
//        return CommonProcess::convertDateTime($this->process_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_3);
        return $this->process_date;
    }
    
    /**
     * Check if this model is belong current user
     * @return True if agent id match, False otherwise
     */
    public function isBelongCurrentUser() {
        $agentId = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : '';
        if (isset($this->rJoinAgent)) {
            if ($this->rJoinAgent->id == $agentId) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Check if this model is belong agent
     * @param String agent_id Id of agent
     * @return True if agent id match, False otherwise
     */
    public function isBelongAgent($agent_id) {
        if (isset($this->rJoinAgent) && isset($this->rJoinAgent->rAgent)) {
            if ($this->rJoinAgent->rAgent->id == $agent_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchOld()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->compare('id',$this->id,true);
            $criteria->compare('detail_id',$this->detail_id,true);
            $now = new CDbExpression("NOW()");
//            $criteria->addCondition("t.process2_date != " . CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4));
            $criteria->addCondition('t.process_date < DATE(NOW())');
            $criteria->compare('total',$this->total,true);
            $criteria->compare('discount',$this->discount,true);
            $criteria->compare('final',$this->final,true);
            $criteria->compare('need_approve',$this->need_approve);
            $criteria->compare('customer_confirm',$this->customer_confirm);
            $criteria->compare('description',$this->description,true);
            $criteria->compare('created_date',$this->created_date,true);
            $criteria->compare('created_by',$this->created_by,true);
            $criteria->compare('receiptionist_id',$this->receiptionist_id,true);
            $criteria->addCondition('t.status != ' . self::STATUS_RECEIPTIONIST);
            $criteria->addCondition('t.status != ' . self::STATUS_INACTIVE);
            $criteria->order = 'id DESC';

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination' => array(
                        'pageSize' => Settings::getListPageSize(),
                    ),
            ));
    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Get list status of treatment schedule detail object
     * @return Array
     */
    public static function getStatus() {
        return array(
            self::STATUS_INACTIVE       => DomainConst::CONTENT00028,
            self::STATUS_ACTIVE         => DomainConst::CONTENT00027,
            self::STATUS_DOCTOR         => DomainConst::CONTENT00247,
            self::STATUS_RECEIPTIONIST  => DomainConst::CONTENT00248,
        );
    }
    
    /**
     * Get list receipts on today
     * @return array List receipts object
     */
    public static function getReceiptsToday() {
        $retVal = array();
        $models = self::model()->findAll();
        $agentId = isset(Yii::app()->user) ? Yii::app()->user->agent_id : '';
        foreach ($models as $model) {
            if ($model->status != self::STATUS_INACTIVE
                    && DateTimeExt::isToday($model->process_date, DomainConst::DATE_FORMAT_4)
                    && ($model->getAgentId() == $agentId)) {
//        CommonProcess::dumpVariable($model->getAgentId());
                $retVal[] = $model;
            }
        }
        
        return $retVal;
//        $criteria = new CDbCriteria();
//        $criteria->addCondition('t.process_date = DATE(NOW())');
//        $criteria->addCondition('t.status != ' . self::STATUS_INACTIVE);
//        $models = self::model()->findAll($criteria);
//        return $models;
    }
    
    /**
     * Get list receipts old
     * @return type
     */
    public static function getReceiptsOld() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.process_date < DATE(NOW())');
        $criteria->addCondition('t.status != ' . self::STATUS_RECEIPTIONIST);
        $criteria->addCondition('t.status != ' . self::STATUS_INACTIVE);
        $models = self::model()->findAll($criteria);
        $retVal = array();
        $agentId = isset(Yii::app()->user) ? Yii::app()->user->agent_id : '';
        foreach ($models as $value) {
            if ($value->getAgentId() == $agentId) {
                $retVal[] = $value;
            }
        }
        return $retVal;
    }
    
    /**
     * Get Revenue value
     * @param Date $from From value
     * @param Date $to To value
     * @return Final
     */
    public static function getRevenue($from, $to, $agent_id) {
        Loggers::info(__FUNCTION__ . "($from, $to, $agent_id)", __FUNCTION__, __LINE__);
        $retVal = 0;
        foreach (self::model()->findAll() as $receipt) {
            $date = $receipt->process_date;
            $compareFrom = DateTimeExt::compare($date, $from);
                $compareTo = DateTimeExt::compare($date, $to);
                // Check if process date is between date range
                if (($compareFrom == 1 || $compareFrom == 0)
                        && ($compareTo == 0 || $compareTo == -1)) {
                    if (($receipt->status != self::STATUS_INACTIVE)
                            && $receipt->isBelongAgent($agent_id)) {
                        $retVal += $receipt->final;
                    }
                }
        }
        return $retVal;
    }
    
    /**
     * Get revenue today
     * @return Final
     */
    public static function getRevenueToday($agent_id) {
        $today = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_6);
        return self::getRevenue($today, $today, $agent_id);
    }
    
    /**
     * Get revenue current month
     * @return Final
     */
    public static function getRevenueCurrentMonth($agent_id) {
        $from = CommonProcess::getFirstDateOfCurrentMonth(DomainConst::DATE_FORMAT_6);
        $today = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_6);
        return self::getRevenue($from, $today, $agent_id);
    }
}