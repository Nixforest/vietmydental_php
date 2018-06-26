<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$arrTeeth = CommonProcess::getListTeeth(false, '');
$labelStyle = "padding-top: 0px; width: auto; float: center;";
?>
<table>
    <tr>
        <td>Răng người lớn: </td>
        <td>
<!--            Check group of teeth-->
            <div colspan='2' class="adults">
                <label class="container gr1">Nhóm 1
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="container gr2">Nhóm 2
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="container gr3">Nhóm 3
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="container gr4">Nhóm 4
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
            </div><!-- end check gr -->
            
            <table border="1" class='teeth-tbl'>
                <tr>
                <?php foreach ($arrTeeth as $key => $teeth): ?>
                    <?php if ($key >= 0 && $key <= 15): ?>
                    <?php
                        $inputId = "teeth_" . $key;
                        $inputName = "teeth" . '[' . $key . ']';
                        $checked = "";
                        if (in_array($key, $selectedTeeth)) {
                            $checked = 'checked="checked"';
                        }
                    ?>
                    <td>
                        <input
                            style ='display: none'
                            name="<?php echo $inputName ?>"
                            value="1"
                            type="checkbox"
                            id="<?php echo $inputId ?>"
                            <?php echo $checked; ?>
                            >
                            <?php echo $teeth; ?>
                    </td>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tr>
                
                <tr>
                <?php foreach ($arrTeeth as $key => $teeth): ?>
                    <?php if ($key >= 16 && $key <= 31): ?>
                    <?php
                        $inputId = "teeth_" . $key;
                        $inputName = "teeth" . '[' . $key . ']';
                        $checked = "";
                        if (in_array($key, $selectedTeeth)) {
                            $checked = 'checked="checked"';
                        }
                    ?>
                    <td>
                        <input
                            style ='display: none'
                            name="<?php echo $inputName ?>"
                            value="1"
                            type="checkbox"
                            id="<?php echo $inputId ?>"
                            <?php echo $checked; ?>
                            >
                            <?php echo $teeth; ?>
                    </td>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>Răng trẻ em: </td>
        <td>
            <!--            Check group of teeth-->
            <div colspan='2' class="children">
                <label class="container gr5">Nhóm 5
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="container gr6">Nhóm 6
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="container gr7">Nhóm 7
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="container gr8">Nhóm 8
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
            </div><!-- end check gr -->
            <table border="1" class='teeth-tbl'>
                <tr>
                <?php foreach ($arrTeeth as $key => $teeth): ?>
                    <?php if ($key >= 32 && $key <= 41): ?>
                    <?php
                        $inputId = "teeth_" . $key;
                        $inputName = "teeth" . '[' . $key . ']';
                        $checked = "";
                        if (in_array($key, $selectedTeeth)) {
                            $checked = 'checked="checked"';
                        }
                    ?>
                    <td>
                        <input
                            style='display: none'
                            name="<?php echo $inputName ?>"
                            value="1"
                            type="checkbox"
                            id="<?php echo $inputId ?>"
                            <?php echo $checked; ?>
                            >
                            <?php echo $teeth; ?>
                    </td>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tr>
                
                <tr>
                <?php foreach ($arrTeeth as $key => $teeth): ?>
                    <?php if ($key >= 42 && $key <= 51): ?>
                    <?php
                        $inputId = "teeth_" . $key;
                        $inputName = "teeth" . '[' . $key . ']';
                        $checked = "";
                        if (in_array($key, $selectedTeeth)) {
                            $checked = 'checked="checked"';
                        }
                    ?>
                    <td>
                        <input
                            style='display: none'
                            name="<?php echo $inputName ?>"
                            value="1"
                            type="checkbox"
                            id="<?php echo $inputId ?>"
                            <?php echo $checked; ?>
                            >
                            <?php echo $teeth; ?>
                    </td>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!--DUONG-->
<script>
    function check(index){
        $('.teeth-tbl td').eq(index).addClass('grey');
        $('.teeth-tbl td').eq(index).find('input').prop('checked', true)
    }
    function uncheck(index){
        $('.teeth-tbl td').eq(index).removeClass('grey');
        $('.teeth-tbl td').eq(index).find('input').prop('checked', false)
    }
