<?php

class HrWorkPlansController extends HrController {

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
        $this->layout = '//layouts/column1';
        $model = $this->loadModel($id);
        // Handle save
        if (filter_input(INPUT_POST, 'save')) {
            Loggers::info('Save button was clicked', '',
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $this->saveWorkSchedule($model);
        }
        if (filter_input(INPUT_POST, 'auto_create')) {
            Loggers::info('Auto click button was clicked', '',
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $model->autoCreateWorkSchedule();
        }
        
        $this->render('view', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }
    
    /**
     * Handle save work schedule
     * @param HrWorkPlans $model Model object
     */
    public function saveWorkSchedule($model) {
        if (isset($_POST['HrWorkSchedules']['data'])) {
            $data = $_POST['HrWorkSchedules']['data'];
            $model->saveWorkSchedule($data);
        }
    }
    
    /**
     * Display all working schedule in an only view
     */
    public function actionViewAll() {
        $this->layout = '//layouts/column1';
        $model = new HrWorkPlans;
        $arrUsers = array();
        if (Roles::isAdminRole()) {
            
        } else {
            // TODO: Implement for the other user
        }
        $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_DB);
        if (filter_input(INPUT_GET, 'search')) {
            $model->month = $_GET['HrWorkPlans']['month'];
            $model->role_id = $_GET['HrWorkPlans']['role_id'];
            $model->department_id = $_GET['HrWorkPlans']['department_id'];
            $model->agent_id = $_GET['HrWorkPlans']['agent_id'];
            $date = CommonProcess::convertDateTime($model->month,
                    DomainConst::DATE_FORMAT_13, DomainConst::DATE_FORMAT_DB);
        }
        $arrUsers = $model->getUserArray();
        $model->date_from   = CommonProcess::getFirstDateOfMonth($date);
        $model->date_to     = CommonProcess::getLastDateOfMonth($date);
//            CommonProcess::dumpVariable($model->date_from);
        $this->render('view_all', array(
            'model'     => $model,
            'arrUsers'  => $arrUsers,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new HrWorkPlans;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $model->status = HrWorkPlans::STATUS_APPROVED;
        if (isset($_POST['HrWorkPlans'])) {
            $model->attributes = $_POST['HrWorkPlans'];
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

        if (isset($_POST['HrWorkPlans'])) {
            $model->attributes = $_POST['HrWorkPlans'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new HrWorkPlans('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['HrWorkPlans'])) {
            $model->attributes = $_GET['HrWorkPlans'];
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
     * @return HrWorkPlans the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = HrWorkPlans::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param HrWorkPlans $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'hr-work-plans-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
