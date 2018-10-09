<?php
/* @var $this HrSalaryReportsController */
/* @var $model HrSalaryReports */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->name; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'start_date',
        'end_date',
        array(
            'name' => 'role_id',
            'value' => $model->getRoleName(),
        ),
        array(
            'name' => 'type_id',
            'value' => $model->getType(),
        ),
        'data',
        array(
            'name' => 'approved',
            'value' => $model->getApproverName(),
        ),
        'approved_date',
        'notify',
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
