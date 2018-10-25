/**
 * Remove sign of string
 * @param {String} str String to remove sign
 * @returns {String}
 */
function removeSign(str) {
    str = str.toLowerCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    return str;
}
/**
 * Style hyphen format
 * @param {String} propertyName String to format
 * @returns {String}
 */
function styleHyphenFormat(propertyName) {
    function upperToHyphenLower(match, offset, string) {
        return (offset ? '-' : '');
    }
    return propertyName.replace(/[/ ]/g, upperToHyphenLower);
}
/**
 * Get short string
 * @param {String} str String to get short
 * @returns {String}
 */
function getShortString(str) {
    str = str.toLocaleLowerCase();
    str = removeSign(str);
    return str;
}
/**
 * Get slug string
 * @param {String} str String to get slug
 * @returns {String}
 */
function getSlugString(str) {
    str = getShortString(str);
    str = styleHyphenFormat(str);
    return str;
}
/**
 * Get username from full name
 * @param {String} str Full name
 * @returns {getUserFromFullName.arr|String}
 */
function getUserFromFullName(str) {
    // Remove sign and make lower case
    str = getShortString(str);
    var retVal = str;
    // Split all words to array
    var arr = str.split(" ");
    // Get length of array
    var len = arr.length;
    // Check if full name have up to 2 words
    if (len > 1) {
        // Get name word
        var name = arr[len - 1];
        retVal = name;
        // Loop for all first name and sub name
        for (var i = 0; i < len - 1; i++) {
            // Take first character and append to return value
            retVal += arr[i].charAt(0);
        }
    }
    return retVal;
}
/**
 * Check if a string is empty
 * @param {String} str String need check
 * @returns {Boolean} True if a string is empty, null or undefined, False otherwise
 */
function isEmptyString(str) {
    return (!str || 0 === str.length);
}
/**
 * Handle binding list districts when change value of city
 * @param {String} inputId Id of city selector
 * @param {String} outputId Id of district selector
 * @param {String} url_ URL of ajax action
 */
function fnBindChangeCity(inputId, outputId, url_) {
    $(inputId).change(function () {
        var city_id = $(this).val();
//        $.blockUI({ overlayCSS: { backgroundColor: '<?php echo DomainConst::BLOCK_UI_COLOR; ?>' } });
        $.ajax({
            url: url_,
            data: {ajax: 1, city_id: city_id},
            type: "get",
            dataType: 'json',
            success: function (data) {
                $(outputId).html(data['html_district']);
//                $.unblockUI();
            }
        });
    });
}
function fnBindChangeCityStreet(inputId, outputId, url_) {
    $(inputId).change(function () {
        var city_id = $(this).val();
        $.ajax({
            url: url_,
            data: {ajax: 1, city_id: city_id},
            type: "get",
            dataType: 'json',
            success: function (data) {
                $(outputId).html(data['html_street']);
//                $.unblockUI();
            }
        });
    });
}
/**
 * Handle binding list wards when change value of districts
 * @param {String} inputId Id of district selector
 * @param {String} outputId Id of ward selector
 * @param {String} url_ URL of ajax action
 */
function fnBindChangeDistrict(inputId, outputId, url_) {
    $(inputId).change(function () {
        var district_id = $(this).val();
//        $.blockUI({overlayCSS: {backgroundColor: '#fff'}});
        $.ajax({
            url: url_,
            data: {ajax: 1, district_id: district_id},
            type: "get",
            dataType: 'json',
            success: function (data) {
                $(outputId).html(data['html_ward']);
//                $.unblockUI();
            }
        });
    });
}
/**
 * Handle text change event on textfield
 * @param {String} _url Search url
 * @param {String} outputId Id of output DOM
 */
