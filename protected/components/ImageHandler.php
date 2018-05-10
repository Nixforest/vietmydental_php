<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageHandler
 *
 * @author nguyenpt
 */
class ImageHandler {
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $folder = 'upload';
    public $file = '';
    public $thumbs = array();
    public $createFullImage = false;        // True if you need to create full size image after resize
    public $aRGB = array(255, 255, 255);    // Full image background
    
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Width */
    const WIDTH                         = 'width';
    /** Height */
    const HEIGHT                        = 'height';
    /** No image folder */
    const NO_IMAGE_PATH                 = '/upload/noimage/';
    /** No image name */
    const NO_IMAGE_NAME                 = 'noimage-all.jpg';
    /** Default font fiel */
    const DEFAULT_FONT_FILE             = 'ARLRDBD.TTF';
    /** Image extension: JPG */
    const IMG_EXT_JPG                   = '.jpg';
    /** Image extension: GIF */
    const IMG_EXT_GIF                   = '.gif';
    /** Image extension: PNG */
    const IMG_EXT_PNG                   = '.png';
    /** Size splitter: [x] */
    const SIZE_SPLITTER                 = 'x';
    
    //-----------------------------------------------------
    // Methods
    //-----------------------------------------------------
    /**
     * Create thumb images to specific folders from exist image
     * @example
     * $ImageHandler = new ImageHandler();
     * $ImageHandler->folder = '/upload/admin/artist';         
     * $ImageHandler->file = 'photo.jpg';
     * $ImageHandler->thumbs = array('thumb1' => array('width'=>'1336','height'=>'768'),
     *                                  'thumb2' =>  array('width'=>'800','height'=>'600'));
     * $ImageHandler->create_thumbs();
     */
    public function createThumbs() {
        if (count($this->thumbs) > 0) {
            // Get root path
            $rootPath = DirectoryHandler::getRootPath()
                    . $this->folder . DIRECTORY_SEPARATOR;
            // Get file path
            $pathFile = $rootPath . $this->file;
            Loggers::info($pathFile, __FUNCTION__, __LINE__);
            // Check path is not exist or file is empty
            if (!file_exists($pathFile) || empty($this->file)) {
                return false;
            }
            DirectoryHandler::createDirectoryByPath($this->folder);
            // Loop for all thumbs
            foreach ($this->thumbs as $folderThumb => $size) {
                // Temp path
                $tempPath = $this->folder . DIRECTORY_SEPARATOR . $folderThumb;
                if (DirectoryHandler::createSingleDirectoryByPath($tempPath)) {
                    // Get size
                    $width = $size[self::WIDTH];
                    $height = $size[self::HEIGHT];
                    // Create thumb image
                    $thumb = new EPhpThumb($this->folder);
                    $thumb->init();
                    $thumPath = $rootPath . $folderThumb . DIRECTORY_SEPARATOR . $this->file;
                    if ($thumb->create($pathFile)
                            ->resize($width, $height)
                            ->save($thumPath)) {
                        Loggers::info('Create thumb success', __FUNCTION__, __LINE__);
                    } else {
                        Loggers::info('Create thumb failed', __FUNCTION__, __LINE__);
                    }
                    self::createNoImage($width, $height);
                    // Create full image
                    if ($this->createFullImage) {
                        self::createFullImage($tempPath, $this->file, $width, $height, NULL, $this->aRGB);
                    }
                }
            }
        }
    }
    
    /**
     * Resize and crop
     * @param type $fileName
     * @example
     * $ImageHandler = new ImageHandler();
     * $ImageHandler->folder = '/upload/admin/artist';         
     * $ImageHandler->file = 'photo.jpg';
     * $ImageHandler->thumbs = array('width'=>'1336','height'=>'768');
     * $ImageHandler->resizeAndCrop('fileNameOfDestinationImage');
     */
    public function resizeAndCrop($fileName) {
        $thumb = new EPhpThumb();
        $thumb->init();
        $rootPath = DirectoryHandler::getRootPath()
                . $this->folder . DIRECTORY_SEPARATOR;
        $thumb->create($rootPath . $this->file)
                ->adaptiveResize($this->thumbs[self::WIDTH], $this->thumbs[self::HEIGHT])
                ->save($rootPath . $fileName);
    }
    
