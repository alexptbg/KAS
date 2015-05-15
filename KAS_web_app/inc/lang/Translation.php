<?php
class Translation
{
    public function Translation($id, $keyWord, $translation)
    {
        if ((int) $id < 0)
            throw new InvalidArgumentException("ID is not valid.");
        if (!is_string($keyWord))
            throw new InvalidArgumentException("Keyword must be string.");
        if (!is_string($translation))
            throw new InvalidArgumentException("Translation must be string.");
        $this->keyWord = $keyWord;
        $this->translation = $translation;
    }
    public function getKeyWord()
    {
        return $this->keyWord;
    }
    public function getTranslation()
    {
        return $this->translation;
    }
    public function getId()
    {
        return $this->id;
    }
    public function __toString() {
        return $this->getTranslation();
    }
    public function replace()
    {
        $numArgs = func_num_args();
        $temp = $this->getTranslation();
        $pos = 0;
        $i = 0;
        while (($pos = strpos($temp, "%t%", $pos)) !== false) {
            if ($i >= $numArgs)
                throw new InvalidArgumentException("Not enough arguments passed.");
            $temp = substr($temp, 0, $pos) . func_get_arg($i) . substr($temp, $pos + 3);
			$pos += strlen(func_get_arg($i));
            $i++;
        }
        return $temp;
    }
    private $keyWord;
    private $id;
    private $translation;
}