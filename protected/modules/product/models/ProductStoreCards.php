<?php

/**
 * This is the model class for table "product_store_cards".
 *
 * The followings are the available columns in table 'product_store_cards':
 * @property string $id             Id of record
 * @property string $input_date     Date input
 * @property integer $store_id      Id of store
 * @property integer $type_id       Id of type
 * @property integer $order_id      Id of order relate
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property ProductStores              $rStore                         Store
 * @property ProductStoreCardTypes      $rType                          ProductStoreCardTypes
 */
class ProductStoreCards extends BaseActiveRecord {
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
     * @return ProductStoreCards the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product_store_cards';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('store_id', 'required'),
            array('store_id, type_id, order_id, status', 'numerical', 'integerOnly' => true),
            array('created_by', 'length', 'max' => 10),
            array('input_date, created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, input_date, store_id, type_id, order_id, status, created_date, created_by', 'safe', 'on' => 'search'),
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
        $parentRelation['rType'] = array(
            self::BELONGS_TO, 'ProductStoreCardTypes', 'type_id',
            'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
        );
        return $parentRelation;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        $parentAttributeLabes               = parent::attributeLabels();
        $parentAttributeLabes['input_date'] = DomainConst::CONTENT00074;
        $parentAttributeLabes['store_id']   = DomainConst::CONTENT00552;
        $parentAttributeLabes['type_id']    = DomainConst::CONTENT00076;
        $parentAttributeLabes['order_id']   = DomainConst::CONTENT00077;
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
        $criteria->compare('input_date', $this->input_date, true);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('order_id', $this->order_id);
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
        $this->formatDate('input_date');
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
     * Get store name
     * @return String Store name
     */
    public function getStore() {
        return $this->getRelationModelName('rStore');
    }
    
    /**
     * Get type name
     * @return String Type name
     */
    public function getType() {
        return $this->getRelationModelName('rType');
    }
    
    /**
     * Get input date
     * @return String Input date
     */
    public function getInputDate() {
        return $this->input_date;
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
