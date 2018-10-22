<?php
/* @var $this RolesController */
/* @var $model Roles */

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
    'id' => 'roles-grid',
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
            'header' => DomainConst::CONTENT00036,
            'class' => 'CButtonColumn',
            'template' => '{group}',
            'htmlOptions' => array('style' => 'width:100px;text-align:center;'),
            'buttons' => array(
                'group' => array(
                    'label' => DomainConst::CONTENT00036,
                    'imageUrl' => Yii::app()->theme->baseUrl . '/img/folder.png',
                    'options' => array('class' => 'show-book-chapters', 'target' => '_blank'),
                    'url' => 'Yii::app()->createAbsoluteUrl("admin/rolesAuth/group",array("id"=>$data->id))',
                )
            ),
        ),
        array(
            'name' => 'role_name',
            'value' => '$data->role_name',
            'visible' => CommonProcess::isUserAdmin(),
        ),
        'role_short_name',
        array(
            'name' => 'application_id',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '!empty($data->application_id) ? $data->application->name : ""',
            'filter' => Applications::loadItems(),
            'visible' => CommonProcess::isUserAdmin(),
        ),
        array(
            'name'      => 'working_type',
            'value'     => '$data->getWorkingType()',
            'filter'    => Roles::getArrayWorkingType(),
        ),
        array(
            'name' => 'status',
            'type' => 'Status',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'visible' => CommonProcess::isUserAdmin(),
        ),
        array(
            'header' => DomainConst::CONTENT00239,
            'class' => 'CButtonColumn',
            'template' => $this->createActionButtons(),
            'visible' => CommonProcess::isUserAdmin(),
        ),
//		array(
//			'class'=>'CButtonColumn',
//                        'visible' => CommonProcess::isUserAdmin(),
//		),
    ),
));
?>
