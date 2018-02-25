<?php

/**
 * This is the model class for table "api_request_logs".
 *
 * The followings are the available columns in table 'api_request_logs':
 * @property string $id
 * @property string $ip_address
 * @property string $country
 * @property string $user_id
 * @property string $method
 * @property string $content
 * @property string $response
 * @property string $created_date
 * @property string $responsed_date
 */
class ApiRequestLogs extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ApiRequestLogs the static model class
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
		return 'api_request_logs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_date', 'required'),
			array('user_id', 'length', 'max'=>11),
			array('ip_address', 'length', 'max'=>50),
			array('country', 'length', 'max'=>200),
			array('method, content, response, responsed_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ip_address, country, user_id, method, content, response, created_date, responsed_date', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ip_address' => 'Ip Address',
			'country' => 'Country',
			'user_id' => 'User',
			'method' => 'Method',
			'content' => 'Content',
			'response' => 'Response',
			'created_date' => 'Created Date',
			'responsed_date' => 'Responsed Date',
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
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('method',$this->method,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('response',$this->response,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('responsed_date',$this->responsed_date,true);
                $criteria->order = 'created_date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
        $this->ip_address = CommonProcess::getUserIP();
        $this->country = CommonProcess::getUserCountry($this->ip_address);
        
        return parent::beforeSave();
    }
}