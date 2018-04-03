<?php

/**
 * This is the model class for table "actions_roles".
 *
 * The followings are the available columns in table 'actions_roles':
 * @property string $id
 * @property integer $role_id
 * @property string $controller_id
 * @property string $actions
 * @property integer $can_access
 */
class ActionsRoles extends BaseActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'actions_roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_id, can_access', 'numerical', 'integerOnly'=>true),
			array('controller_id', 'length', 'max'=>11),
			array('actions', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, role_id, controller_id, actions, can_access', 'safe', 'on'=>'search'),
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
                    'role' => array(self::BELONGS_TO, 'Roles', 'role_id'),
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
			'role_id' => 'Role',
			'controller_id' => 'Controller',
			'actions' => 'Actions',
			'can_access' => 'Can Access',
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
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('controller_id',$this->controller_id,true);
		$criteria->compare('actions',$this->actions,true);
		$criteria->compare('can_access',$this->can_access);

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
	 * @return ActionsRoles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------   
    /**
     * Get list of actions by role and controller
     * @param Int $role_id          Id of role
     * @param Int $controller_id    Id of controller
     * @param String $can_access    Flag can access
     * @return Array Array of actions
     */
    public static function getActionArrByRoleAndController(
    $role_id, $controller_id, $can_access = DomainConst::DEFAULT_ACCESS_ALLOW) {
        $retVal = array();
        $criteria = new CDbCriteria;
        $criteria->compare('t.role_id', $role_id);
        $criteria->compare('t.controller_id', $controller_id);
        $criteria->compare('t.can_access', $can_access);
        $model = self::model()->find($criteria);
        if ($model) {
            if (!empty($model->actions)) {
                $retVal = explode(DomainConst::SPLITTER_TYPE_1, $model->actions);
            }
        }
        return $retVal;
    }

    /**
     * Delete action by controller
     * @param Int $controller_id Id of controller
     */
    public static function deleteByController($controller_id) {
        $criteria = new CDbCriteria;
        $criteria->compare('t.controller_id', $controller_id);
        self::model()->deleteAll($criteria);
    }
    
    public static function insertForAllRole() {
        
    }
    
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
            $_items[$model->id] = $model;
        }
        return $_items;
    }

}
