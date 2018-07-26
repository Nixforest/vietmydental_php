<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'promotions-grid',
	'dataProvider'=>$model->searchByPromotion(),
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
                    'header' => DomainConst::CONTENT00404,
                    'type' => 'raw',
                    'value' => '$data->getType()'
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
                array(
                    'header' => 'Actions',
                    'class'=>'CButtonColumn',
                    'template'=> $this->createActionButtons(array('updateDetail','delete')),
                    'buttons'=>array(
//                        'update'=>array(
//                            'visible'=> '$data->canUpdate()',
//                        ),
//                        'delete'=>array(
//                            'visible'=> '$data->canDelete()',
//                        ),
                        'updateDetail'=>array(
                            'label'=>'Cập nhật chi tiết',
                            'imageUrl'=>Yii::app()->theme->baseUrl . '/img/update.png',
                            'options'=>array('class'=>'updateDetail'),
                            'url'=>'Yii::app()->createAbsoluteUrl("admin/PromotionDetails/updateDetail",
                                array("id"=>$data->id) )',

                        ),
                    ),
                ),
	),
)); 
?>