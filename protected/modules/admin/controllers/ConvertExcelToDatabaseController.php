<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConvertExcelToDatabaseController
 *
 * @author nguyenpt
 */
class ConvertExcelToDatabaseController extends AdminController {

    public $layout = '//layouts/column1';

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new ConvertExcelToDatabase();
        if (isset($_POST['ConvertExcelToDatabase'])) {
            $model->attributes = $_POST['ConvertExcelToDatabase'];
            $model->excelConvertExcelToDatabase();
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

}
