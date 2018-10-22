<?php
/* @var $this RolesController */
/* @var $model Roles */

$this->createMenu('view', $model);
?>

<!--<h1>View Roles #<?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'role_name',
        'role_short_name',
        array(
            'name' => 'application',
            'value' => $model->application->name,
        ),
        array(
            'name' => 'working_type',
            'value' => $model->getWorkingType(),
        ),
        array(
            'name' => 'status',
            'type' => 'Status',
        ),
    ),
));
?>
