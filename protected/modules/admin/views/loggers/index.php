<?php
/* @var $this LoggersController */
/* @var $model Loggers */

$this->createMenu('index', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#loggers-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->pageTitle; ?></h1>

<p>
    <a class="delete" title="<?php echo DomainConst::CONTENT00262; ?>" href="<?php echo Yii::app()->createAbsoluteUrl("admin/loggers/deleteAll"); ?>">
        <?php echo DomainConst::CONTENT00262; ?>
    </a>
<p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'loggers-grid',
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
		'created_date',
                array(
                    'name' => 'level',
                    'value' => 'Loggers::LOG_LEVELS[$data->level]',
                    'filter' => Loggers::LOG_LEVELS,
                ),
		'message',
		'description',
		'category',
		'ip_address',
		'country',
//		'logtime',
                array(
                    'name' => 'logtime',
                    'value' => '$data->getLogtime()',
                ),
                array(
                    'header' => 'Actions',
                    'class'=>'CButtonColumn',
                    'template'=> $this->createActionButtons(),
                ),
	),
)); ?>
