<?php
/* @var $this TreatmentSchedulesController */
/* @var $model TreatmentSchedules */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		array(
                   'name'=>'record_id',
                   'value'=> CommonProcess::generateID(
                           DomainConst::MEDICAL_RECORD_ID_PREFIX,
                           $model->record_id),
                ),
		array(
                   'name'=>'time_id',
                   'value'=> isset($model->rTime) ? $model->rTime->name : '',
                ),
		array(
                   'name'=>'start_date',
                   'value'=> CommonProcess::convertDateTimeWithFormat($model->start_date),
                ),
		array(
                   'name'=>'end_date',
                   'value'=> CommonProcess::convertDateTimeWithFormat($model->end_date),
                ),
		array(
                   'name'=>'diagnosis_id',
                   'value'=> isset($model->rDiagnosis) ? $model->rDiagnosis->name : '',
                ),
		array(
                   'name'=>'pathological_id',
                   'value'=> isset($model->rPathological) ? $model->rPathological->name : '',
                ),
		array(
                    'label' => DomainConst::CONTENT00142,
                    'type'=>'html',
                    'value'=> isset($model->rJoinPathological) ? $model->generateHealthy() : '',
                ),
		array(
                   'name'=>'doctor_id',
                   'value'=> isset($model->rDoctor) ? $model->rDoctor->getFullName() : '',
                ),
		'created_date',
		array(
                   'name'=>'created_by',
                   'value'=> isset($model->rCreatedBy) ? $model->rCreatedBy->username : '',
                ),
		array(
                   'name'=>'status',
//                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                    'value' => TreatmentSchedules::getStatus()[$model->status],
                ),
	),
)); ?>


<h1><?php echo DomainConst::CONTENT00146 . ':'; ?></h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'details-grid',
    'dataProvider' => $details,
//    'filter'    => $model->rProducts,
    'columns' => array(
        array(
            'header' => DomainConst::CONTENT00034,
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'name' => DomainConst::CONTENT00139,
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->start_date',
        ),
        array(
            'name' => DomainConst::CONTENT00140,
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->end_date',
        ),
        array(
            'name' => DomainConst::CONTENT00145,
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->teeth_id',
        ),
        array(
            'name' => DomainConst::CONTENT00121,
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => 'isset($data->rDiagnosis) ? $data->rDiagnosis->name : ""',
        ),
        array(
            'name' => DomainConst::CONTENT00128,
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => 'isset($data->rTreatmentType) ? $data->rTreatmentType->name : ""',
        ),
        array(
            'name' => DomainConst::CONTENT00026,
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => 'TreatmentScheduleDetails::getStatus()[$data->status]',
            'visible' => CommonProcess::isUserAdmin(),
        ),
    ),
));
?>
