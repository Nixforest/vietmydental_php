<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * DataColumn class file.
 * Extends {@link CDataColumn}
 * @author nguyenpt
 */
class DataColumn extends CDataColumn {

    /**
     * @var boolean whether the htmlOptions values should be evaluated. 
     */
    public $evaluateHtmlOptions = false;

    /**
     * Renders a data cell.
     * @param integer $row the row number (zero-based)
     * Overrides the method 'renderDataCell()' of the abstract class CGridColumn
     */
    public function renderDataCell($row) {
        $data = $this->grid->dataProvider->data[$row];
        if ($this->evaluateHtmlOptions) {
            foreach ($this->htmlOptions as $key => $value) {
                $options[$key] = $this->evaluateExpression($value, array('row' => $row, 'data' => $data));
            }
        } else {
            $options = $this->htmlOptions;
        }
        if ($this->cssClassExpression !== null) {
            $class = $this->evaluateExpression($this->cssClassExpression, array('row' => $row, 'data' => $data));
            if (isset($options['class'])) {
                $options['class'] .= ' ' . $class;
            } else {
                $options['class'] = $class;
            }
        }
        echo CHtml::openTag('td', $options);
        $this->renderDataCellContent($row, $data);
        echo '</td>';
    }

}
