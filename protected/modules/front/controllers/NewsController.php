<?php

class NewsController extends FrontController {
    
    /**
     * get content view of news
     * @param int $id
     */
    public function actionView($id){
        $mNews = $this->loadModel($id);
        $this->pageTitle = $mNews->description;
        if(isset($_GET['idCmt'])){
            $idCmt  = $_GET['idCmt'];
            $type    = isset($_GET['type'])    ? $_GET['type']    : '';
            $content = isset($_GET['content']) ? $_GET['content'] : '';
            $this->doComment($type, $idCmt, $content);die;
        }
        $this->render('view', array(
            'model' => $mNews,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }
    
    /**
     * Action category
     * @param type $id
     */
    public function actionCategory($id) {
        $mCategory = NewsCategories::model()->findByPk($id);
        
        if (isset($mCategory)) {
            $this->pageTitle = $mCategory->name;
            $this->render('category', array(
                'model' => $mCategory,
                DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
            ));
        } else {
            Loggers::error('Truy cập không hợp lệ', 'Không có NewsCategories với id = ' . $id, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');;
        }
        
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
    
    //++ BUG0093-IMT (DuongNV 20180924) comment in news
    public function doComment($type, $id, $content) {
        $userId = isset(Yii::app()->user) ? Yii::app()->user->id : '';
        $header = $body = $footer = $classComment = $lastId = '';
        if($type == Comments::TYPE_NEWS){ // Comment
            $lastId = Comments::insertCommentNews($id, $content);
            $header = '<div class="cm-block">'
                        .'<div class="parent-cm">';
            $footer =   '</div>'
                     .'</div>';
            $classComment = ' rep-cm';
        } elseif ($type == Comments::TYPE_CHILD){ // Reply Comment
            $lastId = Comments::replyComment($id, $content);
        }
        $body =  '<img src="https://cdn3.iconfinder.com/data/icons/faticons/32/user-01-512.png" class="cm-avatar"> '
                .'<div class="cm-ctn">'
                    .'<span class="cm-name">'.Comments::getInfoUserById($userId).'</span>'
                    .'<span class="cm-text"> ' . $content .'</span>'
                .'</div>'
                .'<div class="like-block">'
                    .'<span class="like-btn">Like</span><span> - </span>'
                    .'<span class="cm-btn ' . $classComment . '" data-id="' . $lastId . '">Comment</span><span> - </span>'
                    .'<span class="time-text">40 min</span>'
                .'</div>';
        
        echo $header . $body . $footer;
    }
    //-- BUG0093-IMT (DuongNV 20180924) comment in news
}
