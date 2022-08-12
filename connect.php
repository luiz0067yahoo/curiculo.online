<?php
	
	class connect {
		public static $instance;
		public static $servername_		=	"localhost";
		public static $username_		="root";
		public static $password_	=	"";
		public static $database_	=	"CV";
		private function __construct() {
		}

		public static function getInstance() {
			if (!isset(self::$instance)) {
					self::$instance = new PDO("mysql:host=".self::$servername_.";dbname=".self::$database_.";", self::$username_, self::$password_,
						array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
					);
					//utf8_general_ci
					self::$instance->setAttribute(PDO::ATTR_ERRMODE,
					PDO::ERRMODE_EXCEPTION);
					self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS,
					PDO::NULL_EMPTY_STRING);
				}
			return self::$instance;
		}
		public static function close() {
			self::$instance=null;
		}
	}





?>
