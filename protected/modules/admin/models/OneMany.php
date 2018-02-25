<?php

/**
 * This is the model class for table "one_many".
 *
 * The followings are the available columns in table 'one_many':
 * @property string $id
 * @property string $one_id
 * @property string $many_id
 * @property integer $type
 */
class OneMany extends BaseActiveRecord
{
    //-----------------------------------------------------
    // Type of relation
    //-----------------------------------------------------
    /** 1 [medical_records] has many [pathological] */
    const TYPE_MEDICAL_RECORD_PATHOLOGICAL              = DomainConst::NUMBER_ZERO_VALUE;
    /** 1 [treatment_schedules] has many [pathological] */
    const TYPE_TREATMENT_SCHEDULES_PATHOLOGICAL         = DomainConst::NUMBER_ONE_VALUE;
    /** 1 [agents] has many [users] */
    const TYPE_AGENT_USER                               = DomainConst::NUMBER_TWO_VALUE;
    /** 1 [agents] has many [customers] */
    const TYPE_AGENT_CUSTOMER                           = '3';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OneMany the static model class
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
		return 'one_many';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('one_id, many_id, type', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('one_id, many_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, one_id, many_id, type', 'safe', 'on'=>'search'),
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
                    'rPathological' => array(
                        self::BELONGS_TO,
                        'Pathological',
                        'many_id',
                    ),
                    'rUser' => array(
                        self::BELONGS_TO,
                        'Users',
                        'many_id',
                    ),
                    'rAgent' => array(
                        self::BELONGS_TO,
                        'Agents',
                        'one_id',
                    ),
                    'rCustomer' => array(
                        self::BELONGS_TO,
                        'Customers',
                        'many_id',
                    ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'one_id' => 'One',
			'many_id' => 'Many',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('one_id',$this->one_id,true);
		$criteria->compare('many_id',$this->many_id,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Insert new record
     * @param Int $one_id   One id
     * @param Int $many_id  Many id
     * @param String $type  Type of relation
     */
    public static function insertOne($one_id, $many_id, $type) {
        $model = new OneMany();
        $model->one_id = $one_id;
        $model->many_id = $many_id;
        $model->type = $type;
        $model->save();
    }
    
    /**
     * Delete a record
     * @param Int $one_id   One id
     * @param Int $many_id  Many id
     * @param Int $type     Type of relation
     */
    public static function deleteOne($one_id, $many_id, $type) {
        if (empty($one_id)) {
            return;
        }
        $criteria = new CDbCriteria;
        $criteria->compare('one_id', $one_id);
        $criteria->compare('many_id', $many_id);
        $criteria->compare('type', $type);
        self::model()->deleteAll($criteria);
    }
    
    /**
     * Delete all old records
     * @param Int $one_id   One id
     * @param Int $type     Type of relation
     */
    public static function deleteAllOldRecords($one_id, $type) {
        if (empty($one_id)) {
            return;
        }
        $criteria = new CDbCriteria;
        $criteria->compare('one_id', $one_id);
        $criteria->compare('type', $type);
        self::model()->deleteAll($criteria);
    }
    
    /**
     * Delete all old records
     * @param Int $many_id  Many id
     * @param Int $type     Type of relation
     */
    public static function deleteAllManyOldRecords($many_id, $type) {
        if (empty($many_id)) {
            return;
        }
        $criteria = new CDbCriteria;
        $criteria->compare('many_id', $many_id);
        $criteria->compare('type', $type);
        self::model()->deleteAll($criteria);
    }
}