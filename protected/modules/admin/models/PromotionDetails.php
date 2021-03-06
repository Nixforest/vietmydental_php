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
 * @property string $type
 * @property string $created_date
 * @property string $created_by
 * @property int $promotion_id
 */
class PromotionDetails extends BaseActiveRecord
{
    public $treatments;
    const TYPE_DISCOUNT = 1;// Trừ theo phần trăm
    const TYPE_SERVICE = 2; // Trừ theo số tiền
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
			array('type,discount, description', 'required','on'=>'create,update'),
			array('discount', 'numerical'),
			array('customer_types_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('status,type,customer_types_id,treatments, discount, description,promotion_id', 'safe'),
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
			'id' => DomainConst::KEY_ID,
			'customer_types_id' => DomainConst::CONTENT00107,
			'discount' => DomainConst::CONTENT00317,
			'description' => DomainConst::CONTENT00062,
			'treatments' => DomainConst::CONTENT00128,
			'type' => DomainConst::CONTENT00404,
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
		$criteria->compare('type',$this->type);
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
                if(!empty($this->treatments))
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
            return !empty($this->rCustomerType) ? $this->rCustomerType->name : DomainConst::CONTENT00409;
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
            //++ BUG0059-IMT (NguyenPT 20180809) Add new status of TreatmentTypes
            $criteria->addCondition('t.status !=' . TreatmentTypes::STATUS_INACTIVE);
            //-- BUG0059-IMT (NguyenPT 20180809) Add new status of TreatmentTypes
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
                self::STATUS_ACTIVE => DomainConst::CONTENT00407,
                self::STATUS_INACTIVE => DomainConst::CONTENT00408,
            ];
        }
        
        /**
         * get array of type
         * @return array
         */
        public function getArrayType(){
            return [
                self::TYPE_DISCOUNT => DomainConst::CONTENT00405,
                self::TYPE_SERVICE => DomainConst::CONTENT00406,
            ];
        }
        
                
        /**
         * get type of promotions
         * @return string
         */
        public function getType(){
            $aType = $this->getArrayType();
            return !empty($aType[$this->type]) ? $aType[$this->type] : '';
        }
        
        /**
         * convert $this->discount -> int
         */
        public function convertDiscount(){
            $this->discount = str_replace(DomainConst::SPLITTER_TYPE_2, '', $this->discount);
        }
        
        /**
         * get view discount
         * @return string
         */
        public function getDiscount(){
            $result = '';
            switch ($this->type){
                case self::TYPE_DISCOUNT:
                    $result = $this->discount.' '.DomainConst::CONTENT00410;
                    break;
                case self::TYPE_SERVICE:
                    $result = CommonProcess::formatCurrency($this->discount) . ' ' . DomainConst::CONTENT00134;
                    break;
            }
            return $result;
        }
}