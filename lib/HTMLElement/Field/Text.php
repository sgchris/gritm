<?php
/**
 * Implementation of an INPUT TEXT field
 */

require_once __DIR__.'/../Field.php';

define('FIELD_TEXT_VIEW', VIEWS_DIR.'/Field/Text.view.php');

class Field_Text extends Field {
    
    public function getHtml() {
        
		$fieldHtml = htmlentities($this->getValue(), ENT_NOQUOTES, 'utf-8');
		return $fieldHtml;
    }
    
}