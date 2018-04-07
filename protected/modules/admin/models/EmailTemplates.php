<?php

/**
 * This is the model class for table "email_templates".
 *
 * The followings are the available columns in table 'email_templates':
 * @property integer $id
 * @property string $subject
 * @property string $body
 * @property string $param_description
 * @property integer $type
 */
class EmailTemplates extends BaseActiveRecord
{
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const TEMPLATE_ID_RESET_PASSWORD                   = 1;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmailTemplates the static model class
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
		return 'email_templates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type', 'numerical', 'integerOnly'=>true),
			array('subject', 'length', 'max'=>255),
			array('body, param_description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subject, body, param_description, type', 'safe', 'on'=>'search'),
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
                    'rScheduleEmail' => array(self::HAS_MANY, 'ScheduleEmail', 'template_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subject' => 'Subject',
			'body' => 'Body',
			'param_description' => 'Param Description',
			'type' => 'Type',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('param_description',$this->param_description,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => Settings::getListPageSize(),
                        ),
		));
	}
        
    //-----------------------------------------------------
    // Parent override methods
    //-----------------------------------------------------
    /**
     * Override before delete method
     * @return Parent result
     */
    protected function beforeDelete() {
        $retVal = true;
        // Check foreign table schedule_email
        $emails = ScheduleEmail::model()->findByAttributes(array('template_id' => $this->id));
        if (count($emails) > 0) {
            $retVal = false;
        }
        return $retVal;
    }
}