<?php

/**
 * This is the model class for table "agents".
 *
 * The followings are the available columns in table 'agents':
 * @property string $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $foundation_date
 * @property integer $city_id
 * @property integer $district_id
 * @property integer $ward_id
 * @property string $street_id
 * @property string $house_numbers
 * @property string $address
 * @property string $address_vi
 * @property string $created_by
 * @property string $created_date
 * @property integer $status
 */
class Agents extends BaseActiveRecord
{
    public $autocomplete_name_street;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Agents the static model class
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
		return 'agents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, city_id, district_id', 'required'),
			array('city_id, district_id, ward_id, status', 'numerical', 'integerOnly'=>true),
			array('name, house_numbers, address_vi', 'length', 'max'=>255),
			array('phone, email', 'length', 'max'=>200),
			array('street_id, created_by', 'length', 'max'=>11),
			array('foundation_date, address', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, phone, email, foundation_date, city_id, district_id, ward_id, street_id, house_numbers, address, address_vi, created_by, created_date, status', 'safe', 'on'=>'search'),
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
                    'rCity' => array(self::BELONGS_TO, 'Cities', 'city_id'),
                    'rDistrict' => array(self::BELONGS_TO, 'Districts', 'district_id'),
                    'rWard' => array(self::BELONGS_TO, 'Wards', 'ward_id'),
                    'rStreet' => array(self::BELONGS_TO, 'Streets', 'street_id'),
                    'rCreatedBy' => array(self::BELONGS_TO, 'Users', 'created_by'),
                    /** Join relation */
                    'rJoinUser' => array(
                        self::HAS_MANY, 'OneMany', 'one_id',
                        'on'    => 'type = ' . OneMany::TYPE_AGENT_USER,
                    ),
                    'rJoinCustomer' => array(
                        self::HAS_MANY, 'OneMany', 'one_id',
                        'on'    => 'type = ' . OneMany::TYPE_AGENT_CUSTOMER,
                    ),
                    'rJoinReceipt' => array(
                        self::HAS_MANY, 'OneMany', 'one_id',
                        'on'    => 'type = ' . OneMany::TYPE_AGENT_RECEIPT,
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
			'name' => DomainConst::CONTENT00197,
			'phone' => DomainConst::CONTENT00048,
			'email' => DomainConst::CONTENT00040,
			'foundation_date' => DomainConst::CONTENT00198,
			'city_id' => DomainConst::CONTENT00102,
			'district_id' => DomainConst::CONTENT00103,
			'ward_id' => DomainConst::CONTENT00104,
			'street_id' => DomainConst::CONTENT00105,
			'house_numbers' => DomainConst::CONTENT00106,
			'address' => DomainConst::CONTENT00045,
			'address_vi' => 'Address Vi',
			'created_by' => DomainConst::CONTENT00054,
			'created_date' => DomainConst::CONTENT00010,
			'status' => DomainConst::CONTENT00026,
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('foundation_date',$this->foundation_date,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('district_id',$this->district_id);
		$criteria->compare('ward_id',$this->ward_id);
		$criteria->compare('street_id',$this->street_id,true);
		$criteria->compare('house_numbers',$this->house_numbers,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('address_vi',$this->address_vi,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('status',$this->status);

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
        $this->foundation_date = CommonProcess::convertDateTimeToMySqlFormat(
                $this->foundation_date, DomainConst::DATE_FORMAT_3);
        $this->address = CommonProcess::createAddressString(
                $this->city_id, $this->district_id,
                $this->ward_id, $this->street_id,
                $this->house_numbers);
        $this->address_vi = CommonProcess::removeSign(
                $this->name . ' ' .
                $this->phone . ' ' .
                $this->email . ' ' .
                $this->address);
        if ($this->isNewRecord) {   // Add
            // Handle created by
            if (empty($this->created_by)) {
                $this->created_by = CommonProcess::getCurrentUserId();
            }
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        } else {                    // Update
            
        }
        return parent::beforeSave();
    }
    
    /**
     * Override before delete method
     * @return Parent result
     */
    public function beforeDelete() {
        OneMany::deleteAllOldRecords($this->id, OneMany::TYPE_AGENT_USER);
        OneMany::deleteAllOldRecords($this->id, OneMany::TYPE_AGENT_CUSTOMER);
        OneMany::deleteAllOldRecords($this->id, OneMany::TYPE_AGENT_RECEIPT);
        return parent::beforeDelete();
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Loads the agents items for the specified type from the database
     * @param type $emptyOption boolean the item is empty
     * @return type List data
     */
    public static function loadItems($emptyOption = false) {
        $_items = array();
        if ($emptyOption) {
            $_items[""] = "";
        }
        $models = self::model()->findAll(array(
            'order' => 'id ASC',
        ));
        foreach ($models as $model) {
            $_items[$model->id] = $model->name;
        }
        return $_items;
    }
    
    /**
     * Get list users
     * @return \CArrayDataProvider
     */
    public function getUsers() {
        $arrUsers = array();
        if (isset($this->rJoinUser)) {
            foreach ($this->rJoinUser as $value) {
                if (isset($value->rUser)) {
                    $arrUsers[] = $value;
                }
            }
        }
        return new CArrayDataProvider($arrUsers, array(
            'id' => 'users',
            'sort'=>array(
                'attributes'=>array(
                     'id', 'one_id', 'many_id'
                ),
            ),
            'pagination'=>array(
                'pageSize'=>Settings::getListPageSize(),
            ),
        ));
    }
    
    /**
     * Get list receipts
     * @return \CArrayDataProvider
     */
    public function getReceipts() {
        $arrReceipts = array();
        if (isset($this->rJoinReceipt)) {
            foreach ($this->rJoinReceipt as $value) {
                if (isset($value->rReceipt)
                        && ($value->rReceipt->status == Receipts::STATUS_DOCTOR
                                || $value->rReceipt->status == Receipts::STATUS_RECEIPTIONIST)) {
                    $arrReceipts[] = $value;
                }
            }
        }
        return new CArrayDataProvider($arrReceipts, array(
            'id' => 'receipts',
            'sort'=>array(
                'attributes'=>array(
                     'id', 'one_id', 'many_id'
                ),
            ),
            'pagination'=>array(
                'pageSize'=>Settings::getListPageSize(),
            ),
        ));
    }
}