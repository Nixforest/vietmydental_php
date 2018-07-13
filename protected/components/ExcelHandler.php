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
    private static $creator            = 'nkvietmy.com';
    private static $lastModifiedBy     = 'nkvietmy.com';
    private static $category           = 'Dental';
    private static $keyword            = 'office 2007 openxml php';
    private static $font               = 'Calibri';
    private static $writerType         = 'Excel2007';
    private static $subject         = 'Office 2007 XLSX Document';
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
    
    /**
     * get column name file excel
     * @param type $index
     * @return type
     * @throws Exception
     */
    public static function columnName($index) {
        --$index;
        if ($index >= 0 && $index < 26)
            return chr(ord('A') + $index);
        else if ($index > 25)
            return (MyFunctionCustom::columnName($index / 26)) . (MyFunctionCustom::columnName($index % 26 + 1));
        else
            throw new Exception("Invalid Column # " . ($index + 1));
    }

    /**
     * export excel report money
     * @param type $model
     * @param type $from
     * @param type $to
     */
    public static function summaryReportMoney($model, $from, $to) {
        try {
            //        data
            $aData = $model->getReportMoney($from, $to);
            $titleCellDate = 'THÁNG '.date('m/Y',strtotime($from));
            $fileName = 'Báo cáo (' . $from . ' đến ' . $to . ')';
            Yii::import('application.extensions.vendors.PHPExcel', true);
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()->setCreator(ExcelHandler::$creator)
                    ->setLastModifiedBy(ExcelHandler::$lastModifiedBy)
                    ->setTitle('ReportMoney')
                    ->setSubject(ExcelHandler::$subject)
                    ->setDescription("ReportMoney")
                    ->setKeywords(ExcelHandler::$keyword)
                    ->setCategory(ExcelHandler::$category);
            /*             * ************     SHEET CT DTHU **************************** */
            $countDoctor = count($aData['DOCTORS']);
            $row = 1;
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName(ExcelHandler::$font);
            $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(12);
            $objPHPExcel->getActiveSheet()->setTitle('CT DTHU');
            $titleCell = 'CHI TIẾT DOANH THU CỦA BÁC SĨ';
            $objPHPExcel->getActiveSheet()->setCellValue("A$row", $titleCell);
            $objPHPExcel->getActiveSheet()->getStyle("A$row")->getFont()
                    ->setBold(true);
            $objPHPExcel->getActiveSheet()->mergeCells("A$row:".ExcelHandler::columnName($countDoctor+2) . $row);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:".ExcelHandler::columnName($countDoctor+2) . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:".ExcelHandler::columnName($countDoctor+2) . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(30);
            $row++;
            
            $objPHPExcel->getActiveSheet()->setCellValue("A$row", $titleCellDate);
            $objPHPExcel->getActiveSheet()->getStyle("A$row")->getFont()
                    ->setBold(true);
            $objPHPExcel->getActiveSheet()->mergeCells("A$row:".ExcelHandler::columnName($countDoctor+2) . $row);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:".ExcelHandler::columnName($countDoctor+2) . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:".ExcelHandler::columnName($countDoctor+2) . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(30);
            $row++;
            $index = 1;
            $beginBorder = $row;

//        name of column
            $objPHPExcel->getActiveSheet()->getColumnDimension(ExcelHandler::columnName($index))->setWidth(20);
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", 'Ngày');
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index) . "$row", 'Bác sĩ thực hiện');
//        Trừ 1 vì 1 cột đã ghi tiêu đề
            $objPHPExcel->getActiveSheet()->mergeCells(ExcelHandler::columnName($index) . "$row" . ":" . ExcelHandler::columnName($index + $countDoctor - 1) . "$row");
            $index += $countDoctor;
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", 'Ghi chú');
            $index--;
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getFont()->setBold(true);
            $row++;

            $index = 1;
            $rowMerge = $row - 1;
            $objPHPExcel->getActiveSheet()->mergeCells(ExcelHandler::columnName($index) . "$rowMerge" . ':' . ExcelHandler::columnName($index) . "$row");
            $index++;
            $startCurrency = ExcelHandler::columnName($index);
            foreach ($aData['DOCTORS'] as $idDoctor => $strFullName) {
                $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index) . "$row", $strFullName);
                //        set style width
                $objPHPExcel->getActiveSheet()->getColumnDimension(ExcelHandler::columnName($index))->setWidth(20);
                $index++;
            }
            $endCurrency = ExcelHandler::columnName($index-1);
            $objPHPExcel->getActiveSheet()->mergeCells(ExcelHandler::columnName($index) . "$rowMerge" . ':' . ExcelHandler::columnName($index) . "$row");
            $index++;
//        set style column
            $index--;
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getFont()->setBold(true);
            $row++;

//        body
            self::summaryReportMoneyImportBody($model, $aData, $objPHPExcel, $row);

            $row--;
