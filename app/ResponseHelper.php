<?php
namespace App;

class ResponseHelper {
    static function success($data=[],$message = 'success'){
        return response()->json([
            'data'=>$data,
            'message'=>$message
        ],200);
    }

    static function fail($message = 'fail'){
        return response()->json([
            'message'=>$message
        ],422);
    }
}
