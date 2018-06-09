<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FrontController
 *
 * @author nguyenpt
 */
class FrontController extends BaseController {
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/front/column1';
    /**
     * @var string the default module name for the controller view.
     */
    public $module = 'front';

    /**
     * Initialize
     */
    function init() {
        parent::init();
        $this->pageTitle = $this->getPageTitleByAction($this->getCurrentAction());
    }
}
