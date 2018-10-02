<?php
/* @var $this HrWorkPlansController */
/* @var $model HrWorkPlans */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

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
