<?php
class ErrorHandler{
    private $error_files = [];



    public function handle($error_code){
        if(array_key_exists($error_code, $this->error_files)){
            include_once($this->error_files[$error_code]);
            exit();
        }else{
           
        }
   }
}