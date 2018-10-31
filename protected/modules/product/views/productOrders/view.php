<?php
/* @var $this ProductOrdersController */
/* @var $model ProductOrders */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->getName(); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'id',
            'value' => $model->getName(),
        ),
        array(
            'name' => 'book_date',
            'value' => $model->getBookDate(),
        ),
        'payment_code',
        array(
            'name' => 'payment_date',
            'value' => $model->getPaymentDate(),
        ),
        array(
            'name' => 'order_date',
            'value' => $model->getOrderDate(),
        ),
        array(
            'name' => 'customer_id',
            'value' => $model->getCustomer(),
        ),
        'order_type',
        array(
            'name' => 'order_type',
            'value' => $model->getType(),
        ),
        'description',
        'note',
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
