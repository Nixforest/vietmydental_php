<?php

/**
 * This is the model class for table "schedule_email".
 *
 * The followings are the available columns in table 'schedule_email':
 * @property string $id
 * @property integer $type
 * @property integer $template_id
 * @property string $obj_id
 * @property string $user_id
 * @property string $email
 * @property string $time_send
 * @property string $created_date
 * @property string $subject
 * @property string $body
 * @property string $json
 * @property integer $status
 */
class ScheduleEmail extends BaseActiveRecord
{
    //-----------------------------------------------------
    // Type of email
    //-----------------------------------------------------
    const MAIL_NORMAL               = 1;            // Normail email
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ScheduleEmail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'schedule_email';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject, body, json', 'required'),
			array('type, template_id, status', 'numerical', 'integerOnly'=>true),
			array('obj_id, user_id', 'length', 'max'=>11),
			array('email', 'length', 'max'=>255),
			array('time_send, created_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, template_id, obj_id, user_id, email, time_send, created_date, subject, body, json, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'rUser' => array(self::BELONGS_TO, 'Users', 'user_id'),
                    'rTemplate' => array(self::BELONGS_TO, 'EmailTemplates', 'template_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'template_id' => 'Template',
			'obj_id' => 'Obj',
			'user_id' => 'User',
			'email' => 'Email',
			'time_send' => 'Time Send',
			'created_date' => 'Created Date',
			'subject' => 'Subject',
			'body' => 'Body',
			'json' => 'Json',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('template_id',$this->template_id);
		$criteria->compare('obj_id',$this->obj_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('time_send',$this->time_send,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('json',$this->json,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Send email
     * @param Int $countSent Number of email was sent
     * @param String $type Type of email
     */
    public static function sendEmail(&$countSent, $type) {
        try {
            $from = time();
            $aScheduleEmail     = array();
            $aIdScheduleEmail   = array();
            $aUsers             = array();
            $aIdUsers           = array();
            ScheduleEmail::prepareData($aScheduleEmail, $aIdScheduleEmail,
                    $aUsers, $aIdUsers, '');
            $countSent = count($aIdUsers);
            if ($countSent < 1) {
                return;
            }
            $aIdDelete = array();
            foreach ($aScheduleEmail as $key => $mScheduleEmail) {
                switch ($mScheduleEmail->type) {
                    case self::MAIL_NORMAL:
                        $aIdDelete[] = $mScheduleEmail->id;
                        EmailHandler::sendBuiltEmail($mScheduleEmail);
                        break;

                    default:
                        break;
                }
            }
            
            self::deleteByArrayId($aIdScheduleEmail);
            $to = time();
            $second = $to - $from;
            
        } catch (Exception $ex) {
            CommonProcess::dumpVariable($ex->getMessage());
        }
    }
    
    /**
     * Prepare data for send email
     * @param type $aScheduleEmail
     * @param type $aIdScheduleEmail
     * @param type $aUsers
     * @param type $aIdUsers
     * @param type $type
     */
    public static function prepareData(&$aScheduleEmail,
            &$aIdScheduleEmail,
            &$aUsers,
            &$aIdUsers,
            $type) {
        $criteria = new CDbCriteria();
        if (!empty($type)) {
            $criteria->addCondition('t.type=' . $type);
        }
        
        $criteria->addCondition('t.time_send IS NULL OR t.time_send< NOW()');
        $criteria->order = "t.id ASC";
        $criteria->limit = 30;
        $models = self::model()->findAll($criteria);
        // Set return value
        $aScheduleEmail = $models;
        $aIdScheduleEmail = CHtml::listData($models, 'id', 'id');
        $aIdUsers = CHtml::listData($models, 'user_id', 'user_id');
        $aUsers = Users::getArrayModelByArrayId($aIdUsers);
    }
    
    /**
     * Delete by array id
     * @param Array $aIdScheduleEmail Array id
     * @return type
     */
    public static function deleteByArrayId($aIdScheduleEmail) {
        if (count($aIdScheduleEmail) < 1) {
            return;
        }
        $criteria = new CDbCriteria();
        $sParamsIn = implode(',', $aIdScheduleEmail);
        $criteria->addCondition("id IN ($sParamsIn)");
        self::model()->deleteAll($criteria);
    }
}