<?php

/**
 * This is the model class for table "labo_requests".
 *
 * The followings are the available columns in table 'labo_requests':
 * @property string $id
 * @property string $treatment_detail_id
 * @property string $service_id
 * @property string $date_request
 * @property string $date_receive
 * @property string $date_test
 * @property string $tooth_color
 * @property string $teeths
 * @property string $description
 * @property double $price
 * @property double $total
 * @property integer $status
 * @property string $created_date
 * @property string $created_by
 */
class LaboRequests extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaboRequests the static model class
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
		return 'labo_requests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price, total, created_date', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('price, total', 'numerical'),
			array('treatment_detail_id, service_id, created_by', 'length', 'max'=>10),
			array('tooth_color, description', 'length', 'max'=>255),
			array('date_request, date_receive, date_test, teeths', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, treatment_detail_id, service_id, date_request, date_receive, date_test, tooth_color, teeths, description, price, total, status, created_date, created_by', 'safe', 'on'=>'search'),
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
			'treatment_detail_id' => 'Treatment Detail',
			'service_id' => 'Service',
			'date_request' => 'Date Request',
			'date_receive' => 'Date Receive',
			'date_test' => 'Date Test',
			'tooth_color' => 'Tooth Color',
			'teeths' => 'Teeths',
			'description' => 'Description',
			'price' => 'Price',
			'total' => 'Total',
			'status' => 'Status',
			'created_date' => 'Created Date',
			'created_by' => 'Created By',
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
		$criteria->compare('treatment_detail_id',$this->treatment_detail_id,true);
		$criteria->compare('service_id',$this->service_id,true);
		$criteria->compare('date_request',$this->date_request,true);
		$criteria->compare('date_receive',$this->date_receive,true);
		$criteria->compare('date_test',$this->date_test,true);
		$criteria->compare('tooth_color',$this->tooth_color,true);
		$criteria->compare('teeths',$this->teeths,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('total',$this->total);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}