</script>
<script>
    var style = '<style>'+
                    '.grey{background: #eaeaea;}'+
                    '.teeth-tbl{user-select: none;}'+
                    '.container {width:150px;display: block;position: relative;padding-left: 35px;margin-bottom: 12px;cursor: pointer;font-size: 15px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;}'+
                    '.container input {position: absolute;opacity: 0;cursor: pointer;}'+
                    '.checkmark {position: absolute;top: 0;left: 0;height: 25px;width: 25px;background-color: #eee;}'+
                    '.container:hover input ~ .checkmark {background-color: #ccc;}'+
                    '.container input:checked ~ .checkmark {background-color: #2196F3;}'+
                    '.checkmark:after {content: "";position: absolute;display: none;}'+
                    '.container input:checked ~ .checkmark:after {display: block;}'+
                    '.container .checkmark:after {left: 9px;top: 5px;width: 5px;height: 10px;border: solid white;border-width: 0 3px 3px 0;-webkit-transform: rotate(45deg);-ms-transform: rotate(45deg);transform: rotate(45deg);}'+
                '</style>';
    $('head').append(style);
    var els = $('.teeth-tbl td');
    var flag;
    var num_td = $('.teeth-tbl td').length;
    var num_td_in_tr =  num_td / $('.teeth-tbl tr').length;
    for(i=0; i < num_td; i++) {
        els[i].index = i;
    }
    var start = -1, end = -1;
    $('.teeth-tbl td').on('click', function(){
        $(this).toggleClass('grey');
        $(this).find('input').prop('checked', !$(this).find('input').prop("checked"))
    })
    //drag to choose teeth
//    $('.teeth-tbl td').on('mousedown', function(e){
//        flag = true;
//        start = e.target.index;
//    })
//    $(document).on('mouseup', function(e){
//        flag = false;
//    })
//    $('.teeth-tbl').on('mouseover', function(e){
//        if(flag){
//            end = e.target.index;
//            var distance = end - start - num_td_in_tr + 1;
//            var els_tr = $('.teeth-tbl tr');
//            for(var i = 0; i < num_td; i++){
//                $('input').prop('checked',false);
//                $('.teeth-tbl td').eq(i).removeClass('grey');
//            }
//            for(var i = 0; i < distance; i++){
//                $('.teeth-tbl td').eq([parseInt(start+i)]).addClass('grey');
//                $('.teeth-tbl td').eq([parseInt(start+i)]).find('input').prop('checked',true);
//                $('.teeth-tbl td').eq([parseInt(end-i)]).addClass('grey');
//                $('.teeth-tbl td').eq([parseInt(end-i)]).find('input').prop('checked',true);
//            }
//            if(distance <= 0){
//                for(var i = 0; i < end-start+1; i++){
//                    $('.teeth-tbl td').eq([parseInt(start+i)]).addClass('grey');
//                    $('.teeth-tbl td').eq([parseInt(start+i)]).find('input').prop('checked',true);
//                }
//            }
//        }
//    })//end
</script>
<script>
    $('.adults .gr1').on('click', function(){
        for(var i = 0; i < 8; i++){
            if($(this).find('input').prop('checked')){
                check(i);
            } else {
                uncheck(i);
            }
        }
    })
    $('.adults .gr2').on('click', function(){
        for(var i = 8; i < 16; i++){
            if($(this).find('input').prop('checked')){
                check(i);
            } else {
                uncheck(i);
            }
        }
    })
    $('.adults .gr3').on('click', function(){
        for(var i = 16; i < 24; i++){
            if($(this).find('input').prop('checked')){
                check(i);
            } else {
                uncheck(i);
            }
        }
    })
    $('.adults .gr4').on('click', function(){
        for(var i = 24; i < 32; i++){
            if($(this).find('input').prop('checked')){
                check(i);
            } else {
                uncheck(i);
            }
        }
    })
    
    $('.children .gr5').on('click', function(){
        for(var i = 32; i < 37; i++){
            if($(this).find('input').prop('checked')){
                check(i);
            } else {
                uncheck(i);
            }
        }
    })
    $('.children .gr6').on('click', function(){
        for(var i = 37; i < 42; i++){
            if($(this).find('input').prop('checked')){
                check(i);
            } else {
                uncheck(i);
            }
        }
    })
    $('.children .gr7').on('click', function(){
        for(var i = 42; i < 47; i++){
            if($(this).find('input').prop('checked')){
                check(i);
            } else {
                uncheck(i);
            }
        }
    })
    $('.children .gr8').on('click', function(){
        for(var i = 47; i < 52; i++){
            if($(this).find('input').prop('checked')){
                check(i);
            } else {
                uncheck(i);
            }
        }
    })
</script>