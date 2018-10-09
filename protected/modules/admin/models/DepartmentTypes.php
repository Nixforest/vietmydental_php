<?php

/**
 * This is the model class for table "department_types".
 *
 * The followings are the available columns in table 'department_types':
 * @property string $id             Id of record
 * @property string $name           Name of type
 * @property string $description    Description
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property Departments[]              $rDepartments                   List departments
 */
class DepartmentTypes extends BaseTypeRecords {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DepartmentTypes the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'department_types';
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        $parentRelation = parent::relations();
        $parentRelation['rDepartments'] = array(
            self::HAS_MANY, 'Departments', 'type_id',
            'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
        );
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
        // Check foreign key in table departments
        if (!empty($this->rDepartments)) {
            Loggers::error(DomainConst::CONTENT00214, 'Can not delete', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $this->addErrorMessage(DomainConst::CONTENT00521);
            return false;
        }
        return $retVal;
    }

}
