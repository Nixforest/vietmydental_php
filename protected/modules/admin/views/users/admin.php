<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Users', 'url'=>array('index')),
	array('label'=>'Create Users', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#users-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>

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
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        //'pagerCssClass' => 'pagination',
        'itemsCssClass' => 'table table-bordered table-striped',
//        'htmlOptions' => array(
//            'class' => 'container', // this is the class for the whole CGridView
//        ),
//        'pager' => array(
//            'cssFile' => false, // Prevents Yii default CSS for pagination
//        ),
        'cssFile' => false, // Prevents Yii default CSS for CGridView
	'columns'=>array(
                array(
                    'header' => DomainConst::CONTENT00034,
                    'type' => 'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    'headerHtmlOptions' => array('width' => '30px','style' => 'text-align:center;'),
                    'htmlOptions' => array('style' => 'text-align:center;')
                ),
		//'id',
		'username',		
                array(
                    'header' => DomainConst::CONTENT00036,
                    'class'=>'CButtonColumn',
                    'template'=> '{group}',
                    'htmlOptions' => array('style' => 'width:100px;text-align:center;'),
                    'buttons' => array( 
                        'group' => array(
                            'label' => DomainConst::CONTENT00036,
                            'imageUrl' => Yii::app()->theme->baseUrl . '/admin/images/folder.png',
                            'options' => array('class' => 'show-book-chapters','target'=>'_blank'),
                            'url' => 'Yii::app()->createAbsoluteUrl("admin/rolesAuth/user",array("id"=>$data->id))',
                            'visible'=>'Controller::isAllowAccess(Controllers::getByName("rolesAuth")->id, "user")',
                        )
                    ),
		),
		'email',
//		'password_hash',
//		'temp_password',
		'first_name',
		'last_name',
		'code_account',
		'address',
//		'address_vi',
//		'house_numbers',
//		'province_id',
//		'district_id',
//		'ward_id',
//		'street_id',
//		'login_attemp',
//		'created_date',
		'last_logged_in',
		'ip_address',
		//'role_id',
		array(
                    'name'=>'role_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> '!empty($data->role_id) ? $data->role->role_short_name : ""',
                    'filter'=>Roles::loadItems(),
                ),
		'application_id',
		array(
                    'name'=>'application_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> '!empty($data->application_id) ? $data->application->name : ""',
                    'filter'=> Applications::loadItems(),
                ),
		'status',
		'gender',
		'phone',
		'verify_code',
		'slug',
		'address_temp',
		'created_by',
		/*
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
