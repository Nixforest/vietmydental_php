<?php

/**
 * This is the model class for table "hr_coefficient_values".
 *
 * The followings are the available columns in table 'hr_coefficient_values':
 * @property string $id                 Id of record
 * @property integer $coefficient_id    Id of coefficient
 * @property string $value              Value of coefficient
 * @property string $month              Month
 * @property integer $status            Status
 * @property string $created_date       Created date
 * @property string $created_by         Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property HrCoefficients             $rCoefficient                   Coefficient model
 */
class HrCoefficientValues extends HrActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = 0;
    /** Active */
    const STATUS_ACTIVE                 = 1;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return HrCoefficientValues the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hr_coefficient_values';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('coefficient_id, month', 'required'),
            array('coefficient_id, status', 'numerical', 'integerOnly' => true),
//            array('value', 'numerical'),
            array('created_by', 'length', 'max' => 10),
            array('created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, coefficient_id, value, month, status, created_date, created_by', 'safe', 'on' => 'search'),
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
            'rCoefficient' => array(self::BELONGS_TO, 'HrCoefficients', 'coefficient_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'                => 'ID',
            'coefficient_id'    => DomainConst::CONTENT00496,
            'value'             => DomainConst::CONTENT00495,
            'month'             => DomainConst::CONTENT00470,
            'status'            => DomainConst::CONTENT00026,
            'created_date'      => DomainConst::CONTENT00010,
            'created_by'        => DomainConst::CONTENT00054,
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
        $criteria->compare('coefficient_id', $this->coefficient_id);
        $criteria->compare('value', $this->value);
        $criteria->compare('month', $this->month, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->order = 'id desc';
//        $criteria->group = 'coefficient_id';

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
        Loggers::info('Value', $this->value, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $this->value = str_replace(DomainConst::SPLITTER_TYPE_2, '', $this->value);
        
        return parent::beforeSave();
    }
    
    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
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
     * Get coefficient
     * @return string Name of coefficient
     */
    public function getCoefficient() {
        if (isset($this->rCoefficient)) {
            return $this->rCoefficient->name;
        }
        return '';
    }
    
    /**
     * Get value (as formated)
     * @return String Formated value
     */
    public function getValue() {
        if (strpos($this->value, DomainConst::SPLITTER_TYPE_4) != FALSE) {
            return $this->value;
        }
        return CommonProcess::formatCurrency($this->value);
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

}
