<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Handle echo html string
 *
 * @author nguyenpt
 */
class HtmlHandler {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Default class of button */
    const CLASS_GROUP_BUTTON                             = "group-btn";
    
    /**
     * Create button
     * @param String $href Link
     * @param String $title Title of button
     * @param String $isNewTab Want to open in new tab?
     * @param String $class Class of button
     * @return String Html string generate button
     */
    public static function createButton($href, $title, $isNewTab = true, $class = self::CLASS_GROUP_BUTTON) {
        $retVal = '';
        $target = '';
        if ($isNewTab) {
            $target = 'target="_blank"';
        }
        $retVal .= '<div class="' . $class . '">';
        $retVal .= '<a ' . $target . ' href="' . $href . '">' . $title . '</a>';
        $retVal .= '</div>';
        return $retVal;
    }
    
    /**
     * Create button with image icon
     * @param String $href Link
     * @param String $title Title of button
     * @param String $image Image path
     * @param String $isNewTab Want to open in new tab?
     * @param String $class Class of button
     * @return String Html string generate button
     */
    public static function createButtonWithImage($href, $title, $image, $isNewTab = false, $class = self::CLASS_GROUP_BUTTON, $tagAId = '') {
        $retVal = '';
        $target = '';
        if ($isNewTab) {
            $target = 'target="_blank"';
        }
        
        $retVal .= '<div class="' . $class . '">';
        $retVal .= '<a ' . $target . ' href="' . $href . '" id="' . $tagAId . '">'
                . '<img src="' . Yii::app()->theme->baseUrl . DomainConst::IMG_BASE_PATH . $image . '"> '
                . '' . $title . '</a>';
        $retVal .= '</div>';
        return $retVal;
    }
    
    //++ BUG0038-IMT  (DuongNV 201807) Update UI receipt
    /**
     * Create button with image icon
     * @param String $href Link
     * @param String $title Title of button
     * @param String $image Image path
     * @param String $isNewTab Want to open in new tab?
     * @param String $class Class of button
     * @return String Html string generate button
     */
    public static function createBstButton($href, $title, $classIcon = '' , $isNewTab = false, $class = 'btn btn-primary', $tagAId = '') {
        $retVal = '';
        $target = '';
        if ($isNewTab) {
            $target = 'target="_blank"';
        }
        
        $retVal = '<a ' . $target . ' href="' . $href . '" id="' . $tagAId . '" class="' . $class . '">'
                . '<i class="'.$classIcon.'"></i> '
                . '' . $title . '</a>';
        return $retVal;
    }
    //-- BUG0038-IMT  (DuongNV 201807) Update UI receipt
    
