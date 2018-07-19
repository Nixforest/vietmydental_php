<?php
class NewsWidget extends CWidget
{
    public function run()
    {   
        $this->render('news/listNews');
    }
}