<?php
class DataBase
{
    private function DataBase()
    { }
    public static function getInstance()
    {
        if (is_null(self::$self))
            self::$self = new DataBase();
        return self::$self;
    }
    public function connect($host, $name, $pass, $db)
    {
       if (!is_null($this->conn))
           return ;
       if (($this->conn = mysql_connect($host, $name, $pass)) === false)
           throw new Exception('Unable to connect to database server.');
       if (mysql_select_db($db, $this->conn) === false)
           throw new Exception('Unable to select database');
    }
    public function disconnect()
    {
        if (mysql_close($this->conn) === false)
            throw new Exception('Unable to disconnect from server.');

        unset($this->conn);
    }
    public function query($sql)
    {
        if (($temp = mysql_query($sql, $this->conn)) === false)
            throw new Exception(sprintf('Unable to execute SQL query `%s`.', $sql));
        if ($temp === true)
            return true;
        return new Result($temp);
    }
    private static $self;
    private $conn;
}