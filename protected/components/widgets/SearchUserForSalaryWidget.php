<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchUserForSalaryWidget
 *
 * @author nguyenpt
 */
class SearchUserForSalaryWidget extends CWidget {
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    /**
     * Model of work plan
     * @var HrWorkPlans 
     */
    public $model;
    /**
     * Flag can search
     * @var boolean 
     */
    public $canSearch = true;
    /**
     * Run method
     */
    public function run() {
        $this->render('searchUserForSalary', array(
            'model'     => $this->model,
            'canSearch' => $this->canSearch,
        ));
    }
}
