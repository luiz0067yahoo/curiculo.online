<?php
	date_default_timezone_set("America/Sao_Paulo");
	class connect {
		public static $instance;
		const         servername_		        =	"";
		const         username_		            =   "";
		const         password_                 =	"";
		const         database_                 =	"";
		
		const         smtp_server               =   "";
		const         default_email	            =	"";
		const         default_email_password	=	"";
		
		const         JWT_key	                =	"";
		const         time_session	            =	"";
		
		const         name_app_default	        =	"";
		const         user_app_default	        =	"";
		const         password_app_default	    =	"";
		const         email_app_default	        =	"";
		
		private function __construct() {
		}

		public static function getInstance() {
			if (!isset(self::$instance)) {
					self::$instance = new PDO("mysql:host=".self::servername_.";dbname=".self::database_.";", self::username_, self::password_,
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
