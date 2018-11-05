<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserHrs
 *
 * @author nguyenpt
 */
class UserHrs extends Users {
    /**
     * Get base salary
     * @param type $from
     * @param type $to
     * @return type
     */
    public function getBaseSalary($from, $to) {
        return $this->base_salary;
    }
}
