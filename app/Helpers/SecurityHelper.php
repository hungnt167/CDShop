<?php 
function password_encrypt($string, $remeber_token) {
	return md5($string . md5($remeber_token)); 
}