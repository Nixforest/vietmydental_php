<?php

/**
 * This is the model class for table "api_signin_requests".
 *
 * The followings are the available columns in table 'api_signin_requests':
 * @property string $id             Id of record
 * @property string $phone          Phone number
 * @property string $code           Code
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 */
class ApiSigninRequests extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = '0';
    /** New */
    const STATUS_NEW                    = '1';
    /** Confirmed */
    const STATUS_CONFIRMED              = '2';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ApiSigninRequests the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'api_signin_requests';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status', 'numerical', 'integerOnly' => true),
            array('phone, code', 'length', 'max' => 200),
            array('created_by', 'length', 'max' => 10),
            array('created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, phone, code, status, created_date, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        $relation = parent::relations();
        return $relation;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['phone']   = DomainConst::CONTENT00170;
        $attributeLabels['code']    = DomainConst::CONTENT00561;
        return $attributeLabels;
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
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('code', $this->code, true);
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
     * Return status string
     * @return string Status value as string
     */
    public function getStatus() {
        if (isset(self::getArrayStatus()[$this->status])) {
            return self::getArrayStatus()[$this->status];
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
            self::STATUS_NEW            => DomainConst::CONTENT00402,
            self::STATUS_CONFIRMED      => DomainConst::CONTENT00562,
        );
    }
    
    /**
     * Create new object
     * @param String $phone Phone string
     * @return ApiSigninRequests Object, NULL if failed
     */
    public static function createNew($phone) {
        $model = new ApiSigninRequests();
        $model->phone = $phone;
        $model->code = CommonProcess::randString(4, '0123456789');
//        $model->code = '1111';
        if ($model->save()) {
            Loggers::info('Create success', $model->id,
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            return $model;
        } else {
            Loggers::error('Create failed', CommonProcess::json_encode_unicode($model->getErrors()),
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
        return NULL;
    }
    
    /**
     * Validate otp
     * @param String $phone Phone number
     * @param String $code OTP code
     * @return boolean True if found in db
     */
    public static function validateOTP($phone, $code) {
        $criteria = new CDbCriteria();
        $criteria->compare('phone', $phone, true);
        $criteria->compare('code', $code, true);
        $criteria->order = 'id desc';
        $model = self::model()->find($criteria);
        if ($model) {
            // Check otp limit time
            $currentTime = CommonProcess::getCurrentDateTime();
            Loggers::info('Current', $currentTime, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $createdTime = $model->created_date;
            Loggers::info('Created', $createdTime, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $timeFirst  = strtotime($currentTime);
            $timeSecond = strtotime($createdTime);
            $diff = $timeFirst - $timeSecond;
            Loggers::info('Difference time', $diff, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $limit = Settings::getOTPLimitTime();
            if ($limit >= $diff) {
                $model->status = self::STATUS_CONFIRMED;
                $model->save();
                return true;
            }
            
        }
        return false;
    }

}
