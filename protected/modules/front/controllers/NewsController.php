<?php

class NewsController extends FrontController {
    
    /**
     * get content view of news
     * @param int $id
     */
    public function actionView($id){
         $this->render('view', array(
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }
}
