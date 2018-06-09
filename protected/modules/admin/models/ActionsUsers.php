<?php

/**
 * This is the model class for table "actions_users".
 *
 * The followings are the available columns in table 'actions_users':
 * @property string $id
 * @property string $user_id
 * @property string $controller_id
 * @property string $actions
 * @property integer $can_access
 */
class ActionsUsers extends BaseActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'actions_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('can_access', 'numerical', 'integerOnly'=>true),
			array('user_id, controller_id', 'length', 'max'=>11),
			array('actions', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, controller_id, actions, can_access', 'safe', 'on'=>'search'),
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
                    'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
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
			'user_id' => 'User',
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
		$criteria->compare('user_id',$this->user_id,true);
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
	 * @return ActionsUsers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------   
    /**
     * Get list of actions by user and controller
     * @param Int $user_id          Id of user
     * @param Int $controller_id    Id of controller
     * @param String $can_access    Flag can access
     * @return Array Array of actions
     */
    public static function getActionArrByUserAndController(
    $user_id, $controller_id, $can_access = DomainConst::DEFAULT_ACCESS_ALLOW) {
        $retVal = array();
        $criteria = new CDbCriteria;
        $criteria->compare('t.user_id', $user_id);
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
     * Get list actions are allowed for current user and controller
     * @param String $controller_name Controller name
     * @return Array List of actions
     */
    public static function getActionArrAllowForCurrentUserByController($controller_id) {
        $retVal = array();
        // Get current user id
        $user_id = Yii::app()->user->id;
        // Get current user model
        //$mUser = Users::model()->findByPk($user_id);
        // Get controller model by name
        //$mController = Controllers::getByName($controller_name);
        if ($controller_id) {
            // Get List action by user and controller in table [actions_users]
            $mActionsUser = ActionsUsers::model()->find('user_id=' . $user_id . ' AND controller_id=' . $controller_id);
            if (is_null($mActionsUser)) {   // Not fount in table [actions_user]
                // Find in table [actions_roles]
                $aActionAllowGroup = ActionsRoles::getActionArrByRoleAndController(Yii::app()->user->role_id, $controller_id);
                $retVal = $aActionAllowGroup;
            } else {
                $aActionAllowGroup = ActionsUsers::getActionArrByUserAndController($user_id, $controller_id);
                $retVal = $aActionAllowGroup;
            }
        }
        return $retVal;
    }
    
    /**
     * Get list actions are allowed for current user by controller name
     * @param String $controller_name Name of controller
     * @return Array List of actions
     */
    public static function getActionArrAllowForCurrentUserByControllerName($controller_name, $module_name = 'admin') {
        $controller = Controllers::getByName($controller_name, $module_name);
        if ($controller) {
            return ActionsUsers::getActionArrAllowForCurrentUserByController($controller->id);
        } else {
            return array();
        }        
    }
    
    /**
     * Check if controller and action is allow access
     * @param String $controller_name   Name of controller
     * @param String $action_name       Name of action
     * @return boolean                  True/False
     */
    public static function isAllowAccess($controller_id, $action_name) {
        $aActionAllowed = ActionsUsers::getActionArrAllowForCurrentUserByController($controller_id);
        if (in_array(ucfirst($action_name), $aActionAllowed)) {
            return true;
        }
        return false;
    }
    
    /**
     * Check User have custom access
     * @param Int $user_id Id of user
     * @return type
     */
    public static function haveCustomAccess($user_id) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.user_id=' . $user_id);
        return self::model()->count($criteria);
    }
}
