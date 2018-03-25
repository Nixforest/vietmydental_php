<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/front/column1';

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
    protected $listActionsCanAccess = array();

    /**
     * Description of controller
     * @var type 
     */
    public $controllerDescription;
    
    /**
     * Initialize
     */
//    function init() {
//        $this->setActionAccess();
//        // Get controller description from db
//        $this->controllerDescription = Controllers::getControllerDescriptionByName(Yii::app()->controller->id);
//        parent::init();
//    }
//    
//    /**
//     * @return array action filters
//     */
//    public function filters() {
//        return array(
//            'accessControl'
//        );
//    }
//
//    //-----------------------------------------------------
//    // Utility methods
//    //-----------------------------------------------------
//    public function accessRules() {
//        return $this->getAccessRules(Yii::app()->controller->id,
//                Modules::getByName('front')->id);
//    }

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
            return array(array(DomainConst::DEFAULT_ACCESS_DENY));
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
                        $actions_user->can_access,
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
            $criteria->compare("t.role_id", Yii::app()->user->role_id);
            $criteria->compare("t.controller_id", $controller->id);
            $criteria->compare("t.can_access", DomainConst::DEFAULT_ACCESS_ALLOW);
            $actions_roles = ActionsRoles::model()->findAll($criteria);
            if ($actions_roles) {
                foreach ($actions_roles as $key => $actions_role) {
                    if ($actions_role->role_id == Yii::app()->user->role_id) {
                        $arrAction = array_map('trim', explode(",", trim($actions_role->actions)));
                        $accessArr[] = array(
                            $actions_role->can_access,
                            DomainConst::KEY_ACTIONS => $arrAction,
                            'users' => array('@'),
                            'expression' => 'Yii::app()->user->role_id == ' . $actions_role->role_id
                        );
                    }
                }
            }
        }
        $accessArr[] = array(DomainConst::DEFAULT_ACCESS_DENY, // deny all users
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
        foreach ($accessRules as $key => $role) {
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
        $aActionAllowed = ActionsUsers::getActionArrAllowForCurrentUserByController($controller_id);
        $aActionAllowed = array_map('strtolower', $aActionAllowed);
        return in_array(strtolower($action), $aActionAllowed);
    }
    
    public function mailsend($to, $from, $from_name, $subject, $message, $cc = array(), $attachment = array()) {
        $mail = Yii::app()->Smtpmail;
        $mail->SetFrom($from, $from_name);
        $mail->Subject = $subject;
        $mail->MsgHTML($this->mailTemplate($message));
        $mail->AddAddress($to, "");

        // Add CC
        if (!empty($cc)) {
            foreach ($cc as $email) {
                $mail->AddCC($email);
            }
        }

        // Add Attchments
        if (!empty($attachment)) {
            foreach ($attachment as $attach) {
                $mail->AddAttachment($attach);
            }
        }

        if (!$mail->Send()) {
            return false; // Fail echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            return true; // Success
        }
    }

    
    /**
     * Handle create action buttons
     * @param type $buttons
     * @return string
     */
    public function createActionButtons($buttons = array('view', 'update', 'delete')) {
        $retVal = '';
//        CommonProcess::dumpVariable(count($buttons));
        foreach ($buttons as $key => $button) {
//            if (AdminController::isAccessAction($button, $this->listActionsCanAccess)) {
                $retVal .= '&nbsp;&nbsp;{' . $button . '}';
//            }
        }
        return $retVal;
    }
}
