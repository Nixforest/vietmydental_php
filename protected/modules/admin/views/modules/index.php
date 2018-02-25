<?php
/* @var $this ModulesController */
/* @var $model Modules */

//$this->breadcrumbs=array(
//	'Modules'=>array('index'),
//	'Manage',
//);
//
//$this->menu=array(
//	array('label'=>'List Modules', 'url'=>array('index')),
//	array('label'=>'Create Modules', 'url'=>array('create')),
//);
$this->createMenu('index', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#modules-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Modules</h1>-->
<h1><?php echo $this->pageTitle; ?></h1>

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
	'id'=>'modules-grid',
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
//		'id',
		'name',
//                array(
//                    'name'=>'name',
//                    'htmlOptions' => array('style' => 'text-align:center;'),
//                    'value'=> '',
//                    'filter'=>Modules::getControllers(),
//                    ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
