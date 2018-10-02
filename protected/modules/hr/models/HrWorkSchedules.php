<?php

/**
 * This is the model class for table "hr_work_schedules".
 *
 * The followings are the available columns in table 'hr_work_schedules':
 * @property string $id             Id of record
 * @property string $work_day       Work date
 * @property integer $work_shift_id Id of work shift
 * @property integer $work_plan_id  Id of work plan
 * @property string $employee_id    Id of employee
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                  $rCreatedBy         User created this record
 * @property Users                  $rUser              User was scheduled
 * @property HrWorkShifts           $rWorkShift         Work shift model relate with this record
 * @property HrWorkPlans            $rWorkPlan          Work plan model relate with this record
 */
class HrWorkSchedules extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = 0;
    /** Active */
    const STATUS_ACTIVE                 = 1;
    /** Approved */
    const STATUS_APPROVED               = 2;
    
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $autocomplete_user;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return HrWorkSchedules the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hr_work_schedules';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('work_day', 'required'),
            array('work_shift_id, work_plan_id, status', 'numerical', 'integerOnly' => true),
            array('employee_id', 'length', 'max' => 11),
            array('created_by', 'length', 'max' => 10),
            array('created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, work_day, work_shift_id, work_plan_id, employee_id, status, created_date, created_by', 'safe', 'on' => 'search'),
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
            'rUser' => array(self::BELONGS_TO, 'Users', 'employee_id'),
            'rWorkShift' => array(
                self::BELONGS_TO, 'HrWorkShifts', 'work_shift_id',
                'on'    => 'status !=' . HrWorkShifts::STATUS_INACTIVE,
            ),
            'rWorkPlan' => array(
                self::BELONGS_TO, 'HrWorkPlans', 'work_plan_id',
                'on'    => 'status !=' . HrWorkPlans::STATUS_INACTIVE,
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => 'ID',
            'work_day'      => DomainConst::CONTENT00483,
            'work_shift_id' => DomainConst::CONTENT00491,
            'work_plan_id'  => DomainConst::CONTENT00492,
            'employee_id'   => DomainConst::CONTENT00490,
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
        $criteria->compare('work_day', $this->work_day, true);
        $criteria->compare('work_shift_id', $this->work_shift_id);
        $criteria->compare('work_plan_id', $this->work_plan_id);
        $criteria->compare('employee_id', $this->employee_id, true);
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
        $date = $this->work_day;
        $this->work_day = CommonProcess::convertDateTime($date,
            DomainConst::DATE_FORMAT_BACK_END,
            DomainConst::DATE_FORMAT_4);
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
     * Get work shift name
     * @return string Name of work shift
     */
    public function getWorkShift() {
        if (isset(HrWorkShifts::loadItems()[$this->work_shift_id])) {
            return HrWorkShifts::loadItems()[$this->work_shift_id];
        }
        return '';
    }
    
    /**
     * Get work plan name
     * @return string Name of work plan
     */
    public function getWorkPlan() {
        if (isset(HrWorkPlans::loadItems()[$this->work_plan_id])) {
            return HrWorkPlans::loadItems()[$this->work_plan_id];
        }
        return '';
    }
    
    /**
     * Get user name
     * @return string Name of user
     */
    public function getUserName() {
        if (isset($this->rUser)) {
            return $this->rUser->getFullName();
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
            self::STATUS_INACTIVE           => DomainConst::CONTENT00408,
            self::STATUS_ACTIVE             => DomainConst::CONTENT00407,
            self::STATUS_APPROVED           => DomainConst::CONTENT00476,
        );
    }

}
