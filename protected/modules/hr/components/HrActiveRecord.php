<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HrActiveRecord
 *
 * @author nguyenpt
 */
class HrActiveRecord extends BaseActiveRecord {
    /**
     * Get name of role
     * @return string Name of role
     */
    public function getRoleName() {
        if (isset(Roles::getRoleArrayForSalary()[$this->role_id])) {
            return Roles::getRoleArrayForSalary()[$this->role_id];
        }
        return '';
    }
    
    /**
     * Get created user
     * @return string
     */
    public function getCreatedBy() {
        if (isset($this->rCreatedBy)) {
            return $this->rCreatedBy->getFullName();
        }
        return '';
    }
    
    /**
     * Get user array
     * @return Users[] List users
     */
    public function getUserArray() {
        if (isset($this->rRole->rUser)) {
            $arrUser = $this->rRole->rUser;
        } else {
            $arrUser = Roles::getUserModelArrayForSalary();
        }
        // Search by department
        $retVal = $arrUser;
        if (!empty($this->department_id)) {
            $retVal = array();
            foreach ($arrUser as $user) {
                if ($user->department_id == $this->department_id) {
                    $retVal[] = $user;
                }
            }
        }
        // Search by agent
        $arrUser = $retVal;
        if (!empty($this->agent_id)) {
            $retVal = array();
            foreach ($arrUser as $user) {
                if ($user->isBelongAgent($this->agent_id)) {
                    $retVal[] = $user;
                }
            }
        }
        
        return $retVal;
    }
}
