<?php

/**
 * This is the model class for table "receipts".
 *
 * The followings are the available columns in table 'receipts':
 * @property string $id
 * @property string $detail_id
 * @property string $process_date
 * @property string $discount
 * @property integer $need_approve
 * @property integer $customer_confirm
 * @property string $description
 * @property string $created_date
 * @property string $created_by
 * @property integer $status
 */
class Receipts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Receipts the static model class
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
		return 'receipts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('detail_id, process_date, created_date, created_by', 'required'),
			array('need_approve, customer_confirm, status', 'numerical', 'integerOnly'=>true),
			array('detail_id, discount, created_by', 'length', 'max'=>11),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, detail_id, process_date, discount, need_approve, customer_confirm, description, created_date, created_by, status', 'safe', 'on'=>'search'),
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
                    'rTreatmentScheduleDetail' => array(
                        self::BELONGS_TO, 'TreatmentScheduleDetails',
                        'detail_id'
                    ),
                    'rJoinAgent' => array(
                        self::HAS_MANY, 'OneMany', 'many_id',
                        'on'    => 'type = ' . OneMany::TYPE_AGENT_RECEIPT,
                    ),
                    'rUser' => array(
                        self::BELONGS_TO, 'Users', 'created_by'
                    )
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'detail_id' => DomainConst::CONTENT00146,
			'process_date' => DomainConst::CONTENT00241,
			'discount' => DomainConst::CONTENT00242,
			'need_approve' => DomainConst::CONTENT00243,
			'customer_confirm' => DomainConst::CONTENT00244,
			'description' => DomainConst::CONTENT00062,
			'created_date' => DomainConst::CONTENT00010,
			'created_by' => DomainConst::CONTENT00054,
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
		$criteria->compare('detail_id',$this->detail_id,true);
		$criteria->compare('process_date',$this->process_date,true);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('need_approve',$this->need_approve);
		$criteria->compare('customer_confirm',$this->customer_confirm);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('status',$this->status);

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
        $userId = isset(Yii::app()->user) ? Yii::app()->user->id : '';
        if ($this->isNewRecord) {   // Add
            // Handle created by
            if (empty($this->created_by)) {
                $this->created_by = $userId;
            }
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        } else {                    // Update
            
        }
        return parent::beforeSave();
    }
}