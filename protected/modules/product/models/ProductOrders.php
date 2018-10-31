<?php

/**
 * This is the model class for table "product_orders".
 *
 * The followings are the available columns in table 'product_orders':
 * @property string $id             Id of record
 * @property string $book_date      Book date
 * @property string $payment_code   Payment code
 * @property string $payment_date   Payment date
 * @property string $order_date     Order date
 * @property integer $customer_id   Id of customer
 * @property integer $order_type    Type of order
 * @property string $description    Description
 * @property string $note           Note
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property Customers                  $rCustomer                      Customer model
 * @property ProductOrderDetails[]      $rDetails                       Order details
 */
class ProductOrders extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = '0';
    /** Active */
    const STATUS_ACTIVE                 = '1';
    /** Processing */
    const STATUS_PROCESSING             = '2';
    /** Completed */
    const STATUS_COMPLETED              = '3';
    
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $autocomplete_name_customer;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProductOrders the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product_orders';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('customer_id, order_type, status', 'numerical', 'integerOnly' => true),
            array('payment_code', 'length', 'max' => 30),
            array('created_by', 'length', 'max' => 10),
            array('book_date, payment_date, order_date, description, note, created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, book_date, payment_code, payment_date, order_date, customer_id, order_type, description, note, status, created_date, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        $parentRelation = parent::relations();
        $parentRelation['rCustomer'] = array(
            self::BELONGS_TO, 'Customers', 'customer_id',
            'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
        );
        $parentRelation['rDetails'] = array(
            self::HAS_MANY, 'ProductOrderDetails', 'order_id',
            'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
        );
        
        return $parentRelation;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        $parentAttributeLabes               = parent::attributeLabels();
        $parentAttributeLabes['book_date']      = DomainConst::CONTENT00084;
        $parentAttributeLabes['payment_code']   = DomainConst::CONTENT00086;
        $parentAttributeLabes['payment_date']   = DomainConst::CONTENT00087;
        $parentAttributeLabes['order_date']     = DomainConst::CONTENT00085;
        $parentAttributeLabes['customer_id']    = DomainConst::CONTENT00088;
        $parentAttributeLabes['order_type']     = DomainConst::CONTENT00089;
        $parentAttributeLabes['description']    = DomainConst::CONTENT00090;
        $parentAttributeLabes['note']           = DomainConst::CONTENT00091;
        return $parentAttributeLabes;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('book_date', $this->book_date, true);
        $criteria->compare('payment_code', $this->payment_code, true);
        $criteria->compare('payment_date', $this->payment_date, true);
        $criteria->compare('order_date', $this->order_date, true);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('order_type', $this->order_type);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->order = 'id desc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Settings::getListPageSize(),
            ),
        ));
    }
    
    //-----------------------------------------------------
    // Parent methods
    //-----------------------------------------------------
    /**
     * Override before save
     * @return parent
     */
    protected function beforeSave() {
        $this->formatDate('book_date');
        $this->formatDate('payment_date');
        $this->formatDate('order_date');
        if ($this->isNewRecord) {
            $this->created_by = Yii::app()->user->id;
            
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        }
        
        return parent::beforeSave();
    }
    
    /**
     * Override before delete method
     * @return Parent result
     */
    protected function beforeDelete() {
        $retVal = parent::beforeDelete();
        // Check relation
        if (!empty($this->rDetails)) {
            foreach ($this->rDetails as $detail) {
                $detail->delete();
            }
        }
        return $retVal;
    }
    
    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Return status string
     * @return string Status value as string
     */
    public function getStatus() {
        if (isset(self::getArrayStatus()[$this->status])) {
            return self::getArrayStatus()[$this->status];
        }
        return '';
    }
    
    /**
     * Get customer name
     * @return String Customer name
     */
    public function getCustomer() {
        return $this->getRelationModelName('rCustomer');
    }
    
    /**
     * Get type of order
     * @return string Type of order
     */
    public function getType() {
        if (isset(CommonProcess::getTypeOfOrder()[$this->order_type])) {
            return CommonProcess::getTypeOfOrder()[$this->order_type];
        }
        return '';
    }
    
    /**
     * Get name of store card
     * @return String Name of store card
     */
    public function getName() {
        return CommonProcess::generateID(DomainConst::ORDER_ID_PREFIX, $this->id);
    }
    
    /**
     * Get value of book_date
     * @return String Book date value
     */
    public function getBookDate() {
        return CommonProcess::convertDateTime($this->book_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_BACK_END);
    }
    
    /**
     * Get value of payment_date
     * @return String Payment date value
     */
    public function getPaymentDate() {
        return CommonProcess::convertDateTime($this->payment_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_BACK_END);
    }
    
    /**
     * Get value of order_date
     * @return String Order date value
     */
    public function getOrderDate() {
        return CommonProcess::convertDateTime($this->order_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_BACK_END);
    }
    
    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Get status array
     * @return Array Array status of debt
     */
    public static function getArrayStatus() {
        return array(
            self::STATUS_INACTIVE       => DomainConst::CONTENT00408,
            self::STATUS_ACTIVE         => DomainConst::CONTENT00402,
            self::STATUS_PROCESSING     => DomainConst::CONTENT00555,
            self::STATUS_COMPLETED      => DomainConst::CONTENT00204,
        );
    }
    
    /**
     * Loads the type items for the specified type from the database
     * @param type $emptyOption boolean the item is empty
     * @return type List data
     */
    public static function loadItems($emptyOption = false) {
        $_items = array();
        if ($emptyOption) {
            $_items[""] = "";
        }
        $models = self::model()->findAll(array(
            'order' => 'id ASC',
        ));
        foreach ($models as $model) {
            if ($model->status == DomainConst::DEFAULT_STATUS_ACTIVE) {
                $_items[$model->id] = $model->getName();
            }
        }
        return $_items;
    }

}
