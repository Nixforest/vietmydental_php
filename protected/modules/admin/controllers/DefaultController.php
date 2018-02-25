<?php

class DefaultController extends AdminController
{
	public function actionIndex()
	{
		$this->render('index',array(
                        DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
		));
	}
}