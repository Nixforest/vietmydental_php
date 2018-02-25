<?php echo $this->renderPartial('_form_schedule',
    array(
        'model' => $model,
        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
    )); ?>