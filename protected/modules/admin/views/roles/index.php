<?php
/* @var $this RolesController */
/* @var $model Roles */

//$this->breadcrumbs=array(
//	'Roles'=>array('index'),
//	'Manage',
//);
//
//$this->menu=array(
//	array('label'=>'List Roles', 'url'=>array('index')),
//	array('label'=>'Create Roles', 'url'=>array('create')),
//);
$this->createMenu('index', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#roles-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Roles</h1>-->
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
	'id'=>'roles-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
//        'pagerCssClass' => 'pagination',
//        'itemsCssClass' => 'table table-bordered table-striped',
//        'htmlOptions' => array(
//            'class' => 'container', // this is the class for the whole CGridView
//        ),
//        'pager' => array(
//            'cssFile' => false, // Prevents Yii default CSS for pagination
//        ),
//        'cssFile' => false, // Prevents Yii default CSS for CGridView
	'columns'=>array(
                array(
                    'header' => DomainConst::CONTENT00034,
                    'type' => 'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    'headerHtmlOptions' => array('width' => '30px','style' => 'text-align:center;'),
                    'htmlOptions' => array('style' => 'text-align:center;')
                ),
		'role_name',
		'role_short_name',
		array(
                    'name'=>'application_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> '!empty($data->application_id) ? $data->application->name : ""',
                    'filter'=>Applications::loadItems(),
                ),
		
                array(
                    'name'=>'status',
                    'type' => 'Status',
                    'htmlOptions' => array('style' => 'text-align:center;'),
		), 
		
                array(
                    'header' => DomainConst::CONTENT00036,
                    'class'=>'CButtonColumn',
                    'template'=> '{group}',
                    'htmlOptions' => array('style' => 'width:100px;text-align:center;'),
                    'buttons' => array( 
                        'group' => array(
                            'label' => DomainConst::CONTENT00036,
                            'imageUrl' => Yii::app()->theme->baseUrl . '/img/folder.png',
                            'options' => array('class' => 'show-book-chapters','target'=>'_blank'),
                            'url' => 'Yii::app()->createAbsoluteUrl("admin/rolesAuth/group",array("id"=>$data->id))',
                            //'visible'=>'GasCheck::isAllowAccess("rolesAuth", "group")',
                        )
                    ),
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
