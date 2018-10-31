<?php

/**
 * This is the model class for table "product_order_details".
 *
 * The followings are the available columns in table 'product_order_details':
 * @property string $id             Id of record
 * @property string $order_id       Id of order
 * @property integer $product_id    Id of product
 * @property string $qty            Quantity
 * @property string $price          Price
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property ProductOrders              $rOrder                         User created this record
 * @property Products                   $rProduct                       Product
 */
class ProductOrderDetails extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = '0';
    /** Active */
    const STATUS_ACTIVE                 = '1';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProductOrderDetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product_order_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id, product_id, qty', 'required'),
            array('product_id, status', 'numerical', 'integerOnly' => true),
            array('order_id, created_by', 'length', 'max' => 10),
            array('qty, price', 'length', 'max' => 11),
            array('created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, order_id, product_id, qty, price, status, created_date, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        $parentRelation = parent::relations();
        $parentRelation['rOrder'] = array(
            self::BELONGS_TO, 'ProductOrders', 'order_id',
            'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
        );
        $parentRelation['rProduct'] = array(
            self::BELONGS_TO, 'Products', 'product_id',
            'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
        );
        
        return $parentRelation;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        $parentAttributeLabes               = parent::attributeLabels();
        $parentAttributeLabes['order_id']   = DomainConst::CONTENT00077;
        $parentAttributeLabes['product_id'] = DomainConst::CONTENT00550;
        $parentAttributeLabes['qty']        = DomainConst::CONTENT00083;
        $parentAttributeLabes['price']      = DomainConst::CONTENT00129;
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
        $criteria->compare('order_id', $this->order_id, true);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('qty', $this->qty, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_date', $this->created_date, true);
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
        if ($this->isNewRecord) {
            $this->created_by = Yii::app()->user->id;
            
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        }
        $this->qty = CommonProcess::getMoneyValue($this->qty);
        $this->price = CommonProcess::getMoneyValue($this->price);
        
        return parent::beforeSave();
    }
    
    /**
     * Override before delete method
     * @return Parent result
     */
    protected function beforeDelete() {
        $retVal = parent::beforeDelete();
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
     * Get order name
     * @return String Order name
     */
    public function getOrder() {
        return $this->getRelationModelName('rOrder');
    }
    
    /**
     * Get product name
     * @return String Name of product
     */
    public function getProduct() {
        return $this->getRelationModelName('rProduct');
    }
    
    /**
     * Get quantity
     * @return Number Quantity value
     */
    public function getQuantity() {
        return $this->qty;
    }
    
    /**
     * Get price
     * @return String Price value
     */
    public function getPrice() {
        return CommonProcess::formatCurrency($this->price);
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
            self::STATUS_ACTIVE         => DomainConst::CONTENT00407,
        );
    }

}