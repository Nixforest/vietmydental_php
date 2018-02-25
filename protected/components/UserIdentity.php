<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 *          Yii::app()->controller->id          = Name of controller
 *          Yii::app()->controller->module->id  = Name of module
 *          Yii::app()->user->name              = Username of user
 *          Yii::app()->user->id                = Id of user
 *          Yii::app()->user->role_id           = Role id of user
 *          Yii::app()->user->role_name         = Role name of user
 *          Yii::app()->user->agent_id          = Agent id of user
 */
class UserIdentity extends CUserIdentity {
    /** Id of user */
    private $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $users = Users::model()->findByAttributes(array('username' => $this->username));
        if ($users == null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if (!$users->validatePassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $users->id;
            $this->setState('role_id', $users->role_id);
            $this->setState('role_name', $users->rRole->role_name);
            $this->setState('agent_id', $users->getAgentId());
            $this->saveParamToSession($users);
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    /**
     * Get value of id
     * @return Int Id of user
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Handle save parameters to session
     * @param Users $users Model user
     */
    public function saveParamToSession($users) {
        Yii::app()->session[DomainConst::KEY_LOGGED_USER] = $users;
    }
}
