<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AdminController extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    /**
     * List actions controler can access
     * @var type 
     */
    protected $listActionsCanAccess;

    /**
     * Description of controller
     * @var type 
     */
    public $controllerDescription;

    /**
     * Initialize
     */
    function init() {
        $this->setActionAccess();
        // Get controller description from db
        $this->controllerDescription = Controllers::getControllerDescriptionByName(Yii::app()->controller->id);
        parent::init();
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl'
        );
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    public function accessRules() {
        return $this->getAccessRules(Yii::app()->controller->id,
                Modules::getByName(Yii::app()->controller->module->id)->id);
    }

    /**
     * Set list of actions can access
     */
    protected function setActionAccess() {
        if (isset(Yii::app()->user->role_id)) {
            $this->listActionsCanAccess = Controller::getListActionsCanAccess(
                    $this->accessRules(),
                    Yii::app()->user->role_id);
        } else {
            echo 'Yii::app()->user->role_id chưa có giá trị';
        }
    }
    
    /**
     * Get access rule for controller
     * @param String $controller_name Name of controller
     * @param Int $module_id Id of module
     * @return type
     */
    protected function getAccessRules($controller_name, $module_id = NULL) {
        $accessArr = array();
        $controller = Controllers::model()->find("name like '$controller_name' and module_id = '$module_id'");
        if (!$controller) {
            return array(array(DomainConst::KEY_ALLOW));
        }
        // Get user roles, set priority for custome role of user
        // Search in [actions_users] table
        $criteria = new CDbCriteria();
        $criteria->compare("t.user_id", Yii::app()->user->id);
        $criteria->compare("t.controller_id", $controller->id);
        $criteria->compare("t.can_access", DomainConst::DEFAULT_ACCESS_ALLOW);
        $actions_users = ActionsUsers::model()->findAll($criteria);
        if ($actions_users) {
            foreach ($actions_users as $key => $actions_user) {
                if ($actions_user->user) {
                    $arrAction = array_map('trim', explode(",", trim($actions_user->actions)));
                    $accessArr[] = array(
                        DomainConst::KEY_ALLOW,
                        DomainConst::KEY_ACTIONS => $arrAction,
                        'users' => array(
                            $actions_user->user->username,
                        ),
                    );
                } else {
                    // Delete invalid data
                    $actions_user->delete();
                }
            }
        } else {    // Search in [actions_roles] table
            $criteria = new CDbCriteria();
            // [NguyenPT]: TODO - Investigate how to define 'role_id' in [UserIdentify.php]
            $roleId = CommonProcess::getCurrentRoleId();
            $criteria->compare("t.role_id", $roleId);
            $criteria->compare("t.controller_id", $controller->id);
            $criteria->compare("t.can_access", DomainConst::DEFAULT_ACCESS_ALLOW);
            $actions_roles = ActionsRoles::model()->findAll($criteria);
            if ($actions_roles) {
                foreach ($actions_roles as $key => $actions_role) {
                    if ($actions_role->role_id == $roleId) {
                        $arrAction = array_map('trim', explode(",", trim($actions_role->actions)));
                        $accessArr[] = array(
                            DomainConst::KEY_ALLOW,
                            DomainConst::KEY_ACTIONS => $arrAction,
                            'users' => array('@'),
                            'expression' => 'Yii::app()->user->role_id == ' . $actions_role->role_id
                        );
                    }
                }
            }
        }
        $accessArr[] = array(DomainConst::KEY_DENY, // deny all users
            'users' => array('*')
        );

        return $accessArr;
    }

    /**
     * Get list of actions current role can access
     * @param Array $accessRules Access rule array
     * @param Int $role_id Id of role
     * @return Array List of actions
     */
    public static function getListActionsCanAccess($accessRules, $role_id) {
        //foreach ($accessRules as $key => $role) {
        foreach ($accessRules as $role) {
            if (isset($role[0]) && ($role[0] == DomainConst::DEFAULT_ACCESS_ALLOW) && isset($role[DomainConst::KEY_ACTIONS])) {
                return $role[DomainConst::KEY_ACTIONS];
            }
            if (isset($role[DomainConst::KEY_EXPRESSION]) && isset($role[DomainConst::KEY_ACTIONS])) {
                $temp = explode('==', trim($role[DomainConst::KEY_EXPRESSION]));
                if (isset($temp[1]) && trim($temp[1] == $role_id)) {
                    return $role[DomainConst::KEY_ACTIONS];
                }
            }
        }
        return array();
    }

    /**
     * Check if current user is allow access to specific action
     * @param Int $controller_id Id of controller
     * @param String $action Name of action
     * @return True if action is exist in list action of user can access, False otherwise
     */
    public static function isAllowAccess($controller_id, $action) {
        $aActionAllowed = array_map('strtolower', ActionsUsers::getActionArrAllowForCurrentUserByController($controller_id));
        return in_array(strtolower($action), $aActionAllowed);
    }

    /**
     * Get page title by action
     * @param String $action Action id
     * @return String Name of action
     */
    public function getPageTitleByAction($action) {
        return ControllersActions::getActionNameByController(Yii::app()->controller->id, $action);
    }

    /**
     * Check if action is exist inside list actions
     * @param String $action Action id
     * @param Array $listActions List of action
     * @return True if action is exist in list actions
     */
    public static function isAccessAction($action, $listActions) {
        foreach ($listActions as $key => $value) {
            $listActions[$key] = strtolower(trim($value));
        }
        $actionLower = strtolower(trim($action));
        return in_array($actionLower, $listActions);
    }
    
    /**
     * Handle create action buttons
     * @param type $buttons
     * @return string
     */
    public function createActionButtons($buttons = array('view', 'update', 'delete')) {
        $retVal = '';
        foreach ($buttons as $key => $button) {
            if (AdminController::isAccessAction($button, $this->listActionsCanAccess)) {
                $retVal .= '&nbsp;&nbsp;{' . $button . '}';
            }
        }
        return $retVal;
    }

    /**
     * Create operation Menu
     * @param String $action Action id
     * @param Object $model Model object
     * @return Array
     */
    public function createOperationMenu($action, $model = NULL) {
        $listMenu = array();
        $listMenu[] = array(
            'label' => $this->getPageTitleByAction('index'),
            'url' => array('index')
        );
        switch ($action) {
            case DomainConst::KEY_ACTION_INDEX:
                $listMenu[] = array(
                    'label' => $this->getPageTitleByAction('create'),
                    'url' => array('create')
                );
                break;
            case DomainConst::KEY_ACTION_CREATE:
                break;
            case DomainConst::KEY_ACTION_UPDATE:
                $listMenu[] = array(
                    'label' => $this->getPageTitleByAction('create'),
                    'url' => array('create')
                );
                if ($model != NULL) {
                    $listMenu[] = array(
                        'label' => $this->getPageTitleByAction('view'),
                        'url' => array(
                            'view',
                            'id' => $model->id
                        ),
                    );
                }
                break;
            case DomainConst::KEY_ACTION_VIEW:
            case DomainConst::KEY_ACTION_RESET_PASSWORD:
                $listMenu[] = array(
                    'label' => $this->getPageTitleByAction('create'),
                    'url' => array('create')
                );
                if ($model != NULL) {
                    $listMenu[] = array(
                        'label' => $this->getPageTitleByAction('update'),
                        'url' => array(
                            'update',
                            'id' => $model->id
                        ),
                    );
                    $listMenu[] = array(
                        'label' => $this->getPageTitleByAction('delete'),
                        'url' => '#',
                        'linkOptions' => array(
                            'submit' => array(
                                'delete',
                                'id' => $model->id
                            ),
                            'confirm' => DomainConst::CONTENT00038
                        )
                    );
                }
                break;
            case DomainConst::KEY_ACTION_CHANGE_PASSWORD:
                $listMenu[] = array(
                    'label' => DomainConst::CONTENT00070,
                    'url' => array(
                        'view',
                        'id' => Yii::app()->user->id
                ));

                break;
            default:
                break;
        }
        foreach ($listMenu as $key => $value) {
            if (!AdminController::isAccessAction($value['url'][0], $this->listActionsCanAccess)) {
                unset($listMenu[$key]);
            }
        }
        if (count($listMenu) == 0) {
            $this->layout = '//layouts/column1';
//        } else {
//            $this->layout = '//layouts/column2';
        }
        return array_values($listMenu);
    }

    /**
     * Create breadcrumbs array
     * @param String $action Action id
     * @param Object $model Object model
     * @return Array Breadcrumbs array
     */
    public function createBreadCrumbs($action, $model = NULL) {
        $retVal = array();
        $retVal[$this->controllerDescription] = array('index');
        switch ($action) {
            case 'index':
                break;
            case 'create':
                $retVal[] = $this->pageTitle;
                break;
            case 'update':
                if ($model != NULL) {
                    $retVal[$model->id] = array(
                        'view',
                        'id' => $model->id
                    );
                    $retVal[] = $this->pageTitle;
                }
                break;
            case 'view':
                if ($model != NULL) {
                    $retVal[] = $model->id;
                }
                break;
            default:
                break;
        }
        return $retVal;
    }

    /**
     * Start create menu
     * @param String $action Action id
     * @param Object $model Object model
     */
    public function createMenu($action, $model = NULL) {
        $this->pageTitle = $this->getPageTitleByAction($action);
        $this->breadcrumbs = $this->createBreadCrumbs($action, $model);
        $this->menu = $this->createOperationMenu($action, $model);
    }

}
