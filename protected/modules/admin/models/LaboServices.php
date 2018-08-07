<?php

/**
 * This is the model class for table "labo_services".
 *
 * The followings are the available columns in table 'labo_services':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property double $price
 * @property string $type_id
 * @property string $producer_id
 * @property string $time
 * @property integer $status
 * @property string $created_date
 * @property string $created_by
 */
class LaboServices extends BaseActiveRecord
{
    const STATUS_ACTIVE     = 1;
    const STATUS_INACTIVE   = 2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaboServices the static model class
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
		return 'labo_services';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, producer_id, type_id, price, time', 'required','on'=>'update,create'),
			array('time', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, price, type_id, producer_id, time, status, created_date, created_by', 'safe'),
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
                    'rCreatedBy' => array(self::BELONGS_TO, 'Users', 'created_by'),
                    'rType' => array(self::BELONGS_TO, 'LaboServiceTypes', 'type_id'),
                    'rProducer' => array(self::BELONGS_TO, 'LaboProducers', 'producer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => DomainConst::KEY_ID,
			'name' => DomainConst::CONTENT00042,
			'description' => DomainConst::CONTENT00062,
			'price' => DomainConst::CONTENT00129,
			'type_id' => DomainConst::CONTENT00290,
			'producer_id' => DomainConst::CONTENT00410,
			'time' => DomainConst::CONTENT00289,
			'status' => DomainConst::CONTENT00026,
			'created_date' => DomainConst::CONTENT00010,
			'created_by' => DomainConst::CONTENT00054,
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

		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('producer_id',$this->producer_id);
		$criteria->compare('time',$this->time);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * get created date
         * @return date
         */
        public function getCreatedDate(){
            return CommonProcess::convertDateTime($this->created_date,DomainConst::DATE_FORMAT_1,DomainConst::DATE_FORMAT_11);
        }
        
        /**
         * get full name of created by users
         * @return string
         */
        public function getCreatedBy(){
            return !empty($this->rCreatedBy) ? $this->rCreatedBy->getFullName() : '';
        }
        
        /**
         * get field name of table
         * @param string $fieldName
         * @return string
         */
        public function getField($fieldName){
            return !empty($this->$fieldName) ? $this->$fieldName : '';
        }
        
        /**
         * get string of price
         * @return string
         */
        public function getPrice(){
            return !empty($this->price) ? CommonProcess::formatCurrency($this->price) . ' ' . DomainConst::CONTENT00134 : '';
        }
        
        /**
         * get producer of service
         * @return string
         */
        public function getProducer(){
            return !empty($this->rProducer) ? $this->rProducer->name : '';
        }
        
        /**
         * get type of service
         * @return string
         */
        public function getType(){
            return !empty($this->rType) ? $this->rType->name : '';
        }
        
        /**
         * before save
         * @return parent
         */
        protected function beforeSave() {
            if($this->isNewRecord){
                $this->created_by = Yii::app()->user->id;
            }
            $this->price = str_replace(DomainConst::SPLITTER_TYPE_2, '', $this->price);
            return parent::beforeSave();
        }
        
        /**
         * 
         * @param type $emptyOption
         * @return string
         */
        public static function loadItems() {
            $_items = array();
            $criteria = new CDbCriteria;
            $criteria->compare('t.status', self::STATUS_ACTIVE);
            $criteria->order = 't.id ASC';
            $models = self::model()->findAll($criteria);
            foreach ($models as $model) {
                $_items[$model->id] = $model->name;
            }
            return $_items;
        }
}