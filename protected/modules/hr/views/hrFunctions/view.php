<?php
/* @var $this HrFunctionsController */
/* @var $model HrFunctions */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->name; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'function',
        array(
            'name' => 'role_id',
            'value' => $model->getRoleName(),
        ),
        array(
            'name' => 'type_id',
            'value' => $model->getType(),
        ),
        array(
            'name' => 'is_per_day',
            'value' => $model->isPerDayText(),
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
