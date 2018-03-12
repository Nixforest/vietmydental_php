<?php
/* @var $this ApiRequestLogsController */
/* @var $model ApiRequestLogs */

$this->createMenu('index', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#api-request-logs-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->pageTitle; ?></h1>

<p>
    <a class="delete" title="Xoá tất cả" href="<?php echo Yii::app()->createAbsoluteUrl("api/apiRequestLogs/deleteAll"); ?>">
    Xoá tất cả
</a>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
</p>
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'api-request-logs-grid',
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
		'ip_address',
		'country',
//		'user_id',
		array(
                    'name'=>'user_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rUser) ? $data->rUser->username : ""',
                    'filter'=>Users::loadItems(),
                ),
		'method',
                'content',
//		array(
//                    'name'=>'content',
////                    'htmlOptions' => array('style' => 'text-align:center;'),
//                    'value'=> 'CommonProcess::formatJson($data->content)',
//                ),
//		'response',
		array(
                    'name'=>'response',
//                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> '$data->getResponse()',
                ),
		'created_date',
		'responsed_date',
                array(
                    'header' => 'Actions',
                    'class'=>'CButtonColumn',
                    'template'=> $this->createActionButtons(),
                ),
	),
)); ?>
