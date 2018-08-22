<?php
/**
 * @this Newscontroller
 * @model model news
 */
?>
<?php if (!empty($model)) : ?>
    <?php
    $category = '';
    if (isset($model->rCategory)) {
        $isFirst = true;
        foreach (array_reverse($model->rCategory->getChain()) as $mCategory) {
            $category .= '<a href="' . $mCategory->getFrontEndUrl() . '">' . ($isFirst ? '|' : '->') . $mCategory->name . '</a>';
            $isFirst = false;
        }
        
    }
    echo $category;
    ?>
    <h1><?php echo $model->description; ?></h1>
    <?php echo !empty($model) ? $model->getField('content') : ''; ?>
<?php endif; ?>
