<?php

namespace Seslisozluk;

class Translation{
    
    protected $fromLang;
    
    protected $toLang;
    
    protected $translate;
    
    protected $phrase;
    
    
    public function __construct($fromLang, $toLang, $translate, $phrase = null){
        
        $this->setFromLang($fromLang);
        
        $this->setToLang($toLang);
        
        $this->setTranslate($translate);
        
        $this->setPhrase($phrase);
    }
    
	/**
     * @return the $fromLang
     */
    public function getFromLang(){

        return $this->fromLang;
    }

	/**
     * @param field_type $fromLang
     */
    public function setFromLang($fromLang){

        $this->fromLang = strtolower($fromLang);
    }

	/**
     * @return the $toLang
     */
    public function getToLang(){

        return $this->toLang;
    }

	/**
     * @param field_type $toLang
     */
    public function setToLang($toLang){

        $this->toLang = strtolower($toLang);
    }

	/**
     * @return the $translate
     */
    public function getTranslate($raw = false){

        return $raw ? $this->translate : strip_tags($this->translate);
    }

	/**
     * @param field_type $translate
     */
    public function setTranslate($translate){

        $this->translate = $translate;
    }

	/**
     * @return the $phrase
     */
    public function getPhrase(){

        return $this->phrase;
    }

	/**
     * @param field_type $phrase
     */
    public function setPhrase($phrase){

        $this->phrase = $phrase;
    }

    
    
}