<?php
/* @var $this TreatmentGroupController */
/* @var $model TreatmentGroup */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'name',
		'description',
	),
)); ?>

<?php if (isset($model->rTreatmentType) && !empty($model->rTreatmentType)): ?>
    <h1><?php echo DomainConst::CONTENT00128 . ':'; ?></h1>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'children-grid',
        'dataProvider' => $children,
        'columns' => array(
            array(
                'header' => DomainConst::CONTENT00034,
                'type' => 'raw',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'name' => DomainConst::CONTENT00132,
                'htmlOptions' => array('style' => 'text-align:center;'),
                'value' => '$data->id',
            ),
            array(
                'name' => DomainConst::CONTENT00128,
                'htmlOptions' => array('style' => 'text-align:center;'),
                'value' => '$data->name',
            ),
            array(
                'name' => DomainConst::CONTENT00129,
                'htmlOptions' => array('style' => 'text-align:right;'),
                'value' => 'CommonProcess::formatCurrency($data->price)',
            ),
            array(
                'name' => DomainConst::CONTENT00133,
                'htmlOptions' => array('style' => 'text-align:center;'),
                'value' => 'DomainConst::CONTENT00134',
            ),
            array(
                'name' => DomainConst::CONTENT00130,
                'htmlOptions' => array('style' => 'text-align:right;'),
                'value' => 'CommonProcess::formatCurrency($data->material_price)',
            ),
            array(
                'name' => DomainConst::CONTENT00131,
                'htmlOptions' => array('style' => 'text-align:right;'),
                'value' => 'CommonProcess::formatCurrency($data->labo_price)',
            ),
            array(
                'name' => DomainConst::CONTENT00026,
                'htmlOptions' => array('style' => 'text-align:center;'),
                'value' => 'CommonProcess::getDefaultStatus()[$data->status]',
                'visible' => CommonProcess::isUserAdmin(),
            ),
        ),
    ));
    ?>
<?php endif; // end if (isset($model->rTreatmentType) && !empty($model->rTreatmentType)) ?>
