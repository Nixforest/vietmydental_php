<?php
/**
 * @this Newscontroller
 * @model model news
 */
?>
<?php if (!empty($model)) : ?>
    <h1><?php echo $model->description; ?></h1>
    <?php echo !empty($model) ? $model->getField('content') : ''; ?>
<?php endif; ?>
