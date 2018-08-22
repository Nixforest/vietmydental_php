<?php
/* @var $this UsersController */
/* @var $model Users */
//$this->breadcrumbs=array(
//	'News'=>array('index'),
//);
//
//$this->menu=array(
//	array('label'=>'List News', 'url'=>array('index')),
//	array('label'=>'Manage News', 'url'=>array('admin')),
//);

$this->createMenu('index', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#users-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Users</h1>-->
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

<h1><?php echo $this->pageTitle ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
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
                array(
                    'name' => 'description',
                    'type' => 'raw',
                    'value' => '$data->getField(\'description\')',
                ),
                array(
                    'name'  => 'category_id',
                    'value' => 'isset($data->rCategory) ? $data->rCategory->name : ""',
                ),
                array(
                    'name' => 'status',
                    'type' => 'raw',
                    'value' => '$data->getStatus()',
                    'filter' => $model->getArrayStatus(),
                ),
                array(
                    'header' => DomainConst::CONTENT00054,
                    'type' => 'raw',
                    'value' => '$data->getCreatedBy()',
                ),
                array(
                    'header' => DomainConst::CONTENT00010,
                    'type' => 'raw',
                    'value' => '$data->getCreatedDate()',
                ),
                array(
                    'header' => 'Actions',
                    'class'=>'CButtonColumn',
                    'template'=> $this->createActionButtons(),
//                    'buttons'=>array(
//                        'update'=>array(
//                            'visible'=> '$data->canUpdate()',
//                        ),
//                        'delete'=>array(
//                            'visible'=> '$data->canDelete()',
//                        ),
//                    ),
                ),
	),
)); ?>
