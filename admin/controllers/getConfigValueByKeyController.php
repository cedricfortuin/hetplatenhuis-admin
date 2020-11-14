<?php
include '../config/constants.php';

$ConnectionLink = mysqli_connect(LOCAL_HOST, LOCAL_USER, LOCAL_PASSWORD, LOCAL_DATABASE);

class getConfigValueByKey
{
    public $database_key;
    public $value;

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @param $database_key
     */
    public function setKey($database_key)
    {
        $this->database_key = $database_key;
    }

    /**
     * @param $database_key
     * @return mixed
     */
    public function getValue($database_key)
    {
        $ConnectionLink = mysqli_connect(LOCAL_HOST, LOCAL_USER, LOCAL_PASSWORD, LOCAL_DATABASE);
        $get_from_database = $ConnectionLink->query("SELECT * FROM configuration where `KEY` = '$database_key'")->fetch_array();
        return $this->value = $get_from_database;
    }

    /**
     * @return mixed
     */
    public function getDatabaseKey()
    {
        return $this->database_key;
    }
}

$key = new getConfigValueByKey();
$key->setKey('CONFIG_NEW_FEATURE_TEXT');

echo $key->getValue();
