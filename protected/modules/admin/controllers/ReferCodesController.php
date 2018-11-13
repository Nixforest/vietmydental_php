<?php

class ReferCodesController extends AdminController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new ReferCodes();
        if (isset($_POST['count'])) {
            $count = CommonProcess::getMoneyValue($_POST['count']);
            Loggers::info('Count', $count, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            for ($index = 0; $index < $count; $index++) {
                ReferCodes::insertOne(CommonProcess::generateUniqId(), NULL, '0');
            }
        }
        
        $this->createMenu('create', $model);
        $this->render('_form', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new ReferCodes('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ReferCodes'])) {
            $model->attributes = $_GET['ReferCodes'];
        }

        $this->render('index', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Action download excel
     */
    public function actionDownloadExcel() {
        $criteria = new CDbCriteria();
        $criteria->compare('t.status', ReferCodes::STATUS_ACTIVE);
        $criteria->limit = Settings::getItem(Settings::KEY_NUM_QRCODE_DOWNLOAD_MAX);
        $referCodes = ReferCodes::model()->findAll($criteria);
        if ($referCodes) {
            ExcelHandler::saveQRCode($referCodes);
        }
        $this->render('downloadExcel', array(
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Action Print
     */
    public function actionPrint() {
        $model = new ReferCodes();
        $count = 0;
        if (isset($_POST['count'])) {
            $count = CommonProcess::getMoneyValue($_POST['count']);
            Loggers::info('Count', $count, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
        if ($count != 0) {
            $criteria = new CDbCriteria();
            $criteria->compare('t.status', ReferCodes::STATUS_ACTIVE);
            $criteria->limit = $count;
            $referCodes = ReferCodes::model()->findAll($criteria);
            if ($referCodes) {
                ExcelHandler::saveQRCode($referCodes);
            }
        }
        
        $this->createMenu('index', $model);
        $this->render('_form', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ReferCodes the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ReferCodes::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ReferCodes $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'refer-codes-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
