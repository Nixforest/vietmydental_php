<?php

/**
 * This is the model class for table "cities".
 *
 * The followings are the available columns in table 'cities':
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property integer $status
 * @property string $slug
 */
class Cities extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cities the static model class
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
		return 'cities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>200),
			array('short_name, slug', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, short_name, status, slug', 'safe', 'on'=>'search'),
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
                    'rDistrict' => array(self::HAS_MANY, 'Districts', 'city_id',
                        'on' => 'status = 1',
                        'order' => 'name ASC',
                        ),
                    'rStreet' => array(self::HAS_MANY, 'Streets', 'city_id',
                        'on' => 'status = 1',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('short_name',$this->short_name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('slug',$this->slug,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    //-----------------------------------------------------
    // Parent override methods
    //-----------------------------------------------------

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
     * Get all districts in city
     * @param Int $id   City id
     * @return CArrayDataProvider
     */
    public function getDistricts($id) {
        return new CArrayDataProvider(self::model()->findByPk($id)->rDistrict, array(
            'id' => 'districts',
            'sort'=>array(
                'attributes'=>array(
                     'id', 'name', 'short_name', 'slug',
                ),
            ),
            'pagination'=>array(
                'pageSize'=>Settings::getListPageSize(),
            ),
        ));
    }
    
    /**
     * Get list districts data
     * @param String $id City id
     * @return CHtml::listData
     */
    public function getListDistrictsData($id) {
        return CHtml::listData(self::model()->findByPk($id)->rDistrict, 'id', 'name');
    }
        
    /**
     * Get all streets in city
     * @param Int $id   City id
     * @return CArrayDataProvider
     */
    public function getStreets($id) {
        return new CArrayDataProvider(self::model()->findByPk($id)->rStreet, array(
            'id' => 'streets',
            'sort'=>array(
                'attributes'=>array(
                     'id', 'name', 'short_name', 'slug',
                ),
            ),
            'pagination'=>array(
                'pageSize'=>Settings::getListPageSize(),
            ),
        ));
    }
    
    /**
     * Get list streets data
     * @param String $id City id
     * @return CHtml::listData
     */
    public function getListStreetsData($id) {
        return CHtml::listData(self::model()->findByPk($id)->rStreet, 'id', 'name');
    }

    //-----------------------------------------------------
    // JSON methods
    //-----------------------------------------------------
    /**
     * Get address config
     * @return Array
     */
    public static function getJsonAddressConfig() {
        $retVal = array();
        $models = self::model()->findAll(array(
            'order' => 'id ASC',
        ));
        foreach ($models as $model) {
            $dataDistricts = array();
            if ($model->rDistrict) {
                foreach ($model->rDistrict as $district) {
                    $dataWards = array();
                    if ($district->rWard) {
                        foreach ($district->rWard as $ward) {
                            $dataWards[] = CommonProcess::createConfigJson($ward->id, $ward->name);
                        }
                    }
                    $dataDistricts[] = CommonProcess::createConfigJson($district->id, $district->name, $dataWards);
                }
            }
            $retVal[] = CommonProcess::createConfigJson($model->id, $model->name, $dataDistricts);
        }
        return $retVal;
    }
}