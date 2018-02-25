<?php

/**
 * This is the model class for table "controllers_actions".
 *
 * The followings are the available columns in table 'controllers_actions':
 * @property string $id
 * @property integer $controller_id
 * @property string $action
 * @property string $name
 */
class ControllersActions extends BaseActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'controllers_actions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('controller_id, action, name', 'required'),
			array('controller_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, controller_id, action, name', 'safe', 'on'=>'search'),
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
                    'controller' => array(self::BELONGS_TO, 'Controllers', 'controller_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'controller_id' => 'Phân mục',
			'action' => 'Hành động',
			'name' => 'Tên hành động',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('controller_id',$this->controller_id);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ControllersActions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------   
    public static function getActionArrByController($controller_id) {
        $retVal = array();        
        $criteria = new CDbCriteria;
        $criteria->compare('t.controller_id', $controller_id);
        $retVal = self::model()->findAll($criteria);
//        foreach ($models as $model) {
//            $retVal[$model->id] = $model;
//        }
        return $retVal;
    }
    
    /**
     * Get name of action by controller and action id
     * @param Int $controller_name Name of controller
     * @param String $action Id of action
     * @return string Name of action
     */
    public static function getActionNameByController($controller_name, $action) {
        $controller = Controllers::getByName($controller_name);
        if ($controller) {
            foreach (ControllersActions::getActionArrByController($controller->id) as $value) {
            if ($value->action == $action) {
                return $value->name;
            }
        }
        }
        
        return '';
    }
}
