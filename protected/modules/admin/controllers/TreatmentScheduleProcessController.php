<?php

class TreatmentScheduleProcessController extends AdminController
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

        //++ BUG0076-IMT (DuongNV 20180823) Create treatment schedule process
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
         * @params: $ajax if create by opening dialog, set it to TRUE
	 */
	public function actionCreate($ajax = false)
	{
		$model=new TreatmentScheduleProcess;

                // Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                
                if(!empty($_POST['id'])){ // If create from dialog, id is available
                    $model->detail_id = $_POST['id'];
                }
		if(isset($_POST['TreatmentScheduleProcess']))
		{
                        $model->attributes=$_POST['TreatmentScheduleProcess'];
                        $datedmy = $_POST['TreatmentScheduleProcess']['process_date'];
                        $datedmy = str_replace('/', '-', $datedmy);
                        $model->process_date = date('Y-m-d', strtotime($datedmy));
                        if($model->save()){
                            if($ajax){ // Create by opening dialog
                                $customer = $model->getCustomerModel();
                                if (isset($customer)) {
                                    $rightContent = $customer->getCustomerAjaxInfo();
                                    $infoSchedule = $customer->getCustomerAjaxScheduleInfo();
                                }
                                echo CJavaScript::jsonEncode(array(
                                    DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
                                    DomainConst::KEY_CONTENT => DomainConst::CONTENT00035,
                                    DomainConst::KEY_RIGHT_CONTENT  => $rightContent,
                                    DomainConst::KEY_INFO_SCHEDULE => $infoSchedule,
                                ));
                                exit;
                            } else {
                                $this->redirect(array('view','id'=>$model->id));
                            }
                        }
		}

                if($ajax){
                    echo CJSON::encode(array(
                        DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
                        DomainConst::KEY_CONTENT => $this->renderPartial('create',array(
                                'model'=>$model,
                                DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                            ), true, true),
                    ));
                    exit;
                } else {
                    $this->render('create',array(
                            'model'=>$model,
                            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                    ));
                }
	}
        //-- BUG0076-IMT (DuongNV 20180823) Create treatment schedule process
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

		if(isset($_POST['TreatmentScheduleProcess']))
		{
			$model->attributes=$_POST['TreatmentScheduleProcess'];
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
//		$dataProvider=new CActiveDataProvider('TreatmentScheduleProcess');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
		$model=new TreatmentScheduleProcess('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TreatmentScheduleProcess']))
			$model->attributes=$_GET['TreatmentScheduleProcess'];

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
		$model=new TreatmentScheduleProcess('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TreatmentScheduleProcess']))
			$model->attributes=$_GET['TreatmentScheduleProcess'];

		$this->render('admin',array(
			'model'=>$model,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TreatmentScheduleProcess the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TreatmentScheduleProcess::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TreatmentScheduleProcess $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='treatment-schedule-process-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
