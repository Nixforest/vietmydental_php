<?php

class CustomerController extends FrontController {
    /**
     * Handle receiving patient in agent.
     */
    public function actionView($code) {
        // Get refer code object
        $referCode = ReferCodes::model()->findByAttributes(array(
            'code' => $code,
        ));
        if ($referCode) {
            // Get customer stick with refer code
            $customer = $referCode->rCustomer;
        } else {
            // If refer code was not found, find by customer id
            $customer = Customers::model()->findByPk($code);
        }
        // If customer was not found
        if (!$customer) {
            // Add customer empty data
            $customer = new Customers();
        }
        $scheduleId = $customer->getSchedule(false);
        if (!empty($scheduleId)) {
            $schedule = TreatmentScheduleDetails::model()->findByPk($scheduleId);
        } else {
            $schedule = new TreatmentScheduleDetails();
        }
        
        $arrTreatmentSchedule = $customer->getListTreatmentSchedule();
        
        $this->render('view', array(
            'model' => $customer,
            'schedule' => $schedule,
            'treatment' => $arrTreatmentSchedule,
            DomainConst::KEY_ACTIONS => $this->listActionsCanAccess,
        ));
    }

    // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
    
    public function actionGetTreatmentImageAjax($id) {
        $model = TreatmentScheduleDetails::model()->findByPk($id);
        echo '<td class="img-real-container">';
        if (count($model->rImgRealFile)) {
            $listOldImage = array_reverse($model->rImgRealFile);
            $index = 1;
            echo '<div class="lp-list-image">';
                echo '<span class="prev-img">&#10094;</span>';
                echo '<span class="next-img">&#10095;</span>';
                foreach ($listOldImage as $img){
                   echo $img->getViewImage(200, 300);
                }
            echo '</div>';
        }
        echo '</td>'
             .'<td class="img-xquang-container">';
        if (count($model->rImgXRayFile)){
            $listOldImage = array_reverse($model->rImgXRayFile);
            $index = 1;
            echo '<div class="lp-list-image">';
            echo '<span class="prev-img">&#10094;</span>';
            echo '<span class="next-img">&#10095;</span>';
            foreach ($listOldImage as $img){
                echo $img->getViewImage(200, 300); 
            }
            echo '</div>';
        }
        echo '</td>';
    }
}