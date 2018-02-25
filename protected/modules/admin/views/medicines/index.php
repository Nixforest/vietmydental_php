<?php
/* @var $this MedicinesController */
/* @var $model Medicines */

$this->createMenu('index', $model);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#medicines-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

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
	'id'=>'medicines-grid',
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
		'name',
		'code',
		'content',
		array(
                    'name'=>'unit_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rUnit) ? $data->rUnit->name : ""',
                    'filter'=>Units::loadItems(),
                ),
		'active_ingredient',
		array(
                    'name'=>'use_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rUse) ? $data->rUse->name : ""',
                    'filter'=>MedicineUses::loadItems(),
                ),
		'manufacturer',
		array(
                    'name'=>'type_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rType) ? $data->rType->name : ""',
                    'filter'=>MedicineTypes::loadItems(),
                ),
		'buy_price',
		'sell_price',
                array(
                    'name'=>'status',
                    'type' => 'Status',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'visible' => CommonProcess::isUserAdmin(),
                    'filter'=> CommonProcess::getDefaultStatus(true),
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
