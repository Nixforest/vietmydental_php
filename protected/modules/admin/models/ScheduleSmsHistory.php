<?php

/**
 * This is the model class for table "schedule_sms_history".
 *
 * The followings are the available columns in table 'schedule_sms_history':
 * @property string $id
 * @property integer $network
 * @property string $uid_login
 * @property string $phone
 * @property string $user_id
 * @property integer $role_id
 * @property string $username
 * @property integer $type
 * @property string $obj_id
 * @property string $title
 * @property string $json_var
 * @property string $count_run
 * @property string $time_send
 * @property string $created_date
 * @property string $created_date_on_history
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
            array('network, uid_login, phone, user_id, role_id, username, type, obj_id, json_var, time_send, created_date, created_date_on_history, content_type', 'required'),
            array('network, role_id, type, content_type', 'numerical', 'integerOnly' => true),
            array('uid_login, user_id, obj_id, count_run', 'length', 'max' => 11),
            array('phone', 'length', 'max' => 50),
            array('username', 'length', 'max' => 100),
            array('title', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, network, uid_login, phone, user_id, role_id, username, type, obj_id, title, json_var, count_run, time_send, created_date, created_date_on_history, content_type', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'network' => 'Network',
            'uid_login' => 'Uid Login',
            'phone' => 'Phone',
            'user_id' => 'User',
            'role_id' => 'Role',
            'username' => 'Username',
            'type' => 'Type',
            'obj_id' => 'Obj',
            'title' => 'Title',
            'json_var' => 'Json Var',
            'count_run' => 'Count Run',
            'time_send' => 'Time Send',
            'created_date' => 'Created Date',
            'created_date_on_history' => 'Created Date On History',
            'content_type' => 'Content Type',
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
        $criteria->compare('network', $this->network);
        $criteria->compare('uid_login', $this->uid_login, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('obj_id', $this->obj_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('json_var', $this->json_var, true);
        $criteria->compare('count_run', $this->count_run, true);
        $criteria->compare('time_send', $this->time_send, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_date_on_history', $this->created_date_on_history, true);
        $criteria->compare('content_type', $this->content_type);

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
        $aFieldNotCopy = array('id');
        $this->copyFromToTable($mScheduleSms, $mHistory, $aFieldNotCopy);
        // Add new history
        $mHistory->save();
        //client was received then delete schedule notify SMS
        $mScheduleSms->delete();
    }
    
    /**
     * copy attributes to new model
     * @param type $mFrom
     * @param type $mTo
     * @param type $aFieldNotCopy
     * @return type
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
