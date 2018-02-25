<?php
/* @var $this ActionsUsersController */
/* @var $model ActionsUsers */

//$this->breadcrumbs=array(
//	'Actions Users'=>array('index'),
//	$model->id,
//);
//
//$this->menu=array(
//	array('label'=>'List ActionsUsers', 'url'=>array('index')),
//	array('label'=>'Create ActionsUsers', 'url'=>array('create')),
//	array('label'=>'Update ActionsUsers', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete ActionsUsers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage ActionsUsers', 'url'=>array('admin')),
//);
$this->createMenu('view', $model);
?>

<!--<h1>View ActionsUsers #<?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		//'user_id',
                array(
                    'name' => 'user_id',
                    'value' => $model->user->username,
                ),
		//'controller_id',
                array(
                    'name' => 'controller',
                    'value' => $model->controller->name,
                ),
		'actions',
		//'can_access',
		array(
                   'name'=>'can_access',
                   'type'=>'access',
                ),
	),
)); ?>
