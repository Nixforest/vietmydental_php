<?php
/* @var $this DistrictsController */
/* @var $model Districts */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ': ' . $model->name; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
//		'id',
        'name',
        'code_no',
        'short_name',
        'slug',
        array(
            'name' => 'status',
            'type' => 'Status',
            'visible' => CommonProcess::isUserAdmin(),
        ),
        array(
            'name' => 'city_id',
            'value' => isset($model->rCity) ? $model->rCity->name : '',
        ),
    ),
));
?>

<h1><?php echo DomainConst::CONTENT00097 . ':'; ?></h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'wards-grid',
    'dataProvider' => $wards,
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
            'name' => DomainConst::CONTENT00042,
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->name',
        ),
        array(
            'name' => DomainConst::CONTENT00092,
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->short_name',
        ),
        array(
            'name' => DomainConst::CONTENT00095,
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->slug',
        ),
    ),
));
?>
