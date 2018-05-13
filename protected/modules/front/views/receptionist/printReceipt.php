<?php
/* @var $this ReceptionistController */

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
                <td colspan="5">
                    <img src="<?php echo Yii::app()->theme->baseUrl . "/img/logo.png"; ?>" class="img-rounded" alt="">
                    
                </td>
                <td colspan="3">
                </td>
                <!--Agent information-->
                <td colspan="23">
                    <table class="table table-borderless">
                        <?php
                            $address = "128 Huỳnh Tấn Phát P. Phú Mỹ, Quận 7, TP HCM";
                            $phone = "028.3785.8989";
                            $website = "http://nhakhoavietmy.com.vn";
                            $agentName = "";
                            if (isset($model->rJoinAgent) && isset($model->rJoinAgent->rAgent)) {
                                $address = $model->rJoinAgent->rAgent->address;
                                $phone = $model->rJoinAgent->rAgent->phone;
                                $agentName = " - " . $model->rJoinAgent->rAgent->name;
                            }
                        ?>
                        <tr><td colspan="2">NHA KHOA VIỆT MỸ<?php echo $agentName; ?></td></tr>
                        <tr>
                            <td><?php echo DomainConst::CONTENT00308; ?></td>
                                <td>
                                    <i>
                                        <?php echo $address; ?>
                                    </i>
                                </td>
                        </tr>
                        <tr>
                            <td><?php echo DomainConst::CONTENT00307; ?></td>
                            <td><i><?php echo $phone; ?></i></td>
                        </tr>
                        <tr>
                            <td><?php echo DomainConst::CONTENT00312; ?>:</td>
                            <td><i><?php echo $website; ?></i></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!--Row Title-->
            <tr>
                <td colspan="13"></td>
                <td colspan="10" class="align-middle"><font size="6"><?php echo DomainConst::CONTENT00301; ?></font></td>
                <td colspan="8">Số/ID: <?php echo $model->getId();?></td>
            </tr>
            <!--Row Patient information-->
            <tr>
                <!--<td colspan="2"></td>-->
                <td colspan="31">
                    <!--Table patient information-->
                    <table class="table table-borderless">
                        <tr>
                            <td colspan="5"><?php echo DomainConst::CONTENT00302; ?></td>
                            <td colspan="10">
                                <i>
                                    <?php echo CommonProcess::convertDateTime(
                                    $model->process_date, DomainConst::DATE_FORMAT_4,
                                    DomainConst::DATE_FORMAT_3); ?>
                                </i>
                            </td>
                            <td colspan="5"><?php echo DomainConst::CONTENT00303; ?></td>
                            <td colspan="8"><i><?php echo DomainConst::CONTENT00304; ?></i></td>
                        </tr>
                        <tr>
                            <?php
                            if ($model->getCustomer() != NULL) {
                                $customer = $model->getCustomer();
                                $customerName = $customer->name;
                                $customerId = $customer->getId();
                                $customerPhone = $customer->getPhone();
                                $customerEmail = $customer->getEmail();
                                $customerAddress = $customer->getAddress();
                                $oldDebt = $customer->debt;
                            }
                            ?>
                            <td colspan="5"><?php echo DomainConst::CONTENT00305; ?></td>
                            <td colspan="10">
                                <i>
                                    <?php echo $customerName; ?>
                                </i>
                            </td>
                            <td colspan="5"><?php echo DomainConst::CONTENT00306; ?></td>
                            <td colspan="8">
                                <i><?php echo $customerId; ?></i>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5"><?php echo DomainConst::CONTENT00307; ?></td>
                            <td colspan="10"><i><?php echo $customerPhone; ?></i></td>
                            <td colspan="5"><?php echo DomainConst::CONTENT00175; ?>:</td>
                            <td colspan="8"><i><?php echo $customerEmail; ?></i></td>
                        </tr>
                        <tr>
                            <td colspan="5"><?php echo DomainConst::CONTENT00308; ?></td>
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
                        <td><b>#</b></td>
                        <td>
                            <b><?php echo DomainConst::CONTENT00309; ?></b><br>
                            (<?php echo DomainConst::CONTENT00310; ?>)
                        </td>
                        <td>
                            <b><?php echo DomainConst::CONTENT00313; ?></b><br>
                            (<?php echo DomainConst::CONTENT00314; ?>)
                        </td>
                        <td>
                            <b><?php echo DomainConst::CONTENT00315; ?></b><br>
                            (<?php echo DomainConst::CONTENT00316; ?>)
                        </td>
                        <td>
                            <b><?php echo DomainConst::CONTENT00317; ?></b><br>
                            (<?php echo DomainConst::CONTENT00318; ?>)
                        </td>
                        <td>
                            <b><?php echo DomainConst::CONTENT00319; ?></b><br>
                            (<?php echo DomainConst::CONTENT00320; ?>)
                        </td>
                        <td>
                            <b><?php echo DomainConst::CONTENT00259; ?></b><br>
                            (<?php echo DomainConst::CONTENT00321; ?>)
                        </td>
                    </tr>
                    <?php
                    $treatment = $model->getTreatmentType();
                    $money = 0;
                    if ($treatment != NULL) {
                        $treatmentName = $treatment->name;
                        $price = $treatment->getPrice();
                        $money = $treatment->price - $model->discount;
                    }
                    $discount = $model->getDiscount();
                    $final = $model->getFinal();
                    $currentDebt = $model->final - $money;
                    // If receptionist accept this receipt before, must rollback value of old debt
                    if ($model->status == Receipts::STATUS_RECEIPTIONIST) {
                        $oldDebt = $oldDebt + $currentDebt;
}
                    ?>
                    <tr>
                        <td>1</td>
                        <td><?php echo $treatmentName; ?></td>
                        <td>1</td>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $discount; ?></td>
                        <td><?php echo CommonProcess::formatCurrency($money) . ' ' . DomainConst::CONTENT00134; ?></td>
                        <td><?php echo $final; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td><b><?php echo DomainConst::CONTENT00322; ?></b></td>
                        <td><?php echo CommonProcess::formatCurrency($money) . ' ' . DomainConst::CONTENT00134; ?></td>
                        <td><?php echo $final; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td><b><?php echo ($currentDebt <= 0) ? DomainConst::CONTENT00323 : DomainConst::CONTENT00324 ?></b></td>
                        <td><?php echo CommonProcess::formatCurrency(abs($currentDebt)) . ' ' . DomainConst::CONTENT00134; ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td><b><?php echo DomainConst::CONTENT00325; ?></b></td>
                        <td><?php echo CommonProcess::formatCurrency($oldDebt) . ' ' . DomainConst::CONTENT00134;; ?></td>
                        <td></td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr>
                <td colspan="31">
                    <table class="table table-borderless">
                        <tr>
                            <td><b><?php echo DomainConst::CONTENT00326; ?></b></td>
                            <td><b><?php echo DomainConst::CONTENT00327; ?></b></td>
                            <td><b><?php echo DomainConst::CONTENT00328; ?></b></td>
                            <td><b><?php echo DomainConst::CONTENT00329; ?></b></td>
                            <td><b><?php echo DomainConst::CONTENT00330; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo DomainConst::CONTENT00331; ?></td>
                            <td><?php echo DomainConst::CONTENT00331; ?></td>
                            <td><?php echo DomainConst::CONTENT00331; ?></td>
                            <td><?php echo DomainConst::CONTENT00331; ?></td>
                            <td><?php echo DomainConst::CONTENT00331; ?></td>
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
                            <td><?php echo $customerName; ?></td>
                            <td><?php echo $userName; ?></td>
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
.table-borderless > tbody > tr > td,
.table-borderless > tbody > tr > th,
.table-borderless > tfoot > tr > td,
.table-borderless > tfoot > tr > th,
.table-borderless > thead > tr > td,
.table-borderless > thead > tr > th {
    border: none !important;
}
</style>