    /**
     * Create custom treatment history item
     * @param String $href              Url to redirect update treatment info
     * @param String $title             Title of item
     * @param String $time              Time of item
     * @param String $doctor            Doctor info
     * @param String $paymentHref       Url to redirect update payment info
     * @param String $prescriptHref     Url to redirect update prescription info
     * @param String $paymentClick      Jquery code to handle click on payment
     * @param String $prescriptClick    Jquery code to handle click on prescription
     * @param String $status
     * @return String Html string generate button
     */
    public static function createCustomButton($href, $title, $time, $doctor,
            $paymentHref, $prescriptHref, $paymentClick = '',
            $prescriptClick = '', $status = '', $id = '', $mTreatmentProcess = []) {
        $retVal = '';
        $target = '';
        $target = 'target=""';
        $sttClass = 'btn-default';
        //++BUG0017 (DuongNV 20180717) add
        $aCssClass = array('btn-warning', 'btn-success', 'btn-danger'); // 0 - new, 1 - complete, 2 - cancel
        $aStatus = array(
                        0 => DomainConst::CONTENT00402, 
                        1 => DomainConst::CONTENT00204,
                        2 => DomainConst::CONTENT00403
                    );
        $dropdownMenu = '';
        foreach ($aStatus as $key => $value) {
            if($key != $status['type']){
                //++ BUG0017-IMT (DuongNV 20180717) Add event to status btn
                //0 - new, 1 - complete, 2 - cancel
//                $dropdownMenu .= '<li><a style="cursor:pointer;">'.$value.'</a></li>';
                $dropdownMenu .= '<li class="ts-stt-btn" data-type="'.$key.'" data-id="'.$id.'"><a style="cursor:pointer;">'.$value.'</a></li>';
                //-- BUG0017-IMT (DuongNV 20180717) Add event to status btn
            }
        }
        $dropDown = '<div class="dropdown" style="display:inline-block;margin-right:3px;">'
                    .        '<button class="btn '.$aCssClass[$status['type']].' btn-xs dropdown-toggle" type="button" data-toggle="dropdown">'.ucfirst($status['name'])
                    .        ' <span class="caret"></span></button>'
                    .        '<ul class="dropdown-menu" style="min-width:100px;">'
                    .           $dropdownMenu
                    .       '</ul>'
                    .    '</div>';
        //++ BUG0054-IMT (DuongNV 20180806) Update UI treatment history
        $prescriptItem = '<a href="' . $prescriptHref . '" style="cursor:pointer;"><i class="fas fa-capsules"></i> ' . DomainConst::CONTENT00379 . '</a>';
        if (!empty($prescriptClick)) {
            $prescriptItem = '<a onclick="' . $prescriptClick . '" style="cursor:pointer;"><i class="fas fa-capsules"></i> ' . DomainConst::CONTENT00379 . '</a>';
        }
        $laboRequestEvent = '{fnOpenLaboRequest(\'' . $id . '\');}';
        $laboRequestItem = '<a onclick="' . $laboRequestEvent . '" style="cursor:pointer;"><i class="fas fa-exchange-alt"></i> ' . DomainConst::CONTENT00425 . '</a>';
        $warrantyEvent = '{fnOpenWarranty(\'' . $id . '\');}';
        $warranty = '<a onclick="' . $warrantyEvent . '" style="cursor:pointer;"><i class="fas fa-shield-alt"></i>' . DomainConst::CONTENT00447 . '</a>';
            //++ BUG0056-IMT (DuongNV 20180811) Update image data treatment
        $urlXRay = Yii::app()->createAbsoluteUrl("admin/treatmentScheduleDetails/updateImageXRay", array('id' => $id, 'ajax' => false));
        $urlReal = Yii::app()->createAbsoluteUrl("admin/treatmentScheduleDetails/updateImageReal", array('id' => $id, 'ajax' => false));
        $addDropDown = '<div class="dropdown" style="display:inline-block;margin-right:3px;">'
                    .        '<button class="btn btn-xs btn-success dropdown-toggle" type="button" data-toggle="dropdown">Thêm'
                    .        ' <span class="caret"></span></button>'
                    .        '<ul class="dropdown-menu" style="min-width:100px;">'
                    .           '<li class="createPrescription">' . $prescriptItem . '</li>'
                    //++ BUG0076-IMT (DuongNV 20180823) Create treatment schedule process
                    .           '<li><a class="createProcess" style="cursor:pointer;" data-id="'.$id.'"><i class="fas fa-stethoscope"></i> Tạo Tiến trình điều trị</a></li>'
                    //-- BUG0076-IMT (DuongNV 20180823) Create treatment schedule process
                    //++ BUG0056-IMT (DuongNV 20180831) Update image xray and real
                    .           '<li><a class="imageCamera" style="cursor:pointer;" data-type="camera" data-id="'.$id.'"> <i class="fas fa-camera" style="margin:0 1px;"></i> Hình ảnh Camera</a></li>'
                    .           '<li><a class="imageXQuang" style="cursor:pointer;" data-type="xray" data-id="'.$id.'"><i class="fas fa-x-ray"></i> Hình ảnh X-Quang</a></li>'
                    //-- BUG0056-IMT (DuongNV 20180831) Update image xray and real
                    .           '<li class="requestRecoveryImage" data-id="'.$id.'">' . $laboRequestItem . '</li>'
                    .           '<li class="warranty" data-id="' . $id . '">' . $warranty . '</li>'
                    .       '</ul>'
                    .    '</div>';
            //-- BUG0056-IMT (DuongNV 20180811) Update image data treatment
        //-- BUG0054-IMT (DuongNV 20180806) Update UI treatment history
        //--BUG0017 (DuongNV 20180717) add
//        if(!empty($status)){ //use for label, now is dropdown
//            $sttClass = $aCssClass[$status['type']];
//        }
        //++ BUG0054-IMT (DuongNV 20180806) Update UI treatment history
        $paymentItem = '<a href="' . $paymentHref . '" class="btn btn-xs btn-primary mr-1"><i class="fas fa-dollar-sign" title="' . DomainConst::CONTENT00251 . '"></i></a>';
        if (!empty($paymentClick)) {
            $paymentItem = '<a onclick="' . $paymentClick . '" class="btn btn-xs btn-primary mr-1">' . DomainConst::CONTENT00251 . '</a>';
//            $paymentItem = '<a onclick="' . $paymentClick . '" class="btn btn-xs btn-primary mr-1"><i class="fas fa-dollar-sign" title="' . DomainConst::CONTENT00251 . '"></i></a>';
        }
//        $prescriptItem = '<a href="' . $prescriptHref . '" class="btn btn-xs btn-success mr-1">' . DomainConst::CONTENT00379 . '</a>';
//        if (!empty($prescriptClick)) {
//            $prescriptItem = '<a onclick="' . $prescriptClick . '" class="btn btn-xs btn-success mr-1">' . DomainConst::CONTENT00379 . '</a>';
//        }
        //-- BUG0054-IMT (DuongNV 20180806) Update UI treatment history

        $paymentLink = Yii::app()->createAbsoluteUrl("admin/treatmentScheduleDetails/payment");
        $createPrescriptionLink = Yii::app()->createAbsoluteUrl("admin/treatmentScheduleDetails/createPrescription");
        //++BUG0017 (DuongNV 20180717) modify
//        $retVal = '<a ' . $target . '>'
        $retVal = '<div ' . $target . '>'
                .       '<div class="gr-container">'
                .           '<div class="gr-bar">'
                .               $dropDown
//                .               '<h4 style="display: inline; margin-right: 4px;"><span class="label '.$sttClass.'">'.$status['name'].'</span></h4>'
//                .               '<a href="#" onclick="alert(\'' . DomainConst::CONTENT00375 . '\')" class="btn btn-xs btn-primary mr-1">Thanh toán</a>'
//                .               '<a href="#" onclick="alert(\'' . DomainConst::CONTENT00375 . '\')" class="btn btn-xs btn-success mr-1">Tạo toa thuốc</a>'
                .               $paymentItem
                //++ BUG0054-IMT (DuongNV 20180806) Update UI treatment history
//                .               $prescriptItem
                .               $addDropDown
                //-- BUG0054-IMT (DuongNV 20180806) Update UI treatment history
//                .               $dropDown
                .           '</div>'
//                .           '<h4><b><a ' . $target . ' href="' . $href . '">' . $title . '</a></b></h4>'
                .           '<h4><b><a ' . $target . ' onclick="' . $href . '" style="cursor:pointer;">' . $title . '</a></b></h4>'
                .           '<span>Bác sĩ <b>'.$doctor.'</b> thực hiện lúc <b>'.$time.'</b>.</span>'
                //++BUG0054-IMT (DuongNV 20180806) Update UI treatment history
                .           self::createHtmlTreatmentProcess($mTreatmentProcess)
                //--BUG0054-IMT (DuongNV 20180806) Update UI treatment history
                .       '</div>'
                . '</div>';
//                . '</a>';
        //--BUG0017 (DuongNV 20180717) modify
        //++ BUG0056-IMT (DuongNV 20180811) Update image data treatment
//        $scriptColorbox = '<script>afterShowCustomerInfo();</script>';
//        $retVal .= $scriptColorbox;
        //-- BUG0056-IMT (DuongNV 20180811) Update image data treatment
        return $retVal;
    }
    
