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
    <a class="delete" title="<?php echo DomainConst::CONTENT00262; ?>" href="<?php echo Yii::app()->createAbsoluteUrl("api/apiRequestLogs/deleteAll"); ?>">
        <?php echo DomainConst::CONTENT00262; ?>
    </a>
<p>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'api-request-logs-grid',
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
                'header' => 'Actions',
                'class' => 'CButtonColumn',
                'template' => $this->createActionButtons(),
            ),
            'ip_address',
            'country',
            array(
                'name' => 'user_id',
                'htmlOptions' => array('style' => 'text-align:center;'),
                'value' => 'isset($data->rUser) ? $data->rUser->username : ""',
                'filter' => Users::loadItems(),
            ),
            'method',
            'content',
            array(
                'name' => 'response',
                'value' => '$data->getResponse()',
            ),
            'created_date',
            'responsed_date',
        ),
    ));
    ?>
