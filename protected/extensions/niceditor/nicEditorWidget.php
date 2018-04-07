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
 * None
 * 
 * This extension have to be installed into:
 * <Yii-Application>/protected/extensions/niceditor
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
 * 
 */

class nicEditorWidget extends CInputWidget
{

	public $defaultValue;
	public $config;
	public $width = "100%";
	public $height = "150px";

	public function run()
	{
		if(!isset($this->model)){
			throw new CHttpException(500,'"model" have to be set!');
		}
		if(!isset($this->attribute)){
			throw new CHttpException(500,'"attribute" have to be set!');
		}
		if(!isset($this->defaultValue)){
			$this->defaultValue = "";
		}

		$this->render('nicEditorView',array(
			"model"=>$this->model,
			"attribute"=>$this->attribute,
			"defaultValue"=>$this->defaultValue,
			"config"=>$this->config,
			"width"=>$this->width,
			"height"=>$this->height,
		));
	}
}
?>