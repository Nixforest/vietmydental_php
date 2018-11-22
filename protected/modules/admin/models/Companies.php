<?php

/**
 * This is the model class for table "companies".
 *
 * The followings are the available columns in table 'companies':
 * @property string $id             Id of record
 * @property string $name           Name of company
 * @property string $open_date      Open date
 * @property string $tax_code       Tax code
 * @property string $address        Address
 * @property string $director       Id of director
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property Users                      $rDirector                      Director
 * @property Departments[]              $rDepartments                   List departments belong
 */
class Companies extends BaseActiveRecord {
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
    public $autocomplete_user;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Companies the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'companies';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, tax_code, address', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('name, tax_code, address', 'length', 'max' => 255),
            array('director', 'length', 'max' => 11),
            array('created_by', 'length', 'max' => 10),
            array('open_date, created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, open_date, tax_code, address, director, status, created_date, created_by', 'safe', 'on' => 'search'),
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
            'rDirector' => array(
                self::BELONGS_TO, 'Users', 'director',
                'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
            ),
            'rDepartments'  => array(
                self::HAS_MANY, 'Departments', 'company_id',
                'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
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
            'open_date'     => DomainConst::CONTENT00518,
            'tax_code'      => DomainConst::CONTENT00519,
            'address'       => DomainConst::CONTENT00045,
            'director'      => DomainConst::CONTENT00520,
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
        $criteria->compare('open_date', $this->open_date, true);
        $criteria->compare('tax_code', $this->tax_code, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('director', $this->director, true);
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
        $this->formatDate('open_date', DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_4);
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
     * Get Director
     * @return string Name of director
     */
    public function getDirector() {
        if (isset($this->rDirector)) {
            return $this->rDirector->getFullName();
        }
        return '';
    }
    
    /**
     * Get list departments
     * @return Departments[] List departments
     */
    public function getListDepartments() {
        if (isset($this->rDepartments)) {
            return $this->rDepartments;
        }
        return array();
    }
    
    /**
     * Get tree data
     * @return TreeElement Model of tree element
     */
    public function getTreeData() {
        $child = array();
        foreach ($this->getListDepartments() as $department) {
            $child[] = $department->getTreeData();
        }
        return TreeElement::create($this->id, $this->getName(), $child);
    }
    
    /**
     * Get html tree data
     * @return String Html string
     */
    public function getHtmlTreeData() {
        return $this->getTreeData()->getHtmlTree();
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
    
    /**
     * Load array models
     * @return Companies[] Array models
     */
    public static function loadArrModels() {
        return self::model()->findAll(array(
            'condition' => 'status !=:c',
            'order' => 'id ASC',
            'params'    => array(
                ':c'    => DomainConst::DEFAULT_STATUS_INACTIVE,
            ),
        ));
    }

}
