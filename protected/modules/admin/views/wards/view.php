<?php
/* @var $this WardsController */
/* @var $model Wards */

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
            'name' => 'district_id',
            'value' => isset($model->rDistrict) ? $model->rDistrict->name : '',
        ),
    ),
));
?>
