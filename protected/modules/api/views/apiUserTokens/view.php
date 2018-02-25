<?php
/* @var $this ApiUserTokensController */
/* @var $model ApiUserTokens */

$this->breadcrumbs=array(
	'Api User Tokens'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ApiUserTokens', 'url'=>array('index')),
	array('label'=>'Create ApiUserTokens', 'url'=>array('create')),
	array('label'=>'Update ApiUserTokens', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ApiUserTokens', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ApiUserTokens', 'url'=>array('admin')),
);
?>

<h1>View ApiUserTokens #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'type',
		'user_id',
		'username',
		'role_id',
		'token',
		'gcm_device_token',
		'apns_device_token',
		'last_active',
		'created_date',
	),
)); ?>
