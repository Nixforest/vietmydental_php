<?php
/* @var $this PrescriptionDetailsController */
/* @var $model PrescriptionDetails */

$this->createMenu('index', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#prescription-details-grid').yiiGridView('update', {
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
	'id'=>'prescription-details-grid',
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
		'prescription_id',
		array(
                    'name'=>'medicine_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rMedicine) ? $data->rMedicine->getAutoCompleteMedicine() : ""',
                    'filter'=> Medicines::loadItems(),
                ),
		'quantity',
		'quantity1',
		'quantity2',
		'quantity3',
		'quantity4',
		'note',
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
