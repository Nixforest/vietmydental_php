<?php
/* @var $this ActionsUsersController */
/* @var $model ActionsUsers */

$this->breadcrumbs=array(
	'Actions Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ActionsUsers', 'url'=>array('index')),
	array('label'=>'Create ActionsUsers', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#actions-users-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Actions Users</h1>

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
	'id'=>'actions-users-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
                array(
                    'header' => DomainConst::CONTENT00034,
                    'type' => 'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    'headerHtmlOptions' => array('width' => '30px','style' => 'text-align:center;'),
                    'htmlOptions' => array('style' => 'text-align:center;')
                ),
		//'id',
		//'user_id',
		array(
                    'name'=>'user_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> '!empty($data->user_id) ? $data->user->username : ""',
                    'filter'=>Users::loadItems(),
                ),
		//'controller_id',
		array(
                    'name'=>'controller_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> '!empty($data->controller_id) ? $data->controller->name : ""',
                    'filter'=>Controllers::loadItems(),
                ),
		'actions',
		//'can_access',		
                array(
                    'name'=>'can_access',
                    'type' => 'Access',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'filter'=> CommonProcess::getDefaultAccessStatus(true),
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
