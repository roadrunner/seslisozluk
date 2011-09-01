<?php


namespace Seslisozluk;

class Api{
    
    const API_URL = 'http://m.seslisozluk.com/';
    
    
    
    /**
     * lookup translation for a phrase
     * @param string $phrase
     * @return Seslisozluk\Api\Response
     */
    public function lookup($phrase){
        
        $res_html = $this->_fetchPhrase($phrase);
        
        if(preg_match_all('@<table width="100%" cellpadding="3" cellspacing="0"><tbody class="divDrop" id="([\w]+)">(.*?)</tbody></table></h3></div></div>@', $res_html, $matches)){
            
            print_r($matches);
            
            // $matches[1][0] -> dr_en_tr
            // $matches[1][2] -> dr_en_de
            
            // $matches[2][0] -> translation for en_tr
            
            // build api translation response
            
            $langs = array();
            
            foreach ($matches[1] as $dirty_lang){
                
                $langs[] = preg_replace('/^dr_/', '', $dirty_lang);
            }
                        
            $first_translation = $langs[0];
            
            $translations = array_combine($langs, array_values($matches[2]));
            
            $response = Api\Response::BuildTranslations($first_translation, $translations);
            
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
        
        return self::API_URL.'?word='.$phrase;
    }
    
    protected function _fetchPhrase($phrase){
        
        $url = $this->_lookupUrl($phrase);
        
        return file_get_contents($url);
    }
    
}