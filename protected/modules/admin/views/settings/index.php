<?php
/* @var $this SettingsController */
/* @var $model Settings */

$this->createMenu('index', $model);
?>

<h1><?php echo $this->pageTitle; ?></h1>
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
foreach ($aSettings as $value) {
    if ($isActive) {
        $tab = array(
            'label' => $value[DomainConst::KEY_ALIAS],
            'content' => $this->renderPartial(
                    '_tab_content', array(
                'value' => $value,
                'aTypeView' => $aTypeView,
                    ), true),
            'active' => $isActive,
        );
        $isActive = false;
    } else {
        $tab = array(
            'label' => $value[DomainConst::KEY_ALIAS],
            'content' => $this->renderPartial(
                    '_tab_content', array(
                'value' => $value,
                'aTypeView' => $aTypeView,
                    ), true),
        );
    }
    $arrayTabs[] = $tab;
}
$this->widget('bootstrap.widgets.TbTabs', array(
    'type' => 'tabs',
    'tabs' => $arrayTabs,
        )
);
?>
<div class="form form_fix_submit">
    <div class="row buttons" style="padding-left: 250px; padding-top: 20px;">
        <?php echo CHtml::submitButton("Save", array('name' => 'submit')); ?>
    </div>    
</div>
<?php $this->endWidget(); ?>

<script>
    $(document).ready(function () {
        check();
    });
    function check() {
        $('.check-book-settings').on('change', function () {
            var value = this.checked ? "1" : "0";
            var id = '#' + $(this).data('id');
            $(id).val(value);
        });
    }
</script>