    //-----------------------------------------------------
    // Static Methods
    //-----------------------------------------------------
    /**
     * Create no image
     * @param Int $width
     * @param Int $height
     * @param Array $aBkgRGB
     * @param Array $aTextRGB
     * @return boolean True if create success, false otherwise.
     */
    public static function createNoImage($width, $height, $aBkgRGB = array(255, 255, 255), $aTextRGB = array(0, 0, 0)) {
        DirectoryHandler::createDirectoryByPath(self::NO_IMAGE_PATH);
        $rootPath = DirectoryHandler::getRootPath();
        $noImagePath = DirectoryHandler::createPath(array(
            $rootPath,
            self::NO_IMAGE_PATH . $width . self::SIZE_SPLITTER . $height . self::IMG_EXT_JPG
        ));
        if (!file_exists($noImagePath)) {
            $fontPath = $rootPath . self::NO_IMAGE_PATH . self::DEFAULT_FONT_FILE;
            if (!file_exists($fontPath)) {
                echo 'Need font file' . $fontPath;
                exit;
            }
            $bgImage = imagecreatetruecolor($width, $height);
            $bgColor = imagecolorallocate($bgImage, $aBkgRGB[0], $aBkgRGB[1], $aBkgRGB[2]);
            $textColor = imagecolorallocate($bgImage, $aTextRGB[0], $aTextRGB[1], $aTextRGB[2]);
            $grey = imagecolorallocate($bgImage, 128, 128, 128);
            imagefilledrectangle($bgImage, 0, 0, $width, $height, $bgColor);
            
            $text = "NO IMAGE";
            $fontSize = 6;  // Font size is in pixels
            // Retrieve bounding box;
            $area = imagettfbbox($fontSize, 0, $fontPath, $text);
            $textWidth = $area[2] - $area[0] + 2;
            $textHeight = $area[1] - $area[7] + 2;
            
            while ($width / $textWidth > 1.5) {
                $fontSize++;
                // Retrieve bounding box;
                $area = imagettfbbox($fontSize, 0, $fontPath, $text);
                $textWidth = $area[2] - $area[0] + 2;
                $textHeight = $area[1] - $area[7] + 2;
            }
            // Add some shadow to the text
            imagettftext($bgImage, $fontSize, 0, ($width-$textWidth)/2 , ($height-$textHeight)/2 + $textHeight/2 , $grey, $fontPath, $text);

            // Add the text
            imagettftext($bgImage, $fontSize, 0, ($width-$textWidth)/2, ($height-$textHeight)/2 + $textHeight/2, $textColor, $fontPath, $text);

            imagejpeg($bgImage, $noImagePath, 100); 
            
            // Destroy memory handlers
            imagedestroy($bgImage);
            return true;
        }
        return false;
    }
    
