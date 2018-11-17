<?php

/**
 * Working schedule widget
 */
class WorkScheduleWidget extends CWidget {
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    /**
     * Model of work plan
     * @var HrWorkPlans 
     */
    public $model;
    /**
     * List of employees
     * @var Users[] 
     */
    public $arrEmployee;
    /**
     * Id of role
     * @var Int 
     */
    public $role_id;
    /**
     * Flag check can update work schedule
     * @var Boolean 
     */
    public $canUpdate = true;

    /**
     * Run method
     */
    public function run() {
        $arrWorkShifts = HrWorkShifts::getArrayByRole($this->model->role_id);
        $this->render('workSchedule', array(
            'model'             => $this->model,
            'arrEmployee'       => $this->arrEmployee,
            'arrWorkShifts'     => $arrWorkShifts,
            'canUpdate'         => $this->canUpdate,
        ));
    }

}
