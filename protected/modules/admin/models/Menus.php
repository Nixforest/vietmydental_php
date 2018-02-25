<?php

/**
 * This is the model class for table "menus".
 *
 * The followings are the available columns in table 'menus':
 * @property integer $id
 * @property string $name
 * @property string $link
 * @property string $module_id
 * @property string $controller_id
 * @property string $action
 * @property integer $display_order
 * @property integer $show_in_menu
 * @property integer $place_holder_id
 * @property integer $application_id
 * @property integer $parent_id
 */
class Menus extends BaseActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'menus';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, link, display_order, show_in_menu, place_holder_id, application_id', 'required'),
			array('display_order, show_in_menu, place_holder_id, application_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('name, link', 'length', 'max'=>255),
			array('module_id, controller_id, action', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, link, module_id, controller_id, action, display_order, show_in_menu, place_holder_id, application_id, parent_id', 'safe', 'on'=>'search'),
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
                    'rModule' => array(self::BELONGS_TO, 'Modules', 'module_id'),
                    'rController' => array(self::BELONGS_TO, 'Controllers', 'controller_id'),
                    'rApplication' => array(self::BELONGS_TO, 'Applications', 'application_id'),
                    'rMenu' => array(self::BELONGS_TO, 'Menus', 'parent_id'),
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
			'link' => 'Link',
			'module_id' => 'Module',
			'controller_id' => 'Controller',
			'action' => 'Action',
			'display_order' => 'Display Order',
			'show_in_menu' => 'Show In Menu',
			'place_holder_id' => 'Place Holder',
			'application_id' => 'Application',
			'parent_id' => 'Parent',
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
		$criteria->compare('link',$this->link,true);
		$criteria->compare('module_id',$this->module_id,true);
		$criteria->compare('controller_id',$this->controller_id,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('display_order',$this->display_order);
		$criteria->compare('show_in_menu',$this->show_in_menu);
		$criteria->compare('place_holder_id',$this->place_holder_id);
		$criteria->compare('application_id',$this->application_id);
		$criteria->compare('parent_id',$this->parent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Menus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------       
    /**
     * Loads the menu items from the database
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
    
    public function getLink() {
        if ($this->link == '#') {
            return '#';
        } else {
            $module = isset($this->rModule) ? $this->rModule->name : '';
            $controller = isset($this->rController) ? $this->rController->name : '';
//            CommonProcess::dumpVariable($controller);
            return "$module/$controller/$this->action";
        }
    }
}
