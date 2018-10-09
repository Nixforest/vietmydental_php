<?php
/* @var $this DepartmentsController */
/* @var $model Departments */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->name; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        array(
            'name' => 'type_id',
            'value' => $model->getType(),
        ),
        array(
            'name' => 'company_id',
            'value' => $model->getCompany(),
        ),
        array(
            'name' => 'manager',
            'value' => $model->getManager(),
        ),
        array(
            'name' => 'sub_manager',
            'value' => $model->getSubManager(),
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
