<?php
/* @var $this ApiUserTokensController */
/* @var $model ApiUserTokens */

$this->createMenu('index', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#api-user-tokens-grid').yiiGridView('update', {
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
	'id'=>'api-user-tokens-grid',
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
//		'type',
                array(
                    'name'=>'type',
//                    'type' => 'Gender',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'CommonProcess::getPlatforms()[$data->type]',
                    'filter'=> CommonProcess::getPlatforms(),
		),
//		'user_id',
//		'username',
		array(
                    'name'=>'username',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rUser) ? $data->rUser->username : ""',
                    'filter'=>Users::loadItems(),
                ),
		array(
                    'name'=>'role_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rRole) ? $data->rRole->role_short_name : ""',
                    'filter'=>Roles::loadItems(),
                ),
		'token',
		'gcm_device_token',
		'apns_device_token',
		'last_active',
		'created_date',
//		array(
//			'class'=>'CButtonColumn',
//		),
	),
)); ?>
