<?php

namespace Seslisozluk\Api;

class Response{
    
    protected $succestions = null;
    
    protected $translations = array(); // array('tr_tr' => ...);
    
    protected $firstTranslation = null;
    
    protected $error        = null;
    
    
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
    
    
    public function translationCount(){
        
        return count($this->translations);
    }
    
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
    static public function BuildTranslations($firstTranslation, $translations){
        
        $response = new self;
        
        $response->firstTranslation = $firstTranslation;
        
        $response->translations = $translations;
        
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