<?php

/**
 * This is the model class for table "login_logs".
 *
 * The followings are the available columns in table 'login_logs':
 * @property string $id
 * @property string $user_id
 * @property integer $role_id
 * @property string $ip_address
 * @property string $country
 * @property string $description
 * @property integer $type
 * @property string $created_date
 */
class LoginLogs extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LoginLogs the static model class
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
		return 'login_logs';
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
			array('role_id, type', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('ip_address', 'length', 'max'=>50),
			array('country', 'length', 'max'=>100),
			array('description', 'length', 'max'=>300),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, role_id, ip_address, country, description, type, created_date', 'safe', 'on'=>'search'),
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
                    'rRole' => array(self::BELONGS_TO, 'Roles', 'role_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'role_id' => 'Role',
			'ip_address' => 'Ip Address',
			'country' => 'Country',
			'description' => 'Description',
			'type' => 'Type',
			'created_date' => 'Created Date',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('created_date',$this->created_date,true);
                $criteria->order = 'created_date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Update last login time for user record
     */
    public function updateLastLogin() {
        if ($this->rUser) {
            $this->rUser->last_logged_in = CommonProcess::getCurrentDateTime();
            $this->rUser->save();
        }
    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Insert new record
     * @param Int $type Type of login
     * @param String $description Description
     * @param String $user_id Id of user
     * @param String $role_id Id of role
     */
    public static function insertOne($type, $description, $user_id, $role_id) {
        $model = new LoginLogs();
        $model->user_id = $user_id;
        $model->role_id = $role_id;
        $model->type    = $type;
        $model->ip_address  = CommonProcess::getUserIP();
        $model->country     = CommonProcess::getUserCountry($model->ip_address);
        $model->description = $description;
        $model->created_date = CommonProcess::getCurrentDateTime();
        if ($model->save()) {
            $model->updateLastLogin();
        } else {
            CommonProcess::dumpVariable($model->getErrors());
            
        }
    }
}