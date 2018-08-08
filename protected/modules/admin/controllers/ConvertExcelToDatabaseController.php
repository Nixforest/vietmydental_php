<?php

class ConvertExcelToDatabaseController extends AdminController
{
	public $layout='//layouts/column1';
        
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
                if(isset($_POST['ConvertExcelToDatabase'])){
                    ConvertExcelToDatabase::ConvertExcelToDatabase($_POST['ConvertExcelToDatabase']);
                }
		$this->render('index',array(
		));
	}
}
