<?php

class LaboRequestsController extends AdminController {

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
        $model = new LaboRequests('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['LaboRequests'])) {
            $model->attributes = $_POST['LaboRequests'];
            $model->validate();
            if (!$model->hasErrors()) {
                if ($model->save()) {
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * create ajax
     */
    public function actionCreateAjax($id) {
        $model = $this->getLaboRequests($id);
        if (empty($model)) {
            $model = new LaboRequests('create');
            $model->treatment_detail_id = $id;
        } else {
            $model->handleSearch();
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['LaboRequests'])) {
            $model->attributes = $_POST['LaboRequests'];
            if (isset($_POST['teethData'])) {
                $model->teeths = $_POST['teethData'];
            }
            $model->handleBeforeSave();
            $model->validate();
            if (!$model->hasErrors()) {
                $model->handlesave();
                $this->redirect(array('createAjax', 'id' => $id));
            }
        }
        $this->render('_form_ajax', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
//		echo CJSON::encode(array(
//                    DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
//                    DomainConst::KEY_CONTENT => $this->renderPartial('_form_ajax',
//                        array(
//                            'model' => $model,
//                            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
//                        ),
//                        true, true),
//                ));
//                exit;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateAjax($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'update';
        $model->handleSearch();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['LaboRequests'])) {
            $model->attributes = $_POST['LaboRequests'];
            if (isset($_POST['teethData'])) {
                $model->teeths = $_POST['teethData'];
            }
            $model->handleBeforeSave();
            $model->validate();
            if (!$model->hasErrors()) {
                $model->handlesave();
                $this->redirect(array('updateAjax', 'id' => $id));
            }
        }
        $this->render('_form_ajax', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
//		echo CJSON::encode(array(
//                    DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
//                    DomainConst::KEY_CONTENT => $this->renderPartial('_form_ajax',
//                        array(
//                            'model' => $model,
//                            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
//                        ),
//                        true, true),
//                ));
//                exit;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'update';
        $model->handleSearch();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['LaboRequests'])) {
            $model->attributes = $_POST['LaboRequests'];
            if (isset($_POST['teethData'])) {
                $model->teeths = $_POST['teethData'];
            }
            $model->handleBeforeSave();
            $model->validate();
            if (!$model->hasErrors()) {
                $model->handlesave();
                $this->redirect(array('update', 'id' => $id));
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
//		$dataProvider=new CActiveDataProvider('LaboRequests');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
        $model = new LaboRequests('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['LaboRequests'])) {
            $model->attributes = $_GET['LaboRequests'];
        }

        $this->render('index', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new LaboRequests('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['LaboRequests'])) {
            $model->attributes = $_GET['LaboRequests'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return LaboRequests the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = LaboRequests::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param LaboRequests $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'labo-requests-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * get LaboRequests by detail id
     * @param int $detail_id
     */
    public function getLaboRequests($detail_id) {
        $criteria = new CDbCriteria;
        $criteria->compare('treatment_detail_id', $detail_id);
        return LaboRequests::model()->find($criteria);
    }

}
