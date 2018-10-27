<?php
/* @var $this HrWorkPlansController */
/* @var $model HrWorkPlans */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'approved',
            'value' => $model->getApproverName(),
        ),
        'approved_date',
        'notify',
        array(
            'name' => 'role_id',
            'value' => $model->getRoleName(),
        ),
        'date_from',
        'date_to',
        array(
            'name' => 'department_id',
            'value' => $model->getDepartmentName(),
        ),
        array(
            'name' => 'agent_id',
            'value' => $model->getAgentName(),
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
<div id="work_schedule">
    <h2><?php echo DomainConst::CONTENT00011 ?></h2>
    <?php
        $this->widget('WorkScheduleWidget', array(
            'model'         => $model,
            'arrEmployee'   => $model->getUserArray(),
            'role_id'       => $model->role_id,
        ));
    ?>
</div>
