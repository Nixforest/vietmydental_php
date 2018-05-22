<?php
/* @var $this CustomerController */
/* @var $model Customers */
//echo $model->name;
?>
<div class="maincontent-2 clearfix">
    <!-- Medical record -->
    <div class="title-1">
        <span class="icon10"></span> <?php echo DomainConst::CONTENT00138; ?>
    </div>
    <div class="profile__info">
        <div class="row">
            <div class="col-md-4">
                <div class="profile__item">
                    <div class="profile__img">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/tempt/img1.jpg" alt="">
                    </div>
                    <div class="profile__des">
                        <div class="p-item">
                            <span class="icon-p icon-11"></span>
                            <span class="p-info">
                                <strong><?php echo DomainConst::CONTENT00100; ?>:</strong> <?php echo $model->name; ?></span>
                        </div>
                        <div class="p-item">
                            <span class="icon-p icon-12"></span>
                            <span class="p-info">
                                <strong><?php echo DomainConst::CONTENT00101; ?>:</strong> <?php echo $model->getBirthday(); ?></span>
                        </div>
                        <div class="p-item">
                            <span class="icon-p icon-13"></span>
                            <span class="p-info">
                                <strong><?php echo DomainConst::CONTENT00047; ?>:</strong> <?php echo CommonProcess::getGender()[$model->gender]; ?></span>
                        </div>
                        <div class="p-item">
                            <span class="icon-p icon-14"></span>
                            <span class="p-info">
                                <strong><?php echo DomainConst::CONTENT00277; ?>:</strong> <?php echo $model->getMedicalRecordNumber(); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="title-1">
                    <span class="icon15"></span> <?php echo DomainConst::CONTENT00276; ?>
                </div>
                <div class="p-add-info">
                    <div class="p-item">
                        <span class="icon-p icon-16"></span>
                        <span class="p-info">
                            <strong><?php echo DomainConst::CONTENT00045; ?>:</strong> <?php echo $model->getAddress(); ?></span>
                    </div>
                    <div class="p-item">
                        <span class="icon-p icon-17"></span>
                        <span class="p-info">
                            <strong><?php echo DomainConst::CONTENT00048; ?>: </strong> <?php echo $model->getPhone(); ?></span>
                    </div>
                    <div class="p-item">
                        <span class="icon-p icon-18"></span>
                        <span class="p-info">
                            <strong><?php echo DomainConst::CONTENT00175; ?>:</strong> <?php echo $model->getEmail(); ?></span>
                        <!--<a href="#">(Xem Thêm)</a>-->
                    </div>
                </div>
                <div class="p-add-g clearfix">
                    <div class="p-add-1">
                        <div class="title-1">
                            <span class="icon19"></span> <?php echo DomainConst::CONTENT00202; ?>
                        </div>
                        <div class="p-add-info">
                            <?php if (isset($model->rMedicalRecord)): ?>
                                <?php foreach ($model->rMedicalRecord->rJoinPathological as $value): ?>
                                <?php if (isset($value->rPathological)): ?>
                                <div class="p-item">
                                    <span class="icon-p icon-20"></span>
                                    <span class="p-info"><?php echo $value->rPathological->name; ?></span>
                                </div>
                                <?php endif; // end if ($value->rPathological) ?>
                                <?php endforeach; // end foreach ($model->rMedicalRecord->rJoinPathological as $value) ?>
                            <?php endif; // end if (isset($model->rMedicalRecord)) ?>
                            <!--<a href="#">(Xem Thêm)</a>-->
                        </div>
                    </div>
                    <div class="p-add-1">
                        <div class="title-1">
                            <span class="icon21"></span> <?php echo DomainConst::CONTENT00278; ?>
                        </div>
                        <div class="p-add-info">
                            <div class="p-item">
                                <span class="icon-p icon-22"></span>
                                <span class="p-info">
                                    <strong><?php echo DomainConst::CONTENT00143; ?>:</strong> <?php echo $schedule->getDoctor(); ?></span>
                            </div>
                            <?php if ($schedule->getSale() != NULL): ?>
                            <div class="p-item">
                                <span class="icon-p icon-23"></span>
                                <span class="p-info">
                                    <strong><?php echo DomainConst::CONTENT00279; ?>:</strong> <?php echo $schedule->getSale()->getFullname(); ?></span>
                            </div>
                            <?php endif; // end if (isset($schedule->getSale())) ?>
                            
                            <div class="p-item">
                                <span class="icon-p icon-24"></span>
                                <span class="p-info">
                                    <strong><?php echo DomainConst::CONTENT00199; ?>:</strong> <?php echo $model->getAgentName(); ?> </span>
                            </div>
                            <!--<a href="#">(Xem Thêm)</a>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Medical record -->
    <!-- List of treatment -->
    <div class="row list__1">
        <div class="col-md-6">
            <div class="list__2">
                <div class="title-1">
                    <span class="icon25"></span> <?php echo DomainConst::CONTENT00280; ?>
                </div>
                <div class="list__2__info" id="treatment_schedule-info">
                    <?php foreach ($treatment as $value): ?>
                    <div class="list__2__des" id="<?php echo $value->id; ?>">
                        <div class="list__2__item">
                            <span class="icon26 icon-list"></span>
                            <p>
                                <strong><?php echo $value->getTreatmentInfo(); ?></strong>
                            </p>
                            <p><?php echo $value->getStartTime(); ?></p>
                        </div>
                    </div>
                    <?php endforeach; // end foreach ($treatment as $value) ?>
                    <!--<a href="#">(Xem Thêm)</a>-->
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="list__2">
                <div class="title-1">
                    <span class="icon27"></span> <?php echo DomainConst::CONTENT00174; ?>
                </div>
                <div class="list__2__info" id="treatment_schedule_detail-info">
