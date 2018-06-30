<?php

/**
 * This is the model class for table "files".
 *
 * The followings are the available columns in table 'files':
 * @property string $id
 * @property integer $type
 * @property string $belong_id
 * @property string $file_name
 * @property integer $order_number
 * @property string $created_date
 */
class Files extends CActiveRecord
{
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const TYPE_1_USER_AVATAR                        = 1;
    const TYPE_2_TREATMENT_SCHEDULE_DETAIL_XRAY     = 2;
    const TYPE_3_TREATMENT_SCHEDULE_REAL_IMG        = 3;
    
    const ALLOW_IMAGE_FILE_TYPE         = 'jpg,jpeg,png';
    const ALLOW_DOCS_FILE_TYPE          = 'pdf,xls,xlsx,jpg,jpeg,png';
    const UPLOAD_PATH                   = 'upload/all_file';
    const MAX_UPLOAD                    = 50;
    const MAX_UPLOAD_SHOW               = 10;
    
    const KEY_FILE_NAME                 = 'file_name';
    const KEY_NAME                      = 'name';
    const KEY_SIZE                      = 'size';
    const KEY_TMP_NAME                  = 'tmp_name';
    const KEY_CLASS_NAME                = 'Files';
    const KEY_NORMAL_SIZE               = 'size1024x900';
    const KEY_SMALL_SIZE                = 'size128x96';
    
    const IMAGE_SIZES                   = array(
        'size128x96'    =>  array(          // Small size
            ImageHandler::WIDTH     => 128,
            ImageHandler::HEIGHT    => 96
        ),
        'size1024x900'  =>  array(          // Big size
            ImageHandler::WIDTH     => 1024,
            ImageHandler::HEIGHT    => 900
        ),
    );
    
    // Array type => Model's name
    public static $TYPE_ARRAY = array(
        self::TYPE_1_USER_AVATAR                        => 'Users',
        self::TYPE_2_TREATMENT_SCHEDULE_DETAIL_XRAY     => 'TreatmentScheduleDetails',
        self::TYPE_3_TREATMENT_SCHEDULE_REAL_IMG        => 'TreatmentScheduleDetails',
    );
    
