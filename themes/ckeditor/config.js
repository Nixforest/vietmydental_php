/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
        config.removePlugins = 'save,newpage,preview,print,templates,find,replace,selectall,spellchecker,forms,language,about';
        config.filebrowserBrowseUrl = '../../../../../themes/kcfinder/browse.php?opener=ckeditor&type=files';
        config.filebrowserImageBrowseUrl = '../../../../../themes/kcfinder/browse.php?opener=ckeditor&type=images';
        config.filebrowserFlashBrowseUrl = '../../../../../themes/kcfinder/browse.php?opener=ckeditor&type=flash';
        config.filebrowserUploadUrl = '../../../../../themes/kcfinder/upload.php?opener=ckeditor&type=files';
        config.filebrowserImageUploadUrl = '../../../../../themes/kcfinder/upload.php?opener=ckeditor&type=images';
        config.filebrowserFlashUploadUrl = '../../../../../themes/kcfinder/upload.php?opener=ckeditor&type=flash';

};
