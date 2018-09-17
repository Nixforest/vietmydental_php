<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DefaultController
 *
 * @author nguyenpt
 */
class DefaultController extends HrController {

    public function actionIndex() {
        $this->render('index');
    }

}
