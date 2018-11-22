<?php

/**
 * This is the model class for table "departments".
 *
 * The followings are the available columns in table 'departments':
 * @property string $id             Id of record
 * @property string $name           Name of department
 * @property integer $type_id       Id of department_type
 * @property integer $company_id    Id of company
 * @property string $manager        Id of manager
 * @property string $sub_manager    Id of sub_manager
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property DepartmentTypes            $rType                          Department type model
 * @property Companies                  $rCompany                       Company model
 * @property Users                      $rManager                       Manager
 * @property Users                      $rSubManager                    Sub manager
 * @property Users[]                    $rUsers                         List users belong
 */
class Departments extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = 0;
    /** Active */
    const STATUS_ACTIVE                 = 1;
    
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $autocomplete_manager;
    public $autocomplete_sub_manager;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Departments the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'departments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, type_id, company_id', 'required'),
            array('type_id, company_id, status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('manager, sub_manager', 'length', 'max' => 11),
            array('created_by', 'length', 'max' => 10),
            array('created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, type_id, company_id, manager, sub_manager, status, created_date, created_by', 'safe', 'on' => 'search'),
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
            'rType'     => array(
                self::BELONGS_TO, 'DepartmentTypes', 'type_id',
                'on'    => 'status !=' . DepartmentTypes::STATUS_INACTIVE,
            ),
            'rCompany'  => array(
                self::BELONGS_TO, 'Companies', 'company_id',
                'on'    => 'status !=' . Companies::STATUS_INACTIVE,
            ),
            'rManager'  => array(
                self::BELONGS_TO, 'Users', 'manager',
                'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
            ),
            'rSubManager'  => array(
                self::BELONGS_TO, 'Users', 'sub_manager',
                'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
            ),
            'rUsers'  => array(
                self::HAS_MANY, 'Users', 'department_id',
                'on'    => 'status !=' . DomainConst::NUMBER_ZERO_VALUE,
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => 'ID',
            'name'          => DomainConst::CONTENT00042,
            'type_id'       => DomainConst::CONTENT00522,
            'company_id'    => DomainConst::CONTENT00526,
            'manager'       => DomainConst::CONTENT00527,
            'sub_manager'   => DomainConst::CONTENT00528,
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

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('company_id', $this->company_id);
        $criteria->compare('manager', $this->manager, true);
        $criteria->compare('sub_manager', $this->sub_manager, true);
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
     * Get manager
     * @return string Name of manager
     */
    public function getManager() {
        if (isset($this->rManager)) {
            return $this->rManager->getFullName();
        }
        return '';
    }
    
    /**
     * Get sub manager
     * @return string Name of sub manager
     */
    public function getSubManager() {
        if (isset($this->rSubManager)) {
            return $this->rSubManager->getFullName();
        }
        return '';
    }
    
    /**
     * Get type
     * @return String Type name
     */
    public function getType() {
        return isset($this->rType) ? $this->rType->name : '';
    }
    
    /**
     * Get company
     * @return String Company name
     */
    public function getCompany() {
        return isset($this->rCompany) ? $this->rCompany->name : '';
    }
    
    /**
     * Get name of department
     * @return String Name of department
     */
    public function getName() {
        return DomainConst::CONTENT00530 . ' ' . $this->name;
    }
    
    /**
     * Get full name
     * @return String Full name
     */
    public function getFullName() {
        return DomainConst::CONTENT00530 . ' ' . $this->name . ' - ' . $this->getCompany();
    }
    
    /**
     * Get list users
     * @return Users[] List users
     */
    public function getListUsers() {
        if (isset($this->rUsers)) {
            return Roles::sortArrUsersByRoleWeight($this->rUsers);
        }
        return array();
    }
    
    /**
     * Get tree data
     * @return TreeElement Model of tree element
     */
    public function getTreeData() {
        $child = array();
        foreach ($this->getListUsers() as $user) {
            $treeElement = TreeElement::create($user->id, $user->getFullName(), array());
            $child[] = $treeElement;
        }
        return TreeElement::create($this->id, $this->getName(), $child);
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
     * Loads items for the specified type from the database
     * @param type $emptyOption boolean the item is empty
     * @return type List data
     */
    public static function loadItems($emptyOption = false) {
        $_items = array();
        if ($emptyOption) {
            $_items[""] = "";
        }
        $models = self::model()->findAll(array(
            'order' => 'name ASC',
        ));
        foreach ($models as $model) {
            $_items[$model->id] = $model->getFullName();
        }
        return $_items;
    }

}
