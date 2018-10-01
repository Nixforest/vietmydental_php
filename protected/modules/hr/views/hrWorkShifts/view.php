<?php
/* @var $this HrWorkShiftsController */
/* @var $model HrWorkShifts */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->name; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        array(
            'name' => 'from_id',
            'value' => $model->getFromTime(),
        ),
        array(
            'name' => 'to_id',
            'value' => $model->getToTime(),
        ),
        array(
            'name' => 'role_id',
            'value' => $model->getRoleName(),
        ),
        array(
            'name' => 'type',
            'value' => $model->getType(),
        ),
        'factor',
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