    /**
     * Useful in case of full image for SLIDING EFFECT in jquery
     * @param String $sourceFolder 'upload/source'
     * @param String $sourceFile 'source.jpg'
     * @param type $finalWidth
     * @param type $finalHeight
     * @param type $destFolder 'upload/source/full'. If NULL => file "source.jpg" will be override
     * @param type $aRGB
     * @return boolean|string
     */
    public static function createFullImage($sourceFolder, $sourceFile,
            $finalWidth, $finalHeight, $destFolder = null,
            $aRGB = array(255, 255, 255)) {
        $rootPath = DirectoryHandler::getRootPath();
        $watermarkFile = DirectoryHandler::createPath(array(
            $rootPath, $sourceFolder, $sourceFile
        ));
        if ($destFolder == NULL) {
            $destFolder = $sourceFolder;
        }
        
        $finalExtension = self::IMG_EXT_JPG;
        if (!file_exists($watermarkFile)) {
            return false;
        }
        list($sourceWidth, $sourceHeight, $sourceType) = getimagesize($watermarkFile);
        if ($sourceType == NULL) {
            return false;
        }
        switch ($sourceType) {
            case '1':
                $watermark = imagecreatefromgif($watermarkFile);
                $finalExtension = self::IMG_EXT_GIF;
                break;
            case '2':
                $watermark = imagecreatefromjpeg($watermarkFile);
                $finalExtension = self::IMG_EXT_JPG;
                break;
            case '3':
                $watermark = imagecreatefrompng($watermarkFile);
                $finalExtension = self::IMG_EXT_PNG;
                break;
            default:
                return false;
        }
        
        $bgImage = @imagecreatetruecolor($finalWidth, $finalHeight);
        $bgColor = imagecolorallocate($bgImage, $aRGB[0], $aRGB[1], $aRGB[2]);
        imagefilledrectangle($bgImage, 0, 0, $finalWidth, $finalHeight, $bgColor);
        $imageWidth = imagesx($bgImage);
        $imageHeight = imagesy($bgImage);
        $watermarkWidth = $sourceWidth;
        $watermarkHeight = $sourceHeight;
        
        $coordinateX = ($imageWidth - $watermarkWidth) / 2;
        $coordinateY = ($imageHeight - $watermarkHeight) / 2;
        // Merge the wattermark onto base image
        imagecopymerge($bgImage, $watermark, $coordinateX, $coordinateY, 0, 0, $watermarkWidth, $watermarkHeight, 100);
        
        // Save to new location as jpg file
        $filename = pathinfo($watermarkFile, PATHINFO_FILENAME);
        $finalName = $filename . '.' . $finalExtension;
        
        imagejpeg($bgImage, DirectoryHandler::createPath(array(
                    $rootPath, $destFolder, $finalName
                )), 100);

        // Destrou memory handlers
        imagedestroy($bgImage);
        imagedestroy($watermark);
        
        // Return new file name
        return $finalName;
    }
    
    /**
     * Get noimage path
     * @param Int $width Width
     * @param Int $height Height
     * @return String Path of noimage
     */
    public static function getNoImagePath($width, $height) {
        if ($width && $height) {
            return self::NO_IMAGE_PATH . $width . self::SIZE_SPLITTER . $height . self::IMG_EXT_JPG; 
        } else {
            return self::NO_IMAGE_PATH . self::NO_IMAGE_NAME;
        }
    }
    
    /**
     * Return absolute url by relative path. If no image exist. It will return noimage url
     * Require an exist noimage in format:   "upload/noimage/200x300.jpg"
     * @param String $path relative path "upload/noimage/200x300.jpg"
     * @param type $width
     * @param type $height
     * @return string
     */
    public static function getImageUrl($path, $width = NULL, $height = NULL) {
        // Base url
        $baseUrl = Yii::app()->baseUrl;
        // Absolute url
        $absoluteUrl = $baseUrl . DIRECTORY_SEPARATOR . $path;
        
        // Path of no image
        $noimagePath = self::getNoImagePath($width, $height);
        // Root path
        $rootPath = DirectoryHandler::getRootPath() . DIRECTORY_SEPARATOR;
        
        if (!file_exists($rootPath . $path)             // Check file at root path is not exist
                || (strpos($path, '.') === false)) {    // OR path have not containt '.' character
            if (!file_exists($rootPath . $noimagePath)) {   // Check if no-image file at root path is not exist
                // Return default no-image file url
                return $baseUrl . self::NO_IMAGE_PATH . self::NO_IMAGE_NAME;
            } else {
                return $baseUrl . DIRECTORY_SEPARATOR . $noimagePath;
            }
        } else {
            // File exist
            return $absoluteUrl;
        }
    }

