<?php
/* @var $this CustomersController */
/* @var $model Customers */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ': ' . $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'name',
		array(
                   'name'=>'gender',
                   'value'=> CommonProcess::getGender()[$model->gender],
                ),
		'date_of_birth',
		'phone',
//		'email',
                array(
                    'name' => DomainConst::CONTENT00276,
                    'value' => $model->getSocialNetworkInfo(),
                    'type'=>'html',
                    'htmlOptions' => array('style' => 'width:200px;'),
                ),
//		'city_id',
//		'district_id',
//		'ward_id',
//		'street_id',
//		'house_numbers',
		'address',
                array(
                    'name' => 'agent',
                    'value' => $model->getAgentName(),
                ),
		array(
                   'name'=>'type_id',
                   'value'=> isset($model->rType) ? $model->rType->name : '',
                ),
		array(
                   'name'=>'career_id',
                   'value'=> isset($model->rCareer) ? $model->rCareer->name : '',
                ),
		array(
                   'name'=>'user_id',
                   'value'=> isset($model->rUser) ? $model->rUser->username : '',
                ),
		'characteristics',
		array(
                   'name'=>'created_by',
                   'value'=> isset($model->rCreatedBy) ? $model->rCreatedBy->username : '',
                ),
		'created_date',
		array(
                   'name'=>'status',
                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>

<?php if (isset($model->rMedicalRecord)): ?>
    <h1><?php echo DomainConst::CONTENT00138 . ':'; ?></h1>
    <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model->rMedicalRecord,
            'attributes'=>array(
                    'record_number',
                    array(
                        'label' => DomainConst::CONTENT00137,
                        'type'=>'html',
                        'value'=> isset($model->rMedicalRecord->rJoinPathological) ? $model->rMedicalRecord->generateMedicalHistory() : '',
                    ),
                    'created_date',
            ),
    )); ?>
<?php endif; // end if (isset($model->rMedicalRecord)) ?>