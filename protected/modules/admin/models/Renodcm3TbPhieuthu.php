<?php

/**
 * This is the model class for table "renodcm3_tb_phieuthu".
 *
 * The followings are the available columns in table 'renodcm3_tb_phieuthu':
 * @property integer $Id
 * @property string $PhieuThuMa
 * @property integer $TreatmentProfiles_ID
 * @property string $PhieuThuNgay
 * @property integer $OrderTicket_ID
 * @property integer $Patient_ID
 * @property string $PatientCode
 * @property double $Money
 * @property string $Content
 * @property integer $UnitId
 * @property double $Rate
 * @property integer $IsMoney
 * @property integer $CardId
 * @property integer $Method_ID
 * @property string $CardNumber
 * @property string $BankName
 * @property integer $IsDeleted
 * @property integer $IsInvoice
 *
 * The followings are the available model relations:
 * @property Renodcm3TbChitietphieuthu[] $renodcm3TbChitietphieuthus
 */
class Renodcm3TbPhieuthu extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Renodcm3TbPhieuthu the static model class
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
		return 'renodcm3_tb_phieuthu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('TreatmentProfiles_ID, OrderTicket_ID, Patient_ID, UnitId, IsMoney, CardId, Method_ID, IsDeleted, IsInvoice', 'numerical', 'integerOnly'=>true),
			array('Money, Rate', 'numerical'),
			array('PhieuThuMa, PatientCode, CardNumber', 'length', 'max'=>50),
			array('Content', 'length', 'max'=>300),
			array('BankName', 'length', 'max'=>100),
			array('PhieuThuNgay', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, PhieuThuMa, TreatmentProfiles_ID, PhieuThuNgay, OrderTicket_ID, Patient_ID, PatientCode, Money, Content, UnitId, Rate, IsMoney, CardId, Method_ID, CardNumber, BankName, IsDeleted, IsInvoice', 'safe', 'on'=>'search'),
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
			'renodcm3TbChitietphieuthus' => array(self::HAS_MANY, 'Renodcm3TbChitietphieuthu', 'PhieuThuId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'PhieuThuMa' => 'Phieu Thu Ma',
			'TreatmentProfiles_ID' => 'Treatment Profiles',
			'PhieuThuNgay' => 'Phieu Thu Ngay',
			'OrderTicket_ID' => 'Order Ticket',
			'Patient_ID' => 'Patient',
			'PatientCode' => 'Patient Code',
			'Money' => 'Money',
			'Content' => 'Content',
			'UnitId' => 'Unit',
			'Rate' => 'Rate',
			'IsMoney' => 'Is Money',
			'CardId' => 'Card',
			'Method_ID' => 'Method',
			'CardNumber' => 'Card Number',
			'BankName' => 'Bank Name',
			'IsDeleted' => 'Is Deleted',
			'IsInvoice' => 'Is Invoice',
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

		$criteria->compare('Id',$this->Id);
		$criteria->compare('PhieuThuMa',$this->PhieuThuMa,true);
		$criteria->compare('TreatmentProfiles_ID',$this->TreatmentProfiles_ID);
		$criteria->compare('PhieuThuNgay',$this->PhieuThuNgay,true);
		$criteria->compare('OrderTicket_ID',$this->OrderTicket_ID);
		$criteria->compare('Patient_ID',$this->Patient_ID);
		$criteria->compare('PatientCode',$this->PatientCode,true);
		$criteria->compare('Money',$this->Money);
		$criteria->compare('Content',$this->Content,true);
		$criteria->compare('UnitId',$this->UnitId);
		$criteria->compare('Rate',$this->Rate);
		$criteria->compare('IsMoney',$this->IsMoney);
		$criteria->compare('CardId',$this->CardId);
		$criteria->compare('Method_ID',$this->Method_ID);
		$criteria->compare('CardNumber',$this->CardNumber,true);
		$criteria->compare('BankName',$this->BankName,true);
		$criteria->compare('IsDeleted',$this->IsDeleted);
		$criteria->compare('IsInvoice',$this->IsInvoice);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function createFields() {
        $fields = array();
        
        $fields[] = $this->PhieuThuNgay;
        $fields[] = CommonProcess::formatCurrency($this->Money);
        return $fields;
    }
    
    public function createFieldsLbl() {
        $fields = array();
        
        $fields[] = 'PhieuThuNgay';
        $fields[] = 'Money';
        return $fields;
    }
}