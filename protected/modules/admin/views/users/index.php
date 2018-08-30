<?php
/* @var $this UsersController */
/* @var $model Users */

$this->createMenu('index', $model);

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
    'id' => 'users-grid',
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
        'first_name',
        'username',
//	'email',
//        array(
//            'header' => DomainConst::CONTENT00276,
//            'value' => '$data->getSocialNetworkInfo()',
//            'type' => 'html',
//            'htmlOptions' => array('style' => 'width:200px;'),
//        ),
        'address',
        array(
            'name'  => 'birthday',
            'value' => 'CommonProcess::convertDateTime($data->birthday, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_3)',
        ),
        array(
            'name'  => 'date_in',
            'value' => 'CommonProcess::convertDateTime($data->date_in, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_3)',
        ),
        array(
            'header' => DomainConst::CONTENT00421,
            'value' => '$data->getIdentityInfo()',
            'type' => 'html',
            'htmlOptions' => array('style' => 'width:150px;'),
        ),
//	'code_account',
        /*
          'code_account',
          'address',
          'address_vi',
          'house_numbers',
          'province_id',
          'district_id',
          'ward_id',
          'street_id',
          'login_attemp',
          'created_date',
          'last_logged_in',
          'ip_address',
          'application_id',
          'status',
          'gender',
          'verify_code',
          'slug',
          'address_temp',
          'created_by',
         */
//	'last_logged_in',
        'phone',
        array(
            'name'=>'gender',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value'=> 'isset(CommonProcess::getGender()[$data->gender]) ? CommonProcess::getGender()[$data->gender] : ""',
            'filter'=> CommonProcess::getGender(),
        ),
        array(
            'name' => 'agent',
            'type' => 'html',
//                    'value' => '$data->getAgentName()',
            'value' => '$data->getAgentNameTest()',
//            'filter' => Agents::loadItems(),
        ),
        array(
            'name' => 'role_id',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '!empty($data->role_id) ? $data->rRole->role_short_name : ""',
            'filter' => Roles::loadItems(),
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
                    'url' => 'Yii::app()->createAbsoluteUrl("admin/rolesAuth/user",array("id"=>$data->id))',
                )
            ),
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => $this->createActionButtons(),
//            'buttons' => array(
//                'update' => array(
//                    'visible' => '$data->canUpdate()',
//                ),
//                'delete' => array(
//                    'visible' => '$data->canDelete()',
//                ),
//            ),
        ),
    ),
));
?>
