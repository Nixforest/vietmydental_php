<?php

class ProductOrdersController extends ProductController {

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
        $model = new ProductOrders;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ProductOrders'])) {
            $model->attributes = $_POST['ProductOrders'];
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

        if (isset($_POST['ProductOrders'])) {
            $model->attributes = $_POST['ProductOrders'];
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
        $model = new ProductOrders('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductOrders'])) {
            $model->attributes = $_GET['ProductOrders'];
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
     * @return ProductOrders the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ProductOrders::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProductOrders $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-orders-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
