<?php

/**
 * This is the model class for table "treatment_group".
 *
 * The followings are the available columns in table 'treatment_group':
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class TreatmentGroup extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TreatmentGroup the static model class
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
		return 'treatment_group';
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
			array('name', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description', 'safe', 'on'=>'search'),
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
                    'rTreatmentType' => array(self::HAS_MANY, 'TreatmentTypes', 'group_id',
                        'on' => 'status = 1'
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
			'name' => DomainConst::CONTENT00127,
			'description' => DomainConst::CONTENT00062,
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Get all treatment types in group
     * @return CArrayDataProvider
     */
    public function getTreatmentTypes() {
        return new CArrayDataProvider($this->rTreatmentType, array(
            'id' => 'treatmentTypes',
            'sort'=>array(
                'attributes'=>array(
                     'id', 'name', 'description', 'price', 'material_price', 'labo_price', 'status',
                ),
            ),
            'pagination'=>array(
                'pageSize'=>Settings::getListPageSize(),
            ),
        ));
    }

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
            $_items[$model->id] = $model->name;
        }
        return $_items;
    }
    
    /**
     * Load list all model
     * @return List data
     */
    public static function loadModels() {
        $_items = array();
        $models = self::model()->findAll(array(
            'order' => 'id ASC',
        ));
        foreach ($models as $model) {
            $_items[$model->id] = $model;
        }
        return $_items;
    }

    //-----------------------------------------------------
    // JSON methods
    //-----------------------------------------------------
    /**
     * Get json list object
     * @return Array
     * [
     *      {			
     *      	id:"1",		
     *      	name:"Điều trị nha chu"		
     *      	data:[		
     *              {	
     *			id:"2",
     *			name:"Cạo vôi răng"
     *			code:"2",
     *			price:"400,000 VND"
     *              },	
     *              ...	
     *          ],		
     *      },			
     *      ...			
     *  ]
     */
    public static function getJsonList() {
        $retVal = array();
        foreach (TreatmentGroup::loadModels() as $key => $group) {
            $data = array();
            if (empty($group->rTreatmentType)) {
                break;
            }
            foreach ($group->rTreatmentType as $type) {
                $typeInfo = CommonProcess::createConfigJson($type->id, $type->name);
                $typeInfo[DomainConst::KEY_DATA] = $type->getPrice();
                $data[] = $typeInfo;
            }
            $retVal[] = CommonProcess::createConfigJson(
                    $key,
                    $group->name,
                    $data);
        }
        return $retVal;
    }
}