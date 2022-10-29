<?php

function fileStorage($request){
    $imgName = uniqid().$request->file('image')->getClientOriginalName();
    $request->file('image')->storeAs('public',$imgName);
    return $imgName;
}
