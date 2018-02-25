<?php
/* @var $this ScheduleEmailController */
/* @var $model ScheduleEmail */

$this->breadcrumbs=array(
	'Schedule Emails'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ScheduleEmail', 'url'=>array('index')),
	array('label'=>'Create ScheduleEmail', 'url'=>array('create')),
	array('label'=>'View ScheduleEmail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ScheduleEmail', 'url'=>array('admin')),
);
?>

<h1>Update ScheduleEmail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>