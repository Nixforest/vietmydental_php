<?php
/* @var $this ProductStoresDetailsController */
/* @var $model ProductStoresDetails */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'store_id',
            'value' => $model->getStore(),
        ),
        array(
            'name' => 'product_id',
            'value' => $model->getProduct(),
        ),
        array(
            'name' => 'qty',
            'value' => $model->getQuantity(),
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
