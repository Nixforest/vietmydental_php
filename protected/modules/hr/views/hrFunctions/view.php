<?php
/* @var $this HrFunctionsController */
/* @var $model HrFunctions */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->name; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'function',
        array(
            'name' => 'role_id',
            'value' => $model->getRoleName(),
        ),
        array(
            'name' => 'type_id',
            'value' => $model->getType(),
        ),
        array(
            'name' => 'is_per_day',
            'value' => $model->isPerDayText(),
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
    <h1><?php echo DomainConst::CONTENT00545; ?></h1>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'hr-parameters-grid',
        'dataProvider' => $model->getAllParameters(),
        'columns' => array(
            array(
                'header' => HrFunctions::KEYWORD_PARAM,
                'type' => 'raw',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'header' => DomainConst::CONTENT00493,
                'name' => 'name',
            ),
            array(
                'header' => DomainConst::CONTENT00494,
                'name' => 'method',
            ),
            array(
                'header' => DomainConst::CONTENT00488,
                'name' => 'role_id',
                'value' => '$data->getRoleName()',
                'filter' => Roles::getRoleArrayForSalary(),
            ),
        ),
    ));
    ?>
</div>
<div>
    <h1><?php echo DomainConst::CONTENT00496; ?></h1>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'hr-coefficients-grid',
        'dataProvider' => $model->getAllCoefficients(),
        'columns' => array(
            array(
                'header' => HrFunctions::KEYWORD_COEFFICIENT,
                'type' => 'raw',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'header' => DomainConst::CONTENT00497,
                'name' => 'name',
            ),
            array(
                'header' => DomainConst::CONTENT00495,
                'value' => '$data->getValue()',
            ),
            array(
                'header' => DomainConst::CONTENT00488,
                'name' => 'role_id',
                'value' => '$data->getRoleName()',
                'filter' => Roles::getRoleArrayForSalary(),
            ),
        ),
    ));
    ?>
</div>
