<?php

/**
 * This is the model class for table "applications".
 *
 * The followings are the available columns in table 'applications':
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property integer $is_delete
 */
class Applications extends BaseActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'applications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, short_name, is_delete', 'required'),
			array('is_delete', 'numerical', 'integerOnly'=>true),
			array('name, short_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, short_name, is_delete', 'safe', 'on'=>'search'),
                        array('is_delete', 'default',
                            'value' => '0'),
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
                    'role'  => array(self::HAS_MANY, 'Roles', 'application_id'),
                    'rUser'  => array(self::HAS_MANY, 'Users', 'application_id'),
                    'rMenu'  => array(self::HAS_MANY, 'Menus', 'application_id'),
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
			'short_name' => 'Short Name',
			'is_delete' => 'Is Delete',
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
		$criteria->compare('short_name',$this->short_name,true);
		$criteria->compare('is_delete',$this->is_delete);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Applications the static model class
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
        // Check foreign table roles
        $roles = Roles::model()->findByAttributes(array('application_id' => $this->id));
        if (count($roles) > 0) {
            $retVal = false;
        }
        // Check foreign table users
        $users = Users::model()->findByAttributes(array('application_id' => $this->id));
        if (count($users) > 0) {
            $retVal = false;
        }
        // Check foreign table menus
        $menus = Menus::model()->findByAttributes(array('application_id' => $this->id));
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
//        $models = self::model()->findByAttributes(array(
        $models = self::model()->findAll(array(
//            'is_delete' => '1',
            'order' => 'id ASC',
        ));
        foreach ($models as $model) {
            if ($model->is_delete == DomainConst::NUMBER_ZERO_VALUE) {
                $_items[$model->id] = $model->name;
            }            
        }
        return $_items;
    }
    
    /**
     * Admin force delete
     */
    public function adminDelete() {
        // Delete foreign table Roles
        Roles::model()->deleteAllByAttributes(array('application_id' => $this->id));
        // Delete foreign table Users
        Users::model()->deleteAllByAttributes(array('application_id' => $this->id));
        // Delete foreign table Menus
        Menus::model()->deleteAllByAttributes(array('application_id' => $this->id));
        // Delete table Applications
        if ($this->delete()) {
            Yii::log("Delete record id = " . $model->id);
        }
    }

    /**
     * User delete
     */
    public function userDelete() {
        $this->is_delete = DomainConst::NUMBER_ONE_VALUE;
        $this->update();
    }
}
