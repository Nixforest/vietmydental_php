<?php
/* @var $this CustomerController */
/* @var $model Customers */
//echo $model->name;
?>

<div class="container" style="width: 100%; padding: 0!important;">
    <!-- Medical record -->
    <div class="lp-parent-container">
        <div class="lp-parent-title">
            <h3><i class="fas fa-id-card"></i> <?php echo DomainConst::CONTENT00138; ?></h3>
        </div>

        <div class="row row-eq-height lp-row">
            <!--Thong tin benh nhan-->
            <div class="lp-child-container col-md-7">
                <div class="lp-child-title">
                    <h4><i class="fas fa-id-card-alt"></i> <?php echo DomainConst::CONTENT00172; ?></h4>
                </div>
                <div class="lp-child-content">
                    <div class="lp-profile-img">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/tempt/img2.jpg" alt="">
                    </div>
                    <div class="lp-content-row">
                        <i class="fas fa-user" title="<?php echo DomainConst::CONTENT00100; ?>"></i>
                        <span class="lp-txt">
                            <?php echo $model->name; ?>
                        </span>
                    </div>
                    <div class="lp-content-row">
                        <i class="fas fa-birthday-cake" title="<?php echo DomainConst::CONTENT00101; ?>"></i>
                        <span class="lp-txt">
                            <?php echo $model->getBirthday(); ?>
                        </span>
                    </div>
                    <div class="lp-content-row">
                        <i class="fas fa-transgender" title="<?php echo DomainConst::CONTENT00047; ?>"></i>
                        <span class="lp-txt">
                            <?php echo CommonProcess::getGender()[$model->gender]; ?>
                        </span>
                    </div>
                    <div class="lp-content-row">
                        <i class="fas fa-id-card" title="<?php echo DomainConst::CONTENT00277; ?>"></i>
                        <span class="lp-txt">
                            <?php echo $model->getMedicalRecordNumber(); ?>
                        </span>
                    </div>
                    <div class="lp-content-row">
                        <i class="fas fa-map-marker-alt" title="<?php echo DomainConst::CONTENT00045; ?>"></i>
                        <span class="lp-txt">
                            <?php echo $model->getAddress(); ?>
                        </span>
                    </div>
                    <div class="lp-content-row">
                        <i class="fas fa-phone" title="<?php echo DomainConst::CONTENT00048; ?>"></i>
                        <span class="lp-txt">
                            <?php echo $model->getPhone(); ?>
                        </span>
                    </div>
                    <div class="lp-content-row">
                        <i class="fas fa-envelope" title="<?php echo DomainConst::CONTENT00175; ?>"></i>
                        <span class="lp-txt">
                            <?php echo $model->getEmail(); ?>
                        </span>
                        <!--<a href="#">(Xem Thêm)</a>-->
                    </div>
                    <div class="clrfix"></div>
                </div>
            </div>

            <!--Thong tin lien quan-->
            <div class="lp-child-container col-md-5" style="margin-top:0">
                <div class="row">
                    <div class="lp-child-container col-md-12">
                        <div class="lp-child-title">
                            <h4><i class="fas fa-plus"></i> <?php echo DomainConst::CONTENT00278; ?></h4>
                        </div>
                        <div class="lp-child-content">
                            <div class="lp-content-row">
                                <i class="fas fa-user-md" title="<?php echo DomainConst::CONTENT00143; ?>"></i>
                                <span class="lp-txt">
                                    <?php echo $schedule->getDoctor(); ?>
                                </span>
                            </div>
                            <?php if ($schedule->getSale() != NULL): ?>
                                <div class="lp-content-row">
                                    <i class="fas fa-user-plus" title="<?php echo DomainConst::CONTENT00279; ?>"></i>
                                    <span class="lp-txt">
                                        <?php echo $schedule->getSale()->getFullname(); ?>
                                    </span>
                                </div>
                            <?php endif; // end if (isset($schedule->getSale())) ?>

                            <div class="lp-content-row">
                                <i class="fas fa-code-branch" title="<?php echo DomainConst::CONTENT00199; ?>"></i>
                                <span class="lp-txt">
                                    <?php echo $model->getAgentName(); ?> 
                                </span>
                            </div>
                            <!--<a href="#">(Xem Thêm)</a>-->
                        </div>
                    </div>

                    <div class="lp-child-container col-md-12">
                        <!--Thong tin tien su benh-->
                        <div class="lp-child-title">
                            <h4><i class="fas fa-history"></i> <?php echo DomainConst::CONTENT00202; ?></h4>
                        </div>
                        <div class="lp-list-container">
                            <!--for test-->
                            <!--                            <div class="lp-list-item">
                                                            <i class="fas fa-angle-right lp-list-item-icon"></i>
                                                            <b>Tiểu đường</b>
                                                        </div>end for test-->
                            <?php if (isset($model->rMedicalRecord)): ?>
                                <?php foreach ($model->rMedicalRecord->rJoinPathological as $value): ?>
                                    <?php if (isset($value->rPathological)): ?>
                                        <div class="lp-list-item">
                                            <i class="fas fa-angle-right lp-list-item-icon"></i>
                                            <b><?php echo $value->rPathological->name; ?></b>
                                        </div>
                                    <?php endif; // end if ($value->rPathological) ?>
                                <?php endforeach; // end foreach ($model->rMedicalRecord->rJoinPathological as $value) ?>
                            <?php endif; // end if (isset($model->rMedicalRecord)) ?>
                            <!--<a href="#">(Xem Thêm)</a>-->
                        </div>
                    </div>
                </div>
            </div>
        </div><!--End row-->

        <!--Tab-->
        <div class="lp-tab-container">
            <div class="row row-eq-height lp-row">
                <div class="container-fluid">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#treatment-list"><i class="fas fa-list-ol"></i> <?php echo DomainConst::CONTENT00280; ?></a></li>
                        <li><a data-toggle="tab" href="#treatment-time"><i class="fas fa-calendar-check"></i> <?php echo DomainConst::CONTENT00174; ?></a></li>
                        <li><a data-toggle="tab" href="#payment-detail"><i class="fas fa-credit-card"></i> <?php echo DomainConst::CONTENT00256; ?></a></li>
                        <li><a data-toggle="tab" href="#treatment-process"><i class="fas fa-sliders-h"></i> Tiến Trình Điều Trị</a></li>
                        <li><a data-toggle="tab" href="#treatment-picture"><i class="fas fa-images"></i> Hình Ảnh Điều Trị</a></li>
                        <li><a data-toggle="tab" href="#guarantee"><i class="fas fa-shield-alt"></i> Bảo Hành</a></li>
                        <li><a data-toggle="tab" href="#retreatment-schedule"><i class="fas fa-calendar-alt"></i> Lịch Hẹn Tái Khám</a></li>
                    </ul>

                    <div class="tab-content">
                        <!--Danh sach dieu tri -->
                        <div id="treatment-list" class="tab-pane fade in active">
                            <h3><?php echo DomainConst::CONTENT00280; ?></h3>
                            <div class="lp-list-container" id="treatment_schedule-info">
                                <?php $treatmentCnt = count($treatment); ?>
                                <?php foreach ($treatment as $value): ?>
                                    <?php
                                    $title = 'Đợt ' . $treatmentCnt-- . ': ' . $value->getStartTime();
                                    $info = '';
                                    if (isset($value->rDetail) && (count($value->rDetail) > 0)) {
                                        $info = $value->rDetail[0]->getTreatmentInfo();
                                    }
                                    ?>
                                    <div class="lp-list-item" id="<?php echo $value->id; ?>">
                                        <i class="fas fa-list-ol lp-list-item-icon"></i>
                                        <strong><?php echo $title; ?></strong><br>
                                        <span><?php echo $info; ?></span>
                                    </div>
                                <?php endforeach; // end foreach ($treatment as $value) ?>
                                <!--<a href="#">(Xem Thêm)</a>-->
                            </div>
                        </div>
                        <!--Lan dieu tri -->
                        <div id="treatment-time" class="tab-pane fade">
                            <h3><?php echo DomainConst::CONTENT00174; ?></h3>
                            <div class="lp-list-container" id="treatment_schedule_detail-info">
                                <?php
                                if (count($treatment) > 0) {
                                    $retVal = $treatment[0]->getHtmlTreatmentDetail();
                                    echo $retVal;
                                }
                                ?>

                                <!--<a href="#">(Xem Thêm)</a>-->
                            </div>
                        </div>
                        <!--Chi tiet thanh toan -->
                        <div id="payment-detail" class="tab-pane fade">
                            <h3><?php echo DomainConst::CONTENT00256; ?></h3>
                            <div class="lp-list-container">
                                <?php $idx = 1; ?>
                                <?php foreach ($model->getReceipts() as $receipt): ?>
                                    <div class="lp-list-item">
                                        <i class="fas fa-credit-card lp-list-item-icon"></i>
                                        <strong>Thanh Toán Lần <?php echo $idx++; ?>: </strong><br>
                                        <span><?php echo CommonProcess::formatCurrency($receipt->final); ?> (Ngày Thanh Toán: <?php echo $receipt->process_date; ?>)</span>
                                    </div>
                                <?php endforeach; ?>
                                <!--<a href="#">(Xem Thêm)</a>-->
                            </div>
                        </div>
                        <!--Qua trinh dieu tri -->
                        <div id="treatment-process" class="tab-pane fade">
                            <h3>Tiến Trình Điều Trị</h3>
                            <!--                        <div class="list__2__info">
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
                                                    </div>-->
                        </div>
                        <!--Hinh anh dieu tri -->
                        <div id="treatment-picture" class="tab-pane fade" style="padding: 10px 15px!important">
                            <h3>Hình Ảnh Điều Trị</h3>
                            <div class="orbit-spinner loading"> 
                                <div class="orbit"></div>
                                <div class="orbit"></div>
                                <div class="orbit"></div>
                            </div>
                            <div class="lp-child-container">
                                <div class="row">
                                    <table style="width:100%" border="1">
                                        <tr>
                                            <th style="width:10%">Lần điều trị</th>
                                            <th style="width:45%">Hình ảnh thực</th>
                                            <th style="width:45%">X-Quang</th>
                                        </tr>
                                        <tr>
                                            <td id="img-title-container">
    
                                    <?php foreach ($treatment as $item) : ?>
                                        <?php if (isset($item->rDetail)) : ?>
                                            <?php foreach ($item->rDetail as $detail): ?>
                                                <?php if (count($detail->rImgRealFile) || count($detail->rImgXRayFile)) : ?>
                                                    <?php
                                                    $info = '';
                                                    if (isset($detail->rTreatmentType)) {
                                                        $info = $detail->rTreatmentType->name;
                                                    } else if (isset($detail->rDiagnosis)) {
                                                        $info = $detail->rDiagnosis->name;
                                                    } else {
                                                        $info = DomainConst::CONTENT00177;
                                                    }
                                                    ?>
        
                                                <p class="btn btn-primary get-img-btn" data-id="<?php echo $detail->id ?>" style="margin: 10px 0;"><?php echo $detail->getStartTime() . ' - ' . $info; ?></p>
                                                        
                                                    <?php 
