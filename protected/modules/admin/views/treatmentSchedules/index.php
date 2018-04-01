<?php
/* @var $this TreatmentSchedulesController */
/* @var $model TreatmentSchedules */

$this->createMenu('index', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#treatment-schedules-grid').yiiGridView('update', {
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

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'treatment-schedules-grid',
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
                    'name'=>'record_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'CommonProcess::generateID(DomainConst::MEDICAL_RECORD_ID_PREFIX, $data->record_id)',
                ),
		array(
                    'name'=>'time_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rTime) ? $data->rTime->name : ""',
                    'filter'=> ScheduleTimes::loadItems(),
                ),
		array(
                    'name'=>'start_date',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'CommonProcess::convertDateTime($data->start_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_BACK_END)',
                ),  
		array(
                    'name'=>'end_date',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'CommonProcess::convertDateTimeWithFormat($data->end_date)',
                ),
		array(
                    'name'=>'diagnosis_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rDiagnosis) ? $data->rDiagnosis->name : ""',
                    'filter'=>Diagnosis::loadChildItems(),
                ),
		array(
                    'name'=>'pathological_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rPathological) ? $data->rPathological->name : ""',
                    'filter'=>Pathological::loadItems(),
                ),
		array(
                    'header' => DomainConst::CONTENT00260,
                    'type' => 'html',
                    'htmlOptions' => array('style' => 'text-align:left;'),
                    'value'=> 'isset($data->insurrance) ? CommonProcess::formatCurrency($data->insurrance) : "0"',
                ),
		array(
                    'header' => DomainConst::CONTENT00142,
                    'type' => 'html',
                    'htmlOptions' => array('style' => 'text-align:left;'),
                    'value'=> 'isset($data->rJoinPathological) ? $data->generateHealthy() : ""',
                ),
		array(
                    'name'=>'doctor_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rDoctor) ? $data->rDoctor->getFullName() : ""',
                    'filter'=> Users::loadItems(),
                ),
		'created_date',
		array(
                    'name'=>'created_by',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rCreatedBy) ? $data->rCreatedBy->username : ""',
                ),
                array(
                    'name'=>'status',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'TreatmentSchedules::getStatus()[$data->status]',
//                    'visible' => CommonProcess::isUserAdmin(),
                    'filter'=> TreatmentSchedules::getStatus(),
		),
                array(
                    'header' => DomainConst::CONTENT00239,
                    'class'=>'CButtonColumn',
                    'template'=> $this->createActionButtons()
                ),
	),
)); ?>
