<?php

/**
 * This is the model class for table "hr_leaves".
 *
 * The followings are the available columns in table 'hr_leaves':
 * @property string $id             Id of record
 * @property string $user_id        Id of user
 * @property string $start_date     Start date
 * @property string $end_date       End date
 * @property string $description    Description of user leave
 * @property string $approved       Id of approver
 * @property string $approved_date  Approved date
 * @property string $notify         Notify of approver
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property Users                      $rUser                          User was related with this record
 * @property Users                      $rApprover                      User was approved this record
 */
class HrLeaves extends HrActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = '0';
    /** Active */
    const STATUS_ACTIVE                 = '1';
    /** Approved */
    const STATUS_APPROVED               = '2';
    /** Cancel */
    const STATUS_CANCEL                 = '3';
    
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $autocomplete_user;
    public $autocomplete_approver;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return HrLeaves the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hr_leaves';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('user_id, created_by', 'length', 'max' => 10),
            array('approved', 'length', 'max' => 11),
            array('start_date, end_date, description, approved_date, created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, start_date, end_date, description, approved, approved_date, notify, status, created_date, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rCreatedBy'    => array(self::BELONGS_TO, 'Users', 'created_by'),
            'rUser'         => array(self::BELONGS_TO, 'Users', 'user_id'),
            'rApprover'     => array(self::BELONGS_TO, 'Users', 'approved'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => 'ID',
            'user_id'       => DomainConst::CONTENT00540,
            'start_date'    => DomainConst::CONTENT00139,
            'end_date'      => DomainConst::CONTENT00140,
            'description'   => DomainConst::CONTENT00062,
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
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('end_date', $this->end_date, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('approved_date', $this->approved_date, true);
        $criteria->compare('notify', $this->notify, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_date', $this->created_date, true);
        $userId = CommonProcess::getCurrentUserId();
        if (Roles::isAdminRole()) {
            $criteria->compare('created_by', $this->created_by, true);
            $criteria->compare('approved', $this->approved, true);
            $criteria->compare('user_id', $this->user_id, true);
        } else {
            $criteria->addCondition('created_by = ' . $userId, 'OR');
            $criteria->addCondition('approved = ' . $userId, 'OR');
            $criteria->addCondition('user_id = ' . $userId, 'OR');
        }
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
        $this->formatDate('start_date', DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_DB);
        $this->formatDate('end_date', DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_DB);
        if ($this->isNewRecord) {
            $this->created_by = CommonProcess::getCurrentUserId();
            
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        }
        
        return parent::beforeSave();
    }
    
    /**
     * Override afterSave method
     */
    protected function afterSave() {
        // Send email inform
        $this->sendEmail();
    }
    
    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Get name of approver
     * @return string Name of approver
     */
    public function getApproverName() {
        if (isset($this->rApprover)) {
            return $this->rApprover->getFullName();
        }
        return '';
    }
    
    /**
     * Get employee name
     * @return string Name of employee
     */
    public function getEmployee() {
        if (isset($this->rUser)) {
            return $this->rUser->getFullName();
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
     * Get creator email
     * @return string Email of creator
     */
    public function getCreatorEmail() {
        if (isset($this->rCreatedBy)) {
            return $this->rCreatedBy->getEmail();
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
     * Get employee email
     * @return string Email of employee
     */
    public function getEmployeeEmail() {
        if (isset($this->rUser)) {
            return $this->rUser->getEmail();
        }
        return '';
    }
    
    /**
     * Send email inform request was reviewed
     */
    public function sendEmailApproved() {
        switch ($this->status) {
            case self::STATUS_APPROVED:
            case self::STATUS_CANCEL:
                // Send to creator
                EmailHandler::sendApprovedHrLeave($this, $this->rCreatedBy);
                break;

            default:
                break;
        }
    }
    
    /**
     * Send email request review
     */
    public function sendEmailRequest() {
        switch ($this->status) {
            case self::STATUS_ACTIVE:
                // Send to approver
                if (isset($this->rApprover)) {
                    EmailHandler::sendReqApproveHrLeave($this, $this->rApprover);
                }
                break;

            default:
                break;
        }
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
                case $this->approved:           // Current user is approver
                    $this->sendEmailApproved();
                    break;
                case $this->created_by:         // Current user is creator
                    $this->sendEmailRequest();
                    break;

                default:
                    break;
            }
        }
    }
    
    /**
     * Get array status by user
     * @return Array Array status
     */
    public function getArrayStatusByUser() {
        $userId = CommonProcess::getCurrentUserId();
        if (Roles::isAdminRole()) {
            // Administrator
            return self::getArrayStatus();
        } else {
            switch ($userId) {
                case $this->approved:               // Current user is approver
                    return self::getArrayStatusPartial(array(
                        self::STATUS_APPROVED,
                        self::STATUS_CANCEL,
                    ));
                case $this->created_by:             // Current user is creator
                    return self::getArrayStatusPartial(array(
                        self::STATUS_ACTIVE,
                        self::STATUS_INACTIVE,
                    ));

                default:
                    break;
            }
        }
        return self::getArrayStatus();
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
     * Get partial of array status
     * @param Array $arrayId Array id of status
     * @return Array Array status
     */
    public static function getArrayStatusPartial($arrayId) {
        $retVal = array();
        foreach (self::getArrayStatus() as $key => $value) {
            if (in_array($key, $arrayId)) {
                $retVal[$key] = $value;
            }
        }
        return $retVal;
    }

}
