<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DirectoryHandler
 *
 * @author nguyenpt
 */
class DirectoryHandler {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Webroot path */
    const WEB_ROOT_PATH                     = 'webroot';
    /** Folder splitter */
    const FOLDER_SPLITTER                   = DIRECTORY_SEPARATOR;
    
    //-----------------------------------------------------
    // Methods
    //-----------------------------------------------------
    /**
     * Get path of root directory
     * @return String
     */
    public static function getRootPath() {
        return Yii::getPathOfAlias(self::WEB_ROOT_PATH);
    }
    
    /**
     * Create directory by path
     * @param String $path Path
     */
    public static function createDirectoryByPath($path) {
        $aFolder = explode(self::FOLDER_SPLITTER, $path);
        if (is_array($aFolder)) {
            CommonProcess::removeEmptyItemFromArray($aFolder);
            $root = self::getRootPath();
            $currentPath = $root;
            foreach ($aFolder as $folder) {
                $currentPath .= self::FOLDER_SPLITTER . $folder;
                if (!is_dir($currentPath)) {
                    mkdir($currentPath);
                }
            }
        }
    }
    
    /**
     * Create single directory by path
     * @param String $path Path
     * @return bool True on success or false on failure.
     */
    public static function createSingleDirectoryByPath($path) {
        $path = self::getRootPath() . $path;
        if (!is_dir($path)) {
            return mkdir($path);
        }
        return true;
    }
    
    /**
     * Delete image file
     * @param String $source Path of file
     * @return bool True on success or false on failure.
     */
    public static function deleteFile($source) {
        $path = DirectoryHandler::getRootPath() . DIRECTORY_SEPARATOR . $source;
        Loggers::info($path, __FUNCTION__, __LINE__);
        if (file_exists($path)) {
            return unlink($path);
        }
        return false;
    }
    
    /**
     * Create path from array
     * @param Array $arrayPath Array of paths
     * @return String Path string
     */
    public static function createPath($arrayPath) {
        return implode(DIRECTORY_SEPARATOR, $arrayPath);
    }
}
