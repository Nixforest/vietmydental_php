<?php

/**
 * This is the model class for table "schedule_times".
 *
 * The followings are the available columns in table 'schedule_times':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $status
 */
class ScheduleTimes extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ScheduleTimes the static model class
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
		return 'schedule_times';
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
			array('name', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, status', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => DomainConst::CONTENT00238,
			'description' => DomainConst::CONTENT00062,
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
		$criteria->compare('status',$this->status);
                $criteria->order = 'name ASC';

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
            'order' => 'name ASC',
        ));
        foreach ($models as $model) {
            $_items[$model->id] = $model->name;
        }
        return $_items;
    }
    
    /**
     * Get time by id
     * @param String $id Id value
     * @return string
     */
    public static function getTimeById($id) {
        $retVal = '';
        $model = self::model()->findByPk($id);
        if ($model) {
            return $model->name;
        }
        return $retVal;
    }

    //-----------------------------------------------------
    // JSON methods
    //-----------------------------------------------------
    /**
     * Get json list object
     * @return Array
     * [
     *      {
     *          id:"1",
     *          name:"8:00",
     *      },
     *      ...
     * ]
     */
    public static function getJsonList() {
        $retVal = array();
        $criteria=new CDbCriteria;
        $criteria->order = 'name ASC';
        foreach (self::model()->findAll($criteria) as $key => $value) {
            $retVal[] = CommonProcess::createConfigJson($key, $value->name);
        }
        
        return $retVal;
    }
}