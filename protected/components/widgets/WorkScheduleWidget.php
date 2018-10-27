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
        $roleName = '';
        if (isset(Roles::getRoleArrayForSalary()[$this->role_id])) {
            $roleName = Roles::getRoleArrayForSalary()[$this->role_id];
        }
        $mRole = Roles::model()->findByPk($this->role_id);
        $arrWorkShifts = array();
        if ($mRole) {
            $arrWorkShifts = $mRole->rWorkShifts;
        }
        $criteria = new CDbCriteria();
        $criteria->compare('t.role_id', Roles::ROLE_ALL_ID);
        $workShifts = HrWorkShifts::model()->findAll($criteria);
        if ($workShifts) {
            foreach ($workShifts as $value) {
                $arrWorkShifts[] = $value;
            }
        }
        $this->render('workSchedule', array(
            'model'             => $this->model,
            'arrEmployee'       => $this->arrEmployee,
            'arrWorkShifts'     => $arrWorkShifts,
            'canUpdate'         => $this->canUpdate,
        ));
    }

}
