<?php
/* @var $this ApiUserTokensController */
/* @var $model ApiUserTokens */

$this->breadcrumbs=array(
	'Api User Tokens'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ApiUserTokens', 'url'=>array('index')),
	array('label'=>'Manage ApiUserTokens', 'url'=>array('admin')),
);
?>

<h1>Create ApiUserTokens</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>