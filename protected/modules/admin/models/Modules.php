<?php

/**
 * This is the model class for table "modules".
 *
 * The followings are the available columns in table 'modules':
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class Modules extends BaseActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'modules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description', 'required'),
			array('name', 'length', 'max'=>63),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
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
                    'rController'   => array(
                        self::HAS_MANY, 'Controllers', 'module_id',
                        'order' => 'id DESC',
                    ),
                    'rMenu'         => array(self::HAS_MANY, 'Menus', 'module_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => Settings::getListPageSize(),
                        ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Modules the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
        // Check foreign table controllers
        $controllers = Controllers::model()->findByAttributes(array('module_id' => $this->id));
        if (count($controllers) > 0) {
            $retVal = false;
        }
        // Check foreign table menus
        $menus = Menus::model()->findByAttributes(array('module_id' => $this->id));
        if (count($menus) > 0) {
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
            $_items[$model->id] = $model->name;
        }
        return $_items;
    }
    
    /**
     * Get module by id
     * @param String $id Id of module
     * @return Modules Model module
     */
    public static function getById($id)
    {
        return Modules::model()->find('id="'.  $id.'"');
    }
    /**
     * Get module by name
     * @param String $name Name of module
     * @return Modules Model module
     */
    public static function getByName($name)
    {
        return Modules::model()->find('LOWER(name)="'.  strtolower($name).'"');
    }
    
    // TEST
    public static function getControllers() {
        $retVal = array();
        $controllers = Modules::model()->with('rController')->findAll();
        var_dump($controllers);
        die;
        $rC = Modules::model()->rController;
        foreach ($controllers as $value) {
            $retVal[$value->id] = $value->name;
        }
        return $retVal;
    }
}
