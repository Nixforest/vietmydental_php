<?php

/**
 * This is the model class for table "streets".
 *
 * The followings are the available columns in table 'streets':
 * @property string $id
 * @property integer $city_id
 * @property string $name
 * @property string $short_name
 * @property integer $status
 * @property string $slug
 */
class Streets extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Streets the static model class
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
		return 'streets';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_id, name', 'required'),
			array('city_id, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>200),
			array('short_name, slug', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, city_id, name, short_name, status, slug', 'safe', 'on'=>'search'),
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
                    'rCity' => array(self::BELONGS_TO, 'Cities', 'city_id'),
                    'rUsers' => array(self::HAS_MANY, 'Users', 'street_id',
                        'on'    => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
                        'order' => 'name ASC',
                        ),
                    'rAgent' => array(self::HAS_MANY, 'Agents', 'street_id',
                        'on'    => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
                        'order' => 'name ASC',
                        ),
                    'rCustomer' => array(self::HAS_MANY, 'Customers', 'street_id',
                        'on'    => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
                        'order' => 'name ASC',
                        ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'city_id' => DomainConst::CONTENT00093,
			'name' => DomainConst::CONTENT00042,
			'short_name' => DomainConst::CONTENT00092,
			'status' => DomainConst::CONTENT00026,
			'slug' => DomainConst::CONTENT00095,
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
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('short_name',$this->short_name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('slug',$this->slug,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => Settings::getListPageSize(),
                        ),
		));
	}
        
    //-----------------------------------------------------
    // Parent override methods
    //-----------------------------------------------------
    /**
     * Override before delete method
     * @return Parent result
     */
    protected function beforeDelete() {
        $retVal = true;
        // Check foreign table agents
        $agents = Agents::model()->findByAttributes(array('street_id' => $this->id));
        if (count($agents) > 0) {
            $retVal = false;
        }
        // Check foreign table customers
        $customers = Customers::model()->findByAttributes(array('street_id' => $this->id));
        if (count($customers) > 0) {
            $retVal = false;
        }
        // Check foreign table users
        $users = Users::model()->findByAttributes(array('street_id' => $this->id));
        if (count($users) > 0) {
            $retVal = false;
        }
        return $retVal;
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
            $_items[$model->id] = $model->name. ' - ' . $model->rCity->name;
        }
        return $_items;
    }
    
    /**
     * Get autocomplete street
     * @return String [name - city_name]
     */
    public function getAutoCompleteStreet() {
        $retVal = $this->name;
        $retVal .= ' - ' . $this->rCity->name;
        return $retVal;
    }

    //-----------------------------------------------------
    // JSON methods
    //-----------------------------------------------------
    public static function getJsonList($root, $mUser) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.status!=" . DomainConst::DEFAULT_STATUS_INACTIVE);
        $criteria->addCondition("t.city_id=" . $root->id);
        $criteria->order = 't.id DESC';
        // Set condition
        $pageSize = Settings::getApiListPageSize();
        $page = (int)$root->page;
        if ($root->page == -1) {
            $pageSize = 1000;
            $page = 0;
        }
        $retVal = new CActiveDataProvider(
                new Streets(),
                array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => $pageSize,
                        'currentPage' => $page,
                    ),
                ));
        return $retVal;
    }
}