<?php
/* @var $this ProductOrderDetailsController */
/* @var $model ProductOrderDetails */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'order_id',
            'value' => $model->getOrder(),
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
            'name' => 'price',
            'value' => $model->getPrice(),
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
