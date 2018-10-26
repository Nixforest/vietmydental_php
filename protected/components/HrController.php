<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class HrController extends BaseController {
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var string the default module name for the controller view.
     */
    public $module = 'hr';

    /**
     * Initialize
     */
    function init() {
        parent::init();
    }
}
