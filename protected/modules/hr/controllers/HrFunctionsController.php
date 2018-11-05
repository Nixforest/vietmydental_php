<?php

class HrFunctionsController extends HrController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    
    /**
     * Override parent method
     * @param String $action Action id
     * @param HrFunctions $model Model object
     * @return Array List menu
     */
    public function createOperationMenu($action, $model = NULL) {
        $listMenu = parent::createOperationMenu($action, $model);
        switch ($action) {
            case 'indexSetup':
                $listMenu[] = $this->createMenuItem('createSetup');
                break;
            case 'createSetup':
                $listMenu[] = $this->createMenuItem('indexSetup');
                break;

            default:
                break;
        }
        foreach ($listMenu as $key => $value) {
            if (!self::canAccessAction($value['url'][0], $this->listActionsCanAccess)) {
                unset($listMenu[$key]);
            }
        }
        return array_values($listMenu);
    }
    
    /**
     * Lists all models.
     */
    public function actionIndexSetup() {
        $model = new HrFunctions('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['HrFunctions'])) {
            $model->attributes = $_GET['HrFunctions'];
        }
        if (filter_input(INPUT_GET, 'search')) {
            $model->attributes = $_GET['HrFunctions'];
        }

        $this->render('index_setup', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateSetup() {
        $model = new HrFunctions('search');
        $model->unsetAttributes();  // clear any default values

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (filter_input(INPUT_GET, 'search')) {
            $model->attributes = $_GET['HrFunctions'];
        }
        if (isset($_POST['HrFunctions'])) {
            Loggers::info('Start submit data [POST]', CommonProcess::json_encode_unicode($_POST['HrFunctions']),
                __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            foreach ($_POST['HrFunctions'] as $key => $function) {
                $mFunction = $this->loadModel($key);
                $mFunction->attributes = $function;
                if ($mFunction->save()) {
                    Loggers::info('Save function success', $mFunction->id,
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
                    // Delete all relation param
                    OneMany::deleteAllOldRecords($mFunction->id, OneMany::TYPE_FUNCTION_PARAMETER);
                    OneMany::deleteAllOldRecords($mFunction->id, OneMany::TYPE_FUNCTION_COEFFICIENT);
                    if (isset($function['param'])) {
                        foreach ($function['param'] as $value) {
                            OneMany::insertOne($mFunction->id, $value, OneMany::TYPE_FUNCTION_PARAMETER);
                        }
                    }
                    if (isset($function['coeff'])) {
                        foreach ($function['coeff'] as $value) {
                            OneMany::insertOne($mFunction->id, $value, OneMany::TYPE_FUNCTION_COEFFICIENT);
                        }
                    }
                }
            }
            
        }

        $params = array();
        $coefficients = array();
        $itemOption = array(
            'draggable' => 'true',
        );
        foreach (HrParameters::loadModels($model->role_id) as $value) {
            $itemOption['class'] = 'param_container dragItem';
            $itemOption['data-id'] = $value->id;
            $params[] = array(
                'label' => $value->getName(),
                'url' => array('#'),
                'itemOptions' => $itemOption,
            );
        }
        foreach (HrCoefficients::loadModels($model->role_id) as $value) {
            $itemOption['class'] = 'coeff_container dragItem';
            $itemOption['data-id'] = $value->id;
            $coefficients[] = array(
                'label' => $value->getName(),
                'url' => array('#'),
                'itemOptions' => $itemOption,
            );
        }
        $this->additionMenus[DomainConst::CONTENT00545] = $params;
        $this->additionMenus[DomainConst::CONTENT00496] = $coefficients;
        $this->render('create_setup', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }
    
    /**
     * Create new row
     */
    public function actionAjaxCreateNewRow() {
        // Create new model
        $model = new HrFunctions('create');
        $model->type_id = '1';
        // Get role id from POST
        if (!empty($_POST['role_id'])) {
            $model->role_id = $_POST['role_id'];
        }
        // Get type id from POST
        if (!empty($_POST['type_id'])) {
            $model->type_id = $_POST['type_id'];
        }
        $model->name = 'Tên công thức';
        $model->save();
    }
    
    /**
     * Action clone row
     */
    public function actionAjaxCloneRow() {
        $id = '';
        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
        }
        $model = $this->loadModel($id);
        if ($model) {
            $newModel = $model->cloneModel();
            $newModel->save();
            $newModel->cloneRelation($model, 'rParameters', OneMany::TYPE_FUNCTION_PARAMETER);
            $newModel->cloneRelation($model, 'rCoefficients', OneMany::TYPE_FUNCTION_COEFFICIENT);
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new HrFunctions;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['HrFunctions'])) {
            $model->attributes = $_POST['HrFunctions'];
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

        if (isset($_POST['HrFunctions'])) {
            $model->attributes = $_POST['HrFunctions'];
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
     * Lists all models.
     */
    public function actionIndex() {
        $model = new HrFunctions('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['HrFunctions'])) {
            $model->attributes = $_GET['HrFunctions'];
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
     * @return HrFunctions the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = HrFunctions::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param HrFunctions $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'hr-functions-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
