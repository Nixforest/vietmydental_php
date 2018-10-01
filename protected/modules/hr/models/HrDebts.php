<?php

/**
 * This is the model class for table "hr_debts".
 *
 * The followings are the available columns in table 'hr_debts':
 * @property string $id             Id of record
 * @property string $user_id        Id of user
 * @property string $amount         Amount money
 * @property string $reason         Reason
 * @property string $month          Month
 * @property integer $type          Type of debts
 * @property string $relate_id      Id of model relate
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property Users                      $rUser                          User was related with this record
 */
class HrDebts extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = 0;
    /** Active */
    const STATUS_ACTIVE                 = 1;
    /** Done */
    const STATUS_DONE                   = 2;
    
    //-----------------------------------------------------
    // Type of relation
    //-----------------------------------------------------
    /** News */
    const TYPE_NEWS                     = '0';
    /** Type other */
    const TYPE_OTHER                    = '1';
    
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $autocomplete_user;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return HrDebts the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hr_debts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, month, type', 'required'),
            array('type, status', 'numerical', 'integerOnly' => true),
            array('user_id, amount, relate_id', 'length', 'max' => 11),
            array('created_by', 'length', 'max' => 10),
            array('reason, created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, amount, reason, month, type, relate_id, status, created_date, created_by', 'safe', 'on' => 'search'),
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
            'rUser' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => 'ID',
            'user_id'       => DomainConst::CONTENT00468,
            'amount'        => DomainConst::CONTENT00007,
            'reason'        => DomainConst::CONTENT00469,
            'month'         => DomainConst::CONTENT00470,
            'type'          => DomainConst::CONTENT00076,
            'relate_id'     => DomainConst::CONTENT00471,
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
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('reason', $this->reason, true);
        $criteria->compare('month', $this->month, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('relate_id', $this->relate_id, true);
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
        $date = $this->month;
        $this->month = CommonProcess::convertDateTime($date, DomainConst::DATE_FORMAT_13, DomainConst::DATE_FORMAT_4);
        if ($this->isNewRecord) {
            $this->created_by = Yii::app()->user->id;
            
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        }
        $this->amount = str_replace(DomainConst::SPLITTER_TYPE_2, '', $this->amount);
        
        return parent::beforeSave();
    }
    
    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
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
     * Get amount formated
     * @return String Amount value after format
     */
    public function getAmount() {
        return CommonProcess::formatCurrency($this->amount);
    }
    
    /**
     * Get relation information
     * @return string
     */
    public function getRelationInfo() {
        $retVal = '';
        
        return $retVal;
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
     * Get month value
     * @return String Month value in format 'm/Y'
     */
    public function getMonth() {
        return CommonProcess::convertDateTime($this->month, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_13);
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
     * Return type string
     * @return string Type value as string
     */
    public function getType() {
        if (isset(self::getArrayTypes()[$this->type])) {
            return self::getArrayTypes()[$this->type];
        }
        return '';
    }
    
    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Get types array
     * @return Array Array type of debt
     */
    public static function getArrayTypes() {
        return array(
            self::TYPE_NEWS             => DomainConst::CONTENT00472,
            self::TYPE_OTHER            => DomainConst::CONTENT00031,
        );
    }
    
    /**
     * Get status array
     * @return Array Array status of debt
     */
    public static function getArrayStatus() {
        return array(
            self::STATUS_INACTIVE       => DomainConst::CONTENT00408,
            self::STATUS_ACTIVE         => DomainConst::CONTENT00407,
            self::STATUS_DONE           => DomainConst::CONTENT00473,
        );
    }
    
    /**
     * Get user debt value
     * @param String $from From date (Format: Y-m-d)
     * @param String $to To date (Format: Y-m-d)
     * @param String $userId Id of user
     * @return Int Debt value
     */
    public static function getUserDebt($from, $to, $userId) {
        $fromYear = CommonProcess::convertDateTime($from, DomainConst::DATE_FORMAT_4, 'Y');
        $fromMonth = CommonProcess::convertDateTime($from, DomainConst::DATE_FORMAT_4, 'm');
        $toYear = CommonProcess::convertDateTime($to, DomainConst::DATE_FORMAT_4, 'Y');
        $toMonth = CommonProcess::convertDateTime($to, DomainConst::DATE_FORMAT_4, 'm');
        $criteria = new CDbCriteria();
        $criteria->addCondition('YEAR(month) >= ' . $fromYear . ' AND MONTH(month)>=  '. $fromMonth
                . ' AND YEAR(month) <= ' . $toYear . ' AND MONTH(month) <= ' . $toMonth);
        $criteria->addCondition('user_id=' . $userId);
        $models = self::model()->findAll($criteria);
        $retVal = 0;
        foreach ($models as $model) {
            $retVal += $model->amount;
        }
        
        return $retVal;
    }

}
