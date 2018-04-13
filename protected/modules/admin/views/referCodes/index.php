<?php
/* @var $this ReferCodesController */
/* @var $model ReferCodes */

//$this->createMenu('index', $model);

$this->breadcrumbs=array(
	'Danh sách Thẻ phát hành'=>array('index'),
);

$this->menu=array(
	array('label'=>'Danh sách Thẻ phát hành', 'url'=>array('index')),
	array('label'=>'Tạo mới Thẻ phát hành', 'url'=>array('referCodes/create/count/1000')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#refer-codes-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'refer-codes-grid',
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
		'code',
		'object_id',
		'status',
		'type',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
