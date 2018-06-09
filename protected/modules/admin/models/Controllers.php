<?php

/**
 * This is the model class for table "controllers".
 *
 * The followings are the available columns in table 'controllers':
 * @property string $id
 * @property string $name
 * @property string $module_id
 * @property string $description
 */
class Controllers extends BaseActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'controllers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>150),
			array('module_id', 'length', 'max'=>11),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, module_id, description', 'safe', 'on'=>'search'),
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
                    'rActionsRole'  => array(self::HAS_MANY, 'ActionsRoles', 'controller_id'),
                    'rActionsUser'  => array(self::HAS_MANY, 'ActionsUsers', 'controller_id'),
                    'rConrollersActtion'  => array(self::HAS_MANY, 'ControllersActions', 'controller_id'),
                    'rMenu' => array(self::HAS_MANY, 'Menus', 'controller_id'),
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
			'module_id' => 'Module',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('module_id',$this->module_id,true);
		$criteria->compare('description',$this->description,true);
                $criteria->order = 'id DESC';

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
	 * @return Controllers the static model class
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
        // Check foreign table action_roles
        $roles = ActionsRoles::model()->findByAttributes(array('controller_id' => $this->id));
        if (count($roles) > 0) {
            $retVal = false;
        }
        // Check foreign table action_users
        $users = ActionsUsers::model()->findByAttributes(array('controller_id' => $this->id));
        if (count($users) > 0) {
            $retVal = false;
        }
        // Check foreign table controller_actions
        $actions = ControllersActions::model()->findByAttributes(array('controller_id' => $this->id));
        if (count($actions) > 0) {
            $retVal = false;
        }
        // Check foreign table menus
        $menus = Menus::model()->findByAttributes(array('controller_id' => $this->id));
        if (count($menus) > 0) {
            $retVal = false;
        }
        return $retVal;
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------   
    /**
     * Get controller by name
     * @param String $name Name of controller
     * @return Controllers Model controller
     */
    public static function getByName($name, $module_name = 'admin')
    {
        $mModule = Modules::getByName($module_name);
        if ($mModule) {
            $mController = self::model()->find('LOWER(name)="'.  strtolower($name).'" AND module_id="' . $mModule->id . '"');
            if ($mController) {
                return $mController;
            } 
        }
        return NULL;
    }
    
    /**
     * Get controller by id
     * @param String $id Id of controller
     * @return Controllers Model controller
     */
    public static function getById($id)
    {
        return Controllers::model()->find('id="'.  $id.'"');
    }
    
    /**
     * Get name of controller by id
     * @param Int $id Id of controller
     * @return String Name of controller
     */
    public static function getNameById($id) {        
        $criteria=new CDbCriteria;
        $criteria->compare('id', $id);
        $model = self::model()->find($criteria);
        if ($model) {
            return $model->name;
        }
    }
    
    /**
     * Get controller description by name
     * @param String $name name of controller
     * @return string Description of controller
     */
    public static function getControllerDescriptionByName($name, $module_name = 'admin') {
        $controller = Controllers::getByName($name, $module_name);
        if ($controller) {
            return $controller->description;
        }
        return '';
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
            'order' => 'id DESC',
        ));
        foreach ($models as $model) {
            $_items[$model->id] = $model->description;
        }
        return $_items;
    }
    
    /**
     * Add allow/deny actions of role to [actions_roles] table
     * @param Array $post       List of action
     * @param Int $role_id      Id of role
     * @throws CHttpException
     */
    public function addGroupRoles($post, $role_id = NULL) {
        try {
            $allow_actions = '';
            $deny_actions = '';
            foreach ($post as $key => $value) {
                if ($value == DomainConst::DEFAULT_ACCESS_ALLOW) {
                    $allow_actions .= $key . DomainConst::SPLITTER_TYPE_1;
                }
                if ($value == DomainConst::DEFAULT_ACCESS_DENY) {
                    $deny_actions .= $key . DomainConst::SPLITTER_TYPE_1;
                }
            }
            $allow_actions = rtrim($allow_actions, DomainConst::SPLITTER_TYPE_1);
            $deny_actions = rtrim($deny_actions, DomainConst::SPLITTER_TYPE_1);
            if ($role_id == NULL) {
                $role_id = Yii::app()->session['roles'];
            }
            $allow_actionsRoles = ActionsRoles::model()->find(
                    'controller_id = ' . $this->id
                    . ' and role_id = ' . $role_id
                    . ' and can_access like ' . DomainConst::DEFAULT_ACCESS_ALLOW);
            $deny_actionsRoles = ActionsRoles::model()->find(
                    'controller_id = ' . $this->id
                    . ' and role_id = ' . $role_id
                    . ' and can_access like ' . DomainConst::DEFAULT_ACCESS_DENY);

            if ($allow_actionsRoles) {
                $allow_actionsRoles->actions = $allow_actions;
            } else {
                $allow_actionsRoles = new ActionsRoles();
                $allow_actionsRoles->role_id = $role_id;
                $allow_actionsRoles->controller_id = $this->id;
                $allow_actionsRoles->actions = $allow_actions;
                $allow_actionsRoles->can_access = DomainConst::DEFAULT_ACCESS_ALLOW;
            }
            if ($deny_actionsRoles) {
                $deny_actionsRoles->actions = $deny_actions;
            } else {
                $deny_actionsRoles = new ActionsRoles();
                $deny_actionsRoles->role_id = $role_id;
                $deny_actionsRoles->controller_id = $this->id;
                $deny_actionsRoles->actions = $deny_actions;
                $deny_actionsRoles->can_access = DomainConst::DEFAULT_ACCESS_DENY;
            }
            $allow_actionsRoles->save();
            $deny_actionsRoles->save();
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }
    
    /**
     * Add allow/deny actions of user to [actions_users] table
     * @param Array $post       List of action
     * @param Int $user_id      Id of user
     * @throws CHttpException
     */
    public function addUserRoles($post, $user_id = NULL) {
        try {
            $allow_actions = '';
            $deny_actions = '';
            foreach ($post as $key => $value) {
                if ($value == DomainConst::DEFAULT_ACCESS_ALLOW) {
                    $allow_actions .= $key . DomainConst::SPLITTER_TYPE_1;
                }
                if ($value == DomainConst::DEFAULT_ACCESS_DENY) {
                    $deny_actions .= $key . DomainConst::SPLITTER_TYPE_1;
                }
            }
            $allow_actions = rtrim($allow_actions, DomainConst::SPLITTER_TYPE_1);
            $deny_actions = rtrim($deny_actions, DomainConst::SPLITTER_TYPE_1);
            if ($user_id == NULL) {
                $role_id = Yii::app()->session['roles'];
                $user_id = Users::model()->find("username like '$roles'")->id;
            }
            $allow_actionsRoles = ActionsUsers::model()->find(
                    'controller_id = ' . $this->id
                    . ' and user_id = ' . $user_id
                    . ' and can_access like ' . DomainConst::DEFAULT_ACCESS_ALLOW);
            $deny_actionsRoles = ActionsUsers::model()->find(
                    'controller_id = ' . $this->id
                    . ' and user_id = ' . $user_id
                    . ' and can_access like ' . DomainConst::DEFAULT_ACCESS_DENY);
            
            if ($allow_actionsRoles) {
                $allow_actionsRoles->actions = $allow_actions;
            } else {
                $allow_actionsRoles = new ActionsUsers();
                $allow_actionsRoles->user_id = $user_id;
                $allow_actionsRoles->controller_id = $this->id;
                $allow_actionsRoles->can_access = DomainConst::DEFAULT_ACCESS_ALLOW;
                $allow_actionsRoles->actions = $allow_actions;                
            }
            
            if ($deny_actionsRoles) {
                $deny_actionsRoles->actions = $deny_actions;
            } else {
                $deny_actionsRoles = new ActionsUsers();
                $deny_actionsRoles->user_id = $user_id;
                $deny_actionsRoles->controller_id = $this->id;
                $deny_actionsRoles->can_access = DomainConst::DEFAULT_ACCESS_DENY;
                $deny_actionsRoles->actions = $deny_actions;                
            }
            $allow_actionsRoles->save();
            $deny_actionsRoles->save();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