    // Array of type need resize image before save
    public static $TYPE_RESIZE_IMAGE = array(
        self::TYPE_1_USER_AVATAR,
        self::TYPE_2_TREATMENT_SCHEDULE_DETAIL_XRAY,
        self::TYPE_3_TREATMENT_SCHEDULE_REAL_IMG
    );
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Files the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, order_number', 'numerical', 'integerOnly'=>true),
			array('id, belong_id', 'length', 'max'=>11),
			array('file_name, created_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, belong_id, file_name, order_number, created_date', 'safe', 'on'=>'search'),
                        array('file_name', 'file', 'on' => 'UploadFile',
                                'allowEmpty' => true,
                                'types' => self::ALLOW_IMAGE_FILE_TYPE,
                                'wrongType' => "Chỉ cho phép định dạng file " .  self::ALLOW_IMAGE_FILE_TYPE . " .",
                                'maxSize'   => CommonProcess::getMaxFileSize(),
                                'minSize'   => CommonProcess::getMinFileSize(),
                                'tooLarge'  => 'The file was larger than '.(CommonProcess::getMaxFileSize()/1024).' KB. Please upload a smaller file.',
                                'tooSmall'  => 'The file was smaller than '.(CommonProcess::getMinFileSize()/1024).' KB. Please upload a bigger file.',                    
                        ),
                        array('file_name', 'file', 'on' => 'UploadFilePdf',
                            'allowEmpty' => true,
                            'types'=> self::ALLOW_DOCS_FILE_TYPE,
                            'wrongType' => "Chỉ cho phép tải file " . self::ALLOW_DOCS_FILE_TYPE,
                            'maxSize'   => CommonProcess::getMaxFileSize(), // 5MB
                            'tooLarge'  => 'File quá lớn, cho phép '.(CommonProcess::getMaxFileSize()/1024).' KB. Vui lòng up file nhỏ hơn.',
                        ),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'belong_id' => 'Belong',
			'file_name' => 'File Name',
			'order_number' => 'Order Number',
			'created_date' => 'Created Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('belong_id',$this->belong_id,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('order_number',$this->order_number);
		$criteria->compare('created_date',$this->created_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => Settings::getListPageSize(),
                        ),
		));
	}
        
    //-----------------------------------------------------
    // Parent override methods
    //-----------------------------------------------------
    /**
     * Override before delete method
     * @return type Parent value
     */
    protected function beforeDelete() {
        self::removeFileOnly($this, self::KEY_FILE_NAME);
        Loggers::info("Deleted " . get_class($this) . " with id = $this->id.", __FUNCTION__, __LINE__);
        return parent::beforeDelete();
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Get download link
     * @return String
     */
    public function getForceLinkDownload() {
        $link = Yii::app()->createAbsoluteUrl('admin/ajax/forceDownload', array(
            'id'    => $this->id,
            'model' => 'Files',
        ));
        
        return "<a target='_blank' href='$link'>$this->file_name</a>";
    }
    
    /**
     * Get source force download
     * @return String
     */
    public function getSrcForceDownload() {
        $year = DateTimeExt::getYearByDate($this->created_date);
        $month = DateTimeExt::getYearByDate($this->created_date, array('format' => 'm'));
        return self::UPLOAD_PATH . "/$year/$month/$this->file_name";
    }
    
    /**
     * Get view image
     * @return string Image view
     */
    public function getViewImage($width = 80, $height = 60) {
        if (empty($this->file_name) && !in_array($this->type, self::$TYPE_RESIZE_IMAGE)) {
            return '';
        }
        $str = "<a class='gallery' target='_blank' href='" . ImageHandler::bindImageByModel($this, '', '',
                array('size' => self::KEY_NORMAL_SIZE)) . "'>"
                . "<img width='" . $width . "' height='" . $height . "' src='" . ImageHandler::bindImageByModel($this, '', '',
                        array('size' => self::KEY_SMALL_SIZE)) . "'>"
                . "</a>";
        return $str;
    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Validate file
     * @param type $mBelongTo
     * @param type $needMore
     */
    public static function validateFile($mBelongTo, $needMore = array()) {
        $className = get_class($mBelongTo);
        if (isset($_POST[$className][self::KEY_FILE_NAME]) && count($_POST[$className][self::KEY_FILE_NAME])) {
            foreach ($_POST[$className][self::KEY_FILE_NAME] as $key => $item) {
                $mFile = new Files('UploadFile');
                $mFile->file_name = CUploadedFile::getInstance($mBelongTo, self::KEY_FILE_NAME . '[' . $key . ']');
                if ($mFile->file_name !== NULL) {
                    $mFile->validate();
                }
                
                if (!is_null($mFile->file_name) && !$mFile->hasErrors()) {
                    ImageHandler::isImageFile($_FILES[$className]['tmp_name'][self::KEY_FILE_NAME][$key]);
                    $fileName = CommonProcess::removeSign($mFile->file_name->getName());
                    if (strlen($fileName) > 100) {
                        $mFile->addError(self::KEY_FILE_NAME, DomainConst::CONTENT00250);
                    }
                }

                if ($mFile->hasErrors()) {
                    $mBelongTo->addError(self::KEY_FILE_NAME, $mFile->getError(self::KEY_FILE_NAME));
                }
            }
        }
    }
    
    /**
     * Save record file
     * @param type $mBelongTo
     * @param type $type
     */
    public static function saveRecordFile($mBelongTo, $type) {
        $className = get_class($mBelongTo);
        $mBelongTo = BaseActiveRecord::loadModelByClass($mBelongTo->id, $className, 'admin');
        Loggers::info($className, __FUNCTION__, __CLASS__);
        set_time_limit(7200);
        if (isset($_POST[$className][self::KEY_FILE_NAME]) && count($_POST[$className][self::KEY_FILE_NAME])) {
            Loggers::info('isset($_POST[$className][self::KEY_FILE_NAME])', __FUNCTION__, __CLASS__);
            foreach ($_POST[$className][self::KEY_FILE_NAME] as $key => $item) {
                $mFile = new Files();
                $mFile->type = $type;
                $mFile->belong_id = $mBelongTo->id;
                $created_date = explode(' ', $mBelongTo->created_date);
                $mFile->created_date = $created_date[0];
                $mFile->order_number = $key + 1;
                $mFile->file_name = CUploadedFile::getInstance($mBelongTo, self::KEY_FILE_NAME . '[' . $key . ']');
                Loggers::info($mFile->file_name, __FUNCTION__, __CLASS__);
                if (!is_null($mFile->file_name)) {
                    Loggers::info('!is_null($mFile->file_name', __FUNCTION__, __CLASS__);
                    $mFile->file_name = self::saveFile($mFile, 'file_name', $key);
                    if ($mFile->save()) {
                        Loggers::info('$mFile->save success', __FUNCTION__, __LINE__);
                        if (in_array($type, self::$TYPE_RESIZE_IMAGE)) {
                            self::resizeImage($mFile, 'file_name');
                        }
                    } else {
                        Loggers::info(CommonProcess::json_encode_unicode($mFile->getErrors()), __FUNCTION__, __LINE__);
                    }
                }
            }
        }
    }
    
    /**
     * Save file
     * @param type $model
     * @param type $fieldName
     * @param type $count
     * @return string Name of image
     */
    public static function saveFile($model, $fieldName, $count) {
        if (is_null($model->$fieldName)) {
            return '';
        }
        $year = DateTimeExt::getYearByDate($model->created_date);
        $month = DateTimeExt::getYearByDate($model->created_date, array('format' => 'm'));
        $pathUpload = self::UPLOAD_PATH . "/$year/$month";
        $ext = strtolower($model->$fieldName->getExtensionName());
//        if (in_array($model->type, $model->getTypeNotSlugName())) {
//            $fileName = time();
//            $fileName .=  "-" . CommonProcess::randString() . $count . '.' . $ext;
//        } else {
            $fileNameClient = strtolower(CommonProcess::removeSign($model->$fieldName->getName()));
            $fileNameClient = str_replace($ext, "", $fileNameClient);
            $fileName = time() . "$count-" . CommonProcess::slugify($fileNameClient) . '.' . $ext;
//        }
        DirectoryHandler::createDirectoryByPath($pathUpload);
        Loggers::info($pathUpload. DIRECTORY_SEPARATOR . $fileName, __FUNCTION__, __LINE__);
        if ($model->$fieldName->saveAs($pathUpload. DIRECTORY_SEPARATOR . $fileName)) {
            Loggers::info("Save image success", __FUNCTION__, __LINE__);
            return $fileName;
        } else {
            Loggers::info("Save image failed", __FUNCTION__, __LINE__);
        }
        return '';
    }
    
    /**
     * Resize image
     * @param type $model
     * @param type $fieldName
     */
    public static function resizeImage($model, $fieldName) {
        $year = DateTimeExt::getYearByDate($model->created_date);
        $month = DateTimeExt::getYearByDate($model->created_date, array('format' => 'm'));
        $pathUpload = self::UPLOAD_PATH . "/$year/$month";
        $imageHandler = new ImageHandler();
        $imageHandler->folder = $pathUpload;
//        $imageHandler->folder = DIRECTORY_SEPARATOR . $pathUpload;
        $imageHandler->file = $model->$fieldName;
        $imageHandler->aRGB = array(0, 0, 0);   // Full black background
        $imageHandler->thumbs = self::IMAGE_SIZES;
        Loggers::info("Try create thumb: " . $imageHandler->folder, __FUNCTION__, __LINE__);
        $imageHandler->createThumbs();
        Loggers::info("Delete file: " . $imageHandler->folder . DIRECTORY_SEPARATOR . $model->$fieldName, __FUNCTION__, __LINE__);
        DirectoryHandler::deleteFile($imageHandler->folder . DIRECTORY_SEPARATOR . $model->$fieldName);
    }
    
    /**
     * Delete file
     * @param type $modelRemove
     * @param type $fieldName
     */
    public static function removeFileOnly($modelRemove, $fieldName) {
        $aDate = explode('-', $modelRemove->created_date);
        $pathUpload = self::UPLOAD_PATH . "/$aDate[0]/$aDate[1]";
        $imageHandler = new ImageHandler();
//        $imageHandler->folder = DIRECTORY_SEPARATOR . $pathUpload;
        $imageHandler->folder = $pathUpload;
        Loggers::info($imageHandler->folder . DIRECTORY_SEPARATOR . $modelRemove->$fieldName, __FUNCTION__, __LINE__);
        DirectoryHandler::deleteFile($imageHandler->folder . DIRECTORY_SEPARATOR . $modelRemove->$fieldName);
        foreach (self::IMAGE_SIZES as $key => $value) {
            DirectoryHandler::deleteFile($imageHandler->folder . DIRECTORY_SEPARATOR . $key . DIRECTORY_SEPARATOR . $modelRemove->$fieldName);
        }
    }
    
    /**
     * Delete by belong id and type
     * @param type $belongId
     * @param type $type
     */
    public static function deleteByBelongIdAndType($belongId, $type) {
        $criteria = new CDbCriteria();
        $criteria->compare('t.belong_id', $belongId);
        $criteria->compare('t.type', $type);
        $models = self::model()->findAll($criteria);
        foreach ($models as $value) {
            $value->delete();
        }
    }
    
    /**
     * Validate file by api
     * @param type $mBelongTo
     * @param type $fieldName
     * @param type $needMore
     */
    public static function apiValidateFile($mBelongTo, $fieldName, $needMore = array()) {
        if (isset($_FILES[$fieldName][self::KEY_NAME]) && count($_FILES[$fieldName][self::KEY_NAME])) {
            foreach ($_FILES[$fieldName][self::KEY_NAME] as $key => $item) {
                $mFile = new Files('UploadFile');
                $mFile->file_name = CUploadedFile::getInstanceByName("{$fieldName}[$key]");
                $mFile->validate();
                if (!is_null($mFile->file_name) && $mFile->hasErrors()) {
                    ImageHandler::isImageFile($_FILES[$fieldName][self::KEY_TMP_NAME][$key]);
                    $fileName = CommonProcess::removeSign($mFile->file_name->getName());
                    if (strlen($fileName) > 100) {
                        $mFile->addError(self::KEY_FILE_NAME, "Tên file không được quá 100 ký tự, vui lòng đặt tên ngắn hơn");
                    }
                }
                if ($mFile->hasErrors()) {
                    $mBelongTo->addError(self::KEY_FILE_NAME, $mFile->getError(self::KEY_FILE_NAME));
                }
            }
        }
    }
    
    /**
     * Save record file by api
     * @param type $mBelongTo
     * @param type $type
     */
    public static function apiSaveRecordFile($mBelongTo, $type) {
        $className = get_class($mBelongTo);
        $mBelongTo = BaseActiveRecord::loadModelByClass($mBelongTo->id, $className, 'admin');
        set_time_limit(7200);
        if (isset($_FILES[self::KEY_FILE_NAME][self::KEY_NAME]) && count($_FILES[self::KEY_FILE_NAME][self::KEY_NAME])) {
            foreach ($_FILES[self::KEY_FILE_NAME][self::KEY_NAME] as $key => $item) {
                $mFile = new Files();
                $mFile->type = $type;
                $mFile->belong_id = $mBelongTo->id;
                $created_date = explode(' ', $mBelongTo->created_date);
                $mFile->created_date = $created_date[0];
                $mFile->order_number = $key + 1;
                $mFile->file_name = CUploadedFile::getInstanceByName(self::KEY_FILE_NAME . "[$key]");
                if (!is_null($mFile->file_name)) {
                    $mFile->file_name = self::saveFile($mFile, self::KEY_FILE_NAME, $key);
                    $mFile->save();
                    if (in_array($type, self::$TYPE_RESIZE_IMAGE)) {
                        self::resizeImage($mFile, self::KEY_FILE_NAME);
                    }
                }
            }
        }
    }
    
    /**
     * Get array model file
     * @param type $mBelongTo
     * @param type $type
     * @return Array
     */
    public static function getAllFiles($mBelongTo, $type) {
        if (empty($mBelongTo->id)) {
            return array();
        }
        $criteria = new CDbCriteria;
        $criteria->compare('t.belong_id', $mBelongTo->id);
        $criteria->compare('t.type', $type);
        $criteria->order = 't.id';
        return self::model()->findAll($criteria);
    }
    
    /**
     * Delete file in update action
     * @param type $mBelongTo
     */
    public static function deleteFileInUpdate($mBelongTo) {
        Loggers::info(isset($_POST['delete_file']) . "", __FUNCTION__, __LINE__);
//        Loggers::info(CommonProcess::json_encode_unicode($_POST['delete_file']), __FUNCTION__, __LINE__);
        if (isset($_POST['delete_file']) && is_array($_POST['delete_file']) && count($_POST['delete_file'])) {
            Loggers::info('Start delete file', __FUNCTION__, __LINE__);
            $criteria = new CDbCriteria;
            $criteria->compare('t.belong_id', $mBelongTo->id);
            $sParamsIn = implode(',', $_POST['delete_file']);
            Loggers::info($sParamsIn, __FUNCTION__, __LINE__);
            $criteria->addCondition("t.id IN ($sParamsIn)");
            $models = self::model()->findAll($criteria);
            foreach ($models as $model) {
                $model->delete();
            }
        }
    }
    
    /**
     * Delete file in update action (with not in array param)
     * @param type $mBelongTo
     */
    public static function deleteFileInUpdateNotIn($mBelongTo, $type = '') {
        Loggers::info(isset($_POST['delete_file']) . "", __FUNCTION__, __LINE__);
//        Loggers::info(CommonProcess::json_encode_unicode($_POST['delete_file']), __FUNCTION__, __LINE__);
        if (isset($_POST['delete_file']) && is_array($_POST['delete_file']) && count($_POST['delete_file'])) {
            Loggers::info('Start delete file', __FUNCTION__, __LINE__);
            $criteria = new CDbCriteria;
            $criteria->compare('t.belong_id', $mBelongTo->id);
            $sParamsIn = implode(',', $_POST['delete_file']);
            Loggers::info($sParamsIn, __FUNCTION__, __LINE__);
            $criteria->addCondition("t.id NOT IN ($sParamsIn)");
            if (!empty($type)) {
                $criteria->compare('t.type', $type);
            }
            $models = self::model()->findAll($criteria);
            foreach ($models as $model) {
                $model->delete();
            }
        }
    }
    
    /**
     * Get file upload  by api
     * @param type $aModel
     * @return type
     */
    public static function apiGetFileUpload($aModel) {
        $retVal = [];
        foreach ($aModel as $mFile) {
            $tmp = array();
            $tmp['id'] = $mFile->id;
            $tmp['thumb'] = ImageHandler::bindImageByModel($mFile, '', '', array('size' => self::KEY_SMALL_SIZE));
            $tmp['large'] = ImageHandler::bindImageByModel($mFile, '', '', array('size' => self::KEY_NORMAL_SIZE));
            $retVal[] = $tmp;
        }
        return $retVal;
    }
}