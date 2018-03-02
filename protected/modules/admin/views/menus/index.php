<?php
/* @var $this MenusController */
/* @var $model Menus */

//$this->breadcrumbs=array(
//	'Menuses'=>array('index'),
//	'Manage',
//);
//
//$this->menu=array(
//	array('label'=>'List Menus', 'url'=>array('index')),
//	array('label'=>'Create Menus', 'url'=>array('create')),
//);
$this->createMenu('index', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#menus-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Menuses</h1>-->
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
	'id'=>'menus-grid',
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
		'link',
		array(
                    'name'=>'module_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> '!empty($data->module_id) ? $data->rModule->name : ""',
                    'filter'=>Modules::loadItems(),
                ),
		array(
                    'name'=>'controller_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> '!empty($data->controller_id) ? $data->rController->description : ""',
                    'filter'=>Controllers::loadItems(),
                ),
		'action',
		'display_order',
		'show_in_menu',
		'place_holder_id',
		array(
                    'name'=>'application_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> '!empty($data->application_id) ? $data->rApplication->name : ""',
                    'filter'=>Applications::loadItems(),
                ),
		array(
                    'name'=>'parent_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> '!empty($data->parent_id) ? $data->rMenu->name : ""',
                    'filter'=>Menus::loadItems(),
                ),
                array(
                    'header' => DomainConst::CONTENT00239,
                    'class'=>'CButtonColumn',
                    'template'=> $this->createActionButtons()
                ),
	),
)); ?>
