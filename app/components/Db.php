<?php


class Db
{
    private static $instance;
    private $connection;
    private $last_query;

    private function __construct(){
        $this->setConnection();
    }

    private function __clone(){

    }

    public static function getInstance(){
        return !(static::$instance instanceof self) ? static::$instance = new self() : static::$instance;
    }

    private function setConnection (){
        $this->connection = mysqli_connect('localhost', 'root', '', 'gbook');
        $this ->connection ? : die('Соединение с базой не удалось установить!');
    }

    public function query($sql) {
        $this->last_query = $sql;
        $result = mysqli_query($this->connection, $sql);
        return $result;
    }

    private function confirm_query($result){
        $result ? : die('Не удалось выполнить запрос к базе!<br />'.$this->last_query);
    }

    public function escape($string) {
        return mysqli_real_escape_string($this->connection, $string);
    }

    public function fetch_assoc ($result){
        return mysqli_fetch_assoc($result);
    }
}