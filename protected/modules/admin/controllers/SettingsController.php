<?php

class SettingsController extends AdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        
        /**
         * Settings array
         * @var Array 
         */
        public $aSettings = array(
            // Group General setting
            Settings::KEY_GENERAL_SETTINGS  => array(
                DomainConst::KEY_ALIAS      => DomainConst::CONTENT00160,
                DomainConst::KEY_CHILDREN   => array(
                    Settings::KEY_TITLE,
                    Settings::KEY_DOMAIN,
                    Settings::KEY_DOMAIN_SALE_WEBSITE,
                    Settings::KEY_LIST_PAGE_SIZE,
                    Settings::KEY_PASSWORD_LEN_MIN,
                    Settings::KEY_PASSWORD_LEN_MAX,
                    Settings::KEY_NUM_QRCODE_DOWNLOAD_MAX,
                    Settings::KEY_PRINT_RECEIPT_FONT_SIZE_RATE,
                    Settings::KEY_TOOTH_COLOR,
                    /** Test */
//                    Settings::KEY_APP_MOBILE_VERSION_IOS,
//                    Settings::KEY_ADMIN_EMAIL,
//                    Settings::KEY_EMAIL_MAIN_SUBJECT,
//                    Settings::KEY_EMAIL_TRANSPORT_TYPE,
//                    Settings::KEY_EMAIL_TRANSPORT_HOST,
//                    Settings::KEY_EMAIL_TRANSPORT_USERNAME,
//                    Settings::KEY_EMAIL_TRANSPORT_PASSWORD,
//                    Settings::KEY_EMAIL_TRANSPORT_PORT,
//                    Settings::KEY_EMAIL_TRANSPORT_ENCRYPTION,
                ),
            ),
            // Mail setting
            Settings::KEY_APP_SETTINGS     => array(
                DomainConst::KEY_ALIAS      => DomainConst::CONTENT00163,
                DomainConst::KEY_CHILDREN   => array(
                    Settings::KEY_APP_MOBILE_VERSION_IOS,
                    Settings::KEY_APP_API_LIST_PAGE_SIZE,
                    
                ),                
            ),
            // Mail setting
            Settings::KEY_MAIL_SETTINGS     => array(
                DomainConst::KEY_ALIAS      => DomainConst::CONTENT00161,
                DomainConst::KEY_CHILDREN   => array(
                    Settings::KEY_ADMIN_EMAIL,
                    Settings::KEY_EMAIL_MAIN_SUBJECT,
                    Settings::KEY_EMAIL_TRANSPORT_TYPE,
                    Settings::KEY_EMAIL_TRANSPORT_HOST,
                    Settings::KEY_EMAIL_TRANSPORT_USERNAME,
                    Settings::KEY_EMAIL_TRANSPORT_PASSWORD,
                    Settings::KEY_EMAIL_TRANSPORT_PORT,
                    Settings::KEY_EMAIL_TRANSPORT_ENCRYPTION,
                    
                ),                
            ),
            // SMS setting
            Settings::KEY_SMS_SETTINGS      => array(
                DomainConst::KEY_ALIAS      => DomainConst::CONTENT00261,
                DomainConst::KEY_CHILDREN   => array(
                    Settings::KEY_SMS_SERVER_URL,
                ),
            ),
            // TODO: Add more group here
        );

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
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($key = '')
	{
		$model=new Settings;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                $model->key = $key;

		if(isset($_POST['Settings']))
		{
			$model->attributes=$_POST['Settings'];
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

		if(isset($_POST['Settings']))
		{
			$model->attributes=$_POST['Settings'];
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $model=new Settings('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['Settings']))
                    $model->attributes=$_GET['Settings'];

            // Start handle save
            if (filter_input(INPUT_POST, 'submit')) {
                foreach (Settings::loadItems() as $key => $value) {
                    if (isset($_POST[$value->id])) {
                        Settings::updateSetting($value->id, $_POST[$value->id]);
                    }
                }
                Yii::app()->user->setFlash(DomainConst::KEY_SUCCESS_UPDATE, DomainConst::CONTENT00035);
                $this->refresh();
            }
            
            $this->render('index',array(
                    'model'=>$model,
                    'aSettings' => $this->aSettings,
                    DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
            ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Settings('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Settings']))
			$model->attributes=$_GET['Settings'];

		$this->render('admin',array(
			'model'=>$model,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Settings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Settings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Settings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='settings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
