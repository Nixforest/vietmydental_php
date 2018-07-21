<?php

class NewsController extends FrontController {
    
    /**
     * get content view of news
     * @param int $id
     */
    public function actionView($id){
        $mNews = $this->loadModel($id);
        $this->render('view', array(
            'model' => $mNews,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }
    
    /**
    * Returns the data model based on the primary key given in the GET variable.
    * If the data model is not found, an HTTP exception will be raised.
    * @param integer $id the ID of the model to be loaded
    * @return News the loaded model
    * @throws CHttpException
    */
    public function loadModel($id)
    {
        $model = News::model()->findByPk($id);
        if($model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
