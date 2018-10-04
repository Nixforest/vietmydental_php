<?php

/**
 * This is the model class for table "social_networks".
 *
 * The followings are the available columns in table 'social_networks':
 * @property string $id
 * @property string $object_id
 * @property string $value
 * @property integer $status
 * @property integer $type
 * @property integer $type_network
 */
class SocialNetworks extends BaseActiveRecord
{
    //-----------------------------------------------------
    // Type of relation
    //-----------------------------------------------------
    /** 1 [user] has many [social network] */
    const TYPE_USER                 = DomainConst::NUMBER_ONE_VALUE;
    /** 1 [customer] has many [social network] */
    const TYPE_CUSTOMER             = DomainConst::NUMBER_TWO_VALUE;
    //-----------------------------------------------------
    // Type of network
    //-----------------------------------------------------
    /** Email */
    const TYPE_NETWORK_EMAIL        = DomainConst::NUMBER_ONE_VALUE;
    /** Facebook */
    const TYPE_NETWORK_FACEBOOK     = DomainConst::NUMBER_TWO_VALUE;
    /** Zalo */
    const TYPE_NETWORK_ZALO         = '3';
    
    const TYPE_NETWORKS = array(
        self::TYPE_NETWORK_EMAIL    => DomainConst::CONTENT00175,
        self::TYPE_NETWORK_FACEBOOK => DomainConst::CONTENT00274,
        self::TYPE_NETWORK_ZALO     => DomainConst::CONTENT00275,
//        '123' => '466',
//        '1233' => '4663',
    );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SocialNetworks the static model class
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
		return 'social_networks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('value', 'required'),
			array('status, type, type_network', 'numerical', 'integerOnly'=>true),
			array('object_id', 'length', 'max'=>11),
			array('value', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, object_id, value, status, type, type_network', 'safe', 'on'=>'search'),
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
                    'rCustomer' => array(
                        self::BELONGS_TO, 'Customers', 'object_id',
                    ),
                    'rUser' => array(
                        self::BELONGS_TO, 'Users', 'object_id',
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
			'object_id' => 'Object',
			'value' => 'Value',
			'status' => 'Status',
			'type' => 'Type',
			'type_network' => 'Type Network',
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
		$criteria->compare('object_id',$this->object_id,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type);
		$criteria->compare('type_network',$this->type_network);
                $criteria->order = 'id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => Settings::getListPageSize(),
                        ),
		));
	}

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Get list status of treatment schedule detail object
     * @return Array
     */
//    public static function getTypeNetworks() {
//        return array(
//            self::TYPE_NETWORK_EMAIL    => DomainConst::CONTENT00175,
//            self::TYPE_NETWORK_FACEBOOK => DomainConst::CONTENT00274,
//            self::TYPE_NETWORK_ZALO     => DomainConst::CONTENT00275,
//        );
//    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Insert new record
     * @param String $value         Value
     * @param Int $object_id        Object id
     * @param String $type          Type of relation
     * @param String $type_network  Type of network
     */
    public static function insertOne($value, $object_id, $type, $type_network) {
        $model = new SocialNetworks();
        $model->value           = $value;
        $model->object_id       = $object_id;
        $model->type            = $type;
        $model->type_network    = $type_network;
        $model->save();
    }
    
    /**
     * Delete all old record
     * @param Int $object_id Id of object
     * @param String $type Type of relation
     * @return type
     */
    public static function deleteAllOldRecord($object_id, $type) {
        if (empty($object_id)) {
            return;
        }
        $criteria = new CDbCriteria;
        $criteria->compare('object_id', $object_id);
        $criteria->compare('type', $type);
        self::model()->deleteAll($criteria);
    }
}