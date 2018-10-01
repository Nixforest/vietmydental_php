<?php

/**
 * This is the model class for table "hr_work_shifts".
 *
 * The followings are the available columns in table 'hr_work_shifts':
 * @property string $id             Id of record
 * @property string $name           Name of work shift
 * @property integer $from_id       Time from
 * @property integer $to_id         Time to
 * @property integer $role_id       Id of role
 * @property integer $type          Type of role
 * @property double $factor         Factor
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property Roles                      $rRole                          Role belong to
 * @property ScheduleTimes              $rFromTime                      Time from
 * @property ScheduleTimes              $rToTime                        Time to
 */
class HrWorkShifts extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = 0;
    /** Active */
    const STATUS_ACTIVE                 = 1;
    
    //-----------------------------------------------------
    // Type of work shift
    //-----------------------------------------------------
    /** Normal */
    const TYPE_NORMAL                   = '0';
    /** Type other */
    const TYPE_OTHER                    = '1';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return HrWorkShifts the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hr_work_shifts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, from_id, to_id, factor', 'required'),
            array('from_id, to_id, role_id, type, status', 'numerical', 'integerOnly' => true),
            array('factor', 'numerical'),
            array('name', 'length', 'max' => 255),
            array('created_by', 'length', 'max' => 10),
            array('created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, from_id, to_id, role_id, type, factor, status, created_date, created_by', 'safe', 'on' => 'search'),
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
            'rFromTime' => array(
                self::BELONGS_TO, 'ScheduleTimes', 'from_id',
            ),
            'rToTime' => array(
                self::BELONGS_TO, 'ScheduleTimes', 'to_id',
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => 'ID',
            'name'          => DomainConst::CONTENT00485,
            'from_id'       => DomainConst::CONTENT00486,
            'to_id'         => DomainConst::CONTENT00487,
            'role_id'       => DomainConst::CONTENT00488,
            'type'          => DomainConst::CONTENT00076,
            'factor'        => DomainConst::CONTENT00481,
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
        $criteria->compare('from_id', $this->from_id, true);
        $criteria->compare('to_id', $this->to_id, true);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('type', $this->type);
        $criteria->compare('factor', $this->factor);
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
     * Get type string
     * @return string Type value as string
     */
    public function getType() {
        if (isset(self::getArrayTypes()[$this->type])) {
            return self::getArrayTypes()[$this->type];
        }
        return '';
    }
    
    /**
     * Get from time
     * @return string From time value
     */
    public function getFromTime() {
        if (isset($this->rFromTime)) {
            return $this->rFromTime->name;
        }
        return '';
    }
    
    /**
     * Get to time
     * @return string To time value
     */
    public function getToTime() {
        if (isset($this->rToTime)) {
            return $this->rToTime->name;
        }
        return '';
    }
    
    /**
     * Get name of role
     * @return string Name of role
     */
    public function getRoleName() {
        if (isset($this->rRole)) {
            return $this->rRole->role_short_name;
        }
        return '';
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
     * Get array types
     * @return Array Types array
     */
    public static function getArrayTypes() {
        return array(
            self::TYPE_NORMAL       => DomainConst::CONTENT00489,
            self::TYPE_OTHER        => DomainConst::CONTENT00031,
        );
    }
    
    /**
     * Get work shifts by role
     * @param Int $roleId Id of role
     * @return Array List of work shifts
     */
    public static function getWorkShiftsByRole($roleId) {
        $mRole = Roles::model()->findByPk($roleId);
        if ($mRole) {
            return $mRole->rWorkShifts;
        }
        return array();
    }

}
