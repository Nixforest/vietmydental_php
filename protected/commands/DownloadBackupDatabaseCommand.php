<?php

class DownloadBackupDatabaseCommand extends CConsoleCommand {
    const URL = 'http://vietmytest.immortal.vn/vietmy_sql/db/daily/'; 
    const OUT = '/var/www/vietmytest.immortal.vn/private/backup_sql/';

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
    
    /** @Author: HOANG NAM 29/06/2018
     *  @Todo: auto run download file backup
     **/
    public static function doRun() {
        $dateNow = date('Y-m-d');
        $aDb = DownloadBackupDatabaseCommand::getArrayDatabaseName();
        foreach ($aDb as $key => $nameDb) {
            $url = DownloadBackupDatabaseCommand::URL. $nameDb .'-'.$dateNow.'.tar.bz2';
            $outFileName = DownloadBackupDatabaseCommand::OUT . $nameDb .'-'.$dateNow.'.tar.bz2'; 
            //Thực hiện tải về máy
            if(is_file($url)) {
                copy($url, $outFileName); 
            } else {
                $options = array(
                  CURLOPT_FILE    => fopen($outFileName, 'w'),
                  CURLOPT_TIMEOUT =>  28800, // set this to 8 hours so we dont timeout on big files
                  CURLOPT_URL     => $url
                );
                $ch = curl_init();
                curl_setopt_array($ch, $options);
                curl_exec($ch);
                curl_close($ch);
            }
        }
    }
    
    /** @Author: HOANG NAM 29/06/2018
     *  @Todo: get array name of database
     **/
    public static function getArrayDatabaseName(){
        return array(
            1 => 'c2vietmytest',
        );
    }
}

