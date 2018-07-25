<div class="info-content">
    <div class="box-search">
        <form>
            <span class="icon-s" style="top:0;"></span>
            <i class="clr-txt-btn search-area glyphicon glyphicon-remove" style="position: absolute; right: 5px; top: 10px;color:red;"></i>
            <input type="text" class="form-control text-change"  placeholder="<?php echo DomainConst::CONTENT00384?>"
                   id="customer_find">
        </form>
    </div>

    <div class="title-2" id="adv-search-btn" data-toggle="collapse" data-target="#advance-search-ctn">
        <?php echo DomainConst::CONTENT00073; ?>
        <i class="glyphicon glyphicon-chevron-down"></i>
    </div>
    <div class="box-search collapse" id="advance-search-ctn" style="text-align: center;">
        <form style="width: 350px; margin: auto; height: 185px;">
            <div class="form-ctn">
                <i class="left-input-icon glyphicon glyphicon-search" style="position: relative; right: 150px; top: 30px;"></i>
                <i class="clr-txt-btn as-area glyphicon glyphicon-remove" style="position: relative; left: 150px; top: 30px;color:red;"></i>
                <input type="text" class="form-control text-change" placeholder="<?php echo DomainConst::CONTENT00170?>"
                   id="customer_find_phone">
            </div>

            <div class="form-ctn">
                <i class="left-input-icon glyphicon glyphicon-home" style="position: relative; right: 150px; top: 30px;"></i>
                <i class="clr-txt-btn as-area glyphicon glyphicon-remove" style="position: relative; left: 150px; top: 30px;color:red;"></i>
                <input type="text" class="form-control text-change" placeholder="<?php echo DomainConst::CONTENT00045?>"
                   id="customer_find_address">
            </div>

            <div class="form-ctn">
                <i class="left-input-icon glyphicon glyphicon-map-marker" style="right:160px; top: 30px;"></i>
                <select id="customer_find_agent" class="form-control" name="customer_find[agent]" style="width: 350px!important; color: #277aff;">
                    <?php
                    $html = '<option value="" style="color: black">' . DomainConst::CONTENT00385 . '</option>';
                    foreach (Agents::loadItems() as $key => $agent) {
                        $html .= '<option value="' . $key . '"  style="color: black">' . $agent . '</option>';
                    }
                    echo $html;
                    ?>
                </select>
            </div>
        </form>
    </div>
    <div id="customer_info_schedule" class="info-result">
        <div class="group-btn" id="create_customer">
            <?php
                echo CHtml::link(
                        '<i class="glyphicon glyphicon-plus" style="margin-right: 5px;"></i>'
                        . DomainConst::CONTENT00176,
                        '#', array(
                    'style' => 'cursor: pointer;',
                    'onclick' =>''
                    . 'createCustomer();'
                    . ' $("#dialogId").dialog(opt).dialog("open");'
                    . ' return false;',
                ));
            ?>
        </div>
        <div class="content"></div>
    </div>
</div>

<script>
    $(function(){
        fnHandleTextChange(
                "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchCustomerReception'); ?>",
                "#right-content",
                "#right_page_title",
                "<?php echo DomainConst::CONTENT00171 ?>");
    });
    $("body").on("click", "#customer-info tbody tr", function() {
        fnShowCustomerInfo(
                "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/getCustomerInfo'); ?>",
                "#right-content",
                "#right_page_title",
                "<?php echo DomainConst::CONTENT00172 ?>",
                $(this).attr('id'));
    });
    $("#customer_find_agent").change(function() {
        fnSearchCustomerReception(
                "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchCustomerReception'); ?>",
                "#right-content",
                "#right_page_title",
                "<?php echo DomainConst::CONTENT00171 ?>");
    });
    
    /*
     * Customer clear text button at search box and advance search
     * DuongNV
     */
    $(document).on('click', '.clr-txt-btn', function(){
        $(this).siblings('input').val("");
        $(this).css('opacity','0');
    });
    $(document).on('input', '.clr-txt-btn + input', function(){
        if($(this).val() === ''){
            $(this).siblings('i.clr-txt-btn').css('opacity','0');
        } else {
            $(this).siblings('i.clr-txt-btn').css('opacity','1');
        }
    });
    $(document).on('click', '#adv-search-btn', function(){
        var isHidden = $('#adv-search-btn').hasClass('collapsed');
        if(isHidden){
            $('#customer_find_phone').val('');
            $('#customer_find_address').val('');
            $('#customer_find_agent option').eq(0).attr('selected','selectd');
        }
    });
</script>