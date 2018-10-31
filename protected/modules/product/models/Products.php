<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'products':
 * @property string $id             Id of record
 * @property string $name           Name of type
 * @property string $code           Code of type
 * @property string $description    Description
 * @property integer $unit_id       Id of unit
 * @property integer $type_id       Id of type
 * @property integer $parent_id     Id of parent type
 * @property string $price          Price
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property Products                   $rParent                        Parent type
 * @property Products[]                 $rChildren                      Children products
 * @property Units                      $rUnit                          Unit
 * @property ProductTypes               $rType                          Product types
 * @property Files[]                    $rImages                        Images
 */
class Products extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = '0';
    /** Active */
    const STATUS_ACTIVE                 = '1';
    
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $order_number;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Products the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'products';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, unit_id', 'required'),
            array('unit_id, type_id, parent_id, status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('code', 'length', 'max' => 30),
            array('price', 'length', 'max' => 11),
            array('created_by', 'length', 'max' => 10),
            array('description, created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, code, description, unit_id, type_id, parent_id, price, status, created_date, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rCreatedBy' => array(self::BELONGS_TO, 'Users', 'created_by'),
            'rParent' => array(
                self::BELONGS_TO, 'Products', 'parent_id',
                'on'    => 'status !=' . self::STATUS_INACTIVE,
            ),
            'rChildren' => array(
                self::HAS_MANY, 'Products', 'parent_id',
                'on'    => 'status !=' . self::STATUS_INACTIVE,
            ),
            'rUnit' => array(
                self::BELONGS_TO, 'Units', 'unit_id',
            ),
            'rType' => array(
                self::BELONGS_TO, 'ProductTypes', 'type_id',
                'on'    => 'status !=' . self::STATUS_INACTIVE,
            ),
            'rImages' => array(    // Images
                self::HAS_MANY, 'Files', 'belong_id',
                'on' => 'type=' . Files::TYPE_4_PRODUCT_IMAGE,
                'order' => 'id DESC',
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => 'ID',
            'name'          => DomainConst::CONTENT00055,
            'code'          => DomainConst::CONTENT00056,
            'description'   => DomainConst::CONTENT00062,
            'unit_id'       => DomainConst::CONTENT00057,
            'type_id'       => DomainConst::CONTENT00058,
            'parent_id'     => DomainConst::CONTENT00065,
            'price'         => DomainConst::CONTENT00129,
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('unit_id', $this->unit_id);
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('parent_id', $this->parent_id);
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
            $this->created_by = CommonProcess::getCurrentUserId();
            
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        }
        $this->price = CommonProcess::getMoneyValue($this->price);
        Loggers::info('Attributes', $this->price, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        
        return parent::beforeSave();
    }
    
    /**
     * Override before delete method
     * @return Parent result
     */
    protected function beforeDelete() {
        // Check foreign table
        if (!empty($this->rChildren)) {
            Loggers::error(DomainConst::CONTENT00214, 'Can not delete', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $this->addErrorMessage(DomainConst::CONTENT00551);
            return false;
        }
        
        // Delete image
        if (isset($this->rImages)) {
            foreach ($this->rImages as $image) {
                $image->delete();
            }
        }
        return parent::beforeDelete();
    }
    
    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Get unit name
     * @return string Name of unit
     */
    public function getUnit() {
        if (isset($this->rUnit)) {
            return $this->rUnit->name;
        }
        return '';
    }
    /**
     * Get type name
     * @return string Name of unit
     */
    public function getType() {
        if (isset($this->rType)) {
            return $this->rType->name;
        }
        return '';
    }
    
    /**
     * Get parent
     * @return string Name of parent
     */
    public function getParent() {
        if (isset($this->rParent)) {
            return $this->rParent->name;
        }
        return '';
    }
    
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
                $_items[$model->id] = $model->name;
            }
        }
        return $_items;
    }

}
