<?php
/*
 * Created on 03.07.2011
 *
 * Copyright: Viet Nguyen
 * This extension is based on NicEdit from http://nicedit.com/
 * 
 * GNU LESSER GENERAL PUBLIC LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Requirements:
 * No requirements. The Editor itself is included in this extension under assets folder.
 *
 * This extension have to be installed into:
 * <Yii-Application>/proected/extensions/niceditor
 *
 * Usage:
 * $this->widget('ext.niceditor.nicEditorWidget',array(
 *		"model"=>$model,                 # Data-Model
 *		"attribute"=>$attribute,          # Attribute in the Data-Model
 *		"defaultValue"=>$model->description,
 *		"config"=>array("maxHeight"=>"200px"),
 *		"width"=>"400px",					# Optional default to 100%
 *		"height"=>"200px",					# Optional default to 150px
 *	));
 */
$id = CHtml::activeId($model, $attribute);

//modified this path according to your niceditor extension installed path
$nicpath = '/extensions/niceditor/assets';

//This part is for including nicEditor javascript file
$nicEditExt = Yii::app()->assetManager->publish(Yii::app()->basePath.$nicpath);
Yii::app()->clientScript->registerScriptFile($nicEditExt.'/niceditor.js');
$config['iconsPath'] = $nicEditExt.'/nicEditorIcons.gif';

echo CHtml::activeTextArea($model, $attribute, array('value'=>$model->$attribute, "style"=>"width: $width; height: $height;"));
echo CHtml::script("new nicEditor(".CJSON::encode($config).").panelInstance('$id');\n");
?>