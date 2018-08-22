<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$mNews = new News('search');
$aNews = $mNews->getArrayNews(News::STATUS_ACTIVE, $model->id);
?>
<div class="ad_read_news">
    <section>
        <h1 class="title"><strong><?php echo $model->name; ?></strong></h1>
        <div class="content document">
            <ul>
                <?php foreach ($aNews as $key => $mNews) { ?>
                <li>
                    <a target="_blank" class="_link" href="<?php echo Yii::app()->createAbsoluteUrl('/front/news/view',['id'=>$mNews->id]); ?>"><?php echo $mNews->getField('description'); ?></a>
                </li>
                <?php } ?>
                <?php foreach($model->rChildren as $childCategory) : ?>
                    <li>
                        <a target="_blank" class="_link" href="#"><?php echo $childCategory->name; ?></a>
                    </li>
                    <?php
                    $aNews = $mNews->getArrayNews(News::STATUS_ACTIVE, $childCategory->id);
                    ?>
                    <?php foreach ($aNews as $key => $mNews) { ?>
                    <li style="margin-left: 26px;" type="square">
                        <a target="_blank" class="_link" href="<?php echo Yii::app()->createAbsoluteUrl('/front/news/view',['id'=>$mNews->id]); ?>">
                            <?php echo DomainConst::SPACE . $mNews->getField('description'); ?>
                        </a>
                    </li>
                    <?php } ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
</div>


