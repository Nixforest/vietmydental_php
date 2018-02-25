<?php $this->beginContent('//layouts/front/main'); ?>
      <div class="row-fluid">
        <div class="span3">
         <?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Tác vụ',
                                'hideOnEmpty' => false,
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'sidebar'),
//				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
		?>
		</div><!-- sidebar span3 -->

	<div class="span9">
		<div class="main">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent(); ?>
