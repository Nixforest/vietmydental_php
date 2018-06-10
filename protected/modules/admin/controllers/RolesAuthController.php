<?php

class RolesAuthController extends AdminController {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
//    public $aControllers = array(
//        'users' => array(
//            'alias' => 'Quản lý nhân sự',
//            'actions' => array(
//                'view' => array(
//                    'alias' => 'Xem Thông tin nhân viên',
//                    'childActions' => array(),
//                ),
//                'create' => array(
//                    'alias' => 'Tạo mới nhân viên',
//                    'childActions' => array(),
//                ),
//                'index' => array(
//                    'alias' => 'Quản Lý danh sách nhân viên',
//                    'childActions' => array()
//                ),
//                'update' => array(
//                    'alias' => 'Cập nhật Thông tin nhân viên',
//                    'childActions' => array()
//                ),
//                'delete' => array(
//                    'alias' => 'Xóa nhân viên',
//                    'childActions' => array()
//                ),
//            ),
//        ),
//        'roles' => array(
//            'alias' => 'Quản lý nhân sự1',
//            'actions' => array(
//                'view' => array(
//                    'alias' => 'Xem Thông tin nhân viên',
//                    'childActions' => array(),
//                ),
//                'create' => array(
//                    'alias' => 'Tạo mới nhân viên',
//                    'childActions' => array(),
//                ),
//                'index' => array(
//                    'alias' => 'Quản Lý danh sách nhân viên',
//                    'childActions' => array()
//                ),
//                'update' => array(
//                    'alias' => 'Cập nhật Thông tin nhân viên',
//                    'childActions' => array()
//                ),
//                'delete' => array(
//                    'alias' => 'Xóa nhân viên',
//                    'childActions' => array()
//                ),
//            ),
//        ),
//    );
    /** List controllers */
    public $aControllers = array();
    /**
     * Get list of roles that authenticated from database
     * @return array Array object format like
     */
    private static function getListRolesAuthenticatedFromDb() {
        $retVal = array();
        $controllers = Controllers::model()->findAll(array(
            'order' => 'id DESC',
        ));
        // Loop for list controllers
        foreach ($controllers as $id => $controller) {
            $listActions = ControllersActions::getActionArrByController($controller->id);
            if (count($listActions) == 0) {
                continue;
            }
            $retVal[$controller->id] = array();
            $retVal[$controller->id][DomainConst::KEY_ALIAS] = $controller->description;
            $retVal[$controller->id][DomainConst::KEY_ACTIONS] = array();
            // Loop for all actions of this controller
            foreach ($listActions as $action) {
                $retVal[$controller->id][DomainConst::KEY_ACTIONS][$action->action] = array();
                $retVal[$controller->id][DomainConst::KEY_ACTIONS][$action->action][DomainConst::KEY_ALIAS] = $action->name;
                $retVal[$controller->id][DomainConst::KEY_ACTIONS][$action->action][DomainConst::KEY_CHILD_ACTIONS] = array();
            }
        }
        return $retVal;
    }
    /**
     * Get list of roles that authenticated from database
     * @return array Array object format like
     */
    public static function getListRolesAuthenticatedFromDb1() {
        $retVal = array();
        $mModule = Modules::model()->findAll(array(
            'order' => 'id DESC',
        ));
        // Loop for list controllers
        foreach ($mModule as $id => $module) {
            if (!CommonProcess::isUserAdmin() && $module->name == 'api') {
                continue;
            }
            if (isset($module->rController)) {
                $retVal[$module->id] = array();
                $retVal[$module->id][DomainConst::KEY_ALIAS] = $module->description;
                $actions = array();
                // Loop for list controllers
                foreach ($module->rController as $controller) {
                    $listActions = ControllersActions::getActionArrByController($controller->id);
                    if (count($listActions) == 0) {
                        continue;
                    }
                    $actions[$controller->id] = array();
                    $actions[$controller->id][DomainConst::KEY_ALIAS] = $controller->description;
                    $actions[$controller->id][DomainConst::KEY_ACTIONS] = array();
                    // Loop for all actions of this controller
                    foreach ($listActions as $action) {
                        $actions[$controller->id][DomainConst::KEY_ACTIONS][$action->action] = array();
                        $actions[$controller->id][DomainConst::KEY_ACTIONS][$action->action][DomainConst::KEY_ALIAS] = $action->name;
                        $actions[$controller->id][DomainConst::KEY_ACTIONS][$action->action][DomainConst::KEY_CHILD_ACTIONS] = array();
                    }
                }
                $retVal[$module->id][DomainConst::KEY_CHILDREN] = $actions;
            }
        }
        return $retVal;
    }
    
