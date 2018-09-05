<?php

class ConvertExcelToDatabase extends Cities {
    const BAD_CHAR = array('"', "'", "\\");
    public $file_excel,$model_name,$model_field_compare,$model_field_insert,$model_field_compare_parent,$model_name_compare_parent,$model_field_insert_parent_id;
    
    public function rules()
    {
        return array(
            array('file_excel,model_name,model_field_compare,model_field_insert,model_field_compare_parent,model_name_compare_parent,model_field_insert_parent_id', 'safe'),
        );
    }
    
    /**
     * 
     * @param type $post
     * @return type
     * @throws CHttpException
     */
    public function excelConvertExcelToDatabase(){
        try {
            $from = time();
            $FileName = $_FILES['ConvertExcelToDatabase']['tmp_name']['file_excel'];
            if (empty($FileName)){
                return;
            }
            $countUpdate = 0;
            $countInsert = 0;
            $nameModelUpdate    = $this->model_name;
            $nameModelParent    = $this->model_name_compare_parent;
            $fieldCompare       = $this->model_field_compare;
            $fieldCompareParent = $this->model_field_compare_parent;
            $fieldInsert        = $this->model_field_insert;
            $fieldParentId      = $this->model_field_insert_parent_id;
            
            Yii::import('application.extensions.vendors.PHPExcel', true);
            $inputFileType = PHPExcel_IOFactory::identify($FileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel    = $objReader->load(@$_FILES['ConvertExcelToDatabase']['tmp_name']['file_excel']);
            $objWorksheet   = $objPHPExcel->getActiveSheet();
            $highestRow     = $objWorksheet->getHighestRow(); // e.g. 10
            //limit row update, insert
//            if($highestRow > 10000){
//                die("$highestRow row can not import, recheck file excel");
//            }
            
            for ($row = 2; $row <= $highestRow; ++$row) {
                // file excel cần format column theo dạng text hết để người dùng nhập vào khi đọc không lỗi
                $field_compare_table_utf8           = $this->removeBadCharacters($objWorksheet->getCellByColumnAndRow(0, $row)->getValue());
                $field_compare_table_parent_utf8     = $this->removeBadCharacters($objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
                $field_update                   = $this->removeBadCharacters($objWorksheet->getCellByColumnAndRow(2, $row)->getValue());
//                remove utf8
                $field_compare_table            = CommonProcess::removeSignOnly($field_compare_table_utf8);
                $field_compare_table_parent     = CommonProcess::removeSignOnly($field_compare_table_parent_utf8);
//                model_name,model_field_compare,model_field_insert;
                $criteria   = new CDbCriteria;
                $idParent   = 0;
                if(!empty($nameModelParent)){
                    $criteriaParent = new CDbCriteria;
                    $criteriaParent->compare($fieldCompareParent,$field_compare_table_parent);
                    $mParent    = $nameModelParent::model()->find($criteriaParent);
                    $idParent   = isset($mParent->id)? $mParent->id : 0;
                    $criteria->compare($fieldParentId, $idParent);
                }
                $criteria->compare($fieldCompare, $field_compare_table,true);
                $mUpdate = $nameModelUpdate::model()->find($criteria);
                if(empty($mUpdate)){
                    $mUpdate                    = new $nameModelUpdate();
                    if($mUpdate->hasAttribute('name')){
                        $mUpdate->name              = $field_compare_table_utf8;
                    }
                    if($mUpdate->hasAttribute($fieldCompare)){
                        $mUpdate->$fieldCompare     = $field_compare_table;
                    }
                    if($mUpdate->hasAttribute('status')){
                        $mUpdate->status            = DomainConst::NUMBER_ONE_VALUE;
                    }
                    if($mUpdate->hasAttribute('slug')){
                        $mUpdate->slug              = strtolower(implode(DomainConst::SPLITTER_TYPE_3,explode(' ', $field_compare_table)));
                    }
                    if($mUpdate->hasAttribute($fieldInsert)){
                        $mUpdate->$fieldInsert      = $field_update;
                    }
                    if($mUpdate->hasAttribute($fieldParentId)){
                        $mUpdate->$fieldParentId    = $idParent;
                    }
                    if($mUpdate->save()){
                        $countInsert++;
                    }
                }else{
                    if(isset($mUpdate->$fieldInsert)){
                        $mUpdate->$fieldInsert = $field_update;
                        if($mUpdate->update()){
                            $countUpdate++;
                        }
                    }
                }
            }
            $to = time();
            $second = $to-$from;
            $info = "Update $countUpdate row, Insert $countInsert <=> done in: ".($second).'  Second  <=> '.($second/60).' Minutes';
            Loggers::info('Time load excel',$info,__LINE__);
        } catch (Exception $e) {
            Yii::log("Uid: " . Yii::app()->user->id . "Exception " . $e->getMessage(), 'error');
            $code = 404;
            throw new CHttpException($code, $e->getMessage());
        }
    }
    
    /**
     * 
     * @param string $string
     * @param array $needMore
     * @return string
     */
    public function removeBadCharacters($string, $needMore = array())
    {
        $string = str_replace(self::BAD_CHAR, '', $string);
        if (isset($needMore['RemoveScript'])) {
            $string = InputHelper::removeScriptTag($string);
        }
        return trim($string);
//         return str_replace(array('&','<','>','/','\\','"',"'",'?','+'), '', $string);
    }
    
}

