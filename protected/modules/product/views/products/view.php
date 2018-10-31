<?php
/* @var $this ProductsController */
/* @var $model Products */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->name; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'code',
        'description',
        array(
            'name' => 'unit_id',
            'value' => $model->getUnit(),
        ),
        array(
            'name' => 'type_id',
            'value' => $model->getType(),
        ),
        array(
            'name' => 'parent_id',
            'value' => $model->getParent(),
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
