<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../libs/validation/uservalidation.php';

class loginValidation extends IuserValidation
{
    public function __construct(array $params)
    {
        $this->data = $params;
    }
    public function validation(): bool
    {
        $this->normalizeData();
        if ($this->checkEmpty()) {
            return false;
        }
        if (!$this->checkExistDb()) {
            $userData = array(
                ':email' => $this->data['email'],
                'password' => $this->data['password']
            );
            if ($this->dataBase->loginUser($userData)) {
                return true;
            }
            $_SESSION['_errors'][] = 'Неверный пароль';
            return false;
        }
        $_SESSION['_errors'][] = 'Неверный email';
        return false;
    }
}
