<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

class database_connect {
	public $link = NULL;
	// public $server = DB_SERVER;
	
	public function __construct() {
		// $this->link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$this->link = new mysqli(
			DB_HOST, 
			DB_USER, 
			DB_PASSWORD, 
			DB_NAME
		);
		if( ! $this->link ) {
			echo 'Couldn\'t connect to db.';
			exit;
		}
		
		// $gotDb = mysqli_select_db($this->link, DB_DATABASE);
		// if(! $gotDb ) {
		// 	echo 'Couldn\'t select the requested db.';
		// 	exit;
		// }
	}
    
	public function test() {
		return 'test display';
	}
}


$db = new database_connect();