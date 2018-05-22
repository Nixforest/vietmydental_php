<?php

/**
 * This is the model class for table "money".
 *
 * The followings are the available columns in table 'money':
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property integer $isIncomming
 * @property string $amount
 * @property integer $account_id
 * @property string $action_date
 * @property string $created_date
 * @property string $description
 * @property integer $status
 */
class Money extends BaseActiveRecord
{
    public $autocomplete_name_user;
    public $moneyType;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Money the static model class
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
		return 'money';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, isIncomming, action_date, description', 'required'),
			array('user_id, isIncomming, account_id, status', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>11),
			array('created_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, user_id, isIncomming, amount, account_id, action_date, created_date, description', 'safe', 'on'=>'search'),
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
                    'rAccount' => array(self::BELONGS_TO, 'MoneyAccount', 'account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                'id'            => DomainConst::CONTENT00003,
                'name'          => DomainConst::CONTENT00004,
                'user_id'       => DomainConst::CONTENT00005,
                'isIncomming'   => DomainConst::CONTENT00006,
                'amount'        => DomainConst::CONTENT00007,
                'account_id'    => DomainConst::CONTENT00008,
                'action_date'   => DomainConst::CONTENT00009,
                'created_date'  => DomainConst::CONTENT00010,
                'description'   => DomainConst::CONTENT00011,
		'status'        => DomainConst::CONTENT00026,
		'moneyType'     => DomainConst::CONTENT00347,
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('isIncomming',$this->isIncomming);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('action_date',$this->action_date,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);
                $criteria->order = 'action_date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /**
     * Handle before save action
     * @return type Parent method result
     */
    protected function beforeSave() {
        $userId = isset(Yii::app()->user) ? Yii::app()->user->id : '';
        // Format action date value
        $this->action_date = CommonProcess::convertDateTimeToMySqlFormat(
                $this->action_date, DomainConst::DATE_FORMAT_3);
        // Get MoneyAccount model
        $account = MoneyAccount::model()->findByPk($this->account_id);
        // If receipt
        if ($this->isIncomming == DomainConst::NUMBER_ONE_VALUE) {
            // Increase balance
            $account->balance += $this->amount;
        } else if ($this->isIncomming == DomainConst::NUMBER_ZERO_VALUE) {  // Payment
            // Descrease balance
            $account->balance -= $this->amount;
        }
        // Update MoneyAccount model
        $account->save();
        if ($this->isNewRecord) {
            // Handle created by
            if (empty($this->user_id)) {
                $this->user_id = $userId;
            }
        }
        // Call parent method
        return parent::beforeSave();
    }
}