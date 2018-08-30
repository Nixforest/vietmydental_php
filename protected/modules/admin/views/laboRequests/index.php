<?php
/* @var $this LaboRequestsController */
/* @var $dataProvider CActiveDataProvider */
$this->createMenu('', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#labo-grid').yiiGridView('update', {
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

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'labo-requests-grid',
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
            'header' => DomainConst::CONTENT00135,
            'type' => 'raw',
            'value' => '$data->getCustomerName()',
        ),
        array(
            'name' => 'service_id',
            'value' => 'isset($data->rService) ? $data->rService->name : ""',
        ),
        'date_request',
        'date_receive',
        'date_test',
//          'tooth_color',
        'description',
        array(
            'header' => DomainConst::CONTENT00129,
            'type' => 'raw',
            'value' => '$data->getPrice()',
        ),
        array(
            'name' => 'status',
            'type'  => 'status',
        ),
        'created_date',
        array(
            'header' => DomainConst::CONTENT00054,
            'type' => 'raw',
            'value' => '$data->getCreatedBy()',
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => $this->createActionButtons(),
        ),
    ),
));

