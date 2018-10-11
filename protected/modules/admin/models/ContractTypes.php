<?php

/**
 * This is the model class for table "contract_types".
 *
 * The followings are the available columns in table 'contract_types':
 * @property string $id             Id of record
 * @property string $name           Name of type
 * @property string $description    Description
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 */
class ContractTypes extends BaseTypeRecords {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ContractTypes the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'contract_types';
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        $parentRelation = parent::relations();
        return $parentRelation;
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
        return $retVal;
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
