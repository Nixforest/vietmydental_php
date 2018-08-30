<?php
/* @var $this ReceptionistController */
/* @var $model Array */
/* @var $receiptId String */
/* @var $customer Customers */
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'medical-records-form',
	'enableAjaxValidation'=>false,
)); ?>
    <div id="divToPrint">
        <table class="table table-borderless">
            <!--Row header-->
            <tr>
                <td colspan="10">
                    <img src="<?php echo Yii::app()->theme->baseUrl . "/img/logo.png"; ?>" class="img-rounded" alt="" width="220%" height="220%">
                    
                </td>
                <td colspan="3">
                </td>
                <!--Agent information-->
                <td colspan="23">
                    <table class="table table-borderless">
                        <?php
//                            $address = "128 Huỳnh Tấn Phát P. Phú Mỹ, Quận 7, TP HCM";
//                            $phone = "028.3785.8989";
//                            $website = "http://nhakhoavietmy.com.vn";
//                            $agentName = "";
//                            if (isset($model->rJoinAgent) && isset($model->rJoinAgent->rAgent)) {
//                                $address = $model->rJoinAgent->rAgent->address;
//                                $phone = $model->rJoinAgent->rAgent->phone;
//                                $agentName = " - " . $model->rJoinAgent->rAgent->name;
//                            }
//                            $address    = (!empty($aAgent) ? $aAgent[0]->address : '');
//                            $phone      = (!empty($aAgent) ?$aAgent[0]->phone : '');
//                            $website    = DomainConst::CONTENT_WEBSITE;
//                            $agentName  = DomainConst::CONTENT_AGENT. ' - '. (!empty($aAgent) ? $aAgent[0]->name : '');
                            
                            $address = "128 Huỳnh Tấn Phát P. Phú Mỹ, Quận 7, TP HCM";
                            $phone = "028.3785.8989";
                            $website = Settings::getDomainSaleWebsite();
                            $agentName = "";
                            if (isset($mAgent)) {
                                $address    = $mAgent->address;
                                $phone      = $mAgent->phone;
                                $agentName  = $mAgent->getFullName();
                            }
                        ?>
                        <tr><td colspan="2"><b><?php echo $agentName; ?></b></td></tr>
                        <tr>
                            <td class="infofont"><?php echo DomainConst::CONTENT00308; ?></td>
                            <td class="infofont">
                                <i>
                                    <?php echo $address; ?>
                                </i>
                            </td>
                        </tr>
                        <tr>
                            <td class="infofont"><?php echo DomainConst::CONTENT00307; ?></td>
                            <td class="infofont"><i><?php echo $phone; ?></i></td>
                        </tr>
                        <tr>
                            <td class="infofont"><?php echo DomainConst::CONTENT00312; ?>:</td>
                            <td class="infofont"><i><?php echo $website; ?></i></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>
            <!--Row Title-->
            <tr>
                <td colspan="13"></td>
                <td colspan="10" class="align-middle bigfont"><b><?php echo DomainConst::CONTENT00301; ?></b></td>
                <td colspan="8"><b>Số/ID: <?php echo $receiptId; ?></b></td>
            </tr>
            <!--Row Patient information-->
            <tr>
                <!--<td colspan="2"></td>-->
                <td colspan="31">
                    <!--Table patient information-->
                    <table class="table table-borderless">
                        <tr>
                            <td colspan="5"><b><?php echo DomainConst::CONTENT00302; ?></b></td>
                            <td colspan="10">
                                <i>
                                    <?php echo CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3); ?>
                                </i>
                            </td>
                            <td colspan="5"><b><?php echo DomainConst::CONTENT00303; ?></b></td>
                            <td colspan="8"><i><?php echo DomainConst::CONTENT00304; ?></i></td>
                        </tr>
                        <tr>
                            <?php
                            if (isset($customer)) {
                                $customerName = $customer->name;
                                $customerId = $customer->getId();
                                $customerPhone = $customer->getPhone();
                                $customerEmail = $customer->getEmail();
                                $customerAddress    = $customer->getAddress();
                                $oldDebt            = $customer->debt;
                            }
                            ?>
                            <td colspan="5"><b><?php echo DomainConst::CONTENT00305; ?></b></td>
                            <td colspan="10">
                                <i>
                                    <?php echo $customerName; ?>
                                </i>
                            </td>
                            <td colspan="5"><b><?php echo DomainConst::CONTENT00306; ?></b></td>
                            <td colspan="8">
                                <i><?php echo $customerId; ?></i>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5"><b><?php echo DomainConst::CONTENT00307; ?></b></td>
                            <td colspan="10"><i><?php echo $customerPhone; ?></i></td>
                            <td colspan="5"><b><?php echo DomainConst::CONTENT00175; ?>:</b></td>
                            <td colspan="8"><i><?php echo $customerEmail; ?></i></td>
                        </tr>
                        <tr>
                            <td colspan="5"><b><?php echo DomainConst::CONTENT00308; ?></b></td>
                            <td colspan="23"><i><?php echo $customerAddress; ?></i></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!--Detail information-->
            <tr>
                <td colspan="31">
                    <table class="table table-bordered">
                    <tr>
                        <td><b>STT</b></td>
                        <td>
                            <b><?php echo DomainConst::CONTENT00241; ?></b><br>
                            (<?php echo 'Process date'; ?>)
                        </td>
                        <td>
                            <b><?php echo DomainConst::CONTENT00309; ?></b><br>
                            (<?php echo DomainConst::CONTENT00310; ?>)
                        </td>
                        <td>
                            <b><?php echo DomainConst::CONTENT00313; ?></b><br>
                            (<?php echo DomainConst::CONTENT00314; ?>)
                        </td>
                        <td class="center">
                            <!--<b><?php // echo DomainConst::CONTENT00315; ?></b><br>-->
                            <!--(<?php // echo DomainConst::CONTENT00316; ?>)-->
                            <b><?php echo DomainConst::CONTENT00353; ?></b><br>
                            (<?php echo DomainConst::CONTENT00429; ?>)
                        </td>
                        <td class="center">
                            <b><?php echo DomainConst::CONTENT00317; ?></b><br>
                            (<?php echo DomainConst::CONTENT00318; ?>)
                        </td>
                        <td class="center">
                            <b><?php echo DomainConst::CONTENT00319; ?></b><br>
                            (<?php echo DomainConst::CONTENT00320; ?>)
                        </td>
                        <td class="center">
                            <b><?php echo DomainConst::CONTENT00259; ?></b><br>
                            (<?php echo DomainConst::CONTENT00321; ?>)
                        </td>
                    </tr>
                    <?php
                    $index = 1;
                    $totalmoney = 0;
                    $totalFinal = 0;
                    $totalCurrentDebt = 0;
                    ?>
                    <?php foreach ($model as $value): ?>
                    <?php
                        $teethCount = 1;                    // Number of teeth
//                        $treatmentName = '';                // Name of treatment type
                        $price = '';                        // Price of treatment
                        $money = $value->getTotal() - $value->discount; // Money
                        $totalmoney += $money;
                        $discount       = $value->getDiscount();    // Discount value
                        $final          = $value->getFinal();       // Final value
                        $totalFinal += $value->final;
                        $currentDebt    = $value->final - $money;   // Debt value
                        $totalCurrentDebt += $currentDebt;
                        $treatment = $value->getTreatmentType();
                        if (isset($value->rTreatmentScheduleDetail)) {
                            // Get teeth count from treatment detail
                            $teethCount = $value->rTreatmentScheduleDetail->getTeethCount();
                        }
                        if ($treatment != NULL) {
                            // And price
                            $price = $treatment->getPrice();
                        }
                        // Get treatment name
                        $treatmentName = $value->getTreatmentTypeName();
                        if (!empty($price)) {
                            $treatmentName .= ' - ' . $price;
                        }
                    ?>
                    <tr>
                        <td><?php echo $index++; ?></td>
                        <td><?php echo CommonProcess::convertDateTime($value->process_date, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_3); ?></td>
                        <td><?php echo $treatmentName; ?></td>
                        <td><?php echo $teethCount; ?></td>
                        <!--<td class="currency"><?php // echo $price; ?></td>-->
                        <td class="currency"><?php echo CommonProcess::formatCurrency($value->total); ?></td>
                        <td class="currency"><?php echo $discount; ?></td>
                        <td class="currency"><?php echo CommonProcess::formatCurrency($money); ?></td>
                        <td class="currency"><?php echo $final; ?></td>
                    </tr>
                    <?php endforeach; // end foreach ($model as $value) ?>
                    <?php
//                    $teethCount = 1;
//                    $treatment = $model->getTreatmentType();
//                    $money = $model->getTotal() - $model->discount;
//                    if ($treatment != NULL) {
//                        $treatmentName = $treatment->name;
//                        $price = $treatment->getPrice();
////                        $money = $treatment->price - $model->discount;
//                    }
//                    if (isset($model->rTreatmentScheduleDetail)) {
//                        $teethCount = $model->rTreatmentScheduleDetail->getTeethCount();
////                        $money = $model->rTreatmentScheduleDetail->getTotalMoney() - $model->discount;
//                    }
//                    $discount = $model->getDiscount();
//                    $final = $model->getFinal();
//                    $currentDebt = $model->final - $money;
//                    // If receptionist accept this receipt before, must rollback value of old debt
//                    if ($model->status == Receipts::STATUS_RECEIPTIONIST) {
//                        $oldDebt = $oldDebt + $currentDebt;
//}
                    ?>
<!--                    <tr>
                        <td>1</td>
                        <td><?php echo $treatmentName; ?></td>
                        <td><?php echo $teethCount; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $discount; ?></td>
                        <td><?php echo CommonProcess::formatCurrency($money) . ' ' . DomainConst::CONTENT00134; ?></td>
                        <td><?php echo $final; ?></td>
                    </tr>-->
                    <tr>
                        <td colspan="5" style="border: none !important;" ></td>
                        <td style="border: none !important;" ><b><?php echo DomainConst::CONTENT00322; ?></b></td>
                        <td class="currency" style="border: none !important;" ><b><?php echo CommonProcess::formatCurrency($totalmoney); ?></b></td>
                        <td class="currency" style="border: none !important;" ><b><?php echo CommonProcess::formatCurrency($totalFinal); ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="border: none !important;" ></td>
                        <td style="border: none !important;" ><b><?php echo ($totalCurrentDebt <= 0) ? DomainConst::CONTENT00323 : DomainConst::CONTENT00324 ?></b></td>
                        <td class="currency" style="border: none !important;" ><b><?php echo CommonProcess::formatCurrency(abs($totalCurrentDebt)); ?></b></td>
                        <!--<td style="border: none !important;" ></td>-->
                    </tr>
<!--                    <tr>
                        <td colspan="5"></td>
                        <td><b><?php echo DomainConst::CONTENT00325; ?></b></td>
                        <td class="currency"><?php echo CommonProcess::formatCurrency($oldDebt); ?></td>
                        <td></td>-->
                    <!--</tr>-->
                </table>
                </td>
            </tr>
            <tr>
                <td colspan="31">
                    <table class="table table-borderless">
                        <tr>
                            <td class="center"><b><?php echo DomainConst::CONTENT00326; ?></b></td>
                            <td class="center"><b><?php echo DomainConst::CONTENT00327; ?></b></td>
                            <td class="center"><b><?php echo DomainConst::CONTENT00328; ?></b></td>
                            <td class="center"><b><?php echo DomainConst::CONTENT00329; ?></b></td>
                            <td class="center"><b><?php echo DomainConst::CONTENT00330; ?></b></td>
                        </tr>
                        <tr>
                            <td class="smallfont center"><?php echo DomainConst::CONTENT00331; ?></td>
                            <td class="smallfont center"><?php echo DomainConst::CONTENT00331; ?></td>
                            <td class="smallfont center"><?php echo DomainConst::CONTENT00331; ?></td>
                            <td class="smallfont center"><?php echo DomainConst::CONTENT00331; ?></td>
                            <td class="smallfont center"><?php echo DomainConst::CONTENT00331; ?></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <?php
                        $user = Users::model()->findByPk(Yii::app()->user->id);
                        if ($user) {
                            $userName = $user->first_name;
                        }
                        ?>
                        <tr>
                            <td class="center"><?php echo $customerName; ?></td>
                            <td class="center"><?php echo $userName; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div>
    </div>
    <input type="button" onclick="window.print()" value="In"/>
<?php $this->endWidget(); ?>
</div><!-- form -->

<script>
</script>
<script type="text/javascript">
</script>
<style>
/*    table {
        border:solid #000 !important;
        border-width:1px 0 0 1px !important;
    }
    th, td {
        border:solid #000 !important;
        border-width:0 1px 1px 0 !important;
    }*/
    .table-borderless > tbody > tr > td,
    .table-borderless > tbody > tr > th,
    .table-borderless > tfoot > tr > td,
    .table-borderless > tfoot > tr > th,
    .table-borderless > thead > tr > td,
    .table-borderless > thead > tr > th {
        border: none !important;
    }

    .table-bordered > tbody > tr > td,
    .table-bordered > tbody > tr > th,
    .table-bordered > tfoot > tr > td,
    .table-bordered > tfoot > tr > th,
    .table-bordered > thead > tr > td,
    .table-bordered > thead > tr > th {
        /*border: 2px solid #060606;*/
        border:solid #000 !important;
        border-width:2px 2px 2px 2px !important;
    }
    
    .nobordertd {
        border: none !important;
    }

    td {
        font-size: <?php echo Settings::getPrintReceiptFontSize(); ?>;
    }
    .currency {
        text-align: right;
    }
    .bigfont {
        font-size: 250%;
    }
    .infofont {
        font-size: 160%;
    }
    .smallfont {
        font-size: 150%;
    }
    .center {
        text-align: center;
    }
</style>
