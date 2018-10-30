<?php
/* @var $this HrCoefficientsController */
/* @var $model HrCoefficients */
    
$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->name; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        array(
            'name' => DomainConst::CONTENT00495,
            'value' => $model->getValue(),
        ),
        array(
            'name' => 'role_id',
            'value' => $model->getRoleName(),
        ),
        array(
            'name' => 'status',
            'value' => $model->getStatus(),
        ),
        'created_date',
        array(
            'name' => 'created_by',
            'value' => $model->getCreatedBy(),
        ),
    ),
));
?>
<div>
    <h1><?php echo DomainConst::CONTENT00544; ?></h1>
    <?php
    $mValue = new HrCoefficientValues('search');
    $mValue->unsetAttributes();  // clear any default values
    $mValue->coefficient_id = $model->id;
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'hr-coefficient-values-grid',
        'dataProvider' => $mValue->search(),
//        'dataProvider' => $model->getAllValues(),
        'filter' => $mValue,
        'columns' => array(
            array(
                'header' => DomainConst::CONTENT00034,
                'type' => 'raw',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'name' => 'value',
                'value' => '$data->getValue()',
            ),
            array(
                'name' => 'month',
                'value' => '$data->getMonth()',
            ),
            array(
                'name' => 'status',
                'value' => '$data->getStatus()',
            ),
            'created_date',
            array(
                'name' => 'created_by',
                'value' => '$data->getCreatedBy()',
            ),
            array(
                'header' => DomainConst::CONTENT00239,
                'class' => 'CButtonColumn',
                'template' => $this->createActionButtons(),
                'buttons'   => array(
                    'view'  => array(
                        'url'   => 'Yii::app()->createAbsoluteUrl("hr/hrCoefficientValues/view", array("id" => $data->id))',
                    ),
                    'update'  => array(
                        'url'   => 'Yii::app()->createAbsoluteUrl("hr/hrCoefficientValues/update", array("id" => $data->id))',
                    ),
                    'delete'  => array(
                        'url'   => 'Yii::app()->createAbsoluteUrl("hr/hrCoefficientValues/delete", array("id" => $data->id))',
                    ),
                ),
            ),
        ),
        ));
    ?>
</div>
