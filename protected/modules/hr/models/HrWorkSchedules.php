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
    /** Cancel */
    const STATUS_CANCEL                 = 3;
    
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
        $date = CommonProcess::convertDateTime($this->work_day, DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_DB);
        $criteria->compare('work_day', $date, true);
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
        $this->formatDate('work_day', DomainConst::DATE_FORMAT_BACK_END,
            DomainConst::DATE_FORMAT_4);
        if ($this->isNewRecord) {
            $this->created_by = Yii::app()->user->id;
            
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        }
        if ($this->status == self::STATUS_APPROVED
                || $this->status == self::STATUS_ACTIVE) {
            switch ($this->rWorkPlan->status) {
                case HrWorkPlans::STATUS_INACTIVE:
                    $this->status = self::STATUS_INACTIVE;
                    break;
                case HrWorkPlans::STATUS_ACTIVE:
                    $this->status = self::STATUS_ACTIVE;
                    break;
                case HrWorkPlans::STATUS_APPROVED:
                    $this->status = self::STATUS_APPROVED;
                    break;
                case HrWorkPlans::STATUS_CANCEL:
                    $this->status = self::STATUS_CANCEL;
                    break;

                default:
                    $this->status = self::STATUS_ACTIVE;
                    break;
            }
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
    public function getWorkShiftName() {
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
    
    /**
     * Get work date
     * @return String Date work value as Back-end format
     */
    public function getWorkDay() {
        return CommonProcess::convertDateBackEnd($this->work_day);
    }
    
    /**
     * Check if model status is APPROVED
     * @return boolean True if status is APPROVED, false otherwise
     */
    public function isApproved() {
        return $this->status == self::STATUS_APPROVED;
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
            self::STATUS_ACTIVE             => DomainConst::CONTENT00539,
            self::STATUS_APPROVED           => DomainConst::CONTENT00476,
            self::STATUS_CANCEL             => DomainConst::CONTENT00477,
        );
    }
    
    /**
     * Get work shift model
     * @param String $user_id Id of user
     * @param String $date Date value (format Y-m-d)
     * @return HrWorkShifts Return model if found, NULL otherwise
     */
    public static function getWorkShift($user_id, $date, $arrStatus = array()) {
        $criteria = new CDbCriteria();
        $criteria->compare('t.work_day', $date, true);
        $criteria->compare('t.employee_id', $user_id, true);
        if (!empty($arrStatus)) {
            $criteria->addInCondition('t.status', $arrStatus);
        } else {
            $criteria->addCondition('t.status != ' . self::STATUS_INACTIVE);
        }
        
        $model = self::model()->find($criteria);
        if ($model) {
            Loggers::info('Found workshift', '', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            if ($model->isApproved()) {
                return $model->rWorkShift;
            }
        }
        return NULL;
    }

}
