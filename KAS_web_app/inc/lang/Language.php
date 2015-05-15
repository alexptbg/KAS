<?php
class Language
{
    public function Language($id, $short, $name)
    {
        if ((int) $id < 0)
            throw new InvalidArgumentException("ID is not valid.");
        if (!is_string($short))
            throw new InvalidArgumentException("Short name must be string.");
        if (!is_string($name))
            throw new InvalidArgumentException("Name must be string.");
        $this->short = $short;
        $this->name = $name;
        $this->id = (int) $id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getShort()
    {
        return $this->short;
    }
    public function getId()
    {
        return $this->id;
    }
    private $short;
    private $name;
    private $id;
}