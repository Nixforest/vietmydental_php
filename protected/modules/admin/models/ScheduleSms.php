<?php

/**
 * This is the model class for table "schedule_sms".
 *
 * The followings are the available columns in table 'schedule_sms':
 * @property string $id
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
class ScheduleSms extends CActiveRecord {

//  list  key can send  sms
    public $aTypeSchedule = [
        Settings::KEY_SMS_SEND_CREATE_SCHEDULE,
        Settings::KEY_SMS_SEND_UPDATE_SCHEDULE,
        Settings::KEY_SMS_SEND_CREATE_RECEIPT,
    ];
    public $ServiceID       = '';
    public $CommandCode     = '';
    public $User            = '';
    public $Password        = '';
    public $CPCode          = '';
    public $RequestID       = 0;
    public $Url             = ""; // Primary Server

    const ContentTypeVietkey    = 0;
    const ContentTypeNonVietkey = 1;
    const MAX_COUNT_RUN         = 3;
    const NETWORK_VIETTEL       = 1; // mạng viettel
    const NETWORK_MOBI          = 2; // mạng mobile phone
    const NETWORK_VINA          = 3;
    const NETWORK_OTHER         = 4; // mạng khác
    const NETWORK_VIETNAM_MOBILE = 5;
    const NETWORK_G_MOBILE      = 6;
    const NETWORK_S_PHONE       = 7;

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
            array('id, phone, user_id, type, title, content, count_run, time_send, created_date,created_by, status, content_type', 'safe'),
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

    /** @Author: HOANG NAM 09/07/2018
     *  @Todo: send SMS
     * */
    public function runCronBig() {// gửi những SMS SL nhiều
        $aTypeSend = $this->getArrayTypeSend();
        $data = $this->getDataCron($aTypeSend);
        $this->runCron($data);
    }

    /**
     *  get data by type send Sms
     * @param array $type
     * @return type
     */
    public function getDataCron($type = []) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.time_send <= NOW() AND t.count_run < " . self::MAX_COUNT_RUN);
        $criteria->order = 't.count_run ASC, t.id DESC';
        $criteria->limit = 150;
        $criteria->addInCondition('t.type', $type);
        return self::model()->findAll($criteria);
    }

    /** @Author: HOANG NAM 09/07/2018
     *  @Todo: run send Sms
     * */
    public function runCron($data) {
        $from = time();
        if (count($data) < 1) {
            return;
        }
        foreach ($data as $mScheduleSms) {
            $mScheduleSms->doSend();
        }
        $to = time();
        $second = $to - $from;
        $CountData = count($data);
        $ResultRun = "CRON Notify SMS: " . $CountData . ' done in: ' . ($second) . '  Second  <=> ' . round($second / 60, 2) . ' Minutes ';
        $ResultRun .= json_encode(CHtml::listData($data, 'id', 'phone'));
        if ($CountData) {
            Loggers::info(__METHOD__, $ResultRun, get_class());
        }
    }

    /**
     * send SMS in model ScheduleSms
     */
    public function doSend() {
        $mSmsHandler = new SMSHandler();
        $mSmsHandler->sendSMSOnce($this->phone, $this->content);
        // move to history
        $mScheduleSmsHistory = new ScheduleSmsHistory();
        $mScheduleSmsHistory->insertNew($this);
    }

    /**
     * get array type send sms
     */
    public function getArrayTypeSend() {
        $aData = [];
        foreach ($this->aTypeSchedule as $value) {
            $setting = Settings::getItem($value);
            if ($setting == true) {
                $aData[] = $value;
            }
        }
        return $aData;
    }
}
