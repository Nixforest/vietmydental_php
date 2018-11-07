<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

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
            <label for="<?php echo $id; ?>" style="text-align: right;"><?php echo $description; ?></label>
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