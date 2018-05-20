<?php

class UsersController extends AdminController
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
//				'actions'=>array('admin','delete', 'create'),
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
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
                        if($model->save()) {
                            if (filter_input(INPUT_POST, 'submit')) {
                                // Remove old record
                                OneMany::deleteAllManyOldRecords($model->id, OneMany::TYPE_AGENT_USER);
                                $selectedAgent = $_POST['Users']['agent'];
                                OneMany::insertOne($selectedAgent, $model->id, OneMany::TYPE_AGENT_USER);

                                // Handle save social network information
                                foreach (SocialNetworks::TYPE_NETWORKS as $key => $value) {
                                    $value = $_POST['Users']["social_network_$key"];
                                    if (!empty($value)) {
                                        SocialNetworks::insertOne($value, $model->id, SocialNetworks::TYPE_USER, $key);
                                    }
                                }
                            }
                            // Save image avatar
                            $this->saveImage($model);
                            Files::saveRecordFile($model, Files::TYPE_1_USER_AVATAR);
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                $model->agent = $model->getAgentId();
		if(isset($_POST['Users']))
		{
                    $currentImgAvatar = $model->getImageAvatarPath();
			$model->attributes=$_POST['Users'];
//                        Files::validateFile($model);
                        
                        if (!$model->hasErrors()) {
                            Files::deleteFileInUpdate($model);
                            if($model->save()) {                            
                                if (filter_input(INPUT_POST, 'submit')) {
                                    // Remove old record
                                    OneMany::deleteAllManyOldRecords($model->id, OneMany::TYPE_AGENT_USER);
                                    $selectedAgent = $_POST['Users']['agent'];
                                    OneMany::insertOne($selectedAgent, $model->id, OneMany::TYPE_AGENT_USER);

                                    // Handle save social network information
                                    SocialNetworks::deleteAllOldRecord($model->id, SocialNetworks::TYPE_USER);
                                    foreach (SocialNetworks::TYPE_NETWORKS as $key => $value) {
                                        $value = $_POST['Users']["social_network_$key"];
                                        if (!empty($value)) {
                                            SocialNetworks::insertOne($value, $model->id, SocialNetworks::TYPE_USER, $key);
                                        }
                                    }
                                }
                                // Save image avatar
                                $this->saveImage($model);
                                Files::saveRecordFile($model, Files::TYPE_1_USER_AVATAR);
                                $this->redirect(array('view','id'=>$model->id));
                            }
                        } else {
                            Loggers::info(CommonProcess::json_encode_unicode($model->getErrors()), __FUNCTION__, __LINE__);
                        }
			
		}

		$this->render('update',array(
			'model'=>$model,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}
        
        public function saveImage($model) {
            $imgAvatarPath = ImageHandler::saveImage($model, 'img_avatar', Users::UPLOAD_FOLDER);
            if (!empty($imgAvatarPath)) {
                $model->img_avatar = $imgAvatarPath;
                if ($model->save()) {
                    Loggers::info('Saved url', $imgAvatarPath, __LINE__);
                } else {
                    Loggers::info('Saved url failed', $imgAvatarPath, __LINE__);
                }
            }
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
//		$dataProvider=new CActiveDataProvider('Users');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
            $model=new Users('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['Users']))
                    $model->attributes=$_GET['Users'];

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
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
    /**
     * Handle change password
     * @throws CHttpException
     */
    public function actionChangePassword() {
        if (Yii::app()->user->id == '') {
            $this->redirect(array('login'));
        }
        $model = Users::model()->findByPk(Yii::app()->user->id);
        if ($model === null) {
            Yii::log('The requested page does not exist.');
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $model->scenario = 'changeMyPassword';
        if (isset($_POST['Users'])) {
            $model->currentpassword = $_POST['Users']['currentpassword'];
            $model->newpassword = $_POST['Users']['newpassword'];
            $model->password_confirm = $_POST['Users']['password_confirm'];
            if ($model->validate()) {
                $model->temp_password = CommonProcess::generateTempPassword();
                $model->password_hash = CommonProcess::hashPassword(
                                $model->newpassword, $model->temp_password);
                $aUpdate = array('password_hash', 'temp_password');
                if ($model->update($aUpdate)) {
                    Yii::app()->user->setFlash(DomainConst::KEY_SUCCESS_UPDATE, DomainConst::CONTENT00035);
                    $this->refresh();
                }
            }
        }

        $this->render('changePassword', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    /**
     * Handle reset password
     * @throws CHttpException
     */
    public function actionResetPassword($user_id) {
        $model = Users::model()->findByPk($user_id);
        if ($model === null) {
            Yii::log('The requested page does not exist.');
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $model->scenario = 'resetPassword';
        if (isset($_POST['Users'])) {
            $model->newpassword = $_POST['Users']['newpassword'];
            $model->password_confirm = $_POST['Users']['password_confirm'];
            if ($model->validate()) {
                $model->temp_password = CommonProcess::generateTempPassword();
                $model->password_hash = CommonProcess::hashPassword(
                                $model->newpassword, $model->temp_password);
                $aUpdate = array('password_hash', 'temp_password');
                if ($model->update($aUpdate)) {
                    Yii::app()->user->setFlash(DomainConst::KEY_SUCCESS_UPDATE, DomainConst::CONTENT00035);
                    $this->refresh();
                }
            }
        }

        $this->render('resetPassword', array(
            'model' => $model,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }
}
