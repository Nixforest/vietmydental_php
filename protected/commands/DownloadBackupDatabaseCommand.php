<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DownloadBackupDatabaseCommand
 *
 * @author nguyenpt
 */
class DownloadBackupDatabaseCommand extends CConsoleCommand {
    const URL = 'http://localhost/vietmy_sql/db/daily';
    const OUT = '/var/www/localhost/private/backup_sql';
    
    /**
     * Run command
     * @param type $arg
     */
    public function run($arg) {
        try {
            DownloadBackupDatabaseCommand::doRun();
        } catch (Exception $ex) {
            CommonProcess::dumpVariable($ex->getMessage());
        }
    }
    
    /**
     * Run command.
     */
    public static function doRun() {
        Loggers::info(__METHOD__, __LINE__, get_class());
        $dateNow = date(DomainConst::DATE_FORMAT_4);
        $aDb = self::getArrayDatabaseName();
        foreach ($aDb as $key => $dbName) {
            $fileName = $dbName . DomainConst::SPLITTER_TYPE_3 . $dateNow . '.tar.bz2';
            $url = self::URL . $fileName;
            $outFileName = self::OUT . $fileName;
            // Start download
            if (is_file($url)) {
                copy($url, $outFileName);
            } else {
                $options = array(
                    CURLOPT_FILE    => fopen($outFileName, 'w'),
                    CURLOPT_TIMEOUT => 28800,   // Set this to 8 hours so we dont timeout on big files
                    CURLOPT_URL     => $url,
                );
                $ch = curl_init();
                curl_setopt_array($ch, $options);
                curl_exec($ch);
                curl_close($ch);
            }
        }
    }
    
    /**
     * Get list 
     * @return type
     */
    public static function getArrayDatabaseName() {
        return array(
            1   => DATABASE_NAME,
        );
    }
}
