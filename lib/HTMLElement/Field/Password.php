<?php

/**
 * Implementation of an INPUT PASSWORD field
 */

class Field_Password extends Field {

    public function getHtml() {

        $fieldHtml = '<i>encrypted</i>';
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `edit` mode
     */
    protected function getEditHtml() {
        $fieldHtml = '<input type="password" ' .
                'name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'style="width:' . $this->getWidth() . 'px;" ' .
                'placeholder="Leave blank or update" ' .
                '/>';
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `new` mode
     */
    protected function getNewHtml() {
        $fieldHtml = '<input type="password" ' .
                'name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'style="width:' . $this->getWidth() . 'px;" ' .
                'value="" placeholder="' . $this->getName() . '..." ' .
                '/>';
        return $fieldHtml;
    }

    /**
     * 
     * @return text
     */
    protected function getValueFromPost() {
        $req = Request::getInstance();

        // get the raw value from the post
        $rawValue = $req->post($this->getDbName());

        // in the simplest way, this is the new value of the field
        return empty($rawValue) ? $this->getValue() : Field_Password::encryptPassword($rawValue);
    }

    /**
     * 
     * @param type $password
     * @return type
     */
    public static function encryptPassword($password) {
        $salt = uniqid();
        return sha1($password . $salt) . '|' . $salt;
    }

    /**
     * Check if this is the password
     * @param type $passwordString
     * @param type $passwordHash
     * @return type
     */
    public static function passwordIsCorrect($passwordString, $passwordHash) {
        list($hash, $salt) = explode('|', $passwordHash);
        return sha1($passwordString . $salt) . '|' . $salt == $passwordHash;
    }

}