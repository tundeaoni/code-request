<?php
namespace App\Lib\Voucher;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * For handling voucher retrieval and 
 * its peculiarities
 *
 * @author Irokotv
 */
class Data {
    
    Const CODE_FILENAME = "ini/all_vouchers.ini";
    Const CODE_POSITION_FILENAME = "ini/position.ini";
    Const POSITION_KEY = "position";
    Const CODES_KEY = "code";


    
    private $codes;
    private $position;
    private $available = null;
    private $nextCode = null;
    
    public function __construct(){
        
        // get storeage paths
        $positionStorePath = storage_path(self::CODE_POSITION_FILENAME );
        $codeStorePath = storage_path(self::CODE_FILENAME);

        // load voucher codes from source
        $this->codes = \parse_ini_file($codeStorePath);
        
        // get useage position
        $this->getPosition((array) \parse_ini_file($positionStorePath));
        
        // set new code
        if($this->available()){
            $this->nextCode();
            $this->updatePosition($positionStorePath);
         }else{
            return NULL;
        }
        
    }
    
    
    public function getCode(){
        return $this->nextCode;
    }        
            
    private function available(){
        if($this->available === NULL){
            return isset($this->codes[$this->position]);
        }
        return $this->available;
    }
    
    private function code(){
        if($this->code === NULL){
            return isset($this->code[$this->position]);
        }
        return $this->available;
    }
    
    
    private function getPosition(array $array){
        
        // not zero indexed
        if(current($array) === FALSE || (int)count($this->codes) <= $this->position){
            $this->available = FALSE;
            $data = 0;
        }else{
            $data = current($array); 
            $this->available = TRUE;
            $this->position = max (0 , ($data - 1));
        }
        
    }
    
    private function nextCode(){
        if($this->nextCode === NULL){
            $this->nextCode = $this->codes[self::CODES_KEY][++$this->position];
            ++$this->position;
            return $this->nextCode;
        }
        return $this->nextCode;
    }
    
    private function updatePosition($location){
        $content = self::POSITION_KEY."=".$this->position;
        
        //create a file handler by opening the file
        $myTextFileHandler = @fopen($location,"r+");

        //truncate the file to zero
        //or you could have used the write method and written nothing to it
        @ftruncate($myTextFileHandler, 0);
        fclose($myTextFileHandler);
        
        
        $myTextFileHandler = fopen($location, 'w');
        $success = fwrite($myTextFileHandler, $content);

        fclose($myTextFileHandler); 
    }
    
}
