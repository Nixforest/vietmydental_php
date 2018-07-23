<?php
/* @var $this PromotionsController */
/* @var $dataProvider CActiveDataProvider */

//$this->breadcrumbs=array(
//	'Promotions',
//);
//
//$this->menu=array(
//	array('label'=>'Create Promotions', 'url'=>array('create')),
//	array('label'=>'Manage Promotions', 'url'=>array('admin')),
//);
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
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.colorbox-min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/colorbox.css');
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php // $this->widget('zii.widgets.CListView', array(
//	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
//)); ?>

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
	'id'=>'promotions-grid',
	'dataProvider'=>$model->search(),
        'afterAjaxUpdate'=>'function(id, data){ BindClickView(); }',
//	'filter'=>$model,
	'columns'=>array(
                array(
                    'header' => DomainConst::CONTENT00034,
                    'type' => 'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    'headerHtmlOptions' => array('width' => '30px','style' => 'text-align:center;'),
                    'htmlOptions' => array('style' => 'text-align:center;')
                ),
                array(
                    'header' => DomainConst::CONTENT00004,
                    'type' => 'raw',
                    'value' => '$data->getField(\'title\')'
                ),
                array(
                    'header' => DomainConst::CONTENT00062,
                    'type' => 'raw',
                    'value' => '$data->getField(\'description\')'
                ),
                array(
                    'header' => DomainConst::CONTENT00139,
                    'type' => 'raw',
                    'value' => '$data->getStartDate()'
                ),
                array(
                    'header' => DomainConst::CONTENT00140,
                    'type' => 'raw',
                    'value' => '$data->getEndDate()'
                ),
                array(
                    'header' => DomainConst::CONTENT00199,
                    'type' => 'raw',
                    'value' => '$data->getAgents()'
                ),
                array(
                    'header' => DomainConst::CONTENT00404,
                    'type' => 'raw',
                    'value' => '$data->getType()'
                ),
                array(
                    'header' => DomainConst::CONTENT00054,
                    'type' => 'raw',
                    'value' => '$data->getCreatedBy()'
                ),
                array(
                    'header' => DomainConst::CONTENT00010,
                    'type' => 'raw',
                    'value' => '$data->getCreatedDate()'
                ),
                array(
                    'header' => 'Actions',
                    'class'=>'CButtonColumn',
                    'template'=> $this->createActionButtons(array('createDetail','view','update','delete')),
                    'buttons'=>array(
//                        'update'=>array(
//                            'visible'=> '$data->canUpdate()',
//                        ),
//                        'delete'=>array(
//                            'visible'=> '$data->canDelete()',
//                        ),
                        'createDetail'=>array(
                        'label'=>'Thêm mới chi tiết',
                        'imageUrl'=>Yii::app()->theme->baseUrl . '/img/folder.png',
                        'options'=>array('class'=>'createDetail'),
                        'url'=>'Yii::app()->createAbsoluteUrl("admin/borrow/createDetail",
                            array("id"=>$data->id) )',
//                         'visible' => '$data->canCreateDetail()',

                    ),
                    ),
                ),
	),
)); 
?>
<script>
    $(document).ready(function(){
       BindClickView(); 
    });
    
    function BindClickView(){
        $(".createDetail").colorbox({iframe:true,innerHeight:'550', innerWidth: '850',close: "<span title='close'>close</span>"});
    }
</script>