<?php
/* @var $this ApiUserTokensController */
/* @var $model ApiUserTokens */

$this->breadcrumbs=array(
	'Api User Tokens'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ApiUserTokens', 'url'=>array('index')),
	array('label'=>'Create ApiUserTokens', 'url'=>array('create')),
	array('label'=>'View ApiUserTokens', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ApiUserTokens', 'url'=>array('admin')),
);
?>

<h1>Update ApiUserTokens <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>