<?php

/**
 * This is the model class for table "labo_service_types".
 *
 * The followings are the available columns in table 'labo_service_types':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property string $created_date
 * @property integer $created_by
 */
class LaboServiceTypes extends BaseActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 1;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaboServiceTypes the static model class
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
		return 'labo_service_types';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required','on'=>'update,create'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, status, created_date, created_by', 'safe'),
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
         * get field name of table
         * @param string $fieldName
         * @return string
         */
        public function getField($fieldName){
            return !empty($this->$fieldName) ? $this->$fieldName : '';
        }
        
        /**
         * get array status of record
         * @return array
         */
        public function getArrayStatus(){
            return [
                self::STATUS_ACTIVE     => DomainConst::CONTENT00407,
                self::STATUS_INACTIVE   => DomainConst::CONTENT00408,
            ];
        }
        
        /**
         * get full name of created by users
         * @return string
         */
        public function getCreatedBy(){
            return !empty($this->rCreatedBy) ? $this->rCreatedBy->getFullName() : '';
        }
        
        /**
         * before save
         * @return parent
         */
        protected function beforeSave() {
            if($this->isNewRecord){
                $this->created_by = Yii::app()->user->id;
            }
            return parent::beforeSave();
        }
}