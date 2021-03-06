<?php
/* @var $this HrParametersController */
/* @var $model HrParameters */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->name; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'role_id',
            'value' => $model->getRoleName(),
        ),
        'name',
        'method',
        array(
            'name' => 'status',
            'value' => '<span style="color: ' . $model->getColorStatus() . ';">' . $model->getStatus() . '</span>',
            'type'  => 'html',
        ),
        'created_date',
        array(
            'name' => 'created_by',
            'value' => $model->getCreatedBy(),
        ),
    ),
));
?>
