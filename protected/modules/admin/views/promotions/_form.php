<?php
/* @var $this PromotionsController */
/* @var $model Promotions */
/* @var $form CActiveForm */
$mAgents = new Agents();
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'promotions-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textArea($model,'title',array('rows'=>3, 'cols'=>50,'style'=>'width:600px;')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>3, 'cols'=>50,'style'=>'width:600px;')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'attribute' => 'start_date',
                    'model' =>$model,
                    'options'   => array(
                        'showAnim'      => 'fold',
                        'dateFormat'    => DomainConst::DATE_FORMAT_2,
                        'maxDate'       => '0',
                        'changeMonth'   => true,
                        'changeYear'    => true,
                        'showOn'        => 'button',
                        'buttonImage'   => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                        'buttonImageOnly' => true,
                    ),
                    'htmlOptions'=>array(
                                'class'=>'w-16',
                                'readonly'=>'readonly',
                            ),
                ));
                ?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'attribute' => 'end_date',
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
                                'readonly'=>'readonly',
                            ),
                ));
                ?>
		<?php echo $form->error($model,'end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type', $model->getArrayType(), array('class'=>'','empty'=>'Select')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'agents'); ?>
                <?php
                   $this->widget('ext.multiselect.JMultiSelect',array(
                         'model'=>$model,
                         'attribute'=>'agents',
                         'data'=> $mAgents->getAgentList(),
                         // additional javascript options for the MultiSelect plugin
                        'options'=>array('selectedList' => 30,),
                         // additional style
                         'htmlOptions'=>array('style' => 'width: 600px;'),
                   ));    
               ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
                <?php echo $form->dropDownList($model,'status', $model->getArrayStatus(), array('class'=>'')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->