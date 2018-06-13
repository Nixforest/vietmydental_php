<?php

class AgentsController extends AdminController
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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
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
            $model = $this->loadModel($id);
            $users = $model->getUsers();
            $from = '';
            $to = '';
            // Get data from url
//            $this->validateRevenueUrl($from, $to);
            if (empty($from)) {
                $from = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
            }
            if (empty($to)) {
                $to = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
            }
            $receipts = $model->getReceipts($from, $to, array(Receipts::STATUS_RECEIPTIONIST, Receipts::STATUS_DOCTOR));
		$this->render('view',array(
			'model'=>$model,
                        'users' => $users,
                        'receipts' => $receipts,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Agents;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Agents']))
		{
			$model->attributes=$_POST['Agents'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Agents']))
		{
			$model->attributes=$_POST['Agents'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $agent_id = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : '';
            $role_id = isset(Yii::app()->user->role_id) ? Yii::app()->user->role_id : '';
            
            $model=new Agents('search');
            $model->unsetAttributes();  // clear any default values
            if (!Roles::isAdminRole($role_id) && !Roles::isDirectorRole($role_id)) {
                $model->id = $agent_id;
            }
            if(isset($_GET['Agents']))
                    $model->attributes=$_GET['Agents'];

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
		$model=new Agents('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Agents']))
			$model->attributes=$_GET['Agents'];

		$this->render('admin',array(
			'model'=>$model,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Agents the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Agents::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Agents $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='agents-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
