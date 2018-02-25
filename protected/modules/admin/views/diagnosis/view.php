<?php
/* @var $this DiagnosisController */
/* @var $model Diagnosis */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'code',
		'name',
		'name_en',
		array(
                   'name'=>'parent_id',
                   'value'=> isset($model->rParent) ? $model->rParent->name : '',
                    'visible' => $model->parent_id != DomainConst::DEFAULT_PARENT_VALUE,
                ),
		'description',
	),
)); ?>
<?php if ($model->parent_id == DomainConst::DEFAULT_PARENT_VALUE): ?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'children-grid',
        'dataProvider' => $children,
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
                'name' => DomainConst::CONTENT00125,
                'htmlOptions' => array('style' => 'text-align:center;'),
                'value' => '$data->code',
            ),
            array(
                'name' => DomainConst::CONTENT00121,
                'htmlOptions' => array('style' => 'text-align:center;'),
                'value' => '$data->name',
            ),
            array(
                'name' => DomainConst::CONTENT00122,
                'htmlOptions' => array('style' => 'text-align:center;'),
                'value' => '$data->name_en',
            ),
		array(
			'class'=>'CButtonColumn',
		),
        ),
    ));
    ?>
<?php endif; // end if (condition) ?>
