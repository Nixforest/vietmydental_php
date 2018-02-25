<?php

/**
 * This is the model class for table "wards".
 *
 * The followings are the available columns in table 'wards':
 * @property integer $id
 * @property integer $district_id
 * @property string $name
 * @property string $short_name
 * @property string $slug
 * @property integer $status
 */
class Wards extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Wards the static model class
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
		return 'wards';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('district_id, name', 'required'),
			array('district_id, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>200),
			array('short_name, slug', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, district_id, name, short_name, slug, status', 'safe', 'on'=>'search'),
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
                    'rDistrict' => array(self::BELONGS_TO, 'Districts', 'district_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'district_id' => DomainConst::CONTENT00096,
			'name' => DomainConst::CONTENT00042,
			'short_name' => DomainConst::CONTENT00092,
			'slug' => DomainConst::CONTENT00095,
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
		$criteria->compare('district_id',$this->district_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('short_name',$this->short_name,true);
		$criteria->compare('slug',$this->slug,true);
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
     * @param type $district_id Id of district
     * @return type List data
     */
    public static function loadItems($district_id = '', $emptyOption = false) {
        $_items = array();
        if ($emptyOption) {
            $_items[""] = "";
        }
        $models = self::model()->findAll(array(
            'order' => 'id ASC',
        ));
        foreach ($models as $model) {
            if (!empty($district_id)) {
                if ($model->district_id == $district_id) {
                    $_items[$model->id] = $model->name;
                }
            } else {
                $_items[$model->id] = $model->name;
            }
        }
        return $_items;
    }
}