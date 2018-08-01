<?php

/**
 * This is the model class for table "renodcm3_tb_chitietphieuthu".
 *
 * The followings are the available columns in table 'renodcm3_tb_chitietphieuthu':
 * @property integer $Id
 * @property integer $PhieuThuId
 * @property integer $TreatmentId
 * @property integer $ProductId
 * @property string $Content
 * @property double $UnitPrice
 * @property integer $Quantity
 * @property double $OldRemain
 * @property double $Payed
 * @property double $NewRemain
 *
 * The followings are the available model relations:
 * @property Renodcm3TbPhieuthu $phieuThu
 * @property Renodcm3TbTreatment $treatment
 */
class Renodcm3TbChitietphieuthu extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Renodcm3TbChitietphieuthu the static model class
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
		return 'renodcm3_tb_chitietphieuthu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('PhieuThuId, TreatmentId, ProductId, Quantity', 'numerical', 'integerOnly'=>true),
			array('UnitPrice, OldRemain, Payed, NewRemain', 'numerical'),
			array('Content', 'length', 'max'=>300),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, PhieuThuId, TreatmentId, ProductId, Content, UnitPrice, Quantity, OldRemain, Payed, NewRemain', 'safe', 'on'=>'search'),
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
			'phieuThu' => array(self::BELONGS_TO, 'Renodcm3TbPhieuthu', 'PhieuThuId'),
			'treatment' => array(self::BELONGS_TO, 'Renodcm3TbTreatment', 'TreatmentId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'PhieuThuId' => 'Phieu Thu',
			'TreatmentId' => 'Treatment',
			'ProductId' => 'Product',
			'Content' => 'Content',
			'UnitPrice' => 'Unit Price',
			'Quantity' => 'Quantity',
			'OldRemain' => 'Old Remain',
			'Payed' => 'Payed',
			'NewRemain' => 'New Remain',
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
		$criteria->compare('PhieuThuId',$this->PhieuThuId);
		$criteria->compare('TreatmentId',$this->TreatmentId);
		$criteria->compare('ProductId',$this->ProductId);
		$criteria->compare('Content',$this->Content,true);
		$criteria->compare('UnitPrice',$this->UnitPrice);
		$criteria->compare('Quantity',$this->Quantity);
		$criteria->compare('OldRemain',$this->OldRemain);
		$criteria->compare('Payed',$this->Payed);
		$criteria->compare('NewRemain',$this->NewRemain);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function createFields() {
        $fields = array();
        
        $fields[] = $this->Content;
        $fields[] = CommonProcess::formatCurrency($this->UnitPrice);
        $fields[] = $this->Quantity;
        $fields[] = CommonProcess::formatCurrency($this->OldRemain);
        $fields[] = CommonProcess::formatCurrency($this->Payed);
        $fields[] = CommonProcess::formatCurrency($this->NewRemain);
        return $fields;
    }
    
    public function createFieldsLbl() {
        $fields = array();
        
        $fields[] = 'Content';
        $fields[] = 'UnitPrice';
        $fields[] = 'Quantity';
        $fields[] = 'OldRemain';
        $fields[] = 'Payed';
        $fields[] = 'NewRemain';
        return $fields;
    }
}