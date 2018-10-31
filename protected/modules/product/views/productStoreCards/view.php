<?php
/* @var $this ProductStoreCardsController */
/* @var $model ProductStoreCards */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->getName(); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'input_date',
            'value' => $model->getInputDate(),
        ),
        array(
            'name' => 'store_id',
            'value' => $model->getStore(),
        ),
        array(
            'name' => 'type_id',
            'value' => $model->getType(),
        ),
        'order_id',
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
