<?php

class TreatmentScheduleDetailsController extends AdminController
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
        //++ BUG0056-IMT (DuongNV 20180811) Update image data treatment
	public function actionView($id, $ajax = false)
	{
                if($ajax){
                    $this->layout='//layouts/ajax';
                }
		$this->render('view',array(
			'model'=>$this->loadModel($id),
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}
        //-- BUG0056-IMT (DuongNV 20180811) Update image data treatment

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TreatmentScheduleDetails;
                $customer = NULL;
                // Get parameter from url
                $this->validateCreateUrl($model);
                if (isset($model->schedule_id)) {
                    $schedule = TreatmentSchedules::model()->findByPk($model->schedule_id);
                    if ($schedule) {
                        $customer = $schedule->getCustomerModel();
                    }
                }

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TreatmentScheduleDetails']))
		{
			$model->attributes=$_POST['TreatmentScheduleDetails'];
			if($model->save()) {
                            if (filter_input(INPUT_POST, 'submit') || filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_SAVE)) {
                                $index = 0;
                                foreach (CommonProcess::getListTeeth() as $teeth) {
                                    if (isset($_POST['teeth'][$index])
                                            && ($_POST['teeth'][$index] == DomainConst::CHECKBOX_STATUS_CHECKED)) {
                                        OneMany::insertOne($model->id, $index, OneMany::TYPE_TREATMENT_DETAIL_TEETH);
                                    }
                                    $index++;
                                }
                            }
                            $roleName = isset(Yii::app()->user->role_name) ? Yii::app()->user->role_name : '';
                            switch ($roleName) {
                                case Roles::ROLE_RECEPTIONIST:
                                    if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT)) {
                                        $model->status = TreatmentScheduleDetails::STATUS_COMPLETED;
                                        if ($model->save()) {
                                            $this->redirect(array('view', 'id' => $model->id));
                                        }
                                    }
                                    if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_SAVE)) {
                                        $this->redirect(array('../admin/receipts/createReceptionist', 'detailId' => $model->id));
                                    }

                                    break;

                                default:
                                    $this->redirect(array('view', 'id' => $model->id));
                                    break;
                            }
//                            $this->redirect(array('view','id'=>$model->id));
                        }
		}

		$this->render('create',array(
			'model'=>$model,
                        'customer'  => $customer,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}
    
    /**
     * Validate create url and get parameter
     * @param Object $model Model
     */
    public function validateCreateUrl(&$model) {
        $model->schedule_id         = isset($_GET['schedule_id']) ? $_GET['schedule_id'] : '';
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $customer = $model->getCustomerModel();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['TreatmentScheduleDetails'])) {
            $model->attributes = $_POST['TreatmentScheduleDetails'];
            if ($model->save()) {
                // Remove old record
                OneMany::deleteAllOldRecords($model->id, OneMany::TYPE_TREATMENT_DETAIL_TEETH);
                $index = 0;
                foreach (CommonProcess::getListTeeth() as $teeth) {
                    if (isset($_POST['teeth'][$index]) && ($_POST['teeth'][$index] == DomainConst::CHECKBOX_STATUS_CHECKED)) {
                        OneMany::insertOne($model->id, $index, OneMany::TYPE_TREATMENT_DETAIL_TEETH);
                    }
                    $index++;
                }
                $roleName = isset(Yii::app()->user->role_name) ? Yii::app()->user->role_name : '';
                switch ($roleName) {
                    case Roles::ROLE_RECEPTIONIST:
                        if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT)) {
                            $model->status = TreatmentScheduleDetails::STATUS_COMPLETED;
                            if ($model->save()) {
                                $this->redirect(array('view', 'id' => $model->id));
                            }
                        }
                        if (filter_input(INPUT_POST, DomainConst::KEY_SUBMIT_SAVE)) {
                            $this->redirect(array('../admin/receipts/createReceptionist', 'detailId' => $model->id));
                        }
                        
                        break;

                    default:
                        $this->redirect(array('view', 'id' => $model->id));
                        break;
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
            'customer' => $customer,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
         * Handle update image XRay
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
         */
        //++ BUG0056-IMT (DuongNV 20180811) Update image data treatment
        public function actionUpdateImageXRay($id, $ajax = false) {
		$model=$this->loadModel($id);
//                $mImageXRayFile = new Files();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['TreatmentScheduleDetails']))
		{
//			$model->attributes=$_POST['TreatmentScheduleDetails'];
//                        $mImageXRayFile->attributes = $_POST['Files'];
                        Files::deleteFileInUpdateNotIn($model, Files::TYPE_2_TREATMENT_SCHEDULE_DETAIL_XRAY);
                        Files::saveRecordFile($model, Files::TYPE_2_TREATMENT_SCHEDULE_DETAIL_XRAY);
                        if($ajax){
                            echo CJavaScript::jsonEncode(array(
                                DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
                                DomainConst::KEY_CONTENT => DomainConst::CONTENT00035,
                            ));
                            exit;
                        } else {
                            $this->redirect(array('view','id'=>$model->id));
                        }
		}
                if($ajax){
                    echo CJSON::encode(array(
                        DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
                        DomainConst::KEY_CONTENT => $this->renderPartial('updateImageXRay',array(
                                'model'=>$model,
                                DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                            ), true, true),
                    ));
                    exit;
                } else {
                    $this->render('updateImageXRay',array(
                            'model'=>$model,
                            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                    ));
                }
        }
        //-- BUG0056-IMT (DuongNV 20180811) Update image data treatment
        
        /**
         * Update image before and after treatment.
         * @param String $id Id of treatment schedule detail
         */
        //++ BUG0056-IMT (DuongNV 20180811) Update image data treatment
        public function actionUpdateImageReal($id, $ajax = false) {
            $model = $this->loadModel($id);
            if (isset($_POST['TreatmentScheduleDetails'])) {
                Files::deleteFileInUpdateNotIn($model, Files::TYPE_3_TREATMENT_SCHEDULE_REAL_IMG);
                Files::saveRecordFile($model, Files::TYPE_3_TREATMENT_SCHEDULE_REAL_IMG);
                if($ajax){
                    echo CJavaScript::jsonEncode(array(
                        DomainConst::KEY_STATUS => DomainConst::NUMBER_ONE_VALUE,
                        DomainConst::KEY_CONTENT => DomainConst::CONTENT00035,
                    ));
                    exit;
                } else {
                    $this->redirect(array('view','id'=>$model->id));
                }
            }
            
            if($ajax){
                echo CJSON::encode(array(
                    DomainConst::KEY_STATUS => DomainConst::NUMBER_ZERO_VALUE,
                    DomainConst::KEY_CONTENT => $this->renderPartial('updateImageReal',array(
                            'model'=>$model,
                            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                        ), true, true),
                ));
                exit;
            } else {
                $this->render('updateImageReal', array(
                    'model' => $model,
                    DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
                ));
            }
        }
        //-- BUG0056-IMT (DuongNV 20180811) Update image data treatment

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
//		$dataProvider=new CActiveDataProvider('TreatmentScheduleDetails');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
		$model=new TreatmentScheduleDetails('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TreatmentScheduleDetails']))
			$model->attributes=$_GET['TreatmentScheduleDetails'];

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
		$model=new TreatmentScheduleDetails('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TreatmentScheduleDetails']))
			$model->attributes=$_GET['TreatmentScheduleDetails'];

		$this->render('admin',array(
			'model'=>$model,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TreatmentScheduleDetails the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TreatmentScheduleDetails::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TreatmentScheduleDetails $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='treatment-schedule-details-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
