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
            $shiftInfo = $workShift->getInfo();
            ?>
            <li class="shift_container shift_color_<?php echo $colorIdx++; ?>"
                data-shift_name="<?php echo $shiftName; ?>"
                data-shift_id="<?php echo $workShift->id; ?>"
                draggable="true">
                <?php echo $shiftInfo; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
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
                        ?>
                        <td class="cell_container <?php echo CommonProcess::isWeekend($wd) ? 'weekend' : ''; ?>"
                            data-date="<?php echo $date; ?>"
                            data-id="<?php echo $employee->id; ?>">
                            <?php echo ''; ?>
                        </th>
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