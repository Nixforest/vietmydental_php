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
                    'rMoneyAccount' => array(
                        self::HAS_MANY, 'MoneyAccount', 'agent_id',
                        'on'    => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
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
                if (isset($value->rUser) && $value->rUser->isStaff()) {
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
//    public function getReceipts($from, $to) {
    public function getReceipts($from, $to, $arrStatus) {
        $arrReceipts = array();
        if (isset($this->rJoinReceipt)) {
            foreach ($this->rJoinReceipt as $value) {
//                if (isset($value->rReceipt)
//                        && ($value->rReceipt->status == Receipts::STATUS_DOCTOR
//                                || $value->rReceipt->status == Receipts::STATUS_RECEIPTIONIST)) {
                if (isset($value->rReceipt)
                        && in_array($value->rReceipt->status, $arrStatus)) {
                    $date = $value->rReceipt->process_date;
//                    CommonProcess::dumpVariable($date);
                    $compareFrom = DateTimeExt::compare($date, $from);
                    $compareTo = DateTimeExt::compare($date, $to);
                    // Check if receipt is between date range
                    if (($compareFrom == 1 || $compareFrom == 0)
                            && ($compareTo == 0 || $compareTo == -1)) {
                        $arrReceipts[] = $value;
                    }
//                        $arrReceipts[] = $value;
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
    
    /**
     * 
     * @param type $from
     * @param type $to
     * @param type $arrStatus
     * @return \CArrayDataProvider
     */
    public function getMoney($from, $to, $arrIsIncomming) {
        $arrReceipts = array();
        if (isset($this->rMoneyAccount)) {
            foreach ($this->rMoneyAccount as $aValue) {
                foreach ($aValue->rMoney as $value) {
                    if (in_array($value->isIncomming, $arrIsIncomming)) {
                        $date = $value->action_date;
    //                    CommonProcess::dumpVariable($date);
                        $compareFrom = DateTimeExt::compare($date, $from);
                        $compareTo = DateTimeExt::compare($date, $to);
                        // Check if receipt is between date range
                        if (($compareFrom == 1 || $compareFrom == 0)
                                && ($compareTo == 0 || $compareTo == -1)) {
                            $arrReceipts[] = $value;
                        }
    //                        $arrReceipts[] = $value;
                    }
                }
            }
        }
        return new CArrayDataProvider($arrReceipts, array(
            'id' => 'moneys',
            'sort'=>array(
                'attributes'=>array(
                     'id', 'agent_id'
                ),
            ),
            'pagination'=>array(
                'pageSize'=>Settings::getListPageSize(),
            ),
        ));
    }
    
    /**
     * get array report
     * @param type $from
     * @param type $to
     */
    public function getReportMoney($from, $to){
        $aData = array();
        $aData['DOCTORS'] = array();
        $aData['RECEIPT'] = array();
        $aData['RECEIPT']['DATES'] = array();
        $aData['RECEIPT']['VALUES'] = array();
        $aData['DOCTORS'] =  Users::getListUser(Roles::getRoleByName(Roles::ROLE_DOCTOR)->id,$this->id);
//        Load receipts
        $receipts = $this->getReceipts($from, $to, array(Receipts::STATUS_RECEIPTIONIST));
        $receipts->pagination = false;
        $aReceipts = $receipts->getData();
        foreach ($aReceipts as $key => $mJoinReceipt) {
            $mReceipt = $mJoinReceipt->rReceipt;
            $doctor_id = $mReceipt->getDoctorId();
            $money = $mJoinReceipt->getReceiptFinal();
            $date = CommonProcess::convertDateTime($mReceipt->created_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_4);
//            set money RECEIPT
            if(!empty($aData['RECEIPT']['VALUES'][$date][$doctor_id])){
                $aData['RECEIPT']['VALUES'][$date][$doctor_id] += (int)$money;
            }else{
                $aData['RECEIPT']['VALUES'][$date][$doctor_id] = (int)$money;
            }
//            set date
            if(empty($aData['RECEIPT']['DATES'][$date])){
                $aData['RECEIPT']['DATES'][$date] = $date;
            }
        }
//        Load money
        $aData['GENERAL']['DATES']  = array();
        $aData['GENERAL']['IMPORT'] = array();
        $aData['GENERAL']['EXPORT'] = array();
        $aData['EXPORT_DETAIL'] = array();
        $moneys = $this->getMoney($from, $to, array(DomainConst::NUMBER_ONE_VALUE,DomainConst::NUMBER_ZERO_VALUE));
        $moneys->pagination = false;
        $aMoneys = $moneys->getData();
        foreach ($aMoneys as $key => $mMoney) {
            $date = $mMoney->action_date;
//            import
            if($mMoney->isIncomming == DomainConst::NUMBER_ONE_VALUE){
                if(!empty($aData['GENERAL']['IMPORT'][$date])){
                    $aData['GENERAL']['IMPORT'][$date] += $mMoney->amount;
                }else{
                    $aData['GENERAL']['IMPORT'][$date] = $mMoney->amount;
                }
            }
//            export
            if($mMoney->isIncomming == DomainConst::NUMBER_ZERO_VALUE){
                if(!empty($aData['GENERAL']['EXPORT'][$date])){
                    $aData['GENERAL']['EXPORT'][$date] += $mMoney->amount;
                }else{
                    $aData['GENERAL']['EXPORT'][$date] = $mMoney->amount;
                }
//                Detail Export
                $aData['EXPORT_DETAIL'][] = array(
                    'DATE' => $date,
                    'MONEY' => $mMoney->amount,
                    'DESCRIPTION' => $mMoney->description,
                );
            }
//            set date GENERAL
            if(empty($aData['GENERAL']['DATES'][$date])){
                $aData['GENERAL']['DATES'][$date] = $date;
            }
            
        }
        return $aData;
    }
    
}