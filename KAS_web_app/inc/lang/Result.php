<?php
class Result implements Iterator, Countable
{
    public function Result($result)
    {
        if (!is_resource($result) || get_resource_type($result) !== 'mysql result')
            throw new InvalidArgumentException('Not valid MySQL result passed.');
        $this->result = $result;
        $this->count = mysql_num_rows($this->result);
    }
    public function count()
    {
        return $this->count;
    }
    public function current()
    {
        return mysql_fetch_object($this->result);
    }
    public function key()
    {
        return $this->key;
    }
    public function next()
    {
        $this->key++;
    }
    public function rewind()
    {
        if ($this->count() > 0)
            mysql_data_seek($this->result, 0);
        $this->key = 0;
    }
    public function valid()
    {
        return $this->count() > $this->key;
    }
    private $result;
    private $key               = 0;
    private $count;
}