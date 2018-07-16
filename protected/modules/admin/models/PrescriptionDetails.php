<?php

/**
 * This is the model class for table "prescription_details".
 *
 * The followings are the available columns in table 'prescription_details':
 * @property string $id
 * @property string $prescription_id
 * @property string $medicine_id
 * @property string $quantity
 * @property string $quantity1
 * @property string $quantity2
 * @property string $quantity3
 * @property string $quantity4
 * @property string $note
 * @property integer $status
 */
class PrescriptionDetails extends BaseActiveRecord
{
    public $autocomplete_id_medicine;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PrescriptionDetails the static model class
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
		return 'prescription_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('medicine_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('prescription_id, medicine_id, quantity, quantity1, quantity2, quantity3, quantity4', 'length', 'max'=>11),
			array('note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, prescription_id, medicine_id, quantity, quantity1, quantity2, quantity3, quantity4, note, status', 'safe', 'on'=>'search'),
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
                    'rPrescription' => array(self::BELONGS_TO, 'Prescriptions', 'prescription_id'),
                    'rMedicine' => array(self::BELONGS_TO, 'Medicines', 'medicine_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'prescription_id' => DomainConst::CONTENT00153,
			'medicine_id' => DomainConst::CONTENT00154,
			'quantity' => DomainConst::CONTENT00083,
			'quantity1' => DomainConst::CONTENT00155,
			'quantity2' => DomainConst::CONTENT00156,
			'quantity3' => DomainConst::CONTENT00157,
			'quantity4' => DomainConst::CONTENT00158,
			'note' => DomainConst::CONTENT00159,
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
		$criteria->compare('prescription_id',$this->prescription_id,true);
		$criteria->compare('medicine_id',$this->medicine_id,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('quantity1',$this->quantity1,true);
		$criteria->compare('quantity2',$this->quantity2,true);
		$criteria->compare('quantity3',$this->quantity3,true);
		$criteria->compare('quantity4',$this->quantity4,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}