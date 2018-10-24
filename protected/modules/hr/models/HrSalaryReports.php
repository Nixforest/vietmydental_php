<?php

/**
 * This is the model class for table "hr_salary_reports".
 *
 * The followings are the available columns in table 'hr_salary_reports':
 * @property string $id             Id of record
 * @property string $name           Name of report
 * @property string $start_date     Date start
 * @property string $end_date       Date end
 * @property integer $role_id       Id of role
 * @property integer $type_id       Id of type
 * @property string $data           Data
 * @property string $approved       User approved
 * @property string $approved_date  Date approved
 * @property string $notify         Notify
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property Roles                      $rRole                          Role belong to
 * @property HrFunctionTypes            $rType                          HrFunctionTypes belong to
 * @property Users                      $rApproved                      User was approved
 */
class HrSalaryReports extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = 0;
    /** Active */
    const STATUS_ACTIVE                 = 1;
    /** Request */
    const STATUS_REQUEST                = 2;
    /** Approved */
    const STATUS_APPROVED               = 3;
    /** Final */
    const STATUS_FINAL                  = 4;
    
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $autocomplete_user;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return HrSalaryReports the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hr_salary_reports';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, type_id', 'required'),
            array('role_id, type_id, status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('approved', 'length', 'max' => 11),
            array('created_by', 'length', 'max' => 10),
            array('start_date, end_date, data, approved_date, created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, start_date, end_date, role_id, type_id, data, approved, approved_date, notify, status, created_date, created_by', 'safe', 'on' => 'search'),
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
            'rType' => array(
                self::BELONGS_TO, 'HrFunctionTypes', 'type_id',
                'on'    => 'status !=' . HrFunctionTypes::STATUS_INACTIVE,
            ),
            'rApproved' => array(
                self::BELONGS_TO, 'Users', 'approved',
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
            'start_date'    => DomainConst::CONTENT00139,
            'end_date'      => DomainConst::CONTENT00140,
            'role_id'       => DomainConst::CONTENT00488,
            'type_id'       => DomainConst::CONTENT00502,
            'data'          => 'Data',
            'approved'      => DomainConst::CONTENT00474,
            'approved_date' => DomainConst::CONTENT00475,
            'notify'        => DomainConst::CONTENT00091,
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
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('end_date', $this->end_date, true);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('data', $this->data, true);
        $criteria->compare('approved', $this->approved, true);
        $criteria->compare('approved_date', $this->approved_date, true);
        $criteria->compare('notify', $this->notify, true);
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
        $this->formatDate('approved_date', DomainConst::DATE_FORMAT_BACK_END);
        $this->formatDate('start_date', DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_4);
        $this->formatDate('end_date', DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_4);
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
     * Get name of approver
     * @return string Name of approver
     */
    public function getApproverName() {
        if (isset($this->rApproved)) {
            return $this->rApproved->getFullName();
        }
        return '';
    }
    
    /**
     * Get approved date
     * @param String $format Format of date
     * @return String Approved date string (default format is Back-end Date-format)
     */
    public function getApprovedDate($format = DomainConst::DATE_FORMAT_BACK_END) {
        return CommonProcess::convertDateTime($this->approved_date, DomainConst::DATE_FORMAT_1, $format);
    }
    
    /**
     * Check if this plan is approved
     * @return boolean True if status is Approved, false otherwise
     */
    public function isApproved() {
        return ($this->status == self::STATUS_APPROVED);
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
     * Get type
     * @return String Type name
     */
    public function getType() {
        return isset($this->rType) ? $this->rType->name : '';
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
            self::STATUS_ACTIVE         => DomainConst::CONTENT00514,
            self::STATUS_REQUEST        => DomainConst::CONTENT00515,
            self::STATUS_APPROVED       => DomainConst::CONTENT00476,
            self::STATUS_FINAL          => DomainConst::CONTENT00516,
        );
    }

}
