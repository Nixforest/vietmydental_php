<?php
/* @var $this HrCoefficientValuesController */
/* @var $model HrCoefficientValues */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' #' . $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'coefficient_id',
            'value' => $model->getCoefficient(),
        ),
        array(
            'name' => 'value',
            'value' => $model->getValue(),
        ),
        array(
            'name' => 'month',
            'value' => $model->getMonth(),
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
