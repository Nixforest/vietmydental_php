<?php
/* @var $this HrDebtsController */
/* @var $model HrDebts */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->getUserName(); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'user_id',
            'value' => $model->getUserName(),
        ),
        array(
            'name' => 'amount',
            'value' => $model->getAmount(),
        ),
        'reason',
        array(
            'name' => 'month',
            'value' => $model->getMonth(),
        ),
        array(
            'name' => 'type',
            'value' => $model->getType(),
        ),
        array(
            'name' => 'relate_id',
            'value' => $model->getRelationInfo(),
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
