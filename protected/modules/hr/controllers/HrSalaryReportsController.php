<?php

class HrSalaryReportsController extends HrController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new HrSalaryReports;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT)) {
            Loggers::info('Submit button was clicked', '',
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
        if (filter_input(INPUT_POST, 'search')) {
            Loggers::info('Search button was clicked', '',
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
        if (isset($_POST['HrSalaryReports'])) {
            $model->attributes = $_POST['HrSalaryReports'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT)) {
            Loggers::info('Submit button was clicked', '',
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            if (isset($_POST['HrSalaryReports'])) {
                $model->attributes = $_POST['HrSalaryReports'];
                if ($model->save()) {
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }
        if (filter_input(INPUT_POST, 'search')) {
            Loggers::info('Search button was clicked', '',
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            if (isset($_POST['HrSalaryReports'])) {
                $model->attributes = $_POST['HrSalaryReports'];
            }
        }
        
        $dataColumn = array(
            array(
                'header' => DomainConst::CONTENT00034,
                'type' => 'raw',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'name' => DomainConst::CONTENT00490,
                'value' => '$data->getFullName()',
            ),
            array(
                'name' => DomainConst::CONTENT00046,
                'value' => '$data->getRoleName()',
            ),
            array(
                'name' => DomainConst::CONTENT00199,
                'value' => '$data->getAgentName()',
            ),
            array(
                'name' => DomainConst::CONTENT00525,
                'value' => '$data->getDepartment()',
            ),
        );
        
        $this->render('update', array(
            'model'         => $model,
            'dataColumn'    => $dataColumn,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new HrSalaryReports('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['HrSalaryReports'])) {
            $model->attributes = $_GET['HrSalaryReports'];
        }

        $this->render('index', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return HrSalaryReports the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = HrSalaryReports::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param HrSalaryReports $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'hr-salary-reports-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
