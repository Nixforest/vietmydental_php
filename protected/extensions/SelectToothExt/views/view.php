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
            <table>
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
                            name="<?php echo $inputName ?>"
                            value="1"
                            type="checkbox"
                            id="<?php echo $inputId ?>"
                            <?php echo $checked; ?>
                            >
                        <label for="<?php echo $inputId ?>"
                               style="<?php echo $labelStyle; ?>">
                            <?php echo $teeth; ?>
                        </label>
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
                            name="<?php echo $inputName ?>"
                            value="1"
                            type="checkbox"
                            id="<?php echo $inputId ?>"
                            <?php echo $checked; ?>
                            >
                        <label for="<?php echo $inputId ?>"
                               style="<?php echo $labelStyle; ?>">
                            <?php echo $teeth; ?>
                        </label>
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
            <table>
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
                            name="<?php echo $inputName ?>"
                            value="1"
                            type="checkbox"
                            id="<?php echo $inputId ?>"
                            <?php echo $checked; ?>
                            >
                        <label for="<?php echo $inputId ?>"
                               style="<?php echo $labelStyle; ?>">
                            <?php echo $teeth; ?>
                        </label>
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
                            name="<?php echo $inputName ?>"
                            value="1"
                            type="checkbox"
                            id="<?php echo $inputId ?>"
                            <?php echo $checked; ?>
                            >
                        <label for="<?php echo $inputId ?>"
                               style="<?php echo $labelStyle; ?>">
                            <?php echo $teeth; ?>
                        </label>
                    </td>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tr>
            </table>
        </td>
    </tr>
</table>

