<?php

class TemporaryPatientsController extends AdminController {

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
        $model = new TemporaryPatients;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['TemporaryPatients'])) {
            $model->attributes = $_POST['TemporaryPatients'];
            if ($model->save()) {
                // Handle save social network information
                foreach (SocialNetworks::TYPE_NETWORKS as $key => $value) {
                    $value = $_POST['TemporaryPatients']["social_network_$key"];
                    if (!empty($value)) {
                        SocialNetworks::insertOne($value, $model->id, SocialNetworks::TYPE_TEMP_PATIENT, $key);
                    }
                }
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

        if (isset($_POST['TemporaryPatients'])) {
            $model->attributes = $_POST['TemporaryPatients'];
            if ($model->save()) {
                // Handle save social network information
                SocialNetworks::deleteAllOldRecord($model->id, SocialNetworks::TYPE_TEMP_PATIENT);
                foreach (SocialNetworks::TYPE_NETWORKS as $key => $value) {
                    $value = $_POST['TemporaryPatients']["social_network_$key"];
                    if (!empty($value)) {
                        SocialNetworks::insertOne($value, $model->id, SocialNetworks::TYPE_TEMP_PATIENT, $key);
                    }
                }
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
        $model = new TemporaryPatients('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TemporaryPatients'])) {
            $model->attributes = $_GET['TemporaryPatients'];
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
     * @return TemporaryPatients the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = TemporaryPatients::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TemporaryPatients $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'temporary-patients-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
