<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../config/dbparam.php';


class DataBase
{
    private $Connection;

    function __construct()
    {
        global $dsn;
        try {
            $this->Connection = new PDO($dsn);
            $this->Connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (Exception $e) {
            $_SESSION['db_error'] = 'Ошибка подключения к БД';
        }
    }

    function existUser(string $userEmail): bool
    {
        $stmt = $this->Connection->prepare('Select COUNT(*) From users WHERE email = ?');
        //var_dump($userEmail);
        $stmt->execute([$userEmail]);
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        if ($count > 0) {
            return true;
        }
        return false;
    }

    function loginUser(array $userData): bool
    {
        $stmt = $this->Connection->prepare('Select * From users WHERE email = :email');
        $stmt->execute([$userData[':email']]);
        $DbUser = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($userData['password'], $DbUser['password'])) {
            $_SESSION['id'] = $DbUser['id'];
            $_SESSION['name'] = $DbUser['name'];
            $_SESSION['access_level'] = $DbUser['access_level'];
            return true;
        }
        return false;
    }

    function registerNewUser(array $userData): void
    {
        $stmt = $this->Connection->prepare('Insert into users(name,email,password,access_level) values(:name,:email,:password,:level)');
        $userData += [':level' => 'user'];
        $stmt->execute($userData);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['id'] = $this->getMaxIdUsers();
        $_SESSION['name'] = $userData[':name'];
        $_SESSION['access_level'] = $userData[':level'];
    }

    public function getMaxIdReports(): string
    {
        $stmt = $this->Connection->query('Select max(id) from reports');
        return $stmt->fetch()['max'];
    }

    public function getMaxIdUsers(): string
    {
        $stmt = $this->Connection->query('Select max(id) from users');
        return $stmt->fetch()['max'];
    }

    function addReport(array $reportData): void
    {
        $stmt = $this->Connection->prepare('Insert into reports(user_id,title,short_infouser,category,short_inforeport,text,presentation) values(:user_id,:title,:short_infouser,:category,:short_inforeport,:text,:presentation)');
        $stmt->execute($reportData);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getAllUsersShortInfo(): array
    {
        $stmt = $this->Connection->query('select id,name,email from users');
        $result = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $values = array(
                'name' => $row['name'],
                'email' => $row['email']
            );
            $result[$id] = $values;
        }
        return $result;
    }

    function getAllReports()
    {
        $stmt = $this->Connection->query('select * from reports');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getReportsByUserId(string $id)
    {
        $stmt = $this->Connection->prepare('select * from reports where user_id=?');
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getReportById(string $id)
    {
        $stmt = $this->Connection->prepare('select * from reports where id=?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
