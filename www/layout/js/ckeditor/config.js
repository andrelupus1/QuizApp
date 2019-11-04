/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */
// Habilita tags HTML5 removidas pelo editor
CKEDITOR.config.allowedContent = true;

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        //config.extraPlugins = 'dialogadvtab';
        //config.extraPlugins = 'filebrowser,popup';
        //config.extraPlugins = 'youtube';
        config.extraPlugins = 'ckeditor-gwf-plugin';        
        config.extraPlugins = 'simple-image-browser';
        config.simpleImageBrowserURL = '/admin/arquivos/lista';
};
