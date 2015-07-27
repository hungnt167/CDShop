<?php 
function redirect_success($url, $message){
	return redirect()->action($url)->withSuccess($message);
}

function redirect_errors($message){
	return redirect()->back()->withErrors($message);
}