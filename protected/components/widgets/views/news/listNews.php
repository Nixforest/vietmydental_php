<?php 
$mNews = new News('search');
$aNews = $mNews->getArrayNews(News::STATUS_ACTIVE);
?>
<div class="ad_read_news">
    <section>
        <h1 class="title"><strong>Bảng tin</strong></h1>
        <div class="content document">
            <ul>
                <?php foreach ($aNews as $key => $mNews) { ?>
                <li>
                    <a target="_blank" class="_link" href="<?php echo Yii::app()->createAbsoluteUrl('/front/news/view',['id'=>$mNews->id]); ?>"><?php echo $mNews->getField('description'); ?></a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </section>
</div>