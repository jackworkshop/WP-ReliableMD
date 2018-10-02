<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/10/2
 * Time: 11:27
 */
namespace WPReliableMD;

class Poster{
	static function GetToken() {
		$token = (string)(rand() << 16 | rand());
		if (!isset($_SESSION['RMD_POSTER_TOKENS']))
			$_SESSION['RMD_POSTER_TOKENS'] = array();
		$_SESSION['RMD_POSTER_TOKENS'][] = $token;
		return $token;
	}
	static function CheckToken($token){
		for ($i = 0; $i < $_SESSION['RMD_POSTER_TOKENS']; ++$i){
			if($_SESSION['RMD_POSTER_TOKENS'][$i] ==$token)
				return true;
		}
		return false;
	}
}

if ( isset( $_POST['token'] ) && isset( $_POST['data'] ) ) {
	$token = $_POST['token'];
	$data = json_decode($_POST['data']);
	if (Poster::CheckToken($token))
	{
		$obj = new stdClass();
		$obj->success = false;
		$obj->text = 'token error';
		die(json_encode($obj));
	}
	print_r($data);
}
