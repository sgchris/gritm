<?php
/**
 * Implementation of an INPUT TEXT field
 */

require_once __DIR__.'/../Field.php';

define('FIELD_TEXT_VIEW', VIEWS_DIR.'/Field/Text.view.php');

class Field_Text extends Field {
    
    public function getHtml() {
        
		// load page template
		ob_start();
		require FIELD_TEXT_VIEW;
		$fieldHtml = ob_get_clean();

		return $fieldHtml;
    }
    
}