function fnHandleTextChange(_url, outputId, _titleId, _titleVal) {
    $('.text-change').each(function () {
        $(this).attr('oldval', $(this).val());
    });

    var checkLength = function (val) {
        fnSearchCustomerReception(_url, outputId, _titleId, _titleVal);
    };

    $('.text-change').on('change keypress paste focus textInput input', function () {
        var val = $(this).val();
        console.log($(this).attr('id'));
        if (val != $(this).attr('oldval')) {
            $(this).attr('oldval', val);
            checkLength($(this).val());
        }
    });
}
var SEARCH_CUSTOMER_KEYS = ["customer_find", "customer_find_phone", "customer_find_address", "customer_find_agent"];

/**
 * Get search array value
 * @returns {unresolved}
 */
function fnGetSearchArray() {
    var arrVal = {};
    for (var i = 0; i < SEARCH_CUSTOMER_KEYS.length; i++) {
        arrVal[SEARCH_CUSTOMER_KEYS[i]] = $("#" + SEARCH_CUSTOMER_KEYS[i]).val().trim();
    }
    return arrVal;
}

/**
 * Check if array is empty
 * @param {Array} _array Array to check
 * @returns {Boolean} True if all array element is empty, False otherwise
 */
function fnIsEmptySearchArray(_array) {
    var retVal = false;
    for (var i = 0; i < SEARCH_CUSTOMER_KEYS.length; i++) {
        // Check if element is not empty
        if (_array[SEARCH_CUSTOMER_KEYS[i]]) {
            return true;
        }
    }

    return retVal;
}

/**
 * Search customer reception
 * @param {String} _url Search url
 * @param {String} outputId Id of output DOM
 */
function fnSearchCustomerReception(_url, outputId, _titleId, _titleVal) {
    var val = $('.text-change').val();
    var arr = fnGetSearchArray();
//    if (val.length >= 2) {
    if (fnIsEmptySearchArray(arr)) {
        $.ajax({
            url: _url,
            data: {ajax: 1, term: arr},
            type: "get",
            dataType: 'json',
            success: function (data) {
                // Show list customers
                $(outputId).html(data['rightContent']);
                // Change title
                $(_titleId).html(_titleVal);
                if (data['count'] != 0) {
                    // Hide create customer button
                    $('.info-content .info-result #create_customer').css({display: "none"});
                } else {
                    // Show create customer button
                    $('.info-content .info-result #create_customer').css({display: "block"});
                }
            }
        });
    } else {
        // Clear list customers
        $(outputId).html('');
        // Show create customer button
        $('.info-content .info-result #create_customer').css({display: "block"});
        $('.left-page .info-content .info-result .content').html('');
    }
}

/**
 * Show customer information
 * @param {type} _url
 * @param {type} _outputId
 * @param {type} _titleId
 * @param {type} _titleVal
 * @param {type} _customerId
 * @returns {undefined}
 */
function fnShowCustomerInfo(_url, _outputId, _titleId, _titleVal, _customerId) {
    $.ajax({
        url: _url,
        data: {ajax: 1, term: _customerId},
        type: "get",
        dataType: 'json',
        success: function (data) {
            $(_outputId).html(data['rightContent']);
            $(_titleId).html(_titleVal);
            $('.left-page .info-content .info-result .content').html(data['infoSchedule']);
        }
    });
}

/**
 * Show treatment schedule detail information
 * @param {type} _url
 * @param {type} _id
 * @param {type} _outputId
 * @returns {undefined}
 */
function fnShowTreatmentScheduleDetailInfo(_url, _id, _outputId) {
    $.ajax({
        url: _url,
        data: {
            ajax: 1,
            term: _id
        },
        type: "get",
        dataType: 'json',
        success: function (data) {
            $(_outputId).html(data['data']);
        }
    });
}
//function validateNumber(){     
////    console.log('Bind event input number');
//    $(".number_only_v1").each(function(){
//            $(this).unbind("keydown");
//            $(this).bind("keydown",function(event){
//                if( !(event.keyCode === 8                                // backspace
//                    || event.keyCode === 46                              // delete
//                    || event.keyCode === 110                              // dấu chám bên bàn phím nhỏ
//                    || event.keyCode === 9							// tab
//                    || event.keyCode === 190							// dấu chấm (point) 
//                    || (event.keyCode >= 35 && event.keyCode <= 40)     // arrow keys/home/end
//                    || (event.keyCode >= 48 && event.keyCode <= 57)     // numbers on keyboard
//                    || (event.keyCode >= 96 && event.keyCode <= 105))   // number on keypad
//                    ) {
//                        event.preventDefault();     // Prevent character input
//                    }
//            });
//    });
//
//    return;
//    $(".number_only").each(function(){
//            $(this).unbind("keydown");
//            $(this).bind("keydown",function(event){
//                if( !(event.keyCode === 8                                // backspace
//                    || event.keyCode === 46                              // delete
//                    || event.keyCode === 9							// tab
//                    || event.keyCode === 190							// dấu chấm (point) 
//                    || (event.keyCode >= 35 && event.keyCode <= 40)     // arrow keys/home/end
//                    || (event.keyCode >= 48 && event.keyCode <= 57)     // numbers on keyboard
//                    || (event.keyCode >= 96 && event.keyCode <= 105))   // number on keypad
//                    ) {
//                        event.preventDefault();     // Prevent character input
//                    }
//            });
//    });
//}

/**
 * Function handle BEFORE user click on remove icon at Upload file form
 * Override when use
 * @param {type} this_
 * @returns {undefined}
 */
function fnBeforeRemoveActionUploadFile(this_) {}

/**
 * Function handle AFTER user click on remove icon at Upload file form
 * Override when use
 * @returns {undefined}
 */
function fnAfterRemoveActionUploadFile() {}

/**
 * Refesh order number after change number of row
 * @returns {undefined}
 */
function fnRefreshOrderNumber() {
    validateNumber();
    $('.upload_files_table').each(function () {
        var index = 1;
        $(this).find('.order_no').each(function () {
            $(this).text(index++);
        });
    });
}

/**
 * Handle bind remove action on upload file table
 * @returns {undefined}
 */
function fnBindRemoveActionUploadFile() {
    $('.remove_icon_only').live('click', function () {
        if (confirm("Bạn chắc chắn muốn xóa?")) {
            fnBeforeRemoveActionUploadFile($(this));
            $(this).closest('tr').remove();
            fnRefreshOrderNumber();
            fnAfterRemoveActionUploadFile();
        }
    });
}

/**
 * Format current cy
 * @param {Int} price Price need to format
 * @returns {String} Price after formated
 */
function fnFormatCurrency(price) {
    // Create our number formatter.
    var formatter = new Intl.NumberFormat('de-DE', {
        style: 'currency',
        currency: 'VND',
        minimumFractionDigits: 0,
        // the default value for minimumFractionDigits depends on the currency
        // and is usually already 2
    });
    return formatter.format(price);
}
function fnUpdateValue(_input, _label) {
    var nameValue = $(_input).val();
    $(_label).val(fnFormatCurrency(nameValue));
}
//++ BUG0045-IMT  (DuongNV 201807) Format currency when input
function fnFormatNumber(number) {
    var formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 0,
    });
    return formatter.format(number);
}
function fnNumberOnly() {
    $(".number_only").on('keydown', function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
}
//-- BUG0045-IMT  (DuongNV 201807) Format currency when input

//++ BUG0080-IMT (DuongNV 20180906) print prescription
function printDiv(id_element, cssLink = '') {
    var divToPrint = document.getElementById(id_element);
    var title = 'Print';
    var css = '';
    if (cssLink != '') {
        css = "<link rel='stylesheet' href='" + cssLink + "' type='text/css' media='print'/>";
    }
    var newWin = window.open('', 'Print-Window');
    newWin.document.open();
    newWin.document.write('<html><title>' + title + '</title>' + css + '<body onload="window.print()" style="font-size:77%;">' + divToPrint.innerHTML + '</body></html>');
    newWin.document.close();
    setTimeout(function () {
        newWin.close();
    }, 10);
}

function bindPrint(classBtn, idToPrint, cssLink = '') {
    $('#' + idToPrint).hide();
    $('.' + classBtn).on('click', function () {
        printDiv(idToPrint, cssLink);
    });
}
//++ BUG0080-IMT (DuongNV 20180906) print prescription

//++ BUG0062-IMT (DuongNV 20180910) fix bug select row
/* @todo: next cell or prev cell
 * @params: dir (direction) = 1 (next), != 1 (previous)
 */
function gotoCell(currentSelectedElm, dir = 1) {
    var initIndex = currentSelectedElm.children().last().index();
    var limit = 0, step = -1;
    if (dir == 1) {
        limit = initIndex;
        initIndex = 0;
        step = 1;
    }
    if (currentSelectedElm.find('td.selected').length == 0) { // cell not select
        currentSelectedElm.children().eq(initIndex).addClass('selected');
    } else { // cell selected
        indexCell = currentSelectedElm.find('td.selected').index();
        if (indexCell != limit) { // Not final cell
            currentSelectedElm.children().eq(indexCell).removeClass('selected');
            indexCell += step;
            currentSelectedElm.children().eq(indexCell).addClass('selected');
        }
    }
    return indexCell;
}

/* @todo: next row or prev row
 * @params: dir (direction) = 1 (next), != 1 (previous)
 */
function gotoRow(currentSelectedElm, dir = 1, indexCell = '') {
    currentSelectedElm.removeClass('selected');
    currentSelectedElm.find('td.selected').removeClass('selected'); // Remove selected cell
    if (dir == 1) {
        currentSelectedElm = currentSelectedElm.next();
    } else {
        currentSelectedElm = currentSelectedElm.prev();
    }
    currentSelectedElm.addClass('selected');
    if (indexCell !== '') {
        currentSelectedElm.find('td').eq(indexCell).addClass('selected');
    }
    return currentSelectedElm;
}

/* 
 * @todo: bind click event to tr
 */
function bindClickRow() {
    $('table.table-select tr').on('click', function (event) {
        //Remove another selected row
        var anotherSelected = $('body').find('table.table-select tr.selected');
        if (anotherSelected.length != 0) {
            anotherSelected.removeClass('selected');
            anotherSelected.find('td.selected').removeClass('selected');
        } //End remove
        if ($(this).hasClass('selected')) { // Not select
            currentSelectedElm = '';
            $(event.target).removeClass('selected');

        } else { // Selected
            currentSelectedElm = $(this);
            currentSelectedElm.find('td.selected').removeClass('selected');
            $(event.target).addClass('selected');
            indexCell = $(event.target).index();
        }
    });
}

/* 
 * @todo: bind can select row to table.table-select
 */
function bindSelectRow() {
    currentSelectedElm = '';
    indexCell = 0;
    bindClickRow();
    $(document).keydown(function (event) {
        switch (event.which) {
            case 37: // Left arrow 
                indexCell = gotoCell(currentSelectedElm, -1);
                event.preventDefault();
                break;
            case 38: // Up arrow 
                if (typeof currentSelectedElm.prev()[0] != 'undefined') {
                    currentSelectedElm = gotoRow(currentSelectedElm, -1, indexCell);
                }
                event.preventDefault();
                break;
            case 39: // Right arrow 
                indexCell = gotoCell(currentSelectedElm, 1); // Next cell
                event.preventDefault();
                break;
            case 40: // Down arrow 
                if (typeof currentSelectedElm.next()[0] != 'undefined') {
                    currentSelectedElm = gotoRow(currentSelectedElm, 1, indexCell);
                }
                event.preventDefault();
                break;
        }
    });
}
//-- BUG0062-IMT (DuongNV 20180910) fix bug select row

//-----------------------------------------------------
// Handle dragndrop
//-----------------------------------------------------
/**
 * Handle allow drop on target element
 * @param {Events} ev Event param
 */
function allowDrop(ev) {
    ev.preventDefault();
}

/**
 * Handle drag source element
 * @param {Events} ev
 * @param {type} element
 * @param {String} field
 * @param {String} toClass
 */
function drag(ev, element, field, toClass) {
    if ($(element).hasClass('alreadyIn')) {
        toClass = '';
    }
    // lấy id của phần tử đang drag và gán vào biến source
    ev.originalEvent.dataTransfer.setData("source", $(ev.target).text());
    //lấy id của phần tử đang drag và gán vào biến data_id
    ev.originalEvent.dataTransfer.setData("data_id", $(ev.target).data(field));
    ev.originalEvent.dataTransfer.setData("toClass", toClass);
}

/**
 * Drag work_shift
 * @param {Events} ev Event param
 * @param {type} element
 * @param {type} field
 * @param {type} toClass
 * @returns {undefined}
 */
function wsdrag(ev, element, field, toClass) {
    $(element).attr('id', 'dragging'); //element is $(this)
    $(element).parent().attr('id', 'dragging_container');
    ev.originalEvent.dataTransfer.setData("color_class", $(ev.target).attr('class'));
    ev.originalEvent.dataTransfer.setData("data_id", $(ev.target).data('shift_id'));
    ev.originalEvent.dataTransfer.setData("data_name", $(ev.target).data('shift_name'));
    ev.originalEvent.dataTransfer.setData("toClass", toClass);
}

/**
 * 
 * @param {type} ev
 * @param {type} element
 * @param {type} toClass
 * @param {type} format
 * @param {type} autoIncrease
 * @returns {undefined}
 */
function drop(ev, element, toClass, format, autoIncrease) {
    var ts = $(element).children("span").length + 1;
    ev.preventDefault();
    var elmData = ev.originalEvent.dataTransfer.getData('source');//lấy giá trị biến source và gán vào biến elm_id
    var dropAreaClass = ev.originalEvent.dataTransfer.getData('toClass');
    var data_id = ev.originalEvent.dataTransfer.getData('data_id');
    if (dropAreaClass !== toClass)
        return;
    if (elmData === "")
        return;
    $selector = 'span[data-id=' + data_id + ']';
    if ($(element).find($selector).length <= 0) {
        currentTrDrop = $(element).data('current');
        $(element).append("<span class='btnDefault' data-id=" + data_id + ">" + format + ts + ": " + elmData + "<input class='display_none' name='HrFunctions[function][" + currentTrDrop + "][" + format + "][]' value ='" + data_id + "'></span>");
    }

    if (!elmData) {
        return
    }
    $(".dropErr").text("");
}

// Workschedule drop
function wsdrop(ev, element, toClass, format, autoIncrease) {
    var ts = $(element).children("span").length + 1;
    ev.preventDefault();
    var color_class = ev.originalEvent.dataTransfer.getData('color_class');//lấy giá trị biến source và gán vào biến elm_id
    var dropAreaClass = ev.originalEvent.dataTransfer.getData('toClass');
    var data_shift_id = ev.originalEvent.dataTransfer.getData('data_id');
    var data_shift_name = ev.originalEvent.dataTransfer.getData('data_name');
    var data_date = $(ev.target).data('date');
    var data_employee = $(ev.target).data('employee');
    //swap if a drag b
    if ($('#dragging').hasClass('alreadyIn')) { // #dragging is element which being dragging
        $('#dragging').remove();
        $(element).children().clone().appendTo('#dragging_container'); // #dragging is element contain #dragging
        var oldShift = $('#dragging_container').children('.shift_cell').data('shift_id');
        var oldDate = $('#dragging_container').data('date');
        var oldEmp = $('#dragging_container').data('employee');
        $('#dragging_container').children('.shift_cell').attr('data-date', oldDate);
        $('#dragging_container').children('.shift_cell').attr('data-employee', oldEmp);
        var aOldData = [oldShift, oldDate, oldEmp];
        var oldData = JSON.stringify(aOldData);
        $('#dragging_container').find("input[name='HrWorkSchedule[data][]']").val(oldData).removeClass('unmodify');
    } else {
        $('#dragging').removeAttr('id');
    }
    $('#dragging_container').removeAttr('id');

    var pos = color_class.search("shift_color");
    var color_class = color_class.substring(pos, pos + 14);

//        if(dropAreaClass !== toClass) return;
    if (color_class === "")
        return;
    $selector = 'span[data-id=' + data_shift_id + ']';
    if ($(element).find($selector).length <= 0) {
        $(element).empty();
        currentTrDrop = $(element).data('current');
        var aData = [data_shift_id, data_date, data_employee];
        var data = JSON.stringify(aData);
        var html_epd = "<div class='shift_container shift_cell " + color_class +
//                "' data-shift_id=" + data_shift_id + " data-shift_name='" + data_shift_name + "' data-date=" + data_date + " data-employee=" + data_employee + ">" + data_shift_name +
                "' data-shift_id=" + data_shift_id + " data-shift_name='" + data_shift_name + "' data-date=" + data_date + " data-employee=" + data_employee + ">" + "x" +
                "<input type='hidden' name='HrWorkSchedule[data][]' value ='" + data + "'>" +
                "</div>";
        $(element).append(html_epd);
    }

    if (!color_class) {
        return
    }
    $(".dropErr").text("");
}

//drag phần từ trong ô ra ngoài thì xóa phần tử đó (ko áp dụng cho ô input)
function dropOutsideToDelete() {
    $(document).on("dragend", ".alreadyIn", function (event) {
        //var mouse = (typeof event === 'undefined') ?   MouseEvent : event;
        $parent = $(this).parent();
        if (event.originalEvent.dataTransfer.dropEffect === 'none') {
            $('#dragging_container').removeAttr('id');
            $(this).remove();
        }
        $i = 1;
        $parent.find('.alreadyIn').each(function () {
            $(this).html($(this).html().replace(/\d+/, $i++));
        });
    });
}

function initDrag(fromClass, toClass) {
    $("." + fromClass).addClass("dragItem");
    $(document).on("mousedown", ".alreadyIn, ." + fromClass, function () {
        $("." + fromClass).attr("draggable", "true");
        $(".alreadyIn").attr("draggable", "true");
    })
    //kéo phần từ qua vùng cho phép drop thì hiện dấu cho phép drop
    $(document).on("dragover", "." + toClass, function (event) {
        allowDrop(event);
    });
}

/*allowDrag("fromClass", "toClass", "field", "data format", "auto increase")
 * field: "id", "class", "text" (default), "data-*" (vd: "data-value")
 * data format là ký tự dc thêm vào đầu đoạn text của phần tử drag
 * auto inscrease = true(default) or false    
 * function drag từ fromClass đến toClass và tên trường (id, class, text, data-*)
 */
function allowDrag(fromClass, toClass, field = "id", format = "", autoIncrease = "false") {
    initDrag(fromClass, toClass);
    $(document).on("dragstart", ".alreadyIn, ." + fromClass, function (event) {
        drag(event, this, field, toClass);
    });
    $(document).on("drop", "." + toClass, function (event) {
        if ($(this).hasClass(toClass)) {
            $("." + toClass).addClass("dragTarget");
            drop(event, this, toClass, format, autoIncrease);
            $(this).children().addClass("alreadyIn"); //dấu hiệu thêm class alreadyIn để phân biệt cái nào đã được drop vào rồi
        }
    });
    dropOutsideToDelete();
}

//Workschedule 
function wsallowDrag(fromClass, toClass, field = "id", format = "", autoIncrease = "false") {
    initDrag(fromClass, toClass);
    $(document).on("dragstart", ".alreadyIn, ." + fromClass, function (event) {
        wsdrag(event, this, field, toClass);
    });
    $(document).on("drop", "." + toClass, function (event) {
        if ($(this).hasClass(toClass)) {
            $("." + toClass).addClass("dragTarget");
            wsdrop(event, this, toClass, format, autoIncrease);
            $(this).children().addClass("alreadyIn"); //dấu hiệu thêm class alreadyIn để phân biệt cái nào đã được drop vào rồi
        }
    });
    //drag phần từ trong ô ra ngoài thì xóa phần tử đó (ko áp dụng cho ô input)
    dropOutsideToDelete();
}//--END DRAG n DROP