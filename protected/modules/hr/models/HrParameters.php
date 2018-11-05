<?php

/**
 * This is the model class for table "hr_parameters".
 *
 * The followings are the available columns in table 'hr_parameters':
 * @property string $id             Id of record
 * @property integer $role_id       Id of role
 * @property string $method         Name of method
 * @property string $name           Name of parameter
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property Roles                      $rRole                          Role belong to
 * @property HrFunctions[]              $rFunctions                     List functions which using this parameter
 */
class HrParameters extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = 0;
    /** Active */
    const STATUS_ACTIVE                 = 1;
    /** Active */
    const STATUS_NOT_EXIST              = 2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return HrParameters the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hr_parameters';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('method, name', 'required'),
            array('role_id, status', 'numerical', 'integerOnly' => true),
            array('method, name', 'length', 'max' => 255),
            array('created_by', 'length', 'max' => 10),
            array('created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, role_id, method, name, status, created_date, created_by', 'safe', 'on' => 'search'),
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
            'rFunctions'    => array(
                self::MANY_MANY, 'HrFunctions', 'one_many(many_id, one_id)',
                'condition' => 'rFunctions_rFunctions.type=' . OneMany::TYPE_FUNCTION_PARAMETER,
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
            'method'        => DomainConst::CONTENT00494,
            'name'          => DomainConst::CONTENT00493,
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
        $criteria->compare('method', $this->method, true);
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
        // Check foreign table hr_functions
        if (!empty($this->rFunctions)) {
            Loggers::error(DomainConst::CONTENT00214, 'Can not delete', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $this->addErrorMessage(DomainConst::CONTENT00500);
            return false;
        }
        return $retVal;
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
     * Handle save model
     */
    public function handleSave() {
        if ($this->save()) {
            Loggers::info('Update status success', $this->status,
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        } else {
            Loggers::error('Update status failed', CommonProcess::json_encode_unicode($this->getErrors()),
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
    }
    
    /**
     * Check status of method
     */
    public function checkStatus() {
        if (!self::checkMethodExist(HrModule::USER_CLASS_NAME, 'hr', $this->method)) {
            // Method is not exist
            if ($this->status != self::STATUS_NOT_EXIST) {
                $this->status = self::STATUS_NOT_EXIST;
                $this->handleSave();
            }
        } else {
            // Method is exist
            if ($this->status != self::STATUS_ACTIVE) {
                $this->status = self::STATUS_ACTIVE;
                $this->handleSave();
            }
        }
    }
    
    /**
     * Get color of status text
     * @return String 'red' if status is NOT EXIST, 'black' otherwise
     */
    public function getColorStatus() {
        $this->checkStatus();
        if ($this->status == self::STATUS_NOT_EXIST) {
            return 'red';
        }
        return 'black';
    }
    
    /**
     * Return status string
     * @return string Status value as string
     */
    public function getStatus() {
        $this->checkStatus();
        
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
     * Get value of parameter
     * @param String $from  Date from
     * @param String $to    Date to
     * @param Model $mUser  User model
     * @return Float Value of parameter
     */
    public function getValue($from, $to, $mUser) {
        $retVal = $mUser->{$this->method}($from, $to);
        return $retVal;
    }
    
    /**
     * Get name of parameter
     * @return String Name of parameter
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
            self::STATUS_NOT_EXIST      => DomainConst::CONTENT00560,
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
                $retVal = $mRole->rParameters;
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