//                                                     if (count($detail->rImgRealFile)) :
//                                                        $listOldImage = array_reverse($detail->rImgRealFile);
//                                                        $index = 1;
                                                        ?>
<!--                                                        <div class="lp-list-image">
                                                            <span class="prev-img">&#10094;</span>
                                                            <span class="next-img">&#10095;</span>-->
                                                            <?php
//                                                            foreach ($listOldImage as $img) : 
//                                                                echo $img->getViewImage(200, 300);
//                                                            endforeach;
                                                            ?>
                                                        <!--</div>-->
                                                    <?php // endif; ?>
                                        
                                                        <?php 
//                                                        if (count($detail->rImgXRayFile)) :
//                                                            $listOldImage = array_reverse($detail->rImgXRayFile);
//                                                            $index = 1;
                                                            ?>
<!--                                                            <div class="lp-list-image">
                                                                <span class="prev-img">&#10094;</span>
                                                                <span class="next-img">&#10095;</span>-->
                                                                <?php 
//                                                                foreach ($listOldImage as $img) :
//                                                                    echo $img->getViewImage(200, 300);
//                                                                endforeach; 
                                                                ?>
                                                            <!--</div>-->
                                                        <?php // endif; ?>
                                                
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                            </td>
                                            <td class="img-real-container"></td>
                                            <td class="img-xquang-container"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--Bao hanh -->
                        <div id="guarantee" class="tab-pane fade">
                            <h3>Bảo Hành</h3>
                            <div class="lp-text-content">
                                <?php
                                $html = '';
                                if (isset($model->rWarranty)) {
                                    foreach ($model->rWarranty as $warranty) {
                                        if (isset($warranty->rType)) {
                                            
                                        }
                                        $html .= '<p>';
                                        $html .= '<i class="fas fa-angle-double-right"></i> ';
                                        $html .= '<strong>';
                                        $html .= $warranty->rType->name . ' - ' . DomainConst::CONTENT00381 . ': ';
                                        $html .= '</strong>' . $warranty->getWarrantyTime();
                                        $html .= '<br/><i class="fas fa-calendar-plus" title="' . DomainConst::CONTENT00139.'"></i> ';
                                        $html .= $warranty->getStartTime();
                                        $html .= '<br/><i class="fas fa-calendar-minus" title="' . DomainConst::CONTENT00140.'"></i> ';
                                        $html .= $warranty->getEndTime();
                                        $html .= '<br/><i class="fas fa-stopwatch" title="' . DomainConst::CONTENT00382.'"></i> ';
                                        $html .= $warranty->getRemainTime();
                                        $html .= '</p>';
                                    }
                                }
                                echo $html;
                                ?>
                            </div>
                        </div>
                        <!--Lich tai kham -->
                        <div id="retreatment-schedule" class="tab-pane fade">
                            <h3>Lịch Hẹn Tái Khám</h3>
                            <div class="lp-text-content">
                                <p>
                                    <i class="fas fa-angle-double-right"></i> 
                                    <strong>Thời Gian Bảo Hành: 3 Năm </strong><br>
                                    <i class="fas fa-calendar-plus" title="Ngày bắt đầu"></i> 
                                    9:30 AM - 26/03/2018<br>
                                    <i class="fas fa-calendar-minus" title="Ngày kết thúc"></i>
                                    10:30 AM - 26/04/2018<br>
                                    <i class="fas fa-stopwatch" title="Thời gian còn lại"></i> 
                                    365 Ngày<br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--End tab-->
    </div><!--End medical record-->
