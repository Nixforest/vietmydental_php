<?php
/* @var $this RolesAuthController */
/* @var $id String */
/* @var $mUser Users */
?>
<h1><?php echo $this->pageTitle ?></h1>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'roles-auth',
    'enableAjaxValidation' => false,
        ));
?>
<?php if (Yii::app()->user->hasFlash(DomainConst::KEY_SUCCESS_UPDATE)): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash(DomainConst::KEY_SUCCESS_UPDATE); ?>
    </div>
<?php endif; // end if (Yii::app()->user->hasFlash('successUpdate'))  ?>
<?php
$arrayTabs = array();
$isActive = true;
$listControllers = RolesAuthController::getListRolesAuthenticatedFromDb1();
foreach ($listControllers as $module_id => $module) {
    $id = $module_id;
    $label = $module[DomainConst::KEY_ALIAS];
    $content = $this->renderPartial('_module_tab_content', array(
        'module'    => $module,
        'module_id' => $module_id,
        'mUser'     => $mUser,
    ), true);
    if ($isActive) {
        $isActive = false;
        $tab = array(
            'id'        => $id,
            'label'     => $module[DomainConst::KEY_ALIAS],
            'content'   => $content,
            'active'    => true,
        );
    } else {
        $tab = array(
            'id'        => $id,
            'label'     => $module[DomainConst::KEY_ALIAS],
            'content'   => $content,
        );
    }
    $arrayTabs[] = $tab;
}
$this->widget('bootstrap.widgets.TbTabs', array(
    'type' => 'tabs',
    'tabs' => $arrayTabs,
));
?>
<div class="form form_fix_submit">
    <div class="row buttons" style="padding-left: 250px; padding-top: 20px;">
        <?php echo CHtml::submitButton("Save", array('name'=>'submit')); ?>
    </div>    
</div>
<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
<style>
    form label {
        float: none;
        padding-top: 0px;
        padding-left: 20px;
        text-align: left;
        width: 100%;
    }
    table, th, td {
        border: 1px solid black;
    }
</style>
 <script>
</script>
