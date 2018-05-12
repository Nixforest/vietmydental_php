<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExcelHandler
 *
 * @author nguyenpt
 */
class ExcelHandler {
    private $creator            = 'nkvietmy.com';
    private $lastModifiedBy     = 'nkvietmy.com';
    private $category           = 'Dental';
    private $keyword            = 'office 2007 openxml php';
    private $font               = 'Calibri';
    private $writerType         = 'Excel2007';
//    public static function createExcelFile($title, $subject, $description, $sheetName, $fileName, $data) {
//        try {
//            // get a reference to the path of PHPExcel classes	
////            $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
////
////            // Turn off our amazing library autoload 
////             spl_autoload_unregister(array('YiiBase','autoload'));        
////
////            //
////            // making use of our reference, include the main class
////            // when we do this, phpExcel has its own autoload registration
////            // procedure (PHPExcel_Autoloader::Register();)
////           include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
//           
//            $phpExcel = new PHPExcel();
//            // Set properties
////            $phpExcel->getProperties()->setCreator($this->creator)
//            $phpExcel->getProperties()->setCreator('nkvietmy.com')
////                    ->setLastModifiedBy($this->lastModifiedBy)
//                    ->setLastModifiedBy('nkvietmy.com')
//                    ->setTitle($title)
//                    ->setSubject($subject)
//                    ->setDescription($description)
////                    ->setKeywords($this->keyword)
////                    ->setCategory($this->category)
//                    ->setKeywords('office 2007 openxml php')
//                    ->setCategory('Dental');
//            // Create sheet
//            $phpExcel->setActiveSheetIndex(0);
////            $phpExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName($this->font);
//            $phpExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Calibri');
//            $phpExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(12);
//            $phpExcel->getActiveSheet()->setTitle($sheetName);
//            // Write data
//            $rowIdx = 1;
//            foreach ($data as $item) {
//                $phpExcel->getActiveSheet()->setCellValue("A$rowIdx", $item->code);
//                $phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(100);
//                
////                $objDrawing = new PHPExcel_Worksheet_Drawing();
////                $objDrawing->setName('Logo ');
////                $objDrawing->setDescription('Logo ');
//                $imgName = Yii::getPathOfAlias('webroot') . "/upload/qrcode/$item->code.png";
//                file_put_contents($imgName, fopen('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $item->generateURL() . '&choe=UTF-8', 'r'));
////                $objDrawing->setPath($imgName);
////                $objDrawing->setResizeProportional(true);
////                $objDrawing->setWidth(40);
////                $objDrawing->setCoordinates('B5');
////                $objDrawing->setWorksheet($phpExcel->getActiveSheet());
//                
//                $rowIdx += 5;
//            }
//            
//            
//            // Save file
//            $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'PDF');
//            
////            for ($level = ob_get_level(); $level > 0; --$level) {
////                @ob_end_clean();
////            }
//            
//            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//            header('Pragma: public');
//            header('Content-type: '.'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//            header('Content-Disposition: attachment; filename="' . $fileName . '.' . 'pdf' . '"');
//
//            header('Cache-Control: max-age=0');
////            $writer->save('php://output');
//            Yii::app()->end();
////            spl_autoload_register(array('YiiBase','autoload'));
//        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }
    
    /**
     * 
     * @param type $referCodes
     */
    public static function saveQRCode($referCodes) {
        foreach ($referCodes as $item) {
            $imgName = Yii::getPathOfAlias('webroot') . "/upload/qrcode/$item->code.png";
            file_put_contents($imgName, fopen('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $item->generateURL() . '&choe=UTF-8', 'r'));
            $item->type = ReferCodes::TYPE_PRINTED;
            $item->save();
        }
    }
}
