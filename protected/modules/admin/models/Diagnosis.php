<?php

/**
 * This is the model class for table "diagnosis".
 *
 * The followings are the available columns in table 'diagnosis':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $name_en
 * @property integer $parent_id
 * @property string $description
 */
class Diagnosis extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Diagnosis the static model class
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
		return 'diagnosis';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name', 'required'),
			array('parent_id', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>20),
			array('name, name_en', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, name, name_en, parent_id, description', 'safe', 'on'=>'search'),
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
                    'rParent' => array(self::BELONGS_TO, 'Diagnosis', 'parent_id'),
                    'rChildren' => array(self::HAS_MANY, 'Diagnosis', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => ($this->parent_id != DomainConst::DEFAULT_PARENT_VALUE) ? DomainConst::CONTENT00125 : DomainConst::CONTENT00124,
			'name' => ($this->parent_id != DomainConst::DEFAULT_PARENT_VALUE) ? DomainConst::CONTENT00121 : DomainConst::CONTENT00119,
			'name_en' => ($this->parent_id != DomainConst::DEFAULT_PARENT_VALUE) ? DomainConst::CONTENT00122 : DomainConst::CONTENT00120,
			'parent_id' => DomainConst::CONTENT00123,
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Get all children item
     * @return CArrayDataProvider
     */
    public function getChildren() {
        return new CArrayDataProvider($this->rChildren, array(
            'id'    => 'children',
            'sort'  => array(
                'attributes'    => array(
                    'id', 'code', 'name', 'name_en', 'description',
                ),
            ),
            'pagination'    => array(
                'pageSize'  => Settings::getListPageSize(),
            ),
        ));
    }
    
    /**
     * Get detail information
     * @return String
     * Example: K00.0 - Tật không răng - Anodiontia
     */
    public function getDetailInfo() {
        return $this->code . ' - ' . $this->name . ' - ' . $this->name_en;
    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Loads the items for the specified type from the database
     * @param type $emptyOption boolean the item is empty
     * @return type List data
     */
    public static function loadParentItems($emptyOption = false) {
        $_items = array();
        if ($emptyOption) {
            $_items[""] = "";
        }
        $models = self::model()->findAll(array(
            'order' => 'id ASC',
        ));
        foreach ($models as $model) {
            if ($model->parent_id == DomainConst::DEFAULT_PARENT_VALUE) {
                $_items[$model->id] = $model->name;
            }            
        }
        return $_items;
    }
    
    /**
     * Loads the items for the specified type from the database
     * @param type $emptyOption boolean the item is empty
     * @return type List data
     */
    public static function loadChildItems($emptyOption = false) {
        $_items = array();
        if ($emptyOption) {
            $_items[""] = "";
        }
        $models = self::model()->findAll(array(
            'order' => 'id ASC',
        ));
        foreach ($models as $model) {
            if ($model->parent_id != DomainConst::DEFAULT_PARENT_VALUE) {
                $_items[$model->id] = $model->name;
            }            
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
     *          id:"1",
     *          name:"K00.0 - Tật không răng - Anodiontia"
     *          data:[
     *              {	
     *          	id:"2",
     *          	name:"K00.00 - Tật không răng một phần - Partial anodontia [hypodontia] [oligodontia]"
     *              },
     *              ...
     *          ]
     *      },
     *      ...
     * ]
     */
    public static function getJsonList() {
        $retVal = array();
        foreach (Diagnosis::loadModels() as $key => $diagnosis) {
            // Check if this is parent
            if ($diagnosis->parent_id == DomainConst::NUMBER_ZERO_VALUE) {
                $data = array();
                foreach ($diagnosis->rChildren as $child) {
                    $data[] = CommonProcess::createConfigJson(
                            $child->id, $child->getDetailInfo());
                }
                $retVal[] = CommonProcess::createConfigJson(
                        $key,
                        $diagnosis->getDetailInfo(),
                        $data);
            }
            
        }
        return $retVal;
    }
}