<?php

namespace Seslisozluk;

class Config{
    
    protected $enableStatistics = false;
    
    protected $langFrom = null;
    
    protected $langTo = null;
    
    protected $autoPlayPronounciation = false;
    
    protected $databaseDsn;
    
    
    
    
    
    public function getEnableStatistics(){

        return $this->enableStatistics;
    }

	public function setEnableStatistics($enableStatistics){

        $this->enableStatistics = $enableStatistics;
    }

	public function getLangFrom(){

        return $this->langFrom;
    }

	public function setLangFrom($langFrom){

        $this->langFrom = $langFrom;
    }

	public function getLangTo(){

        return $this->langTo;
    }

	public function setLangTo($langTo){

        $this->langTo = $langTo;
    }

	public function getAutoPlayPronounciation(){

        return $this->autoPlayPronounciation;
    }

	public function setAutoPlayPronounciation($autoPlayPronounciation){

        $this->autoPlayPronounciation = $autoPlayPronounciation;
    }

	public function getDatabaseDsn(){

        return $this->databaseDsn;
    }

	public function setDatabaseDsn($databaseDsn){

        $this->databaseDsn = $databaseDsn;
    }

	/**
     * @param string $ini_file
     * @return Config
     */
    static public function CreateFromIniFile($ini_file){
        
        $ini_cfg = null;
                
        if (is_readable($ini_file)) {
            
            $ini_cfg = @parse_ini_file($ini_file, true);
            
            //print_r($ini_cfg);
        }
        
        $config = self::MergeConfigs($ini_cfg, self::GetDefaultConfig());
        
        //var_dump($config); exit;
        
        
        $cfg = new Config();
        
        $cfg->langFrom     = $config['filter']['from'];
        
        $cfg->langTo       = $config['filter']['to'];
        
        $cfg->autoPlayPronounciation = $config['general']['auto_play_pronounciation'];
        
        $cfg->databaseDsn = $config['database']['dsn'];
        
        return $cfg;
        
    }
    
    
    static protected function MergeConfigs($config, $default){
        
        if (!is_array($config)) {
            
            return $default;
        }
        
        foreach ($default as $section => $section_config){
            
            if (isset($config[$section])) {
                
                $default[$section] = array_merge($section_config, $config[$section]);
            }
        }
        
        return $default;
    }
    
    
    static protected function GetDefaultConfig(){
        
        return array(
            'filter' => array(
            	'from' => null, 
            	'to' => null
            ),
            'general' => array(
                'auto_play_pronounciation' => false,
            ),
            'database' => array(
                'dns' => null,
            )
        
        );
        
    }
    
    
}