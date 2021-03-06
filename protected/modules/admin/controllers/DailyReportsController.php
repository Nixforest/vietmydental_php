<?php

class DailyReportsController extends AdminController
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new DailyReports;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DailyReports']))
		{
			$model->attributes=$_POST['DailyReports'];
                        $model->validate();
			if(!$model->hasErrors()){
                            if($model->save()){
                                $this->redirect(array('view','id'=>$model->id));
                            }
                        }
		}

		$this->render('create',array(
			'model'=>$model,
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
                $model->scenario = 'update';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DailyReports']))
		{
			$model->attributes=$_POST['DailyReports'];
			$model->validate();
			if(!$model->hasErrors()){
                            if($model->save()){
                                $this->redirect(array('view','id'=>$model->id));
                            }
                        }
		}

		$this->render('update',array(
			'model'=>$model,
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
//		$dataProvider=new CActiveDataProvider('DailyReports');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
            $model=new DailyReports('search');
            $model->unsetAttributes();  // clear any default values
            $model->date_report = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
            if(isset($_GET['DailyReports'])){
                $model->attributes=$_GET['DailyReports'];
            }
            if(isset($_POST['DailyReports'])){
                $model->attributes=$_POST['DailyReports'];
                $model->createDailyReport();
            }

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
		$model=new DailyReports('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DailyReports']))
			$model->attributes=$_GET['DailyReports'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DailyReports the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DailyReports::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param DailyReports $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='daily-reports-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
         * confirm
         * @param int $id
         */
        public function actionConfirm($id)
	{
            $model = $this->loadModel($id);
            $model->status = DailyReports::STATUS_CONFIRM;
            $model->receipt_total_confirm = $model->receipt_total;
            $model->update();
	}
        
        /**
         * process
         * @param int $id
         */
        public function actionProcess($id)
	{
            $model = $this->loadModel($id);
            $model->status = DailyReports::STATUS_PROCESS;
            $model->update();
	}
        
        /**
         * process
         * @param int $id
         */
        public function actionCancel($id)
	{
            $model = $this->loadModel($id);
            $model->status = DailyReports::STATUS_CANCEL;
            $model->update();
	}
        
        /**
         * View all report date of doctor
         * @param int $doctor_id
         * @param string $date_report Y-m-d
         */
        public function actionViewDetailReport($doctor_id, $date_report){
            $this->layout='//layouts/ajax';
            $mDailyReport = new DailyReports();
            $mDailyReport->approve_id = $doctor_id;
            $mDailyReport->date_report = $date_report;            
            $this->render('revenue_daily_report', array(
                    'model'          => $mDailyReport,
                    DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
            ));
        }
}
