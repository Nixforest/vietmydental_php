<?php

/**
 * This is the model class for table "product_stores_details".
 *
 * The followings are the available columns in table 'product_stores_details':
 * @property string $id             Id of record
 * @property integer $store_id      Id of store
 * @property integer $product_id    Id of product
 * @property string $qty            Quantity
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property ProductStores              $rStore                         Store
 * @property Products                   $rProduct                       Product
 */
class ProductStoresDetails extends BaseActiveRecord {
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
     * @return ProductStoresDetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product_stores_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('store_id, product_id, qty', 'required'),
            array('store_id, product_id, status', 'numerical', 'integerOnly' => true),
            array('qty', 'length', 'max' => 11),
            array('created_by', 'length', 'max' => 10),
            array('created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, store_id, product_id, qty, status, created_date, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        $parentRelation = parent::relations();
        $parentRelation['rStore'] = array(
            self::BELONGS_TO, 'ProductStores', 'store_id',
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
        return array(
            'id'            => 'ID',
            'store_id'      => DomainConst::CONTENT00552,
            'product_id'    => DomainConst::CONTENT00550,
            'qty'           => DomainConst::CONTENT00083,
            'status'        => DomainConst::CONTENT00026,
            'created_date'  => DomainConst::CONTENT00010,
            'created_by'    => DomainConst::CONTENT00054,
        );
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
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('qty', $this->qty, true);
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
        
        return parent::beforeSave();
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
     * Get store name
     * @return String Store name
     */
    public function getStore() {
        return $this->getRelationModelName('rStore');
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
