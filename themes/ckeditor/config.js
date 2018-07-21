/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        config.removeDialogTabs = 'image:advanced;link:advanced';
        config.removePlugins = 'save,newpage,preview,print,templates,find,replace,selectall,spellchecker,forms,language,about';
        config.filebrowserBrowseUrl = '../../../../../themes/kcfinder/browse.php?opener=ckeditor&type=files';
        config.filebrowserImageBrowseUrl = '../../../../../themes/kcfinder/browse.php?opener=ckeditor&type=images';
        config.filebrowserFlashBrowseUrl = '../../../../../themes/kcfinder/browse.php?opener=ckeditor&type=flash';
        config.filebrowserUploadUrl = '../../../../../themes/kcfinder/upload.php?opener=ckeditor&type=files';
        config.filebrowserImageUploadUrl = '../../../../../themes/kcfinder/upload.php?opener=ckeditor&type=images';
        config.filebrowserFlashUploadUrl = '../../../../../themes/kcfinder/upload.php?opener=ckeditor&type=flash';
};
