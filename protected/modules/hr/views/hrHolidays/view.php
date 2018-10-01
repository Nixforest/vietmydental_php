<?php
/* @var $this HrHolidaysController */
/* @var $model HrHolidays */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->date; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'date',
        array(
            'name' => 'type_id',
            'value' => $model->getType(),
        ),
        'compensatory_date',
        'description',
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
