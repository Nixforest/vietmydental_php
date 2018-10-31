<?php

/**
 * This is the model class for table "product_store_card_types".
 *
 * The followings are the available columns in table 'product_store_card_types':
 * @property string $id             Id of record
 * @property string $name           Name of type
 * @property string $code           Code of type
 * @property integer $parent_id     Id of parent type
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property ProductStoreCardTypes      $rParent                        Parent type
 * @property ProductStoreCardTypes[]    $rChildren                      Children type
 * @property ProductStoreCards[]        $rStoreCards                    List store card
 */
class ProductStoreCardTypes extends BaseTypeRecords {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProductStoreCardTypes the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product_store_card_types';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('parent_id, status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('code', 'length', 'max' => 30),
            array('created_by', 'length', 'max' => 10),
            array('created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, code, parent_id, status, created_date, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        $parentRelation = parent::relations();
        $parentRelation['rParent']  = array(
            self::BELONGS_TO, 'ProductStoreCardTypes', 'parent_id',
            'on'    => 'status !=' . self::STATUS_INACTIVE,
        );
        $parentRelation['rChildren'] = array(
            self::HAS_MANY, 'ProductStoreCardTypes', 'parent_id',
            'on'    => 'status !=' . self::STATUS_INACTIVE,
        );
        $parentRelation['rStoreCards']   = array(
            self::HAS_MANY, 'ProductStoreCards', 'type_id',
            'on'    => 'status !=' . self::STATUS_INACTIVE,
        );
        return $parentRelation;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        $parentAttributeLabes               = parent::attributeLabels();
        $parentAttributeLabes['code']       = DomainConst::CONTENT00003;
        $parentAttributeLabes['parent_id']  = DomainConst::CONTENT00065;
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

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('parent_id', $this->parent_id);
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
     * Override before delete method
     * @return Parent result
     */
    protected function beforeDelete() {
        $retVal = parent::beforeDelete();
        // Check foreign table
        if (!empty($this->rStoreCards)) {
            Loggers::error(DomainConst::CONTENT00214, 'Can not delete', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $this->addErrorMessage(DomainConst::CONTENT00554);
            return false;
        }
        return $retVal;
    }
    
    /**
     * Get parent
     * @return string Name of parent
     */
    public function getParent() {
        return $this->getRelationModelName('rParent');
    }
    
    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
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