    //++BUG0054-IMT (DuongNV 20180806) Update UI treatment history
    public static function createHtmlTreatmentProcess($mTreatmentProcess){
        $resVal = '';
        if(empty($mTreatmentProcess)) {
            return $resVal;
        }
        $i = 0;
        foreach ($mTreatmentProcess as $value) {
            if($i++ == 5){
                $resVal .= '<div class="view-more"><span class="vm-btn">Xem thêm <i class="fas fa-angle-double-down"></i></span></div>';
                break;
            }
            $teeth = (!empty($value->description) ? 'Răng ' . $value->description : '');
            $content = 'BS <b>' . (isset($value->rDoctor) ? $value->rDoctor->getFullName() : '') . '</b> thực hiện <b>' . $value->name . '</b>. ';
            //++ BUG0079-IMT (DuongNV 20180109) Update and delete treatment process via ajax
            $actionBtn = '<div class="treatment-process-action">'
                        .   '<i class="fas fa-pencil-alt update-process-btn" data-id="'.$value->id.'"></i>'
                        .   '<i class="fas fa-times delete-process-btn" data-id="'.$value->id.'"></i>'
                        .'</div>';
            $resVal .= '<div class="treatment-process-item">'
                    .   '<p><b>' . $value->process_date.': </b>'
                    .   ' <span>' . $content.'</span>'
                    .   ' <span>' . $teeth.'</span></p>'
                    .   $actionBtn
                    .'</div>';
            //-- BUG0079-IMT (DuongNV 20180109) Update and delete treatment process via ajax
        }
        return $resVal;
    }
    //--BUG0054-IMT (DuongNV 20180806) Update UI treatment history
    
