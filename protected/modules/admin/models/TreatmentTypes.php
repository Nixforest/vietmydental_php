<?php

/**
 * This is the model class for table "treatment_types".
 *
 * The followings are the available columns in table 'treatment_types':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $price
 * @property string $material_price
 * @property string $labo_price
 * @property integer $group_id
 * @property integer $status
 */
class TreatmentTypes extends BaseActiveRecord
{
    //++ BUG0059-IMT (NguyenPT 20180809) Add new status of TreatmentTypes
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const STATUS_INACTIVE               = 0;
    const STATUS_ACTIVE                 = 1;
    const STATUS_OLD                    = 2;
    //-- BUG0059-IMT (NguyenPT 20180809) Add new status of TreatmentTypes
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TreatmentTypes the static model class
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
		return 'treatment_types';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, price, group_id', 'required'),
			array('group_id, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('price, material_price, labo_price', 'length', 'max'=>11),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, price, material_price, labo_price, group_id, status', 'safe', 'on'=>'search'),
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
                    'rGroup' => array(self::BELONGS_TO, 'TreatmentGroup', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => DomainConst::CONTENT00128,
			'description' => DomainConst::CONTENT00062,
			'price' => DomainConst::CONTENT00129,
			'material_price' => DomainConst::CONTENT00130,
			'labo_price' => DomainConst::CONTENT00131,
			'group_id' => DomainConst::CONTENT00127,
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('material_price',$this->material_price,true);
		$criteria->compare('labo_price',$this->labo_price,true);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => Settings::getListPageSize(),
                        ),
		));
	}
        
    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Get price of treatment type
     * @return String Value of price after formated.
     */
    public function getPrice() {
        return CommonProcess::formatCurrency($this->price);
    }

    /**
     * Get autocomplete
     * @return String [id - last_name first_name]
     */
    public function getAutoCompleteView() {
        //++ BUG0059-IMT (NguyenPT 20180809) Add new status of TreatmentTypes
        //return $this->name . " - " . CommonProcess::formatCurrency($this->price);
        $old = ($this->status == self::STATUS_OLD) ? ' (Cũ)' : '';
        return $this->name . $old . " - " . CommonProcess::formatCurrency($this->price);
        //-- BUG0059-IMT (NguyenPT 20180809) Add new status of TreatmentTypes
    }
    
    //++ BUG0059-IMT (NguyenPT 20180809) Add new status of TreatmentTypes
    /**
     * Get status string
     * @return Array Status list
     */
    public static function getStatus() {
        $retVal = array(
            self::STATUS_INACTIVE   => DomainConst::CONTENT00028,
            self::STATUS_ACTIVE     => DomainConst::CONTENT00027,
            self::STATUS_OLD        => DomainConst::CONTENT00413,
        );
        return $retVal;
    }
    //-- BUG0059-IMT (NguyenPT 20180809) Add new status of TreatmentTypes

    //-----------------------------------------------------
    // Static methods
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
            if ($model->status == DomainConst::DEFAULT_STATUS_ACTIVE) {
                $_items[$model->id] = $model->name . " - " . CommonProcess::formatCurrency($model->price);
            }
        }
        return $_items;
    }
    
    /**
     * Get model by name
     * @param String $name Name value
     * @return Object Model object if found, NULL otherwise
     */
    public static function getModelByName($name) {
        $model = self::model()->findByAttributes(array(
            'name' => $name,
        ));
        if (!empty($model)) {
            return $model;
        }
        return NULL;
    }
}