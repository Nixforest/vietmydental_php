<?php
/* @var $this DailyReportsController */
/* @var $model DailyReports */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
                <?php echo $form->labelEx($model,'date_report'); ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'attribute' => 'date_report',
                    'model' =>$model,
                    'options'   => array(
                        'showAnim'      => 'fold',
                        'dateFormat'    => DomainConst::DATE_FORMAT_2,
                        'changeMonth'   => true,
                        'changeYear'    => true,
                        'showOn'        => 'button',
                        'buttonImage'   => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                        'buttonImageOnly' => true,
                    ),
                    'htmlOptions'=>array(
                                'class'=>'w-16',
                                'readonly'=>true,
                            ),
                ));
                ?>
	</div>
    
        <div class="row">
		<?php echo $form->label($model,'approve_id'); ?>
                <?php echo $form->dropDownList($model,'approve_id', $model->getArrayDoctor(), array('class'=>'','empty'=>'Select')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', $model->getArrayStatus(), array('class'=>'','empty'=>'Select')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->