    /**
     * Bind image by phpthumb for unavailable size of no image for other case
     * Require an exist noimage in format:   "/upload/noimage/200x300.jpg"
     * @param string $path relative path "/upload/noimage/200x300.jpg"
     * @param Int $width Width of image
     * @param Int $height Height of image
     * @return String Return absolute url by relative path. If no image exist. It will return noimage url
     */
    public static function bindImage($path, $width, $height) {
        $baseUrl = CommonProcess::getHostUrl();
        Loggers::info($baseUrl, __FUNCTION__, __LINE__);
        $noImagePath = self::NO_IMAGE_PATH . $width . self::SIZE_SPLITTER . $height . self::IMG_EXT_JPG;
        $rootPath = DirectoryHandler::getRootPath();
        
        Loggers::info($rootPath . $path, __FUNCTION__, __LINE__);
        if (!file_exists($rootPath . $path)) {
            
            Loggers::info("file_exists no exist", __FUNCTION__, __LINE__);
            if (!file_exists($rootPath . $noImagePath)) {
                return Yii::app()->createAbsoluteUrl(DIRECTORY_SEPARATOR)
                        . self::NO_IMAGE_PATH . self::NO_IMAGE_NAME;
            } else {
                return Yii::app()->baseUrl . $noImagePath;
            }
        }
        Loggers::info($baseUrl . $path, __FUNCTION__, __LINE__);
        return $baseUrl . $path;
    }
    
    /**
     * Return href of image by model
     * @param type $model
     * @param type $width
     * @param type $height
     * @param type $customField
     * @return type
     */
    public static function bindImageByModel($model, $width = null, $height = null, $customField = array()) {
        $className = get_class($model);
        if ($className == 'Files' && !empty($model->file_name) && !empty($model->created_date)) {
            Loggers::info('$className == Files', __FUNCTION__, __LINE__);
            $aDate = explode('-', $model->created_date);
            $pathUpload = Files::UPLOAD_PATH . "/$aDate[0]/$aDate[1]";
            Loggers::info($pathUpload, __FUNCTION__, __LINE__);
            $path = DIRECTORY_SEPARATOR . $pathUpload . '/size128x96' . DIRECTORY_SEPARATOR . $model->file_name;
            if (isset($customField['size'])) {
                $path = DIRECTORY_SEPARATOR . $pathUpload . DIRECTORY_SEPARATOR . $customField['size'] . DIRECTORY_SEPARATOR . $model->file_name;
            }
            return self::bindImage($path, $width, $height);
        } else {
            $path = '/upload/settings/noimage';
            return self::bindImage($path, $width, $height);
        }
    }
    
    /**
     * Check if file is image file
     * @param String $filename
     * @return boolean True if file is jpg or png file, false otherwise
     * @throws Exception
     */
    public static function isImageFile($filename) {
        if (file_exists($filename)) {
            $imgSize = getimagesize($filename);
            if ($imgSize === FALSE) {
                // Not image
                throw new Exception(DomainConst::CONTENT00249 . '1');
            } else {
                // http://stackoverflow.com/questions/1141227/php-checking-if-the-images-is-jpg
                // http://us2.php.net/manual/en/function.exif-imagetype.php
                $imgType = exif_imagetype($filename);
                if ($imgType != IMAGETYPE_JPEG && $imgType != IMAGETYPE_PNG) {
                    throw new Exception(DomainConst::CONTENT00249 . '3');
                }
                return true;
            }
        } else {
            throw new Exception(inConst::CONTENT00249 . '2');
        }
    }
    
    /**
     * Save image when upload image for model
     * @param Model $model Model object
     * @param String $fieldName Field name
     * @param String $path Path to save image
     * @return String Image name after save success
     */
    public static function saveImage($model, $fieldName, $path) {
        $imgUploaded = CUploadedFile::getInstance($model, $fieldName);
        $fileName = "$fieldName" . "_" . $model->id . ".png";
        DirectoryHandler::createDirectoryByPath($path);
        if ($imgUploaded !== NULL) {
            if (ImageHandler::getImageUrl($path)) {
                
            }
            $imgUploaded->saveAs($path . DIRECTORY_SEPARATOR . $fileName);
            return $fileName;
        }
        
        return '';
    }
}
