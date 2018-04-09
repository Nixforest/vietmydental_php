<?php

/**
 * This is the model class for table "loggers".
 *
 * The followings are the available columns in table 'loggers':
 * @property string $id
 * @property string $ip_address
 * @property string $country
 * @property string $message
 * @property string $created_date
 * @property string $description
 * @property string $level
 * @property integer $logtime
 * @property string $category
 */
class Loggers extends CActiveRecord
{
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const LOG_LEVEL_INFO                    = '0';
    const LOG_LEVEL_WARNING                 = '1';
    const LOG_LEVEL_ERROR                   = '2';
    
    const LOG_LEVELS = array(
        self::LOG_LEVEL_INFO        => 'Info',
        self::LOG_LEVEL_WARNING     => 'Warning',
        self::LOG_LEVEL_ERROR       => 'Error'
    );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Loggers the static model class
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
		return 'loggers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('logtime', 'numerical', 'integerOnly'=>true),
			array('ip_address', 'length', 'max'=>50),
			array('country', 'length', 'max'=>100),
			array('description', 'length', 'max'=>250),
			array('level, category', 'length', 'max'=>128),
			array('message, created_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ip_address, country, message, created_date, description, level, logtime, category', 'safe', 'on'=>'search'),
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
			'message' => 'Message',
			'created_date' => 'Created Date',
			'description' => 'Description',
			'level' => 'Level',
			'logtime' => 'Logtime',
			'category' => 'Category',
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
		$criteria->compare('message',$this->message,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('logtime',$this->logtime);
		$criteria->compare('category',$this->category,true);
                $criteria->order = 'logtime DESC';

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
     * Override before save method
     * @return Parent result
     */
    public function beforeSave() {
        $this->ip_address = CommonProcess::getUserIP();
        $this->country = CommonProcess::getUserCountry($this->ip_address);
        if ($this->isNewRecord) {   // Add
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        } else {                    // Update
            
        }
        return parent::beforeSave();
    }
    
    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Insert record
     * @param String $message
     * @param String $description
     * @param String $level
     * @param String $category
     */
    public static function insertOne($message, $description, $level, $category) {
        $model = new Loggers();
        $model->message = $message;
        $model->description = $description;
        $model->level = $level;
        $model->logtime = time();
        $model->category = $category;
        $model->save();
    }
    
    /**
     * Log info
     * @param String $message
     * @param String $description
     * @param String $category
     */
    public static function info($message, $description, $category) {
        self::insertOne($message, $description, self::LOG_LEVEL_INFO, $category);
    }
    
    /**
     * Log warning
     * @param String $message
     * @param String $description
     * @param String $category
     */
    public static function warning($message, $description, $category) {
        self::insertOne($message, $description, self::LOG_LEVEL_WARNING, $category);
    }
    
    /**
     * Log error
     * @param String $message
     * @param String $description
     * @param String $category
     */
    public static function error($message, $description, $category) {
        self::insertOne($message, $description, self::LOG_LEVEL_ERROR, $category);
    }
    
    /**
     * Check and remove log if over number
     */
    public static function checkLog() {
        $tblName = self::model()->tableName();
//        $model = new Loggers();
        $count = self::model()->getDbConnection()->createCommand('SELECT COUNT(*) FROM '.$tblName)->queryScalar();
        if ($count >= 1000) {
            $query = "DELETE FROM $tblName limit 200";
            $command = Yii::app()->db->createCommand($query);
            $command->execute();
        }
    }
}