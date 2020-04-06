<?php
require $_SERVER['DOCUMENT_ROOT'].'/../libs/validation/validation.php';

abstract class IuserValidation extends IValidation{
    protected function checkExistDb() : bool
    {
        if (!isset($this->dataBase)) {
            $this->dataBase = new DataBase();
        }
        if (isset($_SESSION['db_error'])){
            echo 'Ошибка подключения к БД';
            unset($_SESSION['db_error']);
            die();
        }
        if ($this->dataBase->existUser($this->data['email'])) {
            return false;
        }
        return true;
    }
}