<?php
class Translate
{
    private function Translate()
    {
        $languages = DataBase::getInstance()->query("SELECT * FROM `languages`");
        foreach ($languages as $language)
            $this->avLang[$language->short] = new Language($language->id, $language->short, $language->name);
    }
    public static function getInstance()
    {
        if (self::$self === null)
            self::$self = new Translate();

        return self::$self;
    }
    public function getLanguage()
    {
        return $this->lang;
    }
    public function getAllLanguages()
    {
        return array_values($this->avLang);
    }
    public function getTranslation($keyWord)
    {
        if (!isset($this->translations[$keyWord]))
            throw new Exception("Keyword does not exist.");
        return $this->translations[$keyWord];
    }
    public function setLanguage($lang)
    {
        if (!is_string($lang))
            throw new InvalidArgumentException("Language short name must be string.");
        if (!$this->languageExist($lang))
            throw new InvalidArgumentException("Language does not exist.");
        if ($this->getLanguage() === $lang)
            return ;
        $this->lang = $lang;
        $this->preloadTranslations();
    }
    public function languageExist($lang)
    {
        if (!is_string($lang))
            throw new InvalidArgumentException("Language short name must be string.");
        return isset($this->avLang[$lang]);
    }
    private function preloadTranslations()
    {
        if ($this->lang === null)
            throw new Exception("Language is not set.");
        $result = Database::getInstance()->query(sprintf(
            "SELECT * FROM `translations` WHERE `lang` = %d",
            $this->avLang[$this->lang]->getId()
        ));
        foreach ($result as $translation)
            $this->translations[$translation->keyword] = new Translation($translation->id, $translation->keyword, $translation->value);
    }
    private $lang;
    private $translations;
    private static $self;
    private $avLang;
}