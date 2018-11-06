<?php $this->beginContent('//layouts/main'); ?>
<div class="row-fluid">
    <div class="span2">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => DomainConst::CONTENT00547,
            'hideOnEmpty' => true,
        ));
        $this->widget('zii.widgets.CMenu', array(
            'items' => $this->menu,
            'htmlOptions' => array('class' => 'sidebar'),
            'encodeLabel' => false,
        ));
        $this->endWidget();
        ?>
        <div class="addition_menu">
            <?php
            foreach ($this->additionMenus as $key => $menu) {
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title' => $key,
                    'hideOnEmpty' => false,
                ));
                $this->widget('zii.widgets.CMenu', array(
                    'items' => $menu,
                    'htmlOptions' => array('class' => 'sidebar'),
                    'encodeLabel' => false,
                ));
                $this->endWidget();
            }
            ?>
        </div>
        <div class="module_menu">
            <?php
            foreach ($this->moduleMenus as $key => $menu) {
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title' => $key,
                    'hideOnEmpty' => false,
                ));
                $this->widget('zii.widgets.CMenu', array(
                    'items' => $menu,
                    'htmlOptions' => array('class' => 'sidebar'),
                    'encodeLabel' => false,
                ));
                $this->endWidget();
            }
            ?>
        </div>
        
    </div><!-- sidebar span3 -->

    <div class="span10">
        <div class="main">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
</div>
<?php $this->endContent(); ?>
