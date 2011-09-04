<?php

namespace Seslisozluk\Api;

class Response{
    
    protected $succestions      = null;
    
    protected $translations     = array(); // array('tr_tr' => ...);
    
    protected $firstTranslation = null;
    
    protected $pronounciations  = null;
    
    protected $error            = null;
    
    
    
    
    public function isSuccess(){
        
        return !$this->isError();
    }
    
    public function isError(){
        
        return null !== $this->error;
    }
    
    public function getError(){
        
        return $this->error;
    }
    
    
    public function hasSuccesstions(){
        
        return null !== $this->succestions;
    }
    
    
    public function getSuccestions(){
        
        return $this->succestions;
    }
    
    public function playPronounciationOnBash(){
        
        //print_r($this->pronounciations);
        
        if (count($this->pronounciations) == 0) {
            
            return false;
        }
        
        $mp3_url = $this->pronounciations[0];
        
        
        exec('curl -s '.$mp3_url.' > /tmp/foo.mp3 && afplay /tmp/foo.mp3 && rm /tmp/foo.mp3');
    }
    
    
    public function translationCount(){
        
        return count($this->translations);
    }
    
    /**
     * 
     * Enter description here ...
     * @return Seslisozluk\Translation
     */
    public function getFirstTranslation(){
        
        if ($this->firstTranslation) {
            
            return $this->translations[$this->firstTranslation];
        }
    }
    
    public function hasTranslation($from, $to){
        
        return isset($this->translations[strtolower($from).'_'.strtolower($to)]);
    }
    
    
    /**
     * @param mixed $lang
     * @return mixed
     */
    public function getTranslation($lang = null){
        
        if (null === $lang) {
            
            return $this->translations;
        }
        
        if (isset($this->translations[$lang])) {
            
            return $this->translations[$lang];
        }
    }
    
    
    /**
     * 
     * Enter description here ...
     * @param unknown_type $firstTranslation
     * @param unknown_type $translations
     * @return Seslisozluk\Api\Response
     */
    static public function BuildTranslations($firstTranslation, $translations, $pronounciations = null){
        
        $response = new self;
        
        $response->firstTranslation = $firstTranslation;
        
        $response->translations = $translations;
        
        $response->pronounciations = $pronounciations;
        
        return $response;
    }
    
    /**
     * 
     * Enter description here ...
     * @param unknown_type $succestions
     * @return Seslisozluk\Api\Response
     */
    static public function BuildSuccesstions($succestions){
        
        $response = new self;
        
        $response->succestions = $succestions;
        
        return $response;
    }
    
    /**
     * 
     * Enter description here ...
     * @param unknown_type $error
     * @return Seslisozluk\Api\Response
     */
    static public function BuildError($error){
        
        $response = new self;
        
        $response->error = $error;
        
        return $response;
    }
    
}