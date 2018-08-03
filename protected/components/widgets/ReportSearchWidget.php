<?php
class ReportSearchWidget extends CWidget
{
    public $dateFrom, $dateTo, $model;
    public function run()
    {   
        $this->render('reportSearch/_form', array(
            'dateFrom'   => $this->dateFrom,
            'dateTo'     => $this->dateTo,
        ));
    }
}