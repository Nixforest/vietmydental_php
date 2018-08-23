<?php

/**
 * This is the model class for table "schedule_sms_history".
 *
 * The followings are the available columns in table 'schedule_sms_history':
 * @property string $id
 * @property integer $network
 * @property string $phone
 * @property string $user_id
 * @property integer $type
 * @property string $title
 * @property string $content
 * @property string $count_run
 * @property string $time_send
 * @property string $created_date
 * @property int $created_by
 * @property int $status
 * @property integer $content_type
 */
class ScheduleSmsHistory extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ScheduleSmsHistory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'schedule_sms_history';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, network, phone, user_id, type, title, content, count_run, time_send, created_date,created_by, status, content_type', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            
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
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * insert to history
     * @param type $mScheduleSms
     */
    public function InsertNew($mScheduleSms) {
        $mHistory = new ScheduleSmsHistory('InsertNew');
        $mPhoneHandler = new PhoneHandler();
        $aFieldNotCopy = array('id');
        $this->copyFromToTable($mScheduleSms, $mHistory, $aFieldNotCopy);
        $mHistory->network = $mPhoneHandler->detect_number_network($mHistory->phone);
        // Add new history
        $mHistory->save();
        //client was received then delete schedule notify SMS
        $mScheduleSms->delete();
    }
    
    /**
     * copy attributes to new model
     * @param model $mFrom
     * @param model $mTo
     * @param array $aFieldNotCopy
     * @return model to
     */
    public function copyFromToTable($mFrom, &$mTo, $aFieldNotCopy = array())
    {
        foreach ($mFrom->getAttributes() as $field_name => $field_value) {
            if (count($aFieldNotCopy)) {
                if (!in_array($field_name, $aFieldNotCopy) && $mTo->hasAttribute($field_name))
                    $mTo->$field_name = $mFrom->$field_name;
            } else {
                $mTo->$field_name = $mFrom->$field_name;
            }
        }
        return $mTo;
    }

}
