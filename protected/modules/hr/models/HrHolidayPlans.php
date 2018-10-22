<?php

/**
 * This is the model class for table "hr_holiday_plans".
 *
 * The followings are the available columns in table 'hr_holiday_plans':
 * @property string $id                     Id of record
 * @property string $approved               Id of user approved
 * @property string $approved_date          Date of approved
 * @property string $notify                 Notify of user approved
 * @property integer $status                Status
 * @property string $created_date           Created date
 * @property string $created_by             Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property Users                      $rApproved                      User was approved
 */
class HrHolidayPlans extends BaseActiveRecord {
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
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return HrHolidayPlans the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hr_holiday_plans';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, notify', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('id, created_by', 'length', 'max' => 10),
            array('approved', 'length', 'max' => 11),
            array('approved_date, created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, approved, approved_date, notify, status, created_date, created_by', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => DomainConst::CONTENT00479,
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
        $criteria->compare('approved_date', $this->approved_date, true);
        $criteria->compare('notify', $this->notify, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_date', $this->created_date, true);
        if (Roles::isAdminRole(CommonProcess::getCurrentRoleId())) {
            // Admin user
            $criteria->compare('created_by', $this->created_by, true);
            $criteria->compare('approved', $this->approved, true);
        } else {
            $userId = CommonProcess::getCurrentUserId();
            $criteria->addCondition('created_by = ' . $userId, 'OR');
            $criteria->addCondition('approved = ' . $userId, 'OR');
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
        $date = $this->approved_date;
        $this->approved_date = CommonProcess::convertDateTimeToMySqlFormat(
                $date, DomainConst::DATE_FORMAT_BACK_END);
        if ($this->isNewRecord) {
            $this->created_by = Yii::app()->user->id;
            
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        }
        
        return parent::beforeSave();
    }
    
    /**
     * Override afterSave method
     */
    protected function afterSave() {
        $arr = $this->getHolidaysBelongTo();
        foreach ($arr as $holiday) {
            $holiday->status = $this->status;
            if (!$holiday->save()) {
                Loggers::error('Update holiday failed', CommonProcess::json_encode_unicode($holiday->getErrors()),
                        __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            }
        }
    }
    
    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
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
     * Get year value
     * @return Int Year value
     */
    public function getYear() {
        return $this->id;
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
     * Get html notify
     * @return string Html notify
     */
    public function getHtmlNotify() {
        $retVal = '';
        if ($this->status != self::STATUS_APPROVED) {
            $retVal .= '<b>Năm '. $this->id.' chưa có kế hoạch nghỉ lễ hoặc kế hoạch chưa được duyệt.</b>';
            $retVal .= '<br>';
            $retVal .= 'Khởi tạo lịch nghỉ mặc định: <a class="btn btn-small" href="';
            $retVal .= Yii::app()->createUrl('hr/hrHolidayPlans/generateYearPlan', array('year' => $this->id));
            $retVal .= '"><button class="btn btn-small" style="background:#0080FF; color: white;border:'
                    . ' none;padding: 5px 10px;border-radius: 5px;font-weight: bold;cursor: pointer;"'
                    . ' type="button">' . DomainConst::CONTENT00017 . '</button></a>'
                    . '<br><br>'
                    . '<b>Vui lòng thực hiện các bước sau:</b>'
                    . '<br>'
                    . '<span class="required">Bước 1:</span> Tạo ngày nghỉ lễ bằng cách click vào ngày cần tạo hoặc chỉnh sửa.'
                    . '<br>'
                    . '<span class="required">Bước 2:</span> Sau khi tạo, Chọn người duyệt và click ' . DomainConst::CONTENT00017
                    . ' hoặc ' . DomainConst::CONTENT00377 . ' để gửi yêu cầu đến người duyệt.';
        }
        
        return $retVal;
    }
    
    /**
     * Check if this plan is approved
     * @return boolean True if status is Approved, false otherwise
     */
    public function isApproved() {
        return ($this->status == self::STATUS_APPROVED);
    }
    
    /**
     * Get all holidays model belong to this year
     * @return HrHolidays List models
     */
    public function getHolidaysBelongTo() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('YEAR(date) = ' . $this->getYear());
        $holidays = HrHolidays::model()->findAll($criteria);
        if ($holidays) {
            return $holidays;
        }
        return array();
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

}
