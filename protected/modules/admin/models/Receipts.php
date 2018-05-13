<?php

/**
 * This is the model class for table "receipts".
 *
 * The followings are the available columns in table 'receipts':
 * @property string $id
 * @property string $detail_id
 * @property string $process_date
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
			array('detail_id, process_date, final, created_date, created_by', 'required'),
			array('need_approve, customer_confirm, status', 'numerical', 'integerOnly'=>true),
			array('detail_id, discount, created_by, receiptionist_id', 'length', 'max'=>11),
			array('final', 'length', 'max'=>10),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, detail_id, process_date, discount, final, need_approve, customer_confirm, description, created_date, created_by, receiptionist_id, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('final',$this->final,true);
		$criteria->compare('need_approve',$this->need_approve);
		$criteria->compare('customer_confirm',$this->customer_confirm);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('receiptionist_id',$this->receiptionist_id,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
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
     * Get ajax information
     * @return string
     */
    public function getAjaxInfo() {
        if (isset($this->rTreatmentScheduleDetail)) {
            $teeth = $this->rTreatmentScheduleDetail->getTeeth();
            $diagnosis = $this->rTreatmentScheduleDetail->getDiagnosis();
            $treatmentType = $this->rTreatmentScheduleDetail->getTreatment();
            $money = $this->rTreatmentScheduleDetail->getTreatmentPrice();
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
//        $rightContent .= '<p>' . DomainConst::CONTENT00254 . ': ' . '<b>' . CommonProcess::formatCurrency($money) . '</b></p>';
//        $rightContent .= '<p>' . DomainConst::CONTENT00257 . ': ' . '<b>' . CommonProcess::formatCurrency($this->discount) . '</b></p>';
//        $rightContent .= '<p>' . DomainConst::CONTENT00259 . ': ' . '<b>' . CommonProcess::formatCurrency($this->final) . '</b></p>';
        $rightContent .=    '</div>';
        
        $rightContent .=        '<table>';
        $rightContent .=            '<tr>';
        if ($this->status == self::STATUS_DOCTOR) {
            $rightContent .=                '<td>';
            $rightContent .=                    '<div class="group-btn">';
            $rightContent .=                        '<a href="' . Yii::app()->createAbsoluteUrl("front/receptionist/update", array("id" => $this->id)) . '">' . DomainConst::CONTENT00265 . '</a>';
            $rightContent .=                    '</div>';
            $rightContent .=                '</td>';
        }
        
        $rightContent .=                '<td>';
        $rightContent .=                    '<div class="group-btn">';
//        $rightContent .=                        '<a style="cursor: pointer;"'
//                                                    . ' onclick="{createPrintDialog(); $(\'#dialog\').dialog(\'open\');}">' . DomainConst::CONTENT00264 . '</a>';
        $rightContent .=                        '<a target="_blank" href="' . Yii::app()->createAbsoluteUrl("front/receptionist/printReceipt", array("id" => $this->id)) . '">' . DomainConst::CONTENT00264 . '</a>';
        $rightContent .=                    '</div>';
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
     * Update customer debt
     */
    public function updateCustomerDebt() {
        $money = 0;                 // Money after discount
        $final = $this->final;      // Final money doctor decide take from customer
        $treatment = $this->getTreatmentType();
        if ($treatment != NULL) {
            $money = $treatment->price - $this->discount;
        }
        $debt = $money - $final;
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
        $money = 0;                 // Money after discount
        $final = $this->final;      // Final money doctor decide take from customer
        $treatment = $this->getTreatmentType();
        if ($treatment != NULL) {
            $money = $treatment->price - $this->discount;
        }
        $debt = $money - $final;
        $customer = $this->getCustomer();
        if ($customer != NULL) {
            $customer->debt = $customer->debt - $debt;
            $customer->save();
        }
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
        foreach ($models as $model) {
            if ($model->status != self::STATUS_INACTIVE
                    && DateTimeExt::isToday($model->process_date, DomainConst::DATE_FORMAT_4)) {
                $retVal[] = $model;
            }
        }
        
        return $retVal;
    }
}