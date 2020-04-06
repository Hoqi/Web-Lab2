<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../libs/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/../config/errors.php';

abstract class IValidation
{
    protected $data;

    protected $dataBase;

    protected $errors;

    protected function normalizeData() : void
    {
        unset($this->data['button']);
        unset($this->data['userAccept']);
        foreach ($this->data as &$element) {
            $element = trim($element);
        }
        unset($element);
    }

    protected function checkEmpty() : bool
    {
        $this->errors = array();
        global $emptyErrors;
        foreach ($this->data as $key => $value) {
            if ($value == '') {
                $this->errors[] = $emptyErrors[$key];
            }
        }
        return false;
    }
    abstract public function validation();
}
