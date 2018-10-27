<?php
/* @var $model HrWorkPlans */
/* @var $arrEmployee Users[] */
/* @var $arrWorkShifts HrWorkShifts[] */
/* @var $canUpdate boolean */

// Init code    
$colorIdx       = 1;
$employeeIdx    = 1;
$fromDate       = $model->date_from;
$toDate         = $model->date_to;
$period         = CommonProcess::getDatePeriod($fromDate, $toDate);
?>
<div class="wide form">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'    => 'work_schedule_form',
));
?>
    <div class="row">
        <ul class="work_shift">
            <!-- Show all work_shift -->
            <?php foreach ($arrWorkShifts as $workShift) : ?>
            <?php
            $shiftName = $workShift->name;
            $shiftInfo = $workShift->getDetailInfo();
            ?>
            <li class="shift_container shift_color_<?php echo $colorIdx++; ?>"
                data-shift_name="<?php echo $shiftName; ?>"
                data-shift_id="<?php echo $workShift->id; ?>"
                data-shift_color="<?php echo $workShift->getColorValue(); ?>"
                draggable="true"
                style="background-color: <?php echo $workShift->getColorValue(); ?>;">
                <?php echo $shiftInfo; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Table work schedule -->
            <table id="tbl_work_schedule" class="table_work_schedule table-bordered" align="center">
                <thead>
                    <tr>
                        <th><?php echo DomainConst::CONTENT00034; ?></th>
                        <th><?php echo DomainConst::CONTENT00490; ?></th>
                        <?php
                        foreach ($period as $dt) :
                            $date       = $dt->format('d');
                            $wd         = CommonProcess::getWeekDay($dt->format('w'));
                            $columnName = $date . '<br>' . $wd;
                        ?>
                        <th class="wday <?php echo CommonProcess::isWeekend($wd) ? 'weekend' : ''; ?>"><?php echo $columnName; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($arrEmployee as $employee) : ?>
                    <tr>
                        <td><?php echo $employeeIdx++; ?></td>
                        <td><?php echo $employee->getFullName(); ?></td>
                        <?php
                        foreach ($period as $dt) :
                            $date   = $dt->format(DomainConst::DATE_FORMAT_10);
                            $wd     = CommonProcess::getWeekDay($dt->format('w'));
                            if ($canUpdate) {
                                $arrStatus = array(
                                    HrWorkSchedules::STATUS_ACTIVE,
                                    HrWorkSchedules::STATUS_APPROVED,
                                );
                            } else {
                                $arrStatus = array(
                                    HrWorkSchedules::STATUS_APPROVED,
                                );
                            }
                            $mWorkShift = HrWorkSchedules::getWorkShift($employee->id, $dt->format(DomainConst::DATE_FORMAT_DB), $arrStatus);
                            
                        ?>
                        <td class="cell_container <?php echo CommonProcess::isWeekend($wd) ? 'weekend' : ''; ?>"
                            data-date="<?php echo $date; ?>"
                            data-id="<?php echo $employee->id; ?>">
                            <?php
                            if ($mWorkShift != NULL) :
                                $inputValue = "[$mWorkShift->id,$date,$employee->id]";
                            ?>
                            <div class="shift_container shift_cell alreadyIn"
                                 data-shift_id="<?php echo $mWorkShift->id; ?>"
                                 data-shift_name="<?php echo $mWorkShift->name; ?>"
                                 data-shift_color="<?php echo $mWorkShift->getColorValue(); ?>"
                                 data-date="<?php echo $date; ?>"
                                 data-id="<?php echo $employee->id; ?>"
                                 draggable="true"
                                 style="background-color: <?php echo $mWorkShift->getColorValue(); ?>;">
                                <?php echo DomainConst::SPACE; ?>
                                <input type="hidden" name="HrWorkSchedules[data][]" value="<?php echo $inputValue; ?>">
                            </div>
                            <?php
                            endif;
                            ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row buttons" style="<?php echo $canUpdate ? '' : 'display: none;' ?>">
        <?php echo CHtml::submitButton(DomainConst::CONTENT00377); ?>
    </div>
<?php $this->endWidget(); ?>
</div>  <!-- Close <div class="wide form"> -->
<script type="text/javascript">
    $(document).ready(function() {
        wsallowDrag("shift_container", "cell_container", "shift_id");
    });
</script>