</div>


<script>
    //inport font awesome
    $('head').append('<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">');
    $("body").on("click", "#treatment_schedule-info .lp-list-item", function () {
//        alert($(this).attr('id'));
        fnShowTreatmentScheduleDetailInfo(
                "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/getTreatmentScheduleInfo'); ?>",
                $(this).attr('id'),
                "#treatment_schedule_detail-info"
                );
    });
    
    //Slide
    $('.lp-list-image').on('click', '.prev-img', function(){
        clickSlide('prev', $(this));
    })
    $('.lp-list-image').on('click', '.next-img', function(){
        clickSlide('next', $(this));
    })
    
    function clickSlide(type, elm){
        var firstAImg = elm.siblings('a.gallery').first();
        var aImgWidth = firstAImg.width();
        var imgLink = elm.parent().children('a.gallery');
        var maxLength = parseInt(imgLink.length*aImgWidth);
        var curLength = parseInt(elm.parent().width());
        
        var maxMr = 41;
        var coef = 1;
        if(type == 'prev') {
            maxMr = parseInt(curLength - maxLength - 50);
            coef = -1;
        }
        
        var curMr = firstAImg.css('margin-left');
        curMr = parseInt(curMr.replace('px', ''));
        
        if(curMr*coef <= maxMr*coef){
            var mr = curMr + 150*coef;
            if(maxMr*coef-(curMr*coef+150) <= 0){
                mr = maxMr;
            }
            firstAImg.css('margin-left', mr + 'px');
        }
    }
    
    $('.get-img-btn').on('click', function(e){
        var id = $(e.target).data('id');
        $('.loading').css('opacity', '1');
        $.ajax({
           'url': '<?php echo Yii::app()->createAbsoluteUrl('front/customer/getTreatmentImageAjax') ?>'+'/id/'+id,
           'type': 'get',
           'success': function(html){
                $('.loading').css('opacity', '0');
                $(".img-real-container").remove();
                $(".img-xquang-container").remove();
                $('#img-title-container').after(html);
                $('.lp-list-image').on('click', '.prev-img', function(){
                    clickSlide('prev', $(this));
                })
                $('.lp-list-image').on('click', '.next-img', function(){
                    clickSlide('next', $(this));
                })
           }
        });
    })
</script>
