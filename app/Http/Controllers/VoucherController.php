<?php

namespace App\Http\Controllers;
use \App\Lib\Voucher\Data;

/**
 * Description of VoucherController
 *
 * @author Irokotv
 */



class VoucherController extends Controller {
    
    const OK = 200;
    const UNAUTHORIZED = 401;
    CONST ERROR = 500;
    
    public function getVoucher(){
        $dataObject = new Data();
        $data = array();
        $data["response-code"] = self::OK ;
        $data["message"] = "OK" ;
        $start = time();
        
        if($dataObject->getCode()){
            $data["code"] =  $dataObject->getCode();
            
         }else{
            $data["code"] =  0;
        }

        return response()->json($data);
    }
    
}