<!--                    <div class="list__2__des">
                        <div class="list__2__item">
                            <span class="icon28 icon-list"></span>
                            <p>
                                <strong>Lịch Điều Trị</strong>
                            </p>
                            <p>Ngày Bắt Đầu: 9:30 AM - 26/03/2018
                                <br/> Ngày Kết Thúc: 10:30 AM - 26/04/2018</p>
                        </div>
                    </div>
                    <div class="list__2__des">
                        <div class="list__2__item">
                            <span class="icon29 icon-list"></span>
                            <p>
                                <strong>Răng Số: </strong>
                            </p>
                            <p>2 Hàm</p>
                        </div>
                    </div>
                    <div class="list__2__des">
                        <div class="list__2__item">
                            <span class="icon30 icon-list"></span>
                            <p>
                                <strong>Triệu Chứng: </strong>
                            </p>
                            <p>Chảy Máu Chân Răng</p>
                        </div>
                    </div>
                    <div class="list__2__des">
                        <div class="list__2__item">
                            <span class="icon31 icon-list"></span>
                            <p>
                                <strong>Chuẩn Đoán: </strong>
                            </p>
                            <p>Viêm Nha Chu</p>
                        </div>
                    </div>
                    <div class="list__2__des">
                        <div class="list__2__item">
                            <span class="icon32 icon-list"></span>
                            <p>
                                <strong>Loại Điều Trị:</strong>
                            </p>
                            <p>Cạo Vôi Răng - Đánh Bóng 2 Hàm</p>
                        </div>
                    </div>
                    <div class="list__2__des">
                        <div class="list__2__item">
                            <span class="icon33 icon-list"></span>
                            <p>
                                <strong>Bảo Hiểm Thanh Toán:</strong>
                            </p>
                            <p>5.000.000 VND</p>
                        </div>
                    </div>

                    <a href="#">(Xem Thêm)</a>-->
                </div>
            </div>

        </div>
    </div>
    <!-- End List of treatment -->
    <div class="row list__5">
        <div class="col-md-6">

            <div class="list__2">
                <div class="title-1">
                    <span class="icon34"></span> Chi Tiết Thanh Toán
                </div>
                <div class="list__2__info">
                    <?php foreach($model->getReceipts() as $receipt): ?>
                        <div class="list__2__des">
                            <div class="list__2__item">
                                <span class="icon26 icon-list"></span>
                                <p>
                                    <strong>Thanh Toán Lần 1: </strong>
                                </p>
                                <p><?php echo CommonProcess::formatCurrency($receipt->final); ?> (Ngày Thanh Toán: <?php echo $receipt->process_date; ?>)</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <!--<a href="#">(Xem Thêm)</a>-->
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="list__2">
                <div class="title-1">
                    <span class="icon35"></span> Tiến Trình Điều Trị

                </div>
                <div class="list__2__info">
                    <div class="list__2__des">
                        <div class="list__2__item">
                            <span class="icon26 icon-list"></span>
                            <p>
                                <strong>Thanh Toán Lần 1: </strong>
                            </p>
                            <p>5.000.000 VND (Ngày Thanh Toán: 26/03/2018)</p>
                        </div>
                    </div>
                    <div class="list__2__des">
                        <div class="list__2__item">
                            <span class="icon26 icon-list"></span>
                            <p>
                                <strong>Thanh Toán Lần 1: </strong>
                            </p>
                            <p>5.000.000 VND (Ngày Thanh Toán: 26/03/2018)</p>
                        </div>
                    </div>
                    <div class="list__2__des">
                        <div class="list__2__item">
                            <span class="icon26 icon-list"></span>
                            <p>
                                <strong>Thanh Toán Lần 1: </strong>
                            </p>
                            <p>5.000.000 VND (Ngày Thanh Toán: 26/03/2018)</p>
                        </div>
                    </div>
                    <a href="#">(Xem Thêm)</a>
                </div>
            </div>
        </div>
    </div>
    <div class="list__3">
        <div class="title-1">
            <span class="icon36"></span> Hình Ảnh Điều Trị
        </div>
        <div class="list__3__info">
            <div class="row">
                <div class="col-md-6">
                    <p>Hình Ảnh Trước Và Sau Điều Trị</p>
                    <div class="list__3__img">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/img2.jpg">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/img2.jpg">
                    </div>
                </div>
                <div class="col-md-6">
                    <p>Hình Ảnh Chụp XQuang</p>
                    <div class="list__3__img">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/img2.jpg">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/img2.jpg">
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="list__4">
        <div class="row">
            <div class="col-md-6">
                <div class="title-1">
                    <span class="icon37"></span> Bảo Hành
                </div>
                <div class="list__3__info">
                    <p><strong>Thời Gian Bảo Hành</strong>: 3 Năm
                        <br/> <strong>Ngày Bắt Đầu:</strong> 9:30 AM - 26/03/2018
                        <br/> <strong>Ngày Kết Thúc:</strong> 10:30 AM - 26/04/2018
                        <br/> <strong>Thời Gian Còn Lại</strong>: 365 Ngày</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="title-1">
                    <span class="icon38"></span> Lịch Hẹn Tái Khám
                </div>
                <div class="list__3__info">
                    <p><strong>Thời Gian Bảo Hành</strong>: 3 Năm
                        <br/> <strong>Ngày Bắt Đầu:</strong> 9:30 AM - 26/03/2018
                        <br/> <strong>Ngày Kết Thúc:</strong> 10:30 AM - 26/04/2018
                        <br/> <strong>Thời Gian Còn Lại</strong>: 365 Ngày</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("body").on("click", "#treatment_schedule-info .list__2__des", function() {
//        alert($(this).attr('id'));
        fnShowTreatmentScheduleDetailInfo(
                "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/getTreatmentScheduleDetailInfo'); ?>",
                $(this).attr('id'),
                "#treatment_schedule_detail-info"
                );
    });
</script>