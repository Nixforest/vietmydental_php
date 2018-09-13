<?php

/**
 * This is the model class for table "roles".
 *
 * The followings are the available columns in table 'roles':
 * @property integer $id
 * @property string $role_name
 * @property string $role_short_name
 * @property integer $application_id
 * @property integer $status
 */
class Roles extends BaseActiveRecord
{
    /** Role name */
    const ROLE_MANAGER              = 'ROLE_MANAGER';
    const ROLE_ADMIN                = 'ROLE_ADMIN';
    const ROLE_CUSTOMER             = 'ROLE_CUSTOMER';
    const ROLE_MEMBER               = 'ROLE_MEMBER';
    const ROLE_DIRECTOR             = 'ROLE_DIRECTOR';
    const ROLE_DOCTOR               = 'ROLE_DOCTOR';
    const ROLE_ASSISTANT            = 'ROLE_ASSISTANT';
    const ROLE_RECEPTIONIST         = 'ROLE_RECEPTIONIST';
    const ROLE_SALE                 = 'ROLE_SALE';
    const ROLE_DIRECTOR_AGENT       = 'ROLE_DIRECTOR_AGENT';
    const ROLE_ACCOUNT_MANAGER      = 'ROLE_ACCOUNT_MANAGER';
    
    static $arrAdminRoles           = array(
        self::ROLE_ADMIN,
        self::ROLE_MANAGER,
    );
    static $arrRolesNotResetPass    = array(
        self::ROLE_MANAGER,
        self::ROLE_ADMIN,
        self::ROLE_CUSTOMER
    );
    static $arrRolesStaff           = array(
        self::ROLE_DIRECTOR,
        self::ROLE_DOCTOR,
        self::ROLE_RECEPTIONIST,
        self::ROLE_ASSISTANT,
        self::ROLE_SALE,
    );
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_name, role_short_name, application_id', 'required'),
			array('application_id, status', 'numerical', 'integerOnly'=>true),
			array('role_name, role_short_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, role_name, role_short_name, application_id, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'application'   => array(self::BELONGS_TO, 'Applications', 'application_id'),
                    'rUser'         => array(self::HAS_MANY, 'Users', 'role_id'),
                    'rActionsRole'  => array(self::HAS_MANY, 'ActionsRoles', 'role_id'),
                    'rApiUserToken'  => array(self::HAS_MANY, 'ApiUserTokens', 'role_id'),
                    'rLoginLog'  => array(self::HAS_MANY, 'LoginLogs', 'role_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'role_name' => DomainConst::CONTENT00024,
			'role_short_name' => DomainConst::CONTENT00025,
			'application_id' => 'Application',
			'status' => DomainConst::CONTENT00026,
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('role_name',$this->role_name,true);
                if (CommonProcess::isUserAdmin()) {
                    
                } else {
                    $criteria->addCondition('t.role_name !="' . self::ROLE_ADMIN . '"');
                    $criteria->addCondition('t.role_name !="' . self::ROLE_MANAGER . '"');
                }
		$criteria->compare('role_short_name',$this->role_short_name,true);
		$criteria->compare('application_id',$this->application_id);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
	public static function model($className=__CLASS__)
	{
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
     * @return Role object
     */
    public static function getRoleByName($role_name) {
        return self::model()->find('LOWER(role_name)="'.  strtolower($role_name).'"');
    }
    
    /**
     * Check if a role id is in array admin roles
     * @param String $roleId Id of role
     * @return boolean True if role id is in array admin roles, False otherwise
     */
    public static function isAdminRole($roleId) {
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
}
