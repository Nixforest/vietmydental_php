<?php
/* @var $this ControllersController */
/* @var $model Controllers */

//$this->breadcrumbs=array(
//	'Controllers'=>array('index'),
//	'Manage',
//);
//
//$this->menu=array(
//	array('label'=>'List Controllers', 'url'=>array('index')),
//	array('label'=>'Create Controllers', 'url'=>array('create')),
//);
$this->createMenu('index', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#controllers-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Controllers</h1>-->
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
	'id'=>'controllers-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
//        'pagerCssClass' => 'pagination',
//        'itemsCssClass' => 'table table-bordered table-striped',
//        'htmlOptions' => array(
//            'class' => 'container', // this is the class for the whole CGridView
//        ),
//        'pager' => array(
//            'cssFile' => false, // Prevents Yii default CSS for pagination
//        ),
//        'cssFile' => false, // Prevents Yii default CSS for CGridView
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
		//'module_id',
		array(
                    'name'=>'module_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> '!empty($data->module_id) ? $data->rModule->name : ""',
                    'filter'=>Modules::loadItems(),
                ),
		'description',
                array(
                    'header' => DomainConst::CONTENT00239,
                    'class'=>'CButtonColumn',
                    'template'=> $this->createActionButtons()
                ),
	),
)); ?>