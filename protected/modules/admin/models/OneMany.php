<?php

/**
 * This is the model class for table "one_many".
 *
 * The followings are the available columns in table 'one_many':
 * @property string $id
 * @property string $one_id
 * @property string $many_id
 * @property integer $type
 */
class OneMany extends BaseActiveRecord
{
    //-----------------------------------------------------
    // Type of relation
    //-----------------------------------------------------
    /** 1 [medical_records] has many [pathological] */
    const TYPE_MEDICAL_RECORD_PATHOLOGICAL              = DomainConst::NUMBER_ZERO_VALUE;
    /** 1 [treatment_schedules] has many [pathological] */
    const TYPE_TREATMENT_SCHEDULES_PATHOLOGICAL         = DomainConst::NUMBER_ONE_VALUE;
    /** 1 [agents] has many [users] */
    const TYPE_AGENT_USER                               = DomainConst::NUMBER_TWO_VALUE;
    /** 1 [agents] has many [customers] */
    const TYPE_AGENT_CUSTOMER                           = '3';
    /** 1 [agents] has many [receipt] */
    const TYPE_AGENT_RECEIPT                            = '4';
    /** 1 [warranties] has many [teeth] */
    const TYPE_WARRANTY_TEETH                           = '5';
    /** 1 [treatment_schedule_details] has many [teeth] */
    const TYPE_TREATMENT_DETAIL_TEETH                   = '6';
    /** 1 [promotions] has many [agents] */
    const TYPE_PROMOTION_AGENT                          = '7';
    /** 1 [promotionsDetail] has many [treatmentType] */
    const TYPE_PROMOTION_TREATMENT_TYPE                 = '8';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OneMany the static model class
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
		return 'one_many';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('one_id, many_id, type', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('one_id, many_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, one_id, many_id, type', 'safe', 'on'=>'search'),
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
                    'rPathological' => array(
                        self::BELONGS_TO,
                        'Pathological',
                        'many_id',
                    ),
                    'rUser' => array(
                        self::BELONGS_TO,
                        'Users',
                        'many_id',
                        'on'    => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
                    ),
                    'rAgent' => array(
                        self::BELONGS_TO,
                        'Agents',
                        'one_id',
                    ),
                    'rCustomer' => array(
                        self::BELONGS_TO,
                        'Customers',
                        'many_id',
                    ),
                    'rReceipt' => array(
                        self::BELONGS_TO,
                        'Receipts',
                        'many_id',
                        'on'    => 'status != ' . Receipts::STATUS_INACTIVE,
                    ),
                    'rWarranty' => array(
                        self::BELONGS_TO,
                        'Warranties',
                        'one_id',
                    ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'one_id' => 'One',
			'many_id' => 'Many',
			'type' => 'Type',
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
		$criteria->compare('one_id',$this->one_id,true);
		$criteria->compare('many_id',$this->many_id,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Insert new record
     * @param Int $one_id   One id
     * @param Int $many_id  Many id
     * @param String $type  Type of relation
     */
    public static function insertOne($one_id, $many_id, $type) {
        Loggers::info('WRITE one_many record', "(one_id = $one_id, many_id = $many_id, type = $type)",
                __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $model = new OneMany();
        $model->one_id = $one_id;
        $model->many_id = $many_id;
        $model->type = $type;
        $model->save();
    }
    
    /**
     * Delete a record
     * @param Int $one_id   One id
     * @param Int $many_id  Many id
     * @param Int $type     Type of relation
     */
    public static function deleteOne($one_id, $many_id, $type) {
        Loggers::info('DELETE one_many record', "(one_id = $one_id, many_id = $many_id, type = $type)",
                __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        if (empty($one_id)) {
            return;
        }
        $criteria = new CDbCriteria;
        $criteria->compare('one_id', $one_id);
        $criteria->compare('many_id', $many_id);
        $criteria->compare('type', $type);
        self::model()->deleteAll($criteria);
    }
    
    /**
     * Delete all old records
     * @param Int $one_id   One id
     * @param Int $type     Type of relation
     */
    public static function deleteAllOldRecords($one_id, $type) {
        Loggers::info('DELETE all one_many record', "(one_id = $one_id, type = $type)",
                __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        if (empty($one_id)) {
            return;
        }
        $criteria = new CDbCriteria;
        $criteria->compare('one_id', $one_id);
        $criteria->compare('type', $type);
        self::model()->deleteAll($criteria);
    }
    
    /**
     * Delete all old records
     * @param Int $many_id  Many id
     * @param Int $type     Type of relation
     */
    public static function deleteAllManyOldRecords($many_id, $type) {
        Loggers::info('DELETE all one_many record', "(many_id = $many_id, type = $type)",
                __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        if (empty($many_id)) {
            return;
        }
        $criteria = new CDbCriteria;
        $criteria->compare('many_id', $many_id);
        $criteria->compare('type', $type);
        self::model()->deleteAll($criteria);
    }

    //-----------------------------------------------------
    // Data methods: Receipt
    //-----------------------------------------------------
    /**
     * Get customer name of receipt
     * @return Customer name, or empty
     */
    public function getReceiptCustomerName() {
        if (isset($this->rReceipt)) {
            return $this->rReceipt->getCustomerName();
        }
        return '';
    }
    /**
     * Get customer name of receipt
     * @return Customer name, or empty
     */
    public function getReceiptCustomerRecordNumber() {
        if (isset($this->rReceipt)) {
            return $this->rReceipt->getCustomerRecordNumber();
        }
        return '';
    }
    
    /**
     * Get total price
     * @param type $data
     * @return type
     */
    public static function getReceiptCustomerTotal($data) {
        $arrData = $data;
        $retVal = array();
        foreach ($arrData as $value) {
            if (isset($value->rReceipt)) {
                $customer = $value->rReceipt->getCustomer();
                if ($customer != NULL) {
                    if (!in_array($customer->id, $retVal)) {
                        $retVal[] = $customer->id;
                    }
                }
            }
        }
        return count($retVal) . " hồ sơ";
    }
    
    /**
     * Get treatment type of receipt
     * @return Treatment type name, or "Khám"
     */
    public function getReceiptTreatmentTypeName() {
        $retVal = '';
        if (isset($this->rReceipt)) {
            $retVal = $this->rReceipt->getTreatmentTypeName();
        }
        if (!empty($retVal)) {
            return $retVal;
        }
        return DomainConst::CONTENT00344;
    }
    
    /**
     * Get number of teeth of receipt
     * @return Number of teeth, or "0"
     */
    public function getReceiptNumTeeth() {
        $retVal = '';
        if (isset($this->rReceipt)) {
            $retVal = $this->rReceipt->getNumTeeth();
        }
        if (!empty($retVal)) {
            return $retVal;
        }
        return '1';
    }
    
    /**
     * Get treatment type's price of receipt
     * @return Treatment type price, or "0"
     */
    public function getReceiptTreatmentTypePrice() {
        $retVal = '';
        if (isset($this->rReceipt)) {
            $treatment = $this->rReceipt->getTreatmentType();
            if ($treatment != NULL) {
                $retVal = $treatment->price;
            }
        }
        if (!empty($retVal)) {
            return $retVal;
        }
        return '0';
    }
    
    /**
     * Get treatment type's price of receipt
     * @return Treatment type price, or "0"
     */
    public function getReceiptTreatmentTypePriceText() {
        $retVal = CommonProcess::formatCurrency($this->getReceiptTreatmentTypePrice()) . " " . DomainConst::CONTENT00134;
        if (!empty($retVal)) {
            return $retVal;
        }
        return "0 " . DomainConst::CONTENT00134;
    }
    
    /**
     * Get total price
     * @param type $data
     * @return type
     */
    public static function getReceiptTreatmentTypePriceTotal($data) {
        $arrData = $data;
        $retVal = 0;
        foreach ($arrData as $value) {
            $retVal += $value->getReceiptTreatmentTypePrice();
        }
        return CommonProcess::formatCurrency($retVal) . " " . DomainConst::CONTENT00134;
    }
    
    /**
     * Get total of receipt
     * @return Treatment type price, or "0"
     */
    public function getReceiptTotal() {
        $retVal = '';
        if (isset($this->rReceipt)) {
            $retVal = $this->rReceipt->getTotal();
        }
        if (!empty($retVal)) {
            return $retVal;
        }
        return '0';
    }
    
    /**
     * Get total of receipt
     * @return Treatment type price, or "0"
     */
    public function getReceiptTotalText() {
        $retVal = '';
        if (isset($this->rReceipt)) {
            $retVal = CommonProcess::formatCurrency($this->getReceiptTotal()) . " " . DomainConst::CONTENT00134;
        }
        if (!empty($retVal)) {
            return $retVal;
        }
        return "0 " . DomainConst::CONTENT00134;
    }
    
    /**
     * Get total price
     * @param type $data
     * @return type
     */
    public static function getReceiptTotalTotal($data) {
        $arrData = $data;
        $retVal = 0;
        foreach ($arrData as $value) {
            $retVal += $value->getReceiptTotal();
        }
        return CommonProcess::formatCurrency($retVal) . " " . DomainConst::CONTENT00134;
    }
    
    /**
     * Get discount of receipt
     * @return Discount amount, or "0"
     */
    public function getReceiptDiscount() {
        $retVal = '';
        if (isset($this->rReceipt)) {
            $retVal = $this->rReceipt->discount;
        }
        if (!empty($retVal)) {
            return $retVal;
        }
        return '0';
    }
    
    /**
     * Get discount of receipt
     * @return Discount amount, or "0"
     */
    public function getReceiptDiscountText() {
        $retVal = '';
        if (isset($this->rReceipt)) {
            $retVal = $this->rReceipt->getDiscount();
        }
        if (!empty($retVal)) {
            return $retVal;
        }
        return "0 " . DomainConst::CONTENT00134;
    }
    
    /**
     * Get total discount
     * @param type $data
     * @return type
     */
    public static function getReceiptDiscountTotal($data) {
        $arrData = $data;
        $retVal = 0;
        foreach ($arrData as $value) {
            $retVal += $value->getReceiptDiscount();
        }
        return CommonProcess::formatCurrency($retVal) . " " . DomainConst::CONTENT00134;
    }
    
    /**
     * Get final of receipt
     * @return Final amount, or "0"
     */
    public function getReceiptFinal() {
        $retVal = '';
        if (isset($this->rReceipt)) {
            $retVal = $this->rReceipt->final;
        }
        if (!empty($retVal)) {
            return $retVal;
        }
        return "0";
    }
    
    /**
     * Get final of receipt
     * @return Final amount, or "0"
     */
    public function getReceiptFinalText() {
        $retVal = '';
        if (isset($this->rReceipt)) {
            $retVal = $this->rReceipt->getFinal();
        }
        if (!empty($retVal)) {
            return $retVal;
        }
        return "0 " . DomainConst::CONTENT00134;
    }
    
    /**
     * Get total final
     * @param type $data
     * @return type
     */
    public static function getReceiptFinalTotal($data) {
        $arrData = $data;
        $retVal = 0;
        foreach ($arrData as $value) {
            $retVal += $value->getReceiptFinal();
        }
        return CommonProcess::formatCurrency($retVal) . " " . DomainConst::CONTENT00134;
    }
    
    /**
     * Get debit of receipt
     * @return Debit amount, or "0"
     */
    public function getReceiptDebit() {
        $retVal = '';
        if (isset($this->rReceipt)) {
            $retVal = $this->rReceipt->getDebit();
        }
        if (!empty($retVal)) {
            return $retVal;
        }
        return '0';
    }
    
    /**
     * Get debit of receipt
     * @return Debit amount, or "0"
     */
    public function getReceiptDebitText() {
        $retVal = '';
        if (isset($this->rReceipt)) {
            $retVal = $this->rReceipt->getDebitText();
        }
        if (!empty($retVal)) {
            return $retVal;
        }
        return "0 " . DomainConst::CONTENT00134;
    }
    
    /**
     * Get total debit
     * @param type $data
     * @return type
     */
    public static function getReceiptDebitTotal($data) {
        $arrData = $data;
        $retVal = 0;
        foreach ($arrData as $value) {
            $retVal += $value->getReceiptDebit();
        }
        return CommonProcess::formatCurrency($retVal) . " " . DomainConst::CONTENT00134;
    }
}