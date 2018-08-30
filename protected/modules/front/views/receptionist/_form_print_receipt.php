<?php
/* @var $this ReceptionistController */
/* @var $form CActiveForm */
?>

<div class="form">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'customers-form',
    'enableAjaxValidation' => false,
));
?>
<div>
    <h3><?php echo DomainConst::CONTENT00135 . ': ' . $customer->name; ?></h3>
    <br>
    <?php echo $form->errorSummary($customer); ?>
    <?php // echo DomainConst::CONTENT00375; ?>
    <?php
    $html = '<table class="table table-bordered">';
    $space = '&nbsp';
    $nameArr = DomainConst::KEY_RECEIPT;
    $html .=    '<thead>';
    $html .=        '<tr>';
    $html .=            '<td><h4>' . 'Thông tin' . '</h4></td>';
    $html .=            '<td><h4>' . 'Chọn' . '</h4></td>';
    $html .=        '</tr>';
    $html .=    '</thead>';
    $html .=    '<tbody>';
    if (isset($customer->rMedicalRecord) && isset($customer->rMedicalRecord->rTreatmentSchedule)) {
        $treatmentCnt = count($customer->rMedicalRecord->rTreatmentSchedule);
        foreach ($customer->rMedicalRecord->rTreatmentSchedule as $schedule) {
            if (isset($schedule->rDetail)) {
                $scheduleInputId = $nameArr . '_' . $schedule->id;
                $scheduleInputName = $nameArr . '[' . $schedule->id . ']';
                $title =        'Đợt ' . $treatmentCnt-- . ': ' . $schedule->getStartDate();
                $html .= '<tr class="treatment_td">';
                $html .=    '<td>';
                $html .=            '<b>' . $title . '</b>';
                $html .=    '</td>';
                $html .=    '<td>';
                $html .=        '<input name="' . $scheduleInputName . '" value="1" type="checkbox"'
                                . ' id="' . $scheduleInputId . '" class="treatment">';
                $html .=    '</td>';
                $html .= '</tr>';
                $detailCnt = count($schedule->rDetail);
                foreach ($schedule->rDetail as $detail) {
                    $detailTitle = $space . $space . $space . $detail->getStartTime() . ' - ';
//                    if ($detail->rTreatmentType) {
//                        $detailTitle .= $detail->rTreatmentType->name;
//                    } else if ($detail->rDiagnosis) {
//                        $detailTitle .= $detail->rDiagnosis->name;
//                    } else {
//                        $detailTitle .= DomainConst::CONTENT00177;
//                    }
                    $detailTitle .= $detail->getTreatmentInfo();
                    $html .= '<tr>';
                    $html .=    '<td>';
                    $html .=        $detailTitle;
                    $html .=    '</td>';
                    $html .=    '<td>';
                    if (isset($detail->rReceipt)) {
                        $name = $scheduleInputName . '[' . $detail->rReceipt->id . ']';
                        $id   = $scheduleInputId . '_' . $detail->rReceipt->id;
                        $html .= '<input name="' . $name . '" value="1" type="checkbox"'
                                . ' id="' . $id . '" class="detail">';
                    } else {
//                        $html .= DomainConst::CONTENT00376;
                    }
                    
                    $html .=    '</td>';
                    $html .= '</tr>';
                }
            }
        }
    }
    
    // Test
    
    $html .=    '</tbody>';
    $html .= '</table>';
    echo $html;
    ?>
    <div class="row buttons">
        <?php
        echo HtmlHandler::createButtonWithImage(Yii::app()->createAbsoluteUrl("front/receptionist/printReceipt", array(
                    "id" => 1,
                )), DomainConst::CONTENT00264,
                DomainConst::IMG_PRINT_ICON,
                false, HtmlHandler::CLASS_GROUP_BUTTON,
                'printButton');
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>

</div>
<!-- form -->
<script>
    $(function(){
        /**
         * Update print button href value.
         */
        function fnUpdatePrintButton() {
            var href = $("#printButton").attr('href');
            href = href.substring(0, href.lastIndexOf('/'));
            $("#printButton").attr('href', href + '/' + getSelectedId());
        }
        /**
         * Get selected id string
         * @returns {String} 1-2-3-4
         */
        function getSelectedId() {
            var retVal = '';
            $('.treatment').each(function(index, item) {
//                alert('123');
                // Get current treatment element id
                var id = $(item).attr('id');
                // Loop for all detail element (in same treatment)
                $("input[id^='" + id + "_']").each(function(ii, detail) {
                    var detailId = $(detail).attr('id');
                    // If item is checked
                    if ($(detail).is(":checked")) {
                        retVal += detailId.substring(detailId.lastIndexOf('_') + 1, detail.length) + '-';
                    }
                });
            });
            return retVal;
        }
        // If click on treament element
        $('.treatment').change(function () {
            // Get current treatment element id
            var id = $(this).attr('id');
            // Get current treatment element status checked or unchecked
            var isChecked = $(this).is(":checked");
            if (isChecked) {
                $("input[id^='" + id + "']").prop("checked", true);
            } else {
                $("input[id^='" + id + "']").removeAttr("checked");
            }
            fnUpdatePrintButton();
        });
        // If click on detail element
        $('.detail').change(function () {
            // Get current detail element id
            var id = $(this).attr('id');
            // Get current treatment element id
            var treatmentId = id.substring(0, id.lastIndexOf('_'));
            var checkedCnt = 0;
            // Get number of detail element (in same treatment)
            var detailCount = $("input[id^='" + treatmentId + "_']").length;
            // Loop for all detail element (in same treatment)
            $("input[id^='" + treatmentId + "_']").each(function(index, item) {
                // If item is checked
                if ($(item).is(":checked")) {
                    checkedCnt++;
                }
            });
            
            if (detailCount === checkedCnt) {           // Checked all
                // Remove indeterminate status
                $("#" + treatmentId).prop("indeterminate", false);
                // Set checked
                $("#" + treatmentId).prop("checked", true);
            } else if (checkedCnt === 0) {              // Checked none
                // Remove indeterminate status
                $("#" + treatmentId).prop("indeterminate", false);
                // Set unchecked
                $("#" + treatmentId).removeAttr('checked');
            } else {                                    // Checked 1 or more (not all)
                // Set indeterminate status
                $("#" + treatmentId).prop("indeterminate", true);
            }
            fnUpdatePrintButton();
        });
    });
</script>
<style>
    .treatment_td {
        background: #e0e0e0;
    }
</style>



