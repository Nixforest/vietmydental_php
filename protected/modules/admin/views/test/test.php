<?php
/* @var $this StreetsController */
/* @var $model Streets */

?>
<div id="tabs" class="container">
    <ul class="nav nav-tabs">
        <?php
        $idx = 1;
        foreach ($arrTabs as $value) {
            $class = '';                // Class specific which tab is actived
            if ($idx == $tabId) {
                $class = 'class="active"';
            }
            echo '<li ' . $class . '><a data-toggle="tab" href=#tabs-' . $idx++ . '>' . $value . '</a></li>';
        }
        ?>
    </ul>
    <div class="tab-content">
        <?php $idx = 1; ?>
        <?php foreach ($arrTabs as $value): ?>
        <?php
            $class = '';                // Class specific which tab is actived
            if ($idx == $tabId) {
                $class = 'in active"';
            }
        ?>
        <div id="tabs-<?php echo $idx++; ?>" class="tab-pane fade <?php echo $class; ?>">
            <?php
                    switch ($value) {
                        case 'Email':
                            $this->renderPartial('_email', array());
                            break;

                        default:
                            break;
                    }
            ?>
        </div>
        <?php endforeach; // foreach ($arrTabs as $value): ?>
    </div>
</div>
<?php


