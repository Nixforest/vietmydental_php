<?php

/**
 * This is the model class for table "warranties".
 *
 * The followings are the available columns in table 'warranties':
 * @property string $id
 * @property integer $customer_id
 * @property integer $type_id
 * @property string $start_date
 * @property string $end_date
 * @property integer $status
 */
class Warranties extends CActiveRecord
{
    public $autocomplete_name_customer;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Warranties the static model class
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
		return 'warranties';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_id, start_date, end_date', 'required'),
			array('customer_id, type_id, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, customer_id, type_id, start_date, end_date, status', 'safe', 'on'=>'search'),
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
                    'rType' => array(self::BELONGS_TO, 'WarrantyTypes', 'type_id'),
                    'rCustomer' => array(self::BELONGS_TO, 'Customers', 'customer_id'),
                    'rJoinTeeth' => array(
                        self::HAS_MANY, 'OneMany', 'one_id',
                        'on'    => 'type = ' . OneMany::TYPE_WARRANTY_TEETH,
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
			'customer_id' => DomainConst::CONTENT00135,
			'type_id' => DomainConst::CONTENT00290,
			'start_date' => DomainConst::CONTENT00139,
			'end_date' => DomainConst::CONTENT00140,
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
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('status',$this->status);
                $criteria->order = 'id DESC';

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
        // Format start date value
        $date = $this->start_date;
        $this->start_date = CommonProcess::convertDateTimeToMySqlFormat(
                $date, DomainConst::DATE_FORMAT_3);
        if (empty($this->start_date)) {
            $this->start_date = CommonProcess::convertDateTimeToMySqlFormat(
                    $date, DomainConst::DATE_FORMAT_4);
        }
        if (empty($this->start_date)) {
            $this->start_date = $date;
        }
        // Format end date value
        $date = $this->end_date;
        $this->end_date = CommonProcess::convertDateTimeToMySqlFormat(
                $date, DomainConst::DATE_FORMAT_3);
        if (empty($this->end_date)) {
            $this->end_date = $date;
        }
        return parent::beforeSave();
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Generate List teeth information string
     * @return String list teeth information string
     */
    public function generateTeethInfo($spliter = "<br>") {
        $array = array();
        foreach ($this->rJoinTeeth as $item) {
            $array[] = CommonProcess::getListTeeth()[$item->many_id];
        }        
        return implode($spliter, $array);
    }
}