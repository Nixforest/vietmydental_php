<?php

class ConvertExcelToDatabaseController extends AdminController
{
	public $layout='//layouts/column1';
        
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $model = new ConvertExcelToDatabase();
            if(isset($_POST['ConvertExcelToDatabase'])){
                $model->attributes = $_POST['ConvertExcelToDatabase'];
                $model->excelConvertExcelToDatabase();
            }
            $this->render('index',array(
                'model' => $model,
            ));
	}
}
