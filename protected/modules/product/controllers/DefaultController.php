<?php

class DefaultController extends ProductController {

    public function actionIndex() {
        $this->render('index');
    }

}
