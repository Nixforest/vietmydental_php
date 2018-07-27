<h1>Thông tin <?php echo $model->getField('title'); ?></h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'promotions-grid',
	'dataProvider'=>$model->searchDetail(),
//        'afterAjaxUpdate'=>'function(id, data){ BindClickView(); }',
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
                    'header' => DomainConst::CONTENT00051,
                    'type' => 'raw',
                    'value' => '$data->getCustomerType()'
                ),
                array(
                    'header' => DomainConst::CONTENT00317,
                    'type' => 'raw',
                    'value' => '$data->getField(\'discount\')'
                ),
                array(
                    'header' => DomainConst::CONTENT00062,
                    'type' => 'raw',
                    'value' => '$data->getField(\'description\')'
                ),
                array(
                    'header' => DomainConst::CONTENT00128,
                    'type' => 'raw',
                    'value' => '$data->getTreatmentTypes()'
                ),
	),
)); 
?>

