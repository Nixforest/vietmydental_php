<?php

class CompaniesController extends AdminController {

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
        // Adding start ThangTGM 18112018
            $treeHR = ""; // Load mảng phòng ban
            $treeHR = "<div class='tree'>";
            $treeHR .= "<ul>";
            //$treeHR .= $this->printDepartmentChart($treeHR, 0);
            $treeHR .= "</ul>";
            $treeHR .= "</div>";

        // Adding end
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
        $model = new Companies;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Companies'])) {
            $model->attributes = $_POST['Companies'];
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

        if (isset($_POST['Companies'])) {
            $model->attributes = $_POST['Companies'];
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
        $model = new Companies('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Companies'])) {
            $model->attributes = $_GET['Companies'];
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
     * @return Companies the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Companies::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Companies $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'companies-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*

    */
    public function printDepartmentChart($list, $parent_id){
        $result = "";
        foreach($list as $item){
            if($item['parent_id'] == $parent_id){
                if($this->hasChild($list,  $item['id'])){
                    $result .= "<li><span data-id='".$item['id']."' parent-id='".$item['parent_id']."'><i class='node fa fa-minus-square'></i> ". $item['name'] ."</span>";
                    $result .= "<ul>";
                    $result .= $this->printDepartmentChart($list, $item['id']);
                    $result .= "</ul>";
                }
                else {
                    $result .= "<li><span data-id='".$item['id']."' parent-id='".$item['parent_id']."'>". $item['name'] ."</span>";
                }
                $result .= "</li>";
            }
        }
        return $result;
    }

    /*

    */
    public function hasChild($list, $parent_id){
        foreach($list as $item){
            if($item['parent_id'] == $parent_id){
                return true;
            }
        }
        return false;
    }
}
