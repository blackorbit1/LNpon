<?php

class DBHandler {

    private $host = 'localhost';
    private $username = 'www-data';
    private $password = 'www-data';
    private $db_name = 'php_game';
    private $dsn = 'pgsql:host=' . $this->host . ';dbname=' . $this->db_name;
    private $is_connected = false;

    public function __construct() {
        if (!$this->IsConnected) {
            $this->IsConnected = true;
            $this->Connect = new PDO(sprintf($this->dsn, $this->username, $this->password);
        }
    }

    public function execute($query = '', $data = array()) {
        if ($this->IsConnected) {
            $statement = $this->Connection->prepare($query);
            $statement->execute($data);
        }
    }
}
