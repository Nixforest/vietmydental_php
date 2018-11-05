<?php

/**
 * This is the model class for table "hr_coefficients".
 *
 * The followings are the available columns in table 'hr_coefficients':
 * @property string $id             Id of record
 * @property integer $role_id       Id of role
 * @property string $name           Name of coefficient
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property Roles                      $rRole                          Role belong to
 * @property HrCoefficientValues[]      $rValues                        Values of coefficient
 * @property HrFunctions[]              $rFunctions                     List functions which using this coefficient
 */
class HrCoefficients extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = 0;
    /** Active */
    const STATUS_ACTIVE                 = 1;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return HrCoefficients the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hr_coefficients';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('role_id, status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('created_by', 'length', 'max' => 10),
            array('created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, role_id, name, status, created_date, created_by', 'safe', 'on' => 'search'),
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
            'rRole' => array(self::BELONGS_TO, 'Roles', 'role_id'),
            'rValues'   => array(
                self::HAS_MANY, 'HrCoefficientValues', 'coefficient_id',
                'on'    => 'status !=' . HrCoefficientValues::STATUS_INACTIVE,
                'order' => 'month desc',
            ),
            'rFunctions'    => array(
                self::MANY_MANY, 'HrFunctions', 'one_many(many_id, one_id)',
                'condition' => 'rFunctions_rFunctions.type=' . OneMany::TYPE_FUNCTION_COEFFICIENT,
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => 'ID',
            'role_id'       => DomainConst::CONTENT00488,
            'name'          => DomainConst::CONTENT00497,
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
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('name', $this->name, true);
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
        
        return parent::beforeSave();
    }
    
    /**
     * Override before delete method
     * @return Parent result
     */
    protected function beforeDelete() {
        $retVal = true;
        // Check foreign table hr_coefficient_values
        if (!empty($this->rValues)) {
            Loggers::error(DomainConst::CONTENT00214, 'Can not delete', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $this->addErrorMessage(DomainConst::CONTENT00498);
            return false;
        }
        // Check foreign table hr_functions
        if (!empty($this->rFunctions)) {
            Loggers::error(DomainConst::CONTENT00214, 'Can not delete', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $this->addErrorMessage(DomainConst::CONTENT00500);
            return false;
        }
        return $retVal;
    }
    
    /**
     * Override afterSave method
     */
    protected function afterSave() {
        // Update status of value records
        if (isset($this->rValues)) {
            foreach ($this->rValues as $value) {
                $value->status = $this->status;
                $value->save();
            }
        }
    }
    
    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Get created user
     * @return string
     */
    public function getCreatedBy() {
        if (isset($this->rCreatedBy)) {
            return $this->rCreatedBy->getFullName();
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
     * Get name of role
     * @return string Name of role
     */
    public function getRoleName() {
        if (isset(Roles::getRoleArrayForSalary()[$this->role_id])) {
            return Roles::getRoleArrayForSalary()[$this->role_id];
        }
        return '';
    }
    
    /**
     * Get value of coefficient
     * @param String $from  Date from
     * @param String $to    Date to
     * @return Float Value of coefficient
     */
    public function getValue($from = '', $to = '') {
        if (empty($from) && empty($to)) {
            if (isset($this->rValues) && (count($this->rValues) > 0)) {
                return $this->rValues[0]->getValue();
            }
        }
        if (empty($from)) {
            $from = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_DB);
        }
        if (empty($to)) {
            $to = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_DB);
        }
        $retVal = 0;
        return $retVal;
    }
    
    /**
     * Get all values
     * @return \CArrayDataProvider
     */
    public function getAllValues() {
        return new CArrayDataProvider($this->rValues, array(
            'id'    => 'hr_coefficients_values',
            'sort'  => array(
                'attributes'    => HrCoefficientValues::model()->getTableSchema()->getColumnNames(),
            ),
            'pagination' => array(
                'pageSize' => Settings::getListPageSize(),
            ),
        ));
    }
    
    /**
     * Get name
     * @return String Name
     */
    public function getName() {
        return $this->name;
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
     * Get models by role
     * @param Int $roleId Id of role
     * @return Array List of models
     */
    public static function getArrayByRole($roleId) {
        $retVal = array();
        if ($roleId != Roles::ROLE_ALL_ID) {
            $mRole = Roles::model()->findByPk($roleId);
            if ($mRole) {
                $retVal = $mRole->rCoefficients;
            }
        }
        $arrModel = self::model()->findAll(array(
            'condition' => 'role_id =' . Roles::ROLE_ALL_ID,
        ));
        if ($arrModel) {
            foreach ($arrModel as $value) {
                $retVal[] = $value;
            }
        }
        
        return $retVal;
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
    
    /**
     * Load model
     * @param String $role_id Id of role
     * @return HrParameters[] List model
     */
    public static function loadModels($role_id) {
        $models = self::model()->findAllByAttributes(array(
            'role_id' => $role_id,
        ));
        return $models;
    }

}