    /**
     * Handle action group
     * @param Int $id Id of role
     */
    public function actionGroup($id) {
        $this->aControllers = RolesAuthController::getListRolesAuthenticatedFromDb();
        try {
            // Get role object to take it's name
            $mGroup = Roles::model()->findByPk($id);
            if (CommonProcess::isUserAdmin()) {
                
            } else {
                if (Roles::isAdminRole($id)) {
                    return;
                }
            }
            // Set page title
            $this->pageTitle = 'Phân Quyền cho Nhóm thành viên: ' . $mGroup->role_short_name;
            // Start handle save
            if (filter_input(INPUT_POST, 'submit')) {
                // Loop for all controllers
                foreach ($this->aControllers as $controller_id => $value) {
                    // Get Controller model from id
                    $mController = Controllers::getById($controller_id);
                    if ($mController) {
                        $mController->addGroupRoles($this->postArrayCheckBoxToAllowDenyValue($controller_id), $id);
                        Yii::app()->user->setFlash(DomainConst::KEY_SUCCESS_UPDATE, DomainConst::CONTENT00035);
                    }
                }
                $this->refresh();
            }
            $this->render('group', array(
                'id' => $id,
                'mGroup' => $mGroup,
                DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actionResetRoleCustomOfUser($id) {
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $id);
        ActionsUsers::model()->deleteAll($criteria);
        $this->redirect(array('user', 'id' => $id));
    }

    /**
     * Handle actions of user
     * @param Int $id Id of user
     */
    public function actionUser($id) {
        $this->aControllers = RolesAuthController::getListRolesAuthenticatedFromDb();
        try {
            $mUser = Users::model()->findByPk($id);
            if (is_null($mUser)) {
                throw new Exception('Phân quyền cho user tồn tại');
            }
            $this->pageTitle = 'Phân quyền cho thành viên: ' . strtoupper($mUser->username) . " - " . $mUser->rRole->role_short_name;
            if (filter_input(INPUT_POST, 'submit')) {
                foreach ($this->aControllers as $controller_id => $controller) {
                  $mController = Controllers::getById($controller_id);
                  if ($mController) {
                      $mController->addUserRoles($this->postArrayCheckBoxToAllowDenyValue($controller_id), $id);
                      Yii::app()->user->setFlash(DomainConst::KEY_SUCCESS_UPDATE, DomainConst::CONTENT00035);
                  }
                }                
                $this->refresh();
            }
            $this->render('user',array(
                    'id'=>$id,
                    'mUser'=>$mUser,
                    DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
            ));
        } catch (Exception $exc) {
            Yii::log("Uid: " .Yii::app()->user->id. " Exception ".  $exc->getMessage(), 'error');
            $code = 404;
            if(isset($exc->statusCode))
                $code=$exc->statusCode;
            if($exc->getCode())
                $code=$exc->getCode();
            throw new CHttpException($code, $exc->getMessage());
        }
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */


    /**
     * Handle convert checkbox value to allow and deny array value
     * @param Int $controller_id Id of controller
     * @return Array Array of allow and deny value
     * Example: array{
     *      'index' => '0',
     *      'view' => '1',
     *      'create' => '1',
     * }
     */
    public function postArrayCheckBoxToAllowDenyValue($controller_id) {
        $retVal = array();
        $aControllers = $this->aControllers;
        // Loop for all actions in 1 controller
        foreach ($aControllers[$controller_id][DomainConst::KEY_ACTIONS] as $keyAction => $aAction) {
            // Check if checkbox of action is checked
            if (isset($_POST[$controller_id][$keyAction])
                    && ($_POST[$controller_id][$keyAction] == DomainConst::CHECKBOX_STATUS_CHECKED)) {
                // Set array element: 'action_name' => '1'
                $retVal[$keyAction] = DomainConst::DEFAULT_ACCESS_ALLOW;
                // Handle child actions
                foreach ($aAction[DomainConst::KEY_CHILD_ACTIONS] as $childAction) {
                    $retVal[$childAction] = DomainConst::DEFAULT_ACCESS_ALLOW;
                }
            } else {
                // Set array element: 'action_name' => '0'
                $retVal[$keyAction] = DomainConst::DEFAULT_ACCESS_DENY;
                foreach ($aAction[DomainConst::KEY_CHILD_ACTIONS] as $childAction) {
                    $retVal[$childAction] = DomainConst::DEFAULT_ACCESS_DENY;
                }
            }
        }

        return $retVal;
    }

}
