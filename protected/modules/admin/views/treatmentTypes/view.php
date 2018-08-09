<?php
/* @var $this TreatmentTypesController */
/* @var $model TreatmentTypes */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'description',
        'price',
        'material_price',
        'labo_price',
        array(
            'name'  => 'group_id',
            'value' => isset($model->rGroup) ? $model->rGroup->name : '',
        ),
        array(
            'name'      => 'status',
            //++ BUG0059-IMT (NguyenPT 20180809) Add new status of TreatmentTypes
//            'type'=>'Status',
            'value'     => TreatmentTypes::getStatus()[$model->status],
            //-- BUG0059-IMT (NguyenPT 20180809) Add new status of TreatmentTypes
            'visible' => CommonProcess::isUserAdmin(),
        ),
    ),
));
?>
