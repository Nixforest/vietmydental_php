<?php
/* @var $this ProductStoreCardDetailsController */
/* @var $model ProductStoreCardDetails */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'store_card_id',
            'value' => $model->getStoreCard(),
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
