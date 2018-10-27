<?php

/**
 * This is the model class for table "hr_work_plans".
 *
 * The followings are the available columns in table 'hr_work_plans':
 * @property string $id                     Id of record
 * @property string $approved               Id of user approved
 * @property string $approved_date          Date of approved
 * @property string $notify                 Notify of user approved
 * @property integer $role_id               Id of role
 * @property string $date_from              Date from
 * @property string $date_to                Date to
 * @property integer $department_id         Id of department
 * @property string $agent_id               Id of agent
 * @property integer $status                Status
 * @property string $created_date           Created date
 * @property string $created_by             Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property Users                      $rApproved                      User was approved
 * @property Roles                      $rRole                          Role this record belong to
 * @property HrWorkSchedules[]          $rWorkSchedules                 Work schedules belong this record
 * @property Departments                $rDepartment                    Department belong to
 * @property Agents                     $rAgent                         Agent belong to
 */
class HrWorkPlans extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = 0;
    /** Active */
    const STATUS_ACTIVE                 = 1;
    /** Done */
    const STATUS_APPROVED               = 2;
    /** Cancel */
    const STATUS_CANCEL                 = 3;
    /** Required update */
    const STATUS_REQUIRED_UPDATE        = 4;
    
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $autocomplete_user;
    /**
     * Month value, use when search
     * @var String 
     */
    public $month;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return HrWorkPlans the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hr_work_plans';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date_from, date_to', 'required'),
            array('role_id, department_id, status', 'numerical', 'integerOnly' => true),
            array('approved, agent_id', 'length', 'max' => 11),
            array('created_by', 'length', 'max' => 10),
            array('approved_date, date_from, created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, approved, approved_date, notify, role_id, date_from, date_to, status, created_date, created_by, department_id, agent_id', 'safe', 'on' => 'search'),
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
            'rApproved' => array(self::BELONGS_TO, 'Users', 'approved'),
            'rRole' => array(self::BELONGS_TO, 'Roles', 'role_id'),
            'rWorkSchedules' => array(
                self::HAS_MANY, 'HrWorkSchedules', 'work_plan_id',
                'on'    => 'status !=' . HrWorkSchedules::STATUS_INACTIVE,
            ),
            'rDepartment'   => array(
                self::BELONGS_TO, 'Departments', 'department_id',
                'on'    => 'status !=' . Departments::STATUS_INACTIVE,
            ),
            'rAgent'        => array(
                self::BELONGS_TO, 'Agents', 'agent_id',
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
            'approved'      => DomainConst::CONTENT00474,
            'approved_date' => DomainConst::CONTENT00475,
            'notify'        => DomainConst::CONTENT00091,
            'role_id'       => DomainConst::CONTENT00488,
            'date_from'     => DomainConst::CONTENT00486,
            'date_to'       => DomainConst::CONTENT00487,
            'status'        => DomainConst::CONTENT00026,
            'created_date'  => DomainConst::CONTENT00010,
            'created_by'    => DomainConst::CONTENT00054,
            'department_id' => DomainConst::CONTENT00529,
            'month'         => DomainConst::CONTENT00470,
            'agent_id'      => DomainConst::CONTENT00199,
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
        $criteria->compare('approved', $this->approved, true);
        $criteria->compare('approved_date', $this->approved_date, true);
        $criteria->compare('notify', $this->notify, true);
        $criteria->compare('role_id', $this->role_id);
        $date = CommonProcess::convertDateTime($this->date_from, DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_DB);
        $criteria->compare('date_from', $date, true);
        $date = CommonProcess::convertDateTime($this->date_to, DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_DB);
        $criteria->compare('date_to', $date, true);
        $criteria->compare('department_id', $this->department_id, true);
        $criteria->compare('agent_id', $this->agent_id, true);
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
        $this->formatDate('approved_date');
        $this->formatDate('date_from', DomainConst::DATE_FORMAT_BACK_END,
            DomainConst::DATE_FORMAT_DB);
        $this->formatDate('date_to', DomainConst::DATE_FORMAT_BACK_END,
            DomainConst::DATE_FORMAT_DB);
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
        $retVal = parent::beforeDelete();
        // Check foreign key in table hr_work_schedules
        if (!empty($this->rWorkSchedules)) {
            foreach ($this->rWorkSchedules as $schedule) {
                $schedule->delete();
            }
        }
        return $retVal;
    }
    
    /**
     * Override afterSave method
     */
    protected function afterSave() {
        if (isset($this->rWorkSchedules)) {
            foreach ($this->rWorkSchedules as $workSchedule) {
                switch ($this->status) {
                    case self::STATUS_INACTIVE:
                        $workSchedule->status = HrWorkSchedules::STATUS_INACTIVE;
                        break;
                    case self::STATUS_ACTIVE:
                        $workSchedule->status = HrWorkSchedules::STATUS_ACTIVE;
                        break;
                    case self::STATUS_APPROVED:
                        $workSchedule->status = HrWorkSchedules::STATUS_APPROVED;
                        break;
                    case self::STATUS_CANCEL:
                        $workSchedule->status = HrWorkSchedules::STATUS_CANCEL;
                        break;

                    default:
                        $workSchedule->status = HrWorkSchedules::STATUS_ACTIVE;
                        break;
                }
                $workSchedule->save();
            }
        }
        
        // Send email inform
        $this->sendEmail();
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
     * Get approver email
     * @return string Email of approver
     */
    public function getApproverEmail() {
        if (isset($this->rApproved)) {
            return $this->rApproved->getEmail();
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
     * Get notify value
     * @return String Value of notify
     */
    public function getNotify() {
        return $this->notify;
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
        if (isset($this->rRole)) {
            return $this->rRole->role_short_name;
        }
        return '';
    }
    
    /**
     * Get user array
     * @return Users[] List users
     */
    public function getUserArray() {
        $arrUser = array();
        if (isset($this->rRole->rUser)) {
            $arrUser = $this->rRole->rUser;
        } else {
            $arrUser = Roles::getUserModelArrayForSalary();
        }
        // Search by department
        $retVal = $arrUser;
        if (!empty($this->department_id)) {
            $retVal = array();
            foreach ($arrUser as $user) {
                if ($user->department_id == $this->department_id) {
                    $retVal[] = $user;
                }
            }
        }
        // Search by agent
        $arrUser = $retVal;
        if (!empty($this->agent_id)) {
            $retVal = array();
            foreach ($arrUser as $user) {
                if ($user->isBelongAgent($this->agent_id)) {
                    $retVal[] = $user;
                }
            }
        }
        
        return $retVal;
    }
    
    /**
     * Get user_id array
     * @return String[] List users
     */
    public function getUserIdArray() {
        $retVal = array();
        foreach ($this->getUserArray() as $user) {
            $retVal[] = $user->id;
        }
        return $retVal;
    }
    
    /**
     * Get from date
     * @return String Date from value as Back-end format
     */
    public function getFromDate() {
        return CommonProcess::convertDateBackEnd($this->date_from);
    }
    
    /**
     * Get to date
     * @return String Date to value as Back-end format
     */
    public function getToDate() {
        return CommonProcess::convertDateBackEnd($this->date_to);
    }
    
    /**
     * Send email inform for user
     */
    public function sendEmail() {
        $userId = CommonProcess::getCurrentUserId();
        if (Roles::isAdminRole()) {
            // Update from administrator
            // Do nothing
        } else {
            switch ($userId) {
                case $this->approved:
                    case self::STATUS_APPROVED:
                    case self::STATUS_CANCEL:
                    case self::STATUS_REQUIRED_UPDATE:
                        // Send email
                        EmailHandler::sendApprovedWorkPlan($this, $this->rCreatedBy);
                    break;
                case $this->created_by:         // Current user is creator
                    // Send email to approver
                    switch ($this->status) {
                        case self::STATUS_APPROVED:
                            if (isset($this->rApproved)) {
                                // Send email
                                EmailHandler::sendReqApprovedWorkPlan($this, $this->rApproved);
                            }
                            break;

                        default:
                            break;
                    }
                    break;

                default:
                    break;
            }
        }
    }
    
    /**
     * Get department name
     * @return string Name of department
     */
    public function getDepartmentName() {
        if (isset($this->rDepartment)) {
            return $this->rDepartment->name;
        }
        return '';
    }
    
    /**
     * Get agent name
     * @return string Name of agent
     */
    public function getAgentName() {
        if (isset($this->rAgent)) {
            return $this->rAgent->name;
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
            self::STATUS_ACTIVE             => DomainConst::CONTENT00539,
            self::STATUS_APPROVED           => DomainConst::CONTENT00476,
            self::STATUS_CANCEL             => DomainConst::CONTENT00477,
            self::STATUS_REQUIRED_UPDATE    => DomainConst::CONTENT00478,
        );
    }
    
    /**
     * Get work plans by role
     * @param Int $roleId Id of role
     * @return Array List of work plans
     */
    public static function getWorkPlansByRole($roleId) {
        $mRole = Roles::model()->findByPk($roleId);
        if ($mRole) {
            return $mRole->rWorkPlans;
        }
        return array();
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
            if ($model->status != self::STATUS_INACTIVE) {
                $_items[$model->id] = $model->getRoleName() . ' [' . $model->date_from . ' -> ' . $model->date_to . ']';
            }
        }
        return $_items;
    }

}
