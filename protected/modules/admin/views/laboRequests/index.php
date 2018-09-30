<?php
/* @var $this LaboRequestsController */
/* @var $dataProvider CActiveDataProvider */
$this->createMenu('index', $model);

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
            'value' => '$data->getCustomerName() . " - " . $data->getCustomerRecordNumber()',
        ),
        array(
            'header'    => DomainConst::CONTENT00199,
            'value'     => '$data->getAgentName()',
        ),
        array(
            'header'    => DomainConst::CONTENT00143,
            'value'     => '$data->getDoctorName()',
        ),
        array(
            'header'    => DomainConst::CONTENT00146,
            'type'      => 'html',
            'value'     => '$data->getTreatmentInfo()',
        ),
        array(
            'name' => 'service_id',
            'value' => '$data->getService()',
        ),
        'date_request',
        array(
            'name'      => 'date_receive',
            'header'    => DomainConst::CONTENT00436,
            'value'     => '$data->getReceiveTime()',
        ),
        'date_test',
//          'tooth_color',
        'description',
        array(
            'name' => 'price',
            'type' => 'raw',
            'value' => '$data->getPrice()',
        ),
        array(
            'name' => 'status',
            'value'  => '$data->getStatus()',
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

