<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../libs/validation/validation.php';

class reportValidation extends IValidation
{
    private $files;
    private $filesSize = array(
        'speech' => 10485760,
        'presentation' => 31457280
    );
    private $filesType = array(
        'speech' => array('doc', 'docx', 'pdf'),
        'presentation' => array('ppt', 'pptx', 'pdf'),
    );
    private $filesTypeMime = array(       
        'doc' =>   'application/msword',
        'docx' =>   'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'pdf' =>  'application/pdf',
        'ppt' =>   'application/vnd.ms-powerpoint',
        'pptx' =>  'application/vnd.openxmlformats-officedocument.presentationml.presentation',        
    );

    private $currentType = array();

    public function __construct(array $params, array $files)
    {
        $this->files = $files;
        $this->data = $params;
    }

    private function checkFiles(): bool
    {
        global $uploadErrors;
        foreach ($this->filesSize as $key => $value) {
            $exp = end(explode(".", $this->files[$key]['name']));
            if ($this->files[$key]['error'] == UPLOAD_ERR_OK) {
                if (in_array($exp, $this->filesType[$key]) && $this->files[$key]['type'] == $this->filesTypeMime[$exp]) {
                    $this->currentType += [$key => $exp];
                    if ($this->files[$key]['size'] < $value) {
                        continue;
                    }
                    $this->errors[] = $uploadErrors['size'];
                    return false;
                }
                $this->errors[] = $uploadErrors['type'];
                return false;
            }
            $this->errors[] = $uploadErrors['upload'];
            return false;
        }
        return true;
    }

    private function addReportDb(): array
    {
        if ($this->dataBase == null) {
            $this->dataBase = new DataBase();
        }
        if (isset($_SESSION['db_error'])){
            echo 'Ошибка подключения к БД';
            unset($_SESSION['db_error']);
            die();
        }
        $id = $this->dataBase->getMaxIdReports() + 1;
        $filesPath = array(
            'speech' => $id . 'speech.' . $this->currentType['speech'],
            'presentation' => $id . 'present.' . $this->currentType['presentation']
        );
        $prepareData = array(
            ':user_id' => $_SESSION['id'],
            ':title' => $this->data['title'],
            ':short_infouser' => $this->data['aboutUser'],
            ':category' => $this->data['category'],
            ':short_inforeport' => $this->data['aboutReport'],
            ':text' => $filesPath['speech'],
            ':presentation' => $filesPath['presentation']
        );
        $this->dataBase->addReport($prepareData);
        return $filesPath;
    }

    public function validation()
    {
        $this->normalizeData();
        if ($this->checkEmpty()) {
            return false;
        }
        if (!$this->checkFiles()) {
            $_SESSION['_errors'] = $this->errors;
            return false;
        }
        return $this->addReportDb();
    }
}
