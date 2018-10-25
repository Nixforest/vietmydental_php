<?php

/**
 * This is the model class for table "roles".
 *
 * The followings are the available columns in table 'roles':
 * @property integer $id                Id of record
 * @property string $role_name          Name of role
 * @property string $role_short_name    Short name of role
 * @property integer $application_id    Id of application
 * @property integer $working_type      Type of working schedule
 * @property integer $status            Status
 *
 * The followings are the available model relations:
 * @property HrWorkShifts[]             $rWorkShifts        Array work shifts belong to this role
 * @property HrWorkPlans[]              $rWorkPlans         Array work plans belong to this role
 * @property HrParameters[]             $rParameters        Array parameters belong to this role
 * @property HrCoefficients[]           $rCoefficients      Array coefficients belong to this role
 * @property Users[]                    $rUser             Array users belong to this role
 */
class Roles extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Role all */
    const ROLE_ALL_ID                      = DomainConst::NUMBER_ZERO_VALUE;
    /** Role name */
    const ROLE_MANAGER                      = 'ROLE_MANAGER';
    const ROLE_ADMIN                        = 'ROLE_ADMIN';
    const ROLE_CUSTOMER                     = 'ROLE_CUSTOMER';
    const ROLE_MEMBER                       = 'ROLE_MEMBER';
    const ROLE_DIRECTOR                     = 'ROLE_DIRECTOR';
    const ROLE_DOCTOR                       = 'ROLE_DOCTOR';
    const ROLE_ASSISTANT                    = 'ROLE_ASSISTANT';
    const ROLE_RECEPTIONIST                 = 'ROLE_RECEPTIONIST';
    const ROLE_SALE                         = 'ROLE_SALE';
    const ROLE_DIRECTOR_AGENT               = 'ROLE_DIRECTOR_AGENT';
    const ROLE_ACCOUNT_MANAGER              = 'ROLE_ACCOUNT_MANAGER';

    /**
     * List administrator roles
     * @var Array 
     */
    static $arrAdminRoles = array(
        self::ROLE_ADMIN,
        self::ROLE_MANAGER,
    );
    /**
     * List roles no need reset password
     * @var Array 
     */
    static $arrRolesNotResetPass = array(
        self::ROLE_MANAGER,
        self::ROLE_ADMIN,
        self::ROLE_CUSTOMER
    );
    
    /**
     * List role is staff of company
     * @var Array 
     */
    static $arrRolesStaff = array(
        self::ROLE_DIRECTOR,
        self::ROLE_DOCTOR,
        self::ROLE_RECEPTIONIST,
        self::ROLE_ASSISTANT,
        self::ROLE_SALE,
    );
    
    //-----------------------------------------------------
    // Type of working schedule
    //-----------------------------------------------------
    /** Office hours */
    const TYPE_OFFICE_HOURSE            =   '1';
    /** Working shift */
    const TYPE_SHIFT_WORK               =   '2';
    /** Other */
    const TYPE_OTHER                    =   '3';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'roles';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('role_name, role_short_name, application_id', 'required'),
            array('application_id, status, working_type', 'numerical', 'integerOnly' => true),
            array('role_name, role_short_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, role_name, role_short_name, application_id, status, working_type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'application' => array(self::BELONGS_TO, 'Applications', 'application_id'),
            'rUser' => array(self::HAS_MANY, 'Users', 'role_id'),
            'rActionsRole' => array(self::HAS_MANY, 'ActionsRoles', 'role_id'),
            'rApiUserToken' => array(self::HAS_MANY, 'ApiUserTokens', 'role_id'),
            'rLoginLog' => array(self::HAS_MANY, 'LoginLogs', 'role_id'),
            'rWorkShifts' => array(
                self::HAS_MANY, 'HrWorkShifts', 'role_id',
                'on' => 'status !=' . HrWorkShifts::STATUS_INACTIVE,
            ),
            'rWorkPlans' => array(
                self::HAS_MANY, 'HrWorkPlans', 'role_id',
                'on' => 'status !=' . HrWorkPlans::STATUS_INACTIVE,
            ),
            'rParameters' => array(
                self::HAS_MANY, 'HrParameters', 'role_id',
                'on' => 'status !=' . HrParameters::STATUS_INACTIVE,
            ),
            'rCoefficients' => array(
                self::HAS_MANY, 'HrCoefficients', 'role_id',
                'on' => 'status !=' . HrCoefficients::STATUS_INACTIVE,
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'                => 'ID',
            'role_name'         => DomainConst::CONTENT00024,
            'role_short_name'   => DomainConst::CONTENT00025,
            'application_id'    => 'Application',
            'working_type'      => DomainConst::CONTENT00536,
            'status'            => DomainConst::CONTENT00026,
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('role_name', $this->role_name, true);
        if (CommonProcess::isUserAdmin()) {
            
        } else {
            $criteria->addCondition('t.role_name !="' . self::ROLE_ADMIN . '"');
            $criteria->addCondition('t.role_name !="' . self::ROLE_MANAGER . '"');
        }
        $criteria->compare('role_short_name', $this->role_short_name, true);
        $criteria->compare('application_id', $this->application_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('working_type', $this->working_type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Settings::getListPageSize(),
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Roles the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //-----------------------------------------------------
    // Parent override methods
    //-----------------------------------------------------
    /**
     * Override before delete method
     * @return Parent result
     */
    protected function beforeDelete() {
        $retVal = true;
        // Check foreign table action_roles
        $roles = ActionsRoles::model()->findByAttributes(array('role_id' => $this->id));
        if (count($roles) > 0) {
            $retVal = false;
        }
        // Check foreign table users
        $users = Users::model()->findByAttributes(array('role_id' => $this->id));
        if (count($users) > 0) {
            $retVal = false;
        }
        return $retVal;
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------   
    /**
     * Get working type string
     * @return string Working type
     */
    public function getWorkingType() {
        if (isset(self::getArrayWorkingType()[$this->working_type])) {
            return self::getArrayWorkingType()[$this->working_type];
        }
        return '';
    }
    
    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Loads the application items for the specified type from the database
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
                $_items[$model->id] = $model->role_short_name;
            }
        }
        return $_items;
    }

    /**
     * Get role by name
     * @param type $role_name
     * @return Roles
     */
    public static function getRoleByName($role_name) {
        return self::model()->find('LOWER(role_name)="' . strtolower($role_name) . '"');
    }

    /**
     * Check if a role id is in array admin roles
     * @param String $roleId Id of role (Default is empty => Get current user role)
     * @return boolean True if role id is in array admin roles, False otherwise
     */
    public static function isAdminRole($roleId = '') {
        if (empty($roleId)) {
            $roleId = CommonProcess::getCurrentRoleId();
        }
        foreach (self::$arrAdminRoles as $roleName) {
            if (self::getRoleByName($roleName)->id == $roleId) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if a role id is in array staff roles
     * @param String $roleId Id of role
     * @return boolean True if role id is in array staff roles, False otherwise
     */
    public static function isStaff($roleId) {
        foreach (self::$arrRolesStaff as $role_name) {
            if (self::getRoleByName($role_name)->id == $roleId) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if role is director
     * @param type $roleId
     * @return boolean
     */
    public static function isDirectorRole($roleId) {
        if (self::getRoleByName(self::ROLE_DIRECTOR) == $roleId) {
            return true;
        }
        return false;
    }

    /**
     * Check if role is doctor
     * @param String $roleId id of role
     * @return boolean
     */
    public static function isDoctorRole($roleId) {
        if (self::getRoleByName(self::ROLE_DOCTOR) == $roleId) {
            return true;
        }
        return false;
    }

    /**
     * Get role array for salary calculating
     * @return Array List roles
     */
    public static function getRoleArrayForSalary() {
        $_items = array();
        $_items[self::ROLE_ALL_ID] = DomainConst::CONTENT00409;
        $models = self::model()->findAll(array(
            'order' => 'id ASC',
        ));
        foreach ($models as $model) {
            if (($model->status == DomainConst::DEFAULT_STATUS_ACTIVE) && in_array($model->role_name, self::$arrRolesStaff)) {
                $_items[$model->id] = $model->role_short_name;
            }
        }
        return $_items;
    }
    
    /**
     * Get working type array
     * @return Array Array working type
     */
    public static function getArrayWorkingType() {
        return array(
            self::TYPE_OFFICE_HOURSE        => DomainConst::CONTENT00537,
            self::TYPE_SHIFT_WORK           => DomainConst::CONTENT00538,
            self::TYPE_OTHER                => DomainConst::CONTENT00031,
        );
    }

}
