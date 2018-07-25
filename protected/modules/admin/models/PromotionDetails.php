<?php

/**
 * This is the model class for table "promotions_detail".
 *
 * The followings are the available columns in table 'promotions_detail':
 * @property string $id
 * @property string $customer_types_id
 * @property double $discount
 * @property string $description
 * @property string $status
 * @property string $created_date
 * @property string $created_by
 * @property int $promotion_id
 */
class PromotionDetails extends CActiveRecord
{
    public $treatments;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PromotionDetails the static model class
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
		return 'promotion_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('treatments,discount, description', 'required','on'=>'create,update'),
			array('discount', 'numerical'),
			array('customer_types_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('status,customer_types_id,treatments, discount, description,promotion_id', 'safe'),
			array('id, promotion_id ,customer_types_id, discount, description', 'safe', 'on'=>'search'),
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
                    'rJoinTreatmentType' => array(
                        self::HAS_MANY, 'OneMany', 'one_id',
                        'on'    => 'type = ' . OneMany::TYPE_PROMOTION_TREATMENT_TYPE,
                    ),
                    'rPromotion' => array(self::BELONGS_TO, 'Promotions', 'promotion_id'),
                    'rCustomerType' => array(self::BELONGS_TO, 'CustomerTypes', 'customer_types_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer_types_id' => 'Loại khách hàng',
			'discount' => 'Giảm giá',
			'description' => 'Mô tả',
			'treatments' => 'Loại điều trị',
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
		$criteria->compare('customer_types_id',$this->customer_types_id,true);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * save promotion detail
         */
        public function handleSave(){
            if($this->scenario == 'create'){
                $this->created_by = Yii::app()->user->id;
            }else{
                $this->deleteJoin();
            }
            if($this->save()){
//                save onemany of promotion - agent
                $tableName = OneMany::model()->tableName();
                $aRowInsert = [];
                $typeOneMany = OneMany::TYPE_PROMOTION_TREATMENT_TYPE;
                foreach ($this->treatments as $key => $treatment_type_id) {
                    $aRowInsert[] = "(
                        '{$this->id}',
                        '{$treatment_type_id}',
                        '{$typeOneMany}'
                        )";
                }
                $sql = "insert into $tableName (
                            one_id,
                            many_id,
                            type
                        ) values" . implode(',', $aRowInsert);
                if (count($aRowInsert)){
                    Yii::app()->db->createCommand($sql)->execute();
                }
                return true;
            }
            return false;
        }
        
        /**
         * delete onemany
         */
        public function deleteJoin(){
            $aOneMany = $this->rJoinTreatmentType;
            foreach ($aOneMany as $key => $mOnemany) {
                $mOnemany->delete();
            }
        }
        
        /**
         * search by promotion
         * @return \CActiveDataProvider
         */
        public function searchByPromotion()
	{
            if(empty($this->promotion_id)){
                return new CActiveDataProvider();
            }
            $criteria   =   new CDbCriteria;
            $criteria->compare('promotion_id',$this->promotion_id);
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        /**
         * get field name of model
         * @param string $field
         * @return string
         */
        public function getField($field = 'id'){
            return !empty($this->$field) ? $this->$field : '';
        }
        
        /**
         * get string name of customer type
         * @return string
         */
        public function getCustomerType(){
            return !empty($this->rCustomerType) ? $this->rCustomerType->name : '';
        }
        
        /**
         * delete join
         * @return parent
         */
        public function beforeDelete() {
            $this->deleteJoin();
            return parent::beforeDelete();
        }
        
        /**
         * get treatment type
         * @return string
         */
        public function getTreatmentTypes(){
            $strResult = [];
            $aOneMany = $this->rJoinTreatmentType;
            $agent = [];
            foreach ($aOneMany as $key => $mOnemany) {
                $agent[] = $mOnemany->many_id;
            }
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $agent);
            $aTreatmentTypes = TreatmentTypes::model()->findAll($criteria);
            foreach ($aTreatmentTypes as $key => $mTreatmentTypes) {
                $strResult[] = $mTreatmentTypes->name;
            }
            return implode('<br>', $strResult);
        }
        
        /**
         * set list treat ment of model to $treatments
         */
        public function setTreatmentType(){
            $aOneMany = $this->rJoinTreatmentType;
            foreach ($aOneMany as $key => $mOnemany) {
                $this->treatments[$mOnemany->many_id] = $mOnemany->many_id;
            }
            
        }
        
        /**
         * get array status
         * @return array
         */
        public function getArrayStatus(){
            return [
                self::STATUS_ACTIVE => 'Hoạt động',
                self::STATUS_INACTIVE => 'Không hoạt động',
            ];
        }
}