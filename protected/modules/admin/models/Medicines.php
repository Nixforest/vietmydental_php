<?php

/**
 * This is the model class for table "medicines".
 *
 * The followings are the available columns in table 'medicines':
 * @property string $id
 * @property string $name
 * @property string $code
 * @property string $content
 * @property integer $unit_id
 * @property string $active_ingredient
 * @property integer $use_id
 * @property string $manufacturer
 * @property integer $type_id
 * @property string $buy_price
 * @property string $sell_price
 * @property integer $status
 */
class Medicines extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Medicines the static model class
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
		return 'medicines';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code, unit_id, use_id, type_id', 'required'),
			array('unit_id, use_id, type_id, status', 'numerical', 'integerOnly'=>true),
			array('name, code, active_ingredient, manufacturer', 'length', 'max'=>255),
			array('content', 'length', 'max'=>50),
			array('buy_price, sell_price', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, code, content, unit_id, active_ingredient, use_id, manufacturer, type_id, buy_price, sell_price, status', 'safe', 'on'=>'search'),
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
                    'rUnit' => array(self::BELONGS_TO, 'Units', 'unit_id'),
                    'rUse' => array(self::BELONGS_TO, 'MedicineUses', 'use_id'),
                    'rType' => array(self::BELONGS_TO, 'MedicineTypes', 'type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => DomainConst::CONTENT00112,
			'code' => DomainConst::CONTENT00003,
			'content' => DomainConst::CONTENT00113,
			'unit_id' => DomainConst::CONTENT00114,
			'active_ingredient' => DomainConst::CONTENT00115,
			'use_id' => DomainConst::CONTENT00111,
			'manufacturer' => DomainConst::CONTENT00116,
			'type_id' => DomainConst::CONTENT00110,
			'buy_price' => DomainConst::CONTENT00117,
			'sell_price' => DomainConst::CONTENT00118,
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('active_ingredient',$this->active_ingredient,true);
		$criteria->compare('use_id',$this->use_id);
		$criteria->compare('manufacturer',$this->manufacturer,true);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('buy_price',$this->buy_price,true);
		$criteria->compare('sell_price',$this->sell_price,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------    
    /**
     * Loads the application items for the specified type from the database
     * @param type $emptyOption boolean the item is empty
     * @return type List data
     */
    public static function loadItems($emptyOption = false) {
        $_items = array();
        if ($emptyOption) {
            $_items[""] = "";
        }
        $models = self::model()->findAll(array(
            'order' => 'id ASC',
        ));
        foreach ($models as $model) {
            $_items[$model->id] = $model->name;
        }
        return $_items;
    }

    /**
     * Get autocomplete medical record
     * @return String [Type: name - code - content]
     */
    public function getAutoCompleteMedicine() {
        $retVal = "";
        if (isset($this->rType)) {
        $retVal .= $this->rType->name . ': ';
        }
        $retVal .= $this->name;
        $retVal .= ' - ' . $this->code;
        if (isset($this->content)) {
            $retVal .= ' - ' . $this->content;
        }
        return $retVal;
    }
}