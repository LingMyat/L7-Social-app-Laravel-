<?php
namespace App;

class ResponseHelper {
    static function success($data=[],$message = 'Success'){
        return response()->json([
            'data'=>$data,
            'message'=>$message
        ],200);
    }

    static function fail($message = 'Error'){
        return response()->json([
            'message'=>$message
        ],422);
    }
}
