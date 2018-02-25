<?php echo $this->renderPartial('_form_create_customer',
    array(
        'customer' => $customer,
        'medicalRecord' => $medicalRecord,
        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
    )); ?>