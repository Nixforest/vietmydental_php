<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TreeElement
 *
 * @author nguyenpt
 */
class TreeElement {
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    /**
     * Name of element
     * @var String Element's name 
     */
    private $name = '';
    /**
     * Id of element
     * @var String Element's id 
     */
    private $id = '';
    /**
     * Array children node
     * @var TreeElement[] Array children node 
     */
    private $children = array();
    
    /**
     * Constructor
     */
    public function init() {
        $this->name = '';
        $this->children = array();
    }
    
    /**
     * Set name value
     * @param String $name Name string
     */
    public function setName($name) {
        $this->name = $name;
    }
    
    /**
     * Set children not
     * @param TreeElement[] Array children node 
     */
    public function setChildren($children) {
        $this->children = $children;
    }
    
    /**
     * Get html tree
     * @param String $parent_id Id of parent node
     * @return string Tree as html format
     */ 
    public function getHtmlTree($parent_id = '0') {
        $retVal = '<ul>';
        $retVal .=  '<li class="parent_li">';
        $retVal .=      '<span data-id="' . $this->id . '" parent-id="' . $parent_id . '">';
        $retVal .=          '<i class="node fa fa-minus-square"></i>';
        $retVal .=          $this->name;
        $retVal .=      '</span>';
        
        foreach ($this->children as $child) {
            $retVal .= $child->getHtmlTree($this->id);
        }
        $retVal .=  '</li>';
        $retVal .= '</ul>';
        return $retVal;
    }
    
    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Create object
     * @param String $id Id of element
     * @param String $name Name of element
     * @param TreeElement[] $children Array children node
     * @return TreeElement Tree element object
     */
    public static function create($id, $name, $children) {
        $model = new TreeElement();
        $model->id = $id;
        $model->name = $name;
        $model->children = $children;
        return $model;
    }
}
