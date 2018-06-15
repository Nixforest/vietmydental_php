<?php echo $this->renderPartial('_form_print_receipt',
    array(
        'customer' => $customer,
        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
    )); ?>