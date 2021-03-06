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

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'loggers-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
            array(
                'header' => DomainConst::CONTENT00034,
                'type' => 'raw',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'name' => 'logtime',
                'type' => 'html',
                'value' => '$data->getLogtime()',
            ),
            array(
                'name' => 'level',
                'value' => 'Loggers::LOG_LEVELS[$data->level]',
                'filter' => Loggers::LOG_LEVELS,
            ),
            'description',
            'message',
            'category',
            'ip_address',
            'country',
            array(
                'header' => 'Actions',
                'class' => 'CButtonColumn',
                'template' => $this->createActionButtons(),
            ),
        ),
    ));
    ?>
<style>
    .grid-view table td {
        word-break: break-all;
    }
</style>