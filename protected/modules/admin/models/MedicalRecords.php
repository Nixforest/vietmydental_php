<?php

/**
 * This is the model class for table "medical_records".
 *
 * The followings are the available columns in table 'medical_records':
 * @property string $id             Id of record
 * @property string $customer_id    Id of customer
 * @property string $record_number  Record number
 * @property string $created_date   Created date
 * @property integer $status        Status
 * 
 * The followings are the available model relations:
 * @property Customers              $rCustomer              Customer model
 * @property TreatmentSchedules[]   $rTreatmentSchedule     Treatment schedule model
 */
class MedicalRecords extends BaseActiveRecord {
    /** Auto complete field */
    public $autocomplete_name_customer;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MedicalRecords the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'medical_records';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('customer_id', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('customer_id', 'length', 'max' => 11),
            array('record_number', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, customer_id, record_number, created_date, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rCustomer' => array(self::BELONGS_TO, 'Customers', 'customer_id'),
            'rJoinPathological' => array(
                self::HAS_MANY, 'OneMany', 'one_id',
                'on' => 'type = ' . OneMany::TYPE_MEDICAL_RECORD_PATHOLOGICAL,
            ),
            'rTreatmentSchedule' => array(
                self::HAS_MANY, 'TreatmentSchedules', 'record_id',
                'on' => 'status != ' . TreatmentSchedules::STATUS_INACTIVE,
                'order' => 'id DESC',
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'                => 'ID',
            'customer_id'       => DomainConst::CONTENT00135,
            'record_number'     => DomainConst::CONTENT00136,
            'created_date'      => DomainConst::CONTENT00010,
            'status'            => DomainConst::CONTENT00026,
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
        $criteria->compare('customer_id', $this->customer_id, true);
        $criteria->compare('record_number', $this->record_number, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('status', $this->status);
        $criteria->order = 'created_date DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    //-----------------------------------------------------
    // Parent override methods
    //-----------------------------------------------------
    /**
     * Override before save method
     * @return Parent result
     */
    public function beforeSave() {
        if ($this->isNewRecord) {   // Add
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        } else {                    // Update
        }
        return parent::beforeSave();
    }

    /**
     * Override before delete method
     * @return Parent result
     */
    public function beforeDelete() {
        OneMany::deleteAllOldRecords($this->id, OneMany::TYPE_MEDICAL_RECORD_PATHOLOGICAL);
        if (isset($this->rTreatmentSchedule)) {
            foreach ($this->rTreatmentSchedule as $treatment) {
                $treatment->delete();
            }
        }
        Loggers::info("Deleted " . get_class($this) . " with id = $this->id.", __FUNCTION__, __LINE__);
        return parent::beforeDelete();
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Generate Medical history information string
     * @return String Medical history information string
     */
    public function generateMedicalHistory($spliter = "<br>") {
        $array = array();
        foreach ($this->rJoinPathological as $item) {
            if (isset($item->rPathological)) {
                $array[] = $item->rPathological->name;
            }
        }
        return implode($spliter, $array);
    }

    /**
     * Get auto complete medical record
     * @return String [id - last_name first_name]
     */
    public function getAutoCompleteMedicalRecord() {
        $retVal = CommonProcess::generateID(
                        DomainConst::MEDICAL_RECORD_ID_PREFIX, $this->id);
        if (isset($this->rCustomer)) {
            $retVal .= ' - ' . $this->rCustomer->name;
        }
        $retVal .= ' - ' . $this->record_number;
        return $retVal;
    }

    /**
     * Check if current record number property is not exist in db
     * @return True if record number value is not exist, False otherwise
     */
    public function isValidRecordNumber() {
        $agentId = isset(Yii::app()->user) ? Yii::app()->user->agent_id : '';
        $criteria = new CDbCriteria();
        $criteria->compare('t.record_number', $this->record_number);
        $models = self::model()->findAll($criteria);
        if ($models) {
            foreach ($models as $value) {
                if (($value->record_number == $this->record_number)     // Match record number
                        && $value->getAgentId() == $agentId             // Match agent id
                        && $value->id != $this->id) {                   // Diff model id (case update model)
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Get id of agent
     * @return Id of agent
     */
    public function getAgentId() {
        if (isset($this->rCustomer)) {
            return $this->rCustomer->getAgentId();
        }
    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Get next record number
     * @param String $agent_id Id of agent
     * @return String Value of next record number
     */
    public static function getNextRecordNumber($agent_id) {
        $retVal = SqlHandler::getMaxRecordNumber($agent_id);
        if (empty($retVal)) {
            Loggers::error('Can not get next record number of agent', $agent_id,
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        } else {
            $retVal = $retVal + 1;
        }
        return $retVal;
    }
}
