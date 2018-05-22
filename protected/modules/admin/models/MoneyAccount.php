<?php

/**
 * This is the model class for table "money_account".
 *
 * The followings are the available columns in table 'money_account':
 * @property integer $id
 * @property string $name
 * @property string $owner_id
 * @property string $agent_id
 * @property string $balance
 * @property string $created_date
 * @property integer $status
 */
class MoneyAccount extends BaseActiveRecord
{
    public $autocomplete_name_owner;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MoneyAccount the static model class
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
		return 'money_account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>32),
			array('owner_id, agent_id, balance', 'length', 'max'=>11),
			array('created_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, owner_id, agent_id, balance, created_date, status', 'safe', 'on'=>'search'),
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
                    'rOwner' => array(self::BELONGS_TO, 'Users', 'owner_id'),
                    'rAgent' => array(self::BELONGS_TO, 'Agents', 'agent_id'),
                    'rMoney' => array(self::HAS_MANY, 'Money', 'account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return array(
                'id'            => DomainConst::CONTENT00003,
                'name'          => DomainConst::CONTENT00012,
                'owner_id'      => DomainConst::CONTENT00013,
		'agent_id'      => DomainConst::CONTENT00199,
                'balance'       => DomainConst::CONTENT00014,
                'created_date'  => DomainConst::CONTENT00010,
		'status'        => DomainConst::CONTENT00026,
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('owner_id',$this->owner_id,true);
		$criteria->compare('agent_id',$this->agent_id,true);
		$criteria->compare('balance',$this->balance,true);
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
        // Handle created date
        if ($this->isNewRecord) {
            $this->created_date = CommonProcess::getCurrentDateTime();
        }
        return parent::beforeSave();
    }
        
    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------   
    /**
     * Loads the application items for the specified type from the database
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
            if ($model->status == DomainConst::DEFAULT_STATUS_ACTIVE) {
                $_items[$model->id] = $model->name;
            }
        }
        return $_items;
    }
    
    /**
     * Get current balance
     * @return type
     */
    public function getBalance() {
        $inBalance = 0;
        $outBalance = 0;
        if (isset($this->rMoney)) {
            foreach ($this->rMoney as $value) {
                if ($value->isIncomming == DomainConst::NUMBER_ONE_VALUE) {
                    $inBalance += $value->amount;
                } else {
                    $outBalance += $value->amount;
                }
            }
        }
        return $inBalance - $outBalance;
    }
}