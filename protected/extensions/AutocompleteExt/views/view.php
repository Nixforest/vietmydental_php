<?php
// Initialize variable
$info_name              = '';
$info_code              = '';
$info_address           = '';
$info_phone             = '';
$session                = Yii::app()->session;

?>
<div class="unique_wrap_autocomplete <?php echo $classdAddDivWrap; ?>">
    <?php
    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
        'attribute' => $fieldName,
        'model'     => $model,
        'sourceUrl' => $url,
        'options'   => array(
//            'minLength' => AutocompleteExt::MIN_LENGTH_AUTOCOMPLETE,
            'minLength' => $min_length,
            'multiple'  => true,
            'search'    => "js:function( event, ui ) {
                    $('$idFieldName').addClass('grid-view-loading-gas');
                } ",
            'close'     => "js:function( event, ui ) {
                    if($isDoSomethingOnClose){
                        doSomethingOnClose(ui, '$idFieldName', '$idFieldId');
                    }
                } ",
            'response'  => "js:function( event, ui ) {
                    var json = $.map(ui, function (value, key) { return value; });
                    var parent_div = $('$idFieldName').closest('div.unique_wrap_autocomplete');
                    if(json.length<1){
                        var error = '<div class=\'errorMessage clr autocomplete_name_text\'>Không tìm thấy dữ liệu.</div>';
                        if(parent_div.find('.autocomplete_name_text').size()<1)
                            parent_div.find('.autocomplete_name_error').after(error);
                        else
                            parent_div.find('.autocomplete_name_error').parent('div').find('.autocomplete_name_text').show();
                        parent_div.find('.autocomplete_name_error').parent('div').find('.remove_row_item').hide();
                    }
                    $('$idFieldName').removeClass('grid-view-loading-gas');
                } ",
            'select'    => "js:function(event, ui) {
                    var parent_div = $('$idFieldName').closest('div.unique_wrap_autocomplete');
                    $('$idFieldId').val(ui.item.id);
                    var remove_div = '<span class=\'remove_row_item\' onclick=\'fnRemoveName(this, \"$idFieldName\", \"$idFieldId\")\'></span>';                    
                    $('$idFieldName').parent('div').find('.remove_row_item').remove();
                    $('$idFieldName').attr('readonly',true).after(remove_div);
                    
                    if($isShowInfo){
                        fnBuildTableInfo(ui.item, parent_div);
                        parent_div.find('.autocomplete_customer_info').show();
                    }
                    parent_div.find('.autocomplete_name_error').parent('div').find('.autocomplete_name_text').hide();
                    if($isCallFuncSelected){
                        /* fnCallSomeFunctionAfterSelect(ui.item.id, '$idFieldName', '$idFieldId'); */
                        {$data['fnSelected']}(ui.item.id, '$idFieldName', '$idFieldId');
                    }
                    if($isCallFuncSelectedV2){
                        fnCallSomeFunctionAfterSelectV2(ui, '$idFieldName', '$idFieldId');
                    }
                }",          
        ),
        'htmlOptions' => array(
            'class'         => "autocomplete_name_error $classAdd",
            'size'          => 30,
            'maxlength'     => 45,
            'style'         => "float:left; $style",
            'placeholder'   => $placeholder,
        ),
    ));
    ?>
    <?php if (!empty($updateValue)): ?>
        <script>
            $(function() {
//                console.log('<?php echo $idFieldName; ?>');
                var oldId = '<?php echo $idFieldName; ?>';
                var newId = oldId.replace("_[", "_");
                newId = newId.replace(/\]/g , "_");
                console.log(newId);
                var remove_div = '<span class=\'remove_row_item\' onclick=\'fnRemoveName(this, \"<?php echo $idFieldName;?>\", \"<?php echo $idFieldId;?>\")\'></span>';
//                $('<?php echo $idFieldName; ?>').val('<?php echo $updateValue; ?>').attr('readonly', true).after(remove_div);
$(newId).val('<?php echo $updateValue; ?>').attr('readonly', true).after(remove_div);
            });
        </script>
    <?php endif; // end if ($mUserRelation && $isShowInfo) ?>
</div>
<script>
    function fnRemoveName(this_, idFieldName, idFieldId) {
        $(this_).closest('div.unique_wrap_autocomplete').find(idFieldName).attr("readonly", false);
        $(idFieldName).val("");
        $(idFieldId).val("");
        $(this_).closest('div.unique_wrap_autocomplete').find('.autocomplete_detail_info').hide();
        fnAfterRemove(this_, idFieldName, idFieldId);
    }
    function fnAfterRemove(this_, idFieldName, idFieldId) {}
    function fnBuildTableInfo(item, parent_div) {
        parent_div.find(".info_name").text(item.name_customer);
        parent_div.find(".info_code_account").text(item.code_account);
        parent_div.find(".info_address").text(item.address);
        parent_div.find(".info_phone").text(item.phone);          
    }
    
    <?php if (isset($data[AutocompleteExt::KEY_FN_SELECTED])): ?>
    function fnCallSomeFunctionAfterSelect(user_id, idFieldName, idFieldId) {
        <?php echo $data[AutocompleteExt::KEY_FN_SELECTED]; ?>(user_id, idFieldName, idFieldId);
    }
    <?php endif; // end if (isset($data[AutocompleteExt::KEY_FN_SELECTED])) ?>
    
    <?php if (isset($data[AutocompleteExt::KEY_FN_SELECTED_V2])): ?>
    function fnCallSomeFunctionAfterSelectV2(user_id, idFieldName, idFieldId) {
        <?php echo $data[AutocompleteExt::KEY_FN_SELECTED_V2]; ?>(user_id, idFieldName, idFieldId);
    }
    <?php endif; // end if (isset($data[AutocompleteExt::KEY_FN_SELECTED])) ?>
    
    <?php if (isset($data[AutocompleteExt::KEY_DO_ST_ON_CLOSE])): ?>
    function doSomethingOnClose(user_id, idFieldName, idFieldId) {
        <?php echo $data[AutocompleteExt::KEY_DO_ST_ON_CLOSE]; ?>(user_id, idFieldName, idFieldId);
    }
    <?php endif; // end if (isset($data[AutocompleteExt::KEY_FN_SELECTED])) ?>
</script>
<style>
.remove_row_item {background: url(Yii::app()->theme->baseUrl . '/img/ico-validate-error.png') no-repeat left top; margin-right: 25px; height: 16px; text-indent: -1984em; width: 16px;cursor: pointer;float: left;margin-left: 6px;margin-top: 6px;}
</style>