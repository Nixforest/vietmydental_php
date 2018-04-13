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
                        <tr><td colspan="2">NHA KHOA VIỆT MỸ</td></tr>
                        <tr>
                            <td>Địa chỉ/Address:</td>
                            <td><i>128 Huỳnh Tấn Phát P. Phú Mỹ, Quận 7, TP HCM</i></td>
                        </tr>
                        <tr>
                            <td>Sđt/Phone:</td>
                            <td><i>028.3785.8989</i></td>
                        </tr>
                        <tr>
                            <td>Website:</td>
                            <td><i>nhakhoavietmy.com.vn</i></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!--Row Title-->
            <tr>
                <td colspan="13"></td>
                <td colspan="10" class="align-middle"><font size="6">PHIẾU THU (RECEIPTS)</font></td>
                <td colspan="8">Số/ID: <?php echo $model->getId();?></td>
            </tr>
            <!--Row Patient information-->
            <tr>
                <!--<td colspan="2"></td>-->
                <td colspan="31">
                    <!--Table patient information-->
                    <table class="table table-borderless">
                        <tr>
                            <td colspan="5">Ngày/Date:</td>
                            <td colspan="10">
                                <i>
                                    <?php echo CommonProcess::convertDateTime(
                                    $model->process_date, DomainConst::DATE_FORMAT_4,
                                    DomainConst::DATE_FORMAT_3); ?>
                                </i>
                            </td>
                            <td colspan="5">Hình thức/Type:</td>
                            <td colspan="8"><i>Tiền mặt/Cash</i></td>
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
                            }
                            ?>
                            <td colspan="5">Bệnh nhân/Patient:</td>
                            <td colspan="10">
                                <i>
                                    <?php echo $customerName; ?>
                                </i>
                            </td>
                            <td colspan="5">Mã/Patient code:</td>
                            <td colspan="8">
                                <i><?php echo $customerId; ?></i>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">Điện thoại/Tel:</td>
                            <td colspan="10"><i><?php echo $customerPhone; ?></i></td>
                            <td colspan="5">Email:</td>
                            <td colspan="8"><i><?php echo $customerEmail; ?></i></td>
                        </tr>
                        <tr>
                            <td colspan="5">Địa chỉ/Address:</td>
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
                            <b>Dịch vụ</b><br>
                            (Services)
                        </td>
                        <td>
                            <b>SL</b><br>
                            (Qty)
                        </td>
                        <td>
                            <b>Đơn giá</b><br>
                            (Unit Price)
                        </td>
                        <td>
                            <b>Giảm giá</b><br>
                            (Discount)
                        </td>
                        <td>
                            <b>Thành tiền</b><br>
                            (After discount)
                        </td>
                        <td>
                            <b>Thực thu</b><br>
                            (Actual cost)
                        </td>
                    </tr>
                    <?php
                    $treatment = $model->getTreatmentType();
                    if ($treatment != NULL) {
                        $treatmentName = $treatment->name;
                        $price = $treatment->getPrice();
                        $money = $treatment->price - $model->discount;
                    }
                    $discount = $model->getDiscount();
                    $final = $model->getFinal();
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
                        <td><b>Tổng cộng/Total:</b></td>
                        <td><?php echo CommonProcess::formatCurrency($money) . ' ' . DomainConst::CONTENT00134; ?></td>
                        <td><?php echo $final; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td><b>Còn nợ/Debt:</b></td>
                        <td>0đ</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td><b>Nợ cũ/Old Debt:</b></td>
                        <td>0đ</td>
                        <td></td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr>
                <td colspan="31">
                    <table class="table table-borderless">
                        <tr>
                            <td><b>Bệnh nhân/Patient</b></td>
                            <td><b>Người lập/Creator</b></td>
                            <td><b>Kế toán/Accountant</b></td>
                            <td><b>Thủ quỹ/Cashier</b></td>
                            <td><b>Thủ trưởng/Authorised</b></td>
                        </tr>
                        <tr>
                            <td>(Ký tên/Signature)</td>
                            <td>(Ký tên/Signature)</td>
                            <td>(Ký tên/Signature)</td>
                            <td>(Ký tên/Signature)</td>
                            <td>(Ký tên/Signature)</td>
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