    public static function createAjaxButtonWithImage($title, $image, $onClick, $style, $class = self::CLASS_GROUP_BUTTON) {
        $retVal = '';
        $retVal .= '<div class="' . $class . '">';
        $retVal .= '<a style="' . $style . '" onclick="' . $onClick . '">'
                . '<img src="' . Yii::app()->theme->baseUrl . DomainConst::IMG_BASE_PATH . $image . '"> '
                . '' . $title . '</a>';
        $retVal .= '</div>';
        return $retVal;
    }
    
    //++ BUG0038-IMT  (DuongNV 201807) Update UI receipt
    public static function createBstAjaxButton($title, $classIcon, $onClick, $style, $class = 'btn btn-primary') {
        $retVal = '<a style="' . $style . '" onclick="' . $onClick . '"  class="' . $class . '">'
                . '<i class="'.$classIcon.'"></i> '
                . '' . $title . '</a>';
        return $retVal;
    }
    //-- BUG0038-IMT  (DuongNV 201807) Update UI receipt
    
    /**
     * Create table for customer information
     * @param Array $arrCustomer List of customer
     * @return string Html string
     */
    public static function createTableCustomer($arrCustomer, $title = DomainConst::CONTENT00201) {
        $retVal =    '<div class="title-2">' . $title . '</div>';
        //++ BUG0037-IMT  (DuongNV 221807) Update UI schedule today 
//        $retVal .=   '<div class="scroll-table">';
        $retVal .=   '<div>';
        $retVal .=       '<table id="customer-info" class="table table-striped lp-table">';
        //++ BUG0037-IMT  (DuongNV 221807) Update UI schedule today
        $retVal .=           '<thead>';
        $retVal .=               '<tr>';
        $retVal .=                   '<th>' . DomainConst::CONTENT00135 . '</th>';
        $retVal .=                   '<th>' . DomainConst::CONTENT00101 . '/' . DomainConst::CONTENT00045 . '</th>';
        $retVal .=                   '<th>' . DomainConst::CONTENT00240 . '</th>';
        $retVal .=                   '<th>' . DomainConst::CONTENT00143 . '</th>';
        $retVal .=               '</tr>';
        $retVal .=           '</thead>';
        $retVal .=           '<tbody>';
        foreach ($arrCustomer as $customer) {
            $id         = CommonProcess::getValue($customer, DomainConst::KEY_ID);
            $mCustomer  = Customers::getCustomerById($id);
            $birthday   = '';
            if ($mCustomer) {
                $birthday = $mCustomer->getBirthday();
            }
            $recordNum  = CommonProcess::getValue($customer, DomainConst::KEY_RECORD_NUMBER);
            $name       = CommonProcess::getValue($customer, DomainConst::KEY_NAME);
            $phone      = CommonProcess::getValue($customer, DomainConst::KEY_PHONE);
            $address    = CommonProcess::getValue($customer, DomainConst::KEY_ADDRESS);
            $time       = ScheduleTimes::getTimeById(CommonProcess::getValue($customer, DomainConst::KEY_TIME_ID));
            $doctor     = Users::getUserFullNameById(CommonProcess::getValue($customer, DomainConst::KEY_DOCTOR_ID));
            $retVal .=           '<tr id="' . $id . '" class="customer-info-tr">';
            $retVal .=               '<td>';
            $retVal .=                   self::formatRecordNumber($recordNum) . '<br>' . $name . '<br>' . $phone . '<br>';
            $retVal .=               '</td>';
            $retVal .=               '<td>';
            $retVal .=                   $birthday  . '<br>'. $address;
            $retVal .=               '</td>';
            $retVal .=               '<td>';
            $retVal .=                   $time;
            $retVal .=               '</td>';
            $retVal .=               '<td>';
            $retVal .=                   $doctor;
            $retVal .=               '</td>';
            $retVal .=           '</tr>';
        }
        
        $retVal .=           '</tbody>';
        $retVal .=       '</table>';
        $retVal .=  '</div>';
        return $retVal;
    }
    
    /**
     * Format record number
     * @param String $recordNumber Record number
     * @return String Formated string
     */
    public static function formatRecordNumber($recordNumber) {
        return '<b><font color="blue">' . $recordNumber . '</font></b>';
    }
}
