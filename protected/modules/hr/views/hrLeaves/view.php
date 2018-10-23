<?php
/* @var $this HrLeavesController */
/* @var $model HrLeaves */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'user_id',
            'value' => $model->getEmployee(),
        ),
        'start_date',
        'end_date',
        'description',
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
