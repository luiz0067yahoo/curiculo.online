<?php
	date_default_timezone_set("America/Sao_Paulo");
	class connect {
		public static $instance;
		const         servername_		        =	"localhost";
		const         username_		            =   "u455891610_root";
		const         password_                 =	"9b=vo[bO";
		const         database_                 =	"u455891610_cv";
		
		const         smtp_server               =   "smtp.hostinger.com.br";
		const         default_email	            =	"naoresponda@curiculo.online";
		const         default_email_password	=	"]!xY/>Lv3";
		
		const         JWT_key	                =	"kTiD-pNY6-Uz$!Ri(0:q(Ctf;^{{^O";
		const         time_session	            =	"+10 minutes";
		
		const         name_app_default	        =	"app curiculo online";
		const         user_app_default	        =	"NUaRIenCoNordonetersErYonfISQuiS";
		const         password_app_default	    =	"F0Fp>4klc8Fosy>|pW!,erxDq)JK$[Sn|XpSf#(I";
		const         email_app_default	        =	"app@curiculo.online";
		
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
