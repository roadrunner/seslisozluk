<?php

namespace Seslisozluk;

use Seslisozluk\Api;

class Api{
    
    const API_URL             = 'http://m.seslisozluk.com/';
    
    protected $filterFrom     = null;
    
    protected $filterTo       = null;
    
    /**
     * @param mixed $lang
     * @return Api
     */
    public function filterFrom($lang){
        
        $this->filterFrom = $lang;
        
        return $this;
    }
    
    /**
     * @param mixed $lang
     * @return Api
     */
    public function filterTo($lang){
        
        $this->filterTo = $lang;
        
        return $this;
    }
    
    
    protected function filteredFrom($lang){
        
        if (null === $this->filterFrom || $lang == $this->filterFrom) {
            
            return true;
        }
        
        if (is_array($this->filterFrom)) {
            
            return in_array($lang, $this->filterFrom);
        }
        
        return false;
        
    }
    
    
    protected function filteredTo($lang){
        
        if (null === $this->filterTo || $lang == $this->filterTo) {
            
            return true;
        }
        
        if (is_array($this->filterTo)) {
            
            return in_array($lang, $this->filterTo);
        }
        
        return false;
        
    }
    
    
    
    
    /**
     * lookup translation for a phrase
     * @param string $phrase
     * @return Seslisozluk\Api\Response
     */
    public function lookup($phrase, $filterFrom = null, $filterTo = null){
        
        if (null !== $filterFrom) {
            
            $this->filterFrom($filterFrom);
        }
        
        if (null !== $filterTo) {
            
            $this->filterTo($filterTo);
        }
        
        
        
        $res_html = $this->_fetchPhrase($phrase);
        
        
        $pronounciations = null;
        
        if(preg_match_all('@<a href="(http://voice\.seslisozluk\.com/pronunciation/.*?\.mp3)">@i', $res_html, $mp3_matches)){
            
            //print_r($mp3_matches);
            
            $pronounciations = $mp3_matches[1];
        }
        
        
        
        if(preg_match_all('@<table width="100%" cellpadding="3" cellspacing="0"><tbody class="divDrop" id="([\w]+)">(.*?)</tbody></table></h3></div></div>@', $res_html, $matches)){
            
            //print_r($matches);
            
            // $matches[1][0] -> dr_en_tr
            // $matches[1][2] -> dr_en_de
            
            // $matches[2][0] -> translation for en_tr
            
            // build api translation response
            
            $langs = array();
            
            $translations = array();
            
            $first_translation = null;
            
            for($i = 0; $i < count($matches[1]); $i++){
                
                $lang_to_lang = preg_replace('/^dr_/', '', $matches[1][$i]);
                
                list($fromLang, $toLang) = split('_', $lang_to_lang);
                
                //print_r('from: '.$fromLang.' - to: '.$toLang);
                
                
                if ($this->filteredFrom($fromLang) && $this->filteredTo($toLang)) {
                    
                    //echo $lang_to_lang."\n";
                    
                    $translations[$lang_to_lang] = new Translation($fromLang, $toLang, $matches[2][$i], $phrase);
                    
                    if (null === $first_translation) {
                        
                        $first_translation = $lang_to_lang;
                    }
                }
            }

            $response = Api\Response::BuildTranslations($first_translation, $translations, $pronounciations);
            
            return $response;
            
        }else if(preg_match('@<div class="didumean">@', $res_html)){
            
            if (preg_match('@<div class="dum_div">(.*?)</div>@', $res_html, $matches)) {
                
                
                if(preg_match_all('@<a[^>]*?>(.*?)</a>@', $matches[1], $m)){
                    
                    $response = Api\Response::BuildSuccesstions($m[1]);
                    
                    return $response;
                }
            }
                        
        }
        
        
        $response = Api\Response::BuildError('unknown error.. fixme!'); // TODO: give something clear
    }
    
    
    protected function _lookupUrl($phrase){
        
        return self::API_URL.'?word='.urlencode($phrase);
    }
    
    protected function _fetchPhrase($phrase){
        
        $url = $this->_lookupUrl($phrase);
        
        return file_get_contents($url);
    }
    
}