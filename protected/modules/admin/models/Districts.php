<?php

/**
 * This is the model class for table "districts".
 *
 * The followings are the available columns in table 'districts':
 * @property integer $id
 * @property integer $city_id
 * @property string $name
 * @property string $short_name
 * @property integer $status
 * @property string $slug
 */
class Districts extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Districts the static model class
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
		return 'districts';
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
                    'rWard' => array(self::HAS_MANY, 'Wards', 'district_id'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('short_name',$this->short_name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('slug',$this->slug,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------    
    /**
     * Loads the application items for the specified type from the database
     * @param type $city_id Id of city
     * @param type $emptyOption boolean the item is empty
     * @return type List data
     */
    public static function loadItems($city_id = '', $emptyOption = false) {
        $_items = array();
        if ($emptyOption) {
            $_items[""] = "";
        }
        $models = self::model()->findAll(array(
            'order' => 'id ASC',
        ));
        foreach ($models as $model) {
            if (!empty($city_id)) {
                if ($model->city_id == $city_id) {
                    $_items[$model->id] = $model->name. ' - ' . $model->rCity->name;
                }
            } else {
                $_items[$model->id] = $model->name. ' - ' . $model->rCity->name;
            }
        }
        return $_items;
    }
        
    /**
     * Get all wards in district
     * @param Int $id   District id
     * @return CArrayDataProvider
     */
    public function getWards($id) {
        return new CArrayDataProvider(self::model()->findByPk($id)->rWard, array(
            'id' => 'wards',
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
    
//    public function getDistrictsByCity($city_id = '') {
//        $criteria = new CDbCriteria;
//        if (!empty($city_id)) {
//            $criteria->addCondition('t.city_id=' . $city_id);
//            $criteria->addCondition('t.status=' . DomainConst::DEFAULT_STATUS_ACTIVE);
//        } else {
//            return array();
//        }
//        return  CHtml::listData(self::model()->findAll($criteria),'id','name');
//    }
}