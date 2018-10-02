<?php
/* @var $this HrWorkSchedulesController */
/* @var $model HrWorkSchedules */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'work_day',
        array(
            'name' => 'work_shift_id',
            'value' => $model->getWorkShift(),
        ),
        array(
            'name' => 'work_plan_id',
            'value' => $model->getWorkPlan(),
        ),
        array(
            'name' => 'employee_id',
            'value' => $model->getUserName(),
        ),
        array(
            'name' => 'status',
            'value' => $model->getStatus(),
        ),
        'created_date',
        array(
            'name' => 'created_by',
            'value' => $model->getCreatedBy(),
        ),
    ),
));
?>
