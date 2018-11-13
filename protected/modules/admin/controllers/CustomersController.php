<?php

class CustomersController extends AdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
//	public function filters()
//	{
//		return array(
//			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
//		);
//	}
//
//	/**
//	 * Specifies the access control rules.
//	 * This method is used by the 'accessControl' filter.
//	 * @return array access control rules
//	 */
//	public function accessRules()
//	{
//		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);
//	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Customers;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Customers']))
		{
			$model->attributes=$_POST['Customers'];
                        // Convert value of debt from formated value to save value
                        $model->debt = str_replace(DomainConst::SPLITTER_TYPE_MONEY, '', $_POST['Customers']['debt']);
//                        Import::importCustomer();
			if($model->save()) {
                            if (filter_input(INPUT_POST, 'submit')) {
                                $selectedAgent = $_POST['Customers']['agent'];
                                OneMany::insertOne($selectedAgent, $model->id, OneMany::TYPE_AGENT_CUSTOMER);
                                $referCode = $_POST['Customers']['referCode'];
                                // Handle save refer code
//                                if (!empty($referCode)) {
//                                    ReferCodes::connect($referCode, $model->id, ReferCodes::TYPE_CUSTOMER);
//                                }
                                $model->updateReferCode($referCode);
                                // Handle save social network information
                                foreach (SocialNetworks::TYPE_NETWORKS as $key => $value) {
                                    $value = $_POST['Customers']["social_network_$key"];
                                    if (!empty($value)) {
                                        SocialNetworks::insertOne($value, $model->id, SocialNetworks::TYPE_CUSTOMER, $key);
                                    }
                                }
                            }
                            $this->redirect(array('view','id'=>$model->id));
                        }
		}

		$this->render('create',array(
			'model'=>$model,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
                
//                $model->autocomplete_name_user = $model->rUser ? $model->rUser->user_name : "";
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                $model->agent = $model->getAgentId();
		if(isset($_POST['Customers']))
		{
			$model->attributes=$_POST['Customers'];
                        // Convert value of debt from formated value to save value
                        $model->debt = str_replace(DomainConst::SPLITTER_TYPE_MONEY, '', $_POST['Customers']['debt']);
			if($model->save()) {                            
                            if (filter_input(INPUT_POST, 'submit')) {
                                // Remove old record
                                OneMany::deleteAllManyOldRecords($model->id, OneMany::TYPE_AGENT_CUSTOMER);
                                $selectedAgent = $_POST['Customers']['agent'];
                                OneMany::insertOne($selectedAgent, $model->id, OneMany::TYPE_AGENT_CUSTOMER);
                                $referCode = $_POST['Customers']['referCode'];
                                // Handle save refer code
//                                if (!empty($referCode)) {
//                                    ReferCodes::connect($referCode, $model->id, ReferCodes::TYPE_CUSTOMER);
//                                }
                                $model->updateReferCode($referCode);
                                // Handle save social network information
                                SocialNetworks::deleteAllOldRecord($model->id, SocialNetworks::TYPE_CUSTOMER);
                                foreach (SocialNetworks::TYPE_NETWORKS as $key => $value) {
                                    $value = $_POST['Customers']["social_network_$key"];
                                    if (!empty($value)) {
                                        SocialNetworks::insertOne($value, $model->id, SocialNetworks::TYPE_CUSTOMER, $key);
                                    }
                                }
                            }
                            $this->redirect(array('view','id'=>$model->id));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
//	public function actionDelete($id)
//	{
//		$this->loadModel($id)->delete();
//
//		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Customers('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Customers']))
			$model->attributes=$_GET['Customers'];

		$this->render('index',array(
			'model'=>$model,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Customers('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Customers']))
			$model->attributes=$_GET['Customers'];

		$this->render('admin',array(
			'model'=>$model,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Customers the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Customers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Customers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='customers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
