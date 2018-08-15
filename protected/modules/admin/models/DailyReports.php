<?php

/**
 * This is the model class for table "daily_reports".
 *
 * The followings are the available columns in table 'daily_reports':
 * @property string $id
 * @property double $receipt_customer_total
 * @property double $receipt_total_total
 * @property double $receipt_discount_total
 * @property double $receipt_final_total
 * @property double $receipt_debit_total
 * @property double $new_customer_total
 * @property double $new_total_total
 * @property double $new_discount_total
 * @property double $new_final_total
 * @property double $new_debit_total
 * @property string $approve_id
 * @property integer $status
 * @property string $created_by
 * @property string $created_date
 */
class DailyReports extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DailyReports the static model class
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
		return 'daily_reports';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('receipt_customer_total, approve_id, created_by, created_date', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('receipt_customer_total, receipt_total_total, receipt_discount_total, receipt_final_total, receipt_debit_total, new_customer_total, new_total_total, new_discount_total, new_final_total, new_debit_total', 'numerical'),
			array('approve_id, created_by', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, receipt_customer_total, receipt_total_total, receipt_discount_total, receipt_final_total, receipt_debit_total, new_customer_total, new_total_total, new_discount_total, new_final_total, new_debit_total, approve_id, status, created_by, created_date', 'safe', 'on'=>'search'),
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
			'id' => DomainConst::KEY_ID,
			'receipt_customer_total' => DomainConst::CONTENT00352,
			'receipt_total_total' => DomainConst::CONTENT00353,
			'receipt_discount_total' => DomainConst::CONTENT00354,
			'receipt_final_total' => DomainConst::CONTENT00355,
			'receipt_debit_total' => DomainConst::CONTENT00356,
			'new_customer_total' => DomainConst::CONTENT00352,
			'new_total_total' => DomainConst::CONTENT00353,
			'new_discount_total' => DomainConst::CONTENT00354,
			'new_final_total' => DomainConst::CONTENT00355,
			'new_debit_total' => DomainConst::CONTENT00356,
			'approve_id' => 'Người duyệt',
			'status' => DomainConst::CONTENT00026,
			'created_by' => DomainConst::CONTENT00054,
			'created_date' => DomainConst::CONTENT00010,
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
		$criteria->compare('receipt_customer_total',$this->receipt_customer_total);
		$criteria->compare('receipt_total_total',$this->receipt_total_total);
		$criteria->compare('receipt_discount_total',$this->receipt_discount_total);
		$criteria->compare('receipt_final_total',$this->receipt_final_total);
		$criteria->compare('receipt_debit_total',$this->receipt_debit_total);
		$criteria->compare('new_customer_total',$this->new_customer_total);
		$criteria->compare('new_total_total',$this->new_total_total);
		$criteria->compare('new_discount_total',$this->new_discount_total);
		$criteria->compare('new_final_total',$this->new_final_total);
		$criteria->compare('new_debit_total',$this->new_debit_total);
		$criteria->compare('approve_id',$this->approve_id,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('created_date',$this->created_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}