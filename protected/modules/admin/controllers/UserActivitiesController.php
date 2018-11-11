<?php

class UserActivitiesController extends AdminController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new UserActivities('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserActivities'])) {
            $model->attributes = $_GET['UserActivities'];
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
     * @return UserActivities the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = UserActivities::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param UserActivities $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-activities-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
