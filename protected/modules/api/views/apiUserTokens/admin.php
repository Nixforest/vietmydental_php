<?php
/* @var $this ApiUserTokensController */
/* @var $model ApiUserTokens */

$this->breadcrumbs=array(
	'Api User Tokens'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ApiUserTokens', 'url'=>array('index')),
	array('label'=>'Create ApiUserTokens', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#api-user-tokens-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Api User Tokens</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'api-user-tokens-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'type',
		'user_id',
		'username',
		'role_id',
		'token',
		/*
		'gcm_device_token',
		'apns_device_token',
		'last_active',
		'created_date',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
