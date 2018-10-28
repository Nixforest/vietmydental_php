<?php
/* @var $this HrWorkPlansController */
/* @var $model HrWorkPlans */

$this->createMenu('viewAll', $model);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$('#hr-work-plans-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1><?php echo $this->pageTitle; ?></h1>
<?php echo CHtml::link(DomainConst::CONTENT00073, '#', array('class' => 'search-button')); ?>
<div class="search-form">
    <?php
    $this->renderPartial('_search_schedule', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<div id="work_schedule" class="grid-view">
    <?php
        $this->widget('WorkScheduleWidget', array(
            'model'         => $model,
            'arrEmployee'   => $arrUsers,
            'role_id'       => $model->role_id,
            'canUpdate'     => false,
        ));
    ?>
</div>