//        set borders
            $objPHPExcel->getActiveSheet()->getStyle("A$beginBorder:" . ExcelHandler::columnName($index) . $row)
                    ->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle("A$beginBorder:" . ExcelHandler::columnName($index) . $row)
                    ->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle($startCurrency.$beginBorder.':'.$endCurrency.$row)->getNumberFormat()->setFormatCode('#,##0');


            /*             * ************     SHEET CT CHI **************************** */
            $objPHPExcel->createSheet(1);
            $row = 1;
            $objPHPExcel->setActiveSheetIndex(1);
            $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName(ExcelHandler::$font);
            $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(12);
            $objPHPExcel->getActiveSheet()->setTitle('CT CHI');
            $titleCell = 'BÁO CÁO CHI TIẾT CHI HÀNG NGÀY';
            $objPHPExcel->getActiveSheet()->setCellValue("A$row", $titleCell);
            $objPHPExcel->getActiveSheet()->getStyle("A$row")->getFont()
                    ->setBold(true);
            $objPHPExcel->getActiveSheet()->mergeCells("A$row:C$row");
            $objPHPExcel->getActiveSheet()->getStyle("A$row:C" . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:C" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(30);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue("A$row", $titleCellDate);
            $objPHPExcel->getActiveSheet()->getStyle("A$row")->getFont()
                    ->setBold(true);
            $objPHPExcel->getActiveSheet()->mergeCells("A$row:C$row");
            $objPHPExcel->getActiveSheet()->getStyle("A$row:C" . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:C" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(30);
            $row++;
            $index = 1;
            $beginBorder = $row;
//        name of column
            $objPHPExcel->getActiveSheet()->getColumnDimension(ExcelHandler::columnName($index))->setWidth(20);
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", 'Ngày');
            $objPHPExcel->getActiveSheet()->getColumnDimension(ExcelHandler::columnName($index))->setWidth(30);
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", 'Nội dung');
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", 'Số tiền');
//        set style column
            $index--;
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getFont()->setBold(true);
            $row++;

//        body
            self::summaryReportMoneyExportBody($model, $aData, $objPHPExcel, $row);


            $row--;
//        set borders
            $objPHPExcel->getActiveSheet()->getStyle("A$beginBorder:" . ExcelHandler::columnName($index) . $row)
                    ->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle("A$beginBorder:" . ExcelHandler::columnName($index) . $row)
                    ->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("C$beginBorder:C".$row)->getNumberFormat()->setFormatCode('#,##0');

            /*             * ************     SHEET GENERAL **************************** */
            $objPHPExcel->createSheet(2);
            $row = 1;
            $objPHPExcel->setActiveSheetIndex(2);
            $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName(ExcelHandler::$font);
            $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(12);
            $objPHPExcel->getActiveSheet()->setTitle('TH THU CHI');
            $titleCell = 'BẢNG TỔNG HỢP THU - CHI';
            $objPHPExcel->getActiveSheet()->setCellValue("A$row", $titleCell);
            $objPHPExcel->getActiveSheet()->getStyle("A$row")->getFont()
                    ->setBold(true);
            $objPHPExcel->getActiveSheet()->mergeCells("A$row:D$row");
            $objPHPExcel->getActiveSheet()->getStyle("A$row:D" . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:D" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(30);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue("A$row", $titleCellDate);
            $objPHPExcel->getActiveSheet()->getStyle("A$row")->getFont()
                    ->setBold(true);
            $objPHPExcel->getActiveSheet()->mergeCells("A$row:D$row");
            $objPHPExcel->getActiveSheet()->getStyle("A$row:D" . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:D" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(30);
            $row++;
            $index = 1;
            $beginBorder = $row;
//        name of column
            $objPHPExcel->getActiveSheet()->getColumnDimension(ExcelHandler::columnName($index))->setWidth(20);
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", 'Ngày');
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", 'Số tiền (VNĐ)');
            $objPHPExcel->getActiveSheet()->mergeCells(ExcelHandler::columnName($index - 1) . "$row:" . ExcelHandler::columnName($index) . $row);
            $index++;
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", 'Ghi chú');
//        set style column
            $index--;
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getFont()->setBold(true);
            $row++;
            $rowMerge = $row - 1;
            $index = 1;
            $objPHPExcel->getActiveSheet()->mergeCells(ExcelHandler::columnName($index) . "$rowMerge:" . ExcelHandler::columnName($index) . $row);
            $index++;
            $objPHPExcel->getActiveSheet()->getColumnDimension(ExcelHandler::columnName($index))->setWidth(25);
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", 'Thu');
            $objPHPExcel->getActiveSheet()->getColumnDimension(ExcelHandler::columnName($index))->setWidth(25);
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", 'Chi');
            $objPHPExcel->getActiveSheet()->mergeCells(ExcelHandler::columnName($index) . "$rowMerge:" . ExcelHandler::columnName($index) . $row);
            $index++;
//        set style column
            $index--;
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getFont()->setBold(true);
            $row++;
//        body
            self::summaryReportMoneyGeneralBody($model, $aData, $objPHPExcel, $row);
            $row--;
//        set borders
            $objPHPExcel->getActiveSheet()->getStyle("A$beginBorder:" . ExcelHandler::columnName($index) . $row)
                    ->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle("A$beginBorder:" . ExcelHandler::columnName($index) . $row)
                    ->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("B$beginBorder:C".$row)->getNumberFormat()->setFormatCode('#,##0');
            //save file
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            for ($level = ob_get_level(); $level > 0;  --$level) {
                @ob_end_clean();
            }
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-type: ' . 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $fileName . '.' . 'xlsx' . '"');

            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
            Yii::app()->end();
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
    }

    /**
     * 
     * @param type $aData
     * @param type $objPHPExcel
     * @param type $row
     * @param type $model
     */
    public static function summaryReportMoneyImportBody($model, $aData, &$objPHPExcel, &$row) {
        $aSum = array();
        foreach ($aData['RECEIPT']['DATES'] as $key => $date) :
            $index = 1;
            if (empty($aData['RECEIPT']['VALUES'][$date])) {
                continue;
            }
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", $date);
            foreach ($aData['DOCTORS'] as $idDoctor => $strFullName) {
                $moneyPrintf = !empty($aData['RECEIPT']['VALUES'][$date][$idDoctor]) ? $aData['RECEIPT']['VALUES'][$date][$idDoctor] : '';
                $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", $moneyPrintf);
//                sum money doctor
                if (!empty($aSum[$idDoctor])) {
                    $aSum[$idDoctor] += !empty($aData['RECEIPT']['VALUES'][$date][$idDoctor]) ? $aData['RECEIPT']['VALUES'][$date][$idDoctor] : 0;
                } else {
                    $aSum[$idDoctor] = !empty($aData['RECEIPT']['VALUES'][$date][$idDoctor]) ? $aData['RECEIPT']['VALUES'][$date][$idDoctor] : 0;
                }
            }
            $row++;
        endforeach; // end foreach 
//        draw sum
        $index = 1;
        $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", 'Cộng:');
        foreach ($aData['DOCTORS'] as $idDoctor => $strFullName) {
            $moneyPrintf = !empty($aSum[$idDoctor]) ? $aSum[$idDoctor] : 0;
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", $moneyPrintf);
        }
        $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("A$row:A$row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A$row:A$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $row++;
        $index = 1;
        $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", 'Tổng cộng:');
        $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index) . "$row", array_sum($aSum));
//        Trừ 1 vì 1 cột đã ghi tiêu đề
        $countDoctor = count($aData['DOCTORS']);
        $objPHPExcel->getActiveSheet()->mergeCells(ExcelHandler::columnName($index) . "$row" . ":" . ExcelHandler::columnName($index + $countDoctor - 1) . "$row");
        ;
        $index += $countDoctor;
        $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $row++;
    }

    public static function summaryReportMoneyExportBody($model, $aData, &$objPHPExcel, &$row) {
        $sum = 0;
        foreach ($aData['EXPORT_DETAIL'] as $key => $valueExport) :
            $index = 1;
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", $valueExport['DATE']);
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", $valueExport['DESCRIPTION']);
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", $valueExport['MONEY']);
            $sum += $valueExport['MONEY'];
            $row++;
        endforeach; // end foreach 
        $index = 1;
        $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index) . "$row", 'Tổng cộng:');
        $objPHPExcel->getActiveSheet()->getStyle(ExcelHandler::columnName($index) . "$row:" . ExcelHandler::columnName($index) . "$row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle(ExcelHandler::columnName($index) . "$row:" . ExcelHandler::columnName($index) . "$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells(ExcelHandler::columnName($index) . "$row" . ":" . ExcelHandler::columnName($index + 1) . "$row");
        $index += 2;
        $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", $sum);
        $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getFont()->setBold(true);
        $row++;
    }

    public static function summaryReportMoneyGeneralBody($model, $aData, &$objPHPExcel, &$row) {
        $sumImport = 0;
        $sumExport = 0;
        foreach ($aData['GENERAL']['DATES'] as $key => $date) :
            $index = 1;
            $importPrintf = !empty($aData['GENERAL']['IMPORT'][$date]) ? $aData['GENERAL']['IMPORT'][$date] : '';
            $sumImport += !empty($aData['GENERAL']['IMPORT'][$date]) ? $aData['GENERAL']['IMPORT'][$date] : 0;
            $exportPrintf = !empty($aData['GENERAL']['EXPORT'][$date]) ? $aData['GENERAL']['EXPORT'][$date] : '';
            $sumExport += !empty($aData['GENERAL']['EXPORT'][$date]) ? $aData['GENERAL']['EXPORT'][$date] : 0;
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", $date);
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", $importPrintf);
            $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", $exportPrintf);
            $row++;
        endforeach; // end foreach 
        $index = 1;
        $objPHPExcel->getActiveSheet()->getStyle(ExcelHandler::columnName($index) . "$row:" . ExcelHandler::columnName($index) . "$row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle(ExcelHandler::columnName($index) . "$row:" . ExcelHandler::columnName($index) . "$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", 'Cộng:');
        $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", $sumImport);
        $objPHPExcel->getActiveSheet()->setCellValue(ExcelHandler::columnName($index++) . "$row", $sumExport);
        $objPHPExcel->getActiveSheet()->getStyle("A$row:" . ExcelHandler::columnName($index) . $row)->getFont()->setBold(true);
        $row++;
    }

}
