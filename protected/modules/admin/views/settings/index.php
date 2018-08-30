<?php
/* @var $this SettingsController */
/* @var $model Settings */

//$this->breadcrumbs=array(
//	'Settings'=>array('index'),
//	'Manage',
//);
//
//$this->menu=array(
//	array('label'=>'List Settings', 'url'=>array('index')),
//	array('label'=>'Create Settings', 'url'=>array('create')),
//);
$this->createMenu('index', $model);
?>

<!--<h1>Manage Settings</h1>-->
<h1><?php echo $this->pageTitle; ?></h1>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'roles-auth',
    'enableAjaxValidation' => false,
        ));
$isFirstTab = true;
$isFirstTabContent = true;
?>
<?php if (Yii::app()->user->hasFlash(DomainConst::KEY_SUCCESS_UPDATE)): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash(DomainConst::KEY_SUCCESS_UPDATE); ?>
    </div>
<?php endif; // end if (Yii::app()->user->hasFlash('successUpdate'))  ?>
<div id="tabs" class="container">
    <ul class="nav nav-tabs">
        <?php
        foreach ($aSettings as $key => $value) {
            $class = '';                // Class specific which tab is actived
            if ($isFirstTab) {
                $class = 'class="active"';
                $isFirstTab = false;
            }
            echo '<li ' . $class . '><a data-toggle="tab" href=#tabs-' . $key . '>' . $value[DomainConst::KEY_ALIAS] . '</a></li>';
        }
        ?>
    </ul>
    <div class="tab-content">
        <?php foreach ($aSettings as $key => $value): ?>
        <?php
            $class = '';                // Class specific which tab is actived
            if ($isFirstTabContent) {
                $class = 'in active"';
                $isFirstTabContent = false;
            }
        ?>
        <div id="tabs-<?php echo $key; ?>" class="tab-pane fade <?php echo $class; ?>">
            <?php foreach ($value[DomainConst::KEY_CHILDREN] as $child): ?>
                <?php
                    $description = $child;
                    $value = '';
                    $id = '';
                    $isNew = false;
                    if (isset(Settings::loadItems()[$child])) {
                        $description = Settings::loadItems()[$child]->description;
                        $value = Settings::loadItems()[$child]->value;
                        $id = Settings::loadItems()[$child]->id;
                    } else {
                        // Handle set url to create new key-value
                        $isNew = true;
                    }
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <label for="<?php echo $id; ?>"><?php echo $description; ?></label>
                    </div>
                    <div class="col-md-3">
                        <?php if(in_array($child, $aTypeView['CheckBox'])): ?>
                        <input style="display: none;" type="text" name="<?php echo $id;?>" id="<?php echo $id; ?>"
                               value="<?php echo $value ?>">
                        <input class="check-book-settings" type="checkbox" data-id="<?php echo $id; ?>"
                               <?php echo $value == true ? 'checked' : ''; ?>>
                        <?php else: ?>
                        <input type="text" name="<?php echo $id;?>" id="<?php echo $id; ?>"
                               value="<?php echo $value ?>">
                        <?php endif; ?>
                    </div>
                    <?php if ($isNew): ?>
                    <div class="col-md-1">
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('admin/settings/create', array(
                            'key' => $description,
                        )) ?>"><?php echo DomainConst::CONTENT00017 ?></a>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; // foreach ($value[DomainConst::KEY_CHILDREN] as $child): ?>
        </div>
        <?php endforeach; // foreach ($aSettings as $key => $value): ?>
    </div>
</div>
<div class="form form_fix_submit">
    <div class="row buttons" style="padding-left: 250px; padding-top: 20px;">
        <?php echo CHtml::submitButton("Save", array('name'=>'submit')); ?>
    </div>    
</div>
<?php $this->endWidget(); ?>

<script>
    $(document).ready(function(){
        check();
    });
    function check() {
        $('.check-book-settings').on('change',function(){
            var value = this.checked ? "1" : "0";
            var id = '#'+ $(this).data('id');
            $(id).val(value);
        });
    }
</script>