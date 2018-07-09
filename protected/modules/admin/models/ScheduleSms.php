<?php

/**
 * This is the model class for table "schedule_sms".
 *
 * The followings are the available columns in table 'schedule_sms':
 * @property string $id
 * @property string $uid_login
 * @property string $phone
 * @property string $user_id
 * @property string $username
 * @property integer $type
 * @property string $obj_id
 * @property string $title
 * @property string $json_var
 * @property string $count_run
 * @property string $time_send
 * @property string $created_date
 * @property integer $content_type
 */
class ScheduleSms extends CActiveRecord {

    public $ServiceID       = '';
    public $CommandCode     = '';
    public $User            = '';
    public $Password        = '';
    public $CPCode          = '';
    public $RequestID       = 0;
    public $Url = "";// Primary Server
    
    const ContentTypeVietkey            = 0;
    const ContentTypeNonVietkey         = 1;
    const MAX_COUNT_RUN                 = 3;
    const NETWORK_VIETTEL               = 1;// mạng viettel
    const NETWORK_MOBI                  = 2;// mạng mobile phone
    const NETWORK_VINA                  = 3;
    const NETWORK_OTHER                 = 4;// mạng khác
    const NETWORK_VIETNAM_MOBILE        = 5;
    const NETWORK_G_MOBILE              = 6;
    
    const TYPE_NOMAL     = 1;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ScheduleSms the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'schedule_sms';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid_login, phone, user_id, username, type, obj_id, json_var, time_send, created_date, content_type', 'required'),
            array('type, content_type', 'numerical', 'integerOnly' => true),
            array('uid_login, user_id, obj_id, count_run', 'length', 'max' => 11),
            array('phone', 'length', 'max' => 50),
            array('username', 'length', 'max' => 100),
            array('title', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, uid_login, phone, user_id, username, type, obj_id, title, json_var, count_run, time_send, created_date, content_type', 'safe', 'on' => 'search'),
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
            'uid_login' => 'Uid Login',
            'phone' => 'Phone',
            'user_id' => 'User',
            'username' => 'Username',
            'type' => 'Type',
            'obj_id' => 'Obj',
            'title' => 'Title',
            'json_var' => 'Json Var',
            'count_run' => 'Count Run',
            'time_send' => 'Time Send',
            'created_date' => 'Created Date',
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
        $criteria->compare('uid_login', $this->uid_login, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('obj_id', $this->obj_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('json_var', $this->json_var, true);
        $criteria->compare('count_run', $this->count_run, true);
        $criteria->compare('time_send', $this->time_send, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('content_type', $this->content_type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /** @Author: HOANG NAM 09/07/2018
     *  @Todo: send SMS
     **/
    public function runCronBig() {// gửi những SMS SL nhiều
        $data = $this->getDataCron(ScheduleSms::TYPE_NOMAL);
        $this->runCron($data);
    }
    
    /**
     *  get data by type send Sms
     * @param type $type
     * @return type
     */
    public function getDataCron($type) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.time_send <= NOW() AND t.count_run < ".self::MAX_COUNT_RUN);
        $criteria->order = 't.count_run ASC, t.id DESC';
        $criteria->limit = 150;
        $criteria->addCondition("t.type = {$type}");
        return self::model()->findAll($criteria);
    }
    
    /** @Author: HOANG NAM 09/07/2018
     *  @Todo: run send Sms
     **/
    public function runCron($data) {
        $from = time();
        if(count($data) < 1 ){
            return ;
        }
        foreach($data as $mScheduleSms){
            $mScheduleSms->doSend();
        }
        $to = time();
        $second = $to-$from;
        $CountData = count($data);
        $ResultRun = "CRON Notify SMS: ".$CountData.' done in: '.($second).'  Second  <=> '.round($second/60, 2).' Minutes ';
        $ResultRun .= json_encode(CHtml::listData($data, 'id', 'phone'));
        if($CountData){
            Loggers::info(__METHOD__, $ResultRun, get_class());
        }
    }
    /**
     * send SMS in model ScheduleSms
     */
    public function doSend() {
        $ReceiverID = $this->phone;
        $Content = $this->title;
        $ContentType = $this->content_type;
        $user_param = array (
            'User'      => $this->User,
            'Password'  => $this->Password,
            'CPCode'    => $this->CPCode,
            'RequestID' => $this->RequestID,
            'UserID'    => $ReceiverID,
            'ReceiverID'    => $ReceiverID,
            'ServiceID'     => $this->ServiceID,
            'CommandCode'   => $this->CommandCode,
            'Content'       => $Content,
            'ContentType'   => $ContentType,
        );
        $client = $this->sending($user_param, "wsCpMt");
        // move sang history
        $mScheduleSmsHistory = new ScheduleSmsHistory();
        $mScheduleSmsHistory->InsertNew($this);
    }
    
    /**
     * Send sms
     * @param type $user_param
     * @param type $functionCall
     * @return \SoapClient
     */
    public function sending($user_param, $functionCall) {
        $client = new SoapClient($this->Url, array("soap_version" => SOAP_1_1,"trace" => 1));
        $client->__soapCall(
           $functionCall,
           array($user_param)
        );
        return $client;
    }
}
