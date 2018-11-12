<?php

/**
 * This is the model class for table "active_record_logs".
 *
 * The followings are the available columns in table 'active_record_logs':
 * @property string $id             Id of record
 * @property string $description    Description
 * @property string $action         Name of action
 * @property string $model          Class model
 * @property string $model_id        Id of model
 * @property string $field          name of field
 * @property string $old_value      Old value
 * @property string $new_value      New value
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 */
class ActiveRecordLogs extends BaseActiveRecord {

    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE = '0';

    /** Active */
    const STATUS_ACTIVE = '1';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ActiveRecordLogs the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'active_record_logs';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('old_value, new_value', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('description', 'length', 'max' => 255),
            array('action', 'length', 'max' => 20),
            array('model, field', 'length', 'max' => 45),
            array('model_id, created_by', 'length', 'max' => 10),
            array('created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, description, action, model, model_id, field, old_value, new_value, status, created_date, created_by', 'safe', 'on' => 'search'),
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
        $labels = parent::attributeLabels();
        $labels['action'] = 'Action';
        $labels['model'] = 'Model';
        $labels['model_id'] = 'Model id';
        $labels['field'] = 'Field';
        $labels['old_value'] = 'Old value';
        $labels['new_value'] = 'New value';
        return $labels;
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
        $criteria->compare('description', $this->description, true);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('model', $this->model, true);
        $criteria->compare('model_id', $this->model_id, true);
        $criteria->compare('field', $this->field, true);
        $criteria->compare('old_value', $this->old_value, true);
        $criteria->compare('new_value', $this->new_value, true);
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
     * Insert new record
     * @param String $description
     * @param String $action
     * @param Object $modelObj
     * @param String $model_id
     * @param String $field
     * @param String $old
     * @param String $value
     */
    public static function insertOne($description, $action, $modelObj, $model_id, $field, $old, $value) {
        if (!Settings::canLogActiveRecordUpdate()) {
            return;
        }
        $model                = new ActiveRecordLogs();
        $model->description   = $description;
        $model->action        = $action;
        $model->model         = $modelObj;
        $model->model_id      = $model_id;
        $model->field         = $field;
        $model->old_value     = $old;
        $model->new_value     = $value;
        $model->save();
    }

}
