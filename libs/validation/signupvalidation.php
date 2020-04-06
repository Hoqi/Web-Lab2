<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../libs/validation/uservalidation.php';


class signUpValidation extends IuserValidation
{

    private $cyrillicExp = "/[^а-яА-Я \-]{1,}/u";

    private $passwordExp = "/^[A-Za-z0-9]+$/u";
    private $onlyDigitExp = "/^[0-9]+$/u";

    private $minLenght = 6;

    public function cyrillicCheck(): bool
    {
        if (preg_match($this->cyrillicExp, $this->data['name']) == 0) {
            return true;
        }
        global $validErrors;
        $this->errors[] = $validErrors['name'];
        return false;
    }
    public function passwordLenghtCheck(): bool
    {
        if (iconv_strlen($this->data['password']) >= $this->minLenght) {
            return true;
        }
        global $validErrors;
        $this->errors[] = $validErrors['password_len'];
        return false;
    }
    private function passwordValid(): bool
    {
        global $validErrors;
        if (preg_match($this->passwordExp, $this->data['password']) == 1) {
            if (preg_match($this->onlyDigitExp, $this->data['password']) == 1) {
                $this->errors[] = $validErrors['password_digit'];
                return false;
            }
            return true;
        }

        $this->errors[] = $validErrors['password'];
        return false;
    }
    public function __construct(array $params)
    {
        $this->data = $params;
    }

    private function addNewUser(): void
    {
        $userData = array(
            ':name' => $this->data['name'],
            ':email' => $this->data['email'],
            ':password' => password_hash($this->data['password'], PASSWORD_BCRYPT)
        );
        $this->dataBase->registerNewUser($userData);
    }

    public function validation(): bool
    {
        $this->normalizeData();
        $this->checkEmpty();
        $this->cyrillicCheck();
        $this->passwordLenghtCheck();
        $this->passwordValid();
        if (!empty($this->errors)) {
            $_SESSION['_errors'] = $this->errors;
            return false;
        }
        if ($this->checkExistDb()) {
            $this->addNewUser();
            return true;
        }
        $_SESSION['_errors'][] = 'Пользователь с данным email уже зарегестрирован';
        return false;
    }
}
