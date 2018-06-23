<?php
/* @var $this CustomersController */
/* @var $model Customers */

$this->createMenu('index', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#customers-grid').yiiGridView('update', {
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
	'id'=>'customers-grid',
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
		'name',
                array(
                    'name'=>'gender',
//                    'type' => 'Gender',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'CommonProcess::getGender()[$data->gender]',
                    'filter'=> CommonProcess::getGender(),
		),
		'date_of_birth',
		'phone',
//		'email',
                array(
                    'header' => DomainConst::CONTENT00276,
                    'value' => '$data->getSocialNetworkInfo()',
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
                    'value' => '$data->getAgentName()',
                ),
//		array(
//                    'name'=>'type_id',
//                    'htmlOptions' => array('style' => 'text-align:center;'),
//                    'value'=> 'isset($data->rType) ? $data->rType->name : ""',
//                    'filter'=>CustomerTypes::loadItems(),
//                ),
//		array(
//                    'name'=>'career_id',
//                    'htmlOptions' => array('style' => 'text-align:center;'),
//                    'value'=> 'isset($data->rCareer) ? $data->rCareer->name : ""',
//                    'filter'=>Careers::loadItems(),
//                ),
//		array(
//                    'name'=>'user_id',
//                    'htmlOptions' => array('style' => 'text-align:center;'),
//                    'value'=> 'isset($data->rUser) ? $data->rUser->username : ""',
//                    'filter'=>Users::loadItems(),
//                ),
//		'characteristics',
		array(
                    'name'=>'created_by',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rCreatedBy) ? $data->rCreatedBy->getFullName() : ""',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
		'created_date',
                array(
                    'name' => 'debt',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'value' => 'CommonProcess::formatCurrency($data->debt)',
                ),
                array(
                    'name'=>'status',
                    'type' => 'Status',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'visible' => CommonProcess::isUserAdmin(),
                    'filter'=> CommonProcess::getDefaultStatus(true),
		),
                array(
                    'header' => DomainConst::CONTENT00239,
                    'class'=>'CButtonColumn',
                    'template'=> $this->createActionButtons()
                ),
	),
)); ?>
