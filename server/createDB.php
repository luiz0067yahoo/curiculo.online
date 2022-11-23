<?php
require_once($base_server_path_files.'/server/library/functions.php');

$sql="CREATE TABLE IF NOT EXISTS `logs` (";
$sql.="  `id` int(11) DEFAULT NULL,";
$sql.="  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,";
$sql.="  `username` blob NOT NULL,";
$sql.="  `start_session` datetime NOT NULL,";
$sql.="  `end_session` datetime DEFAULT NULL,";
$sql.="  `date_insert` datetime DEFAULT NULL,";
$sql.="  `date_update` datetime DEFAULT NULL";
$sql.=") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
DAOquery($sql,[],false,"");

$sql="CREATE TABLE IF NOT EXISTS `users` (";
$sql.="  `id` int(11) NOT NULL AUTO_INCREMENT,";
$sql.="  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,";
$sql.="  `username` blob NOT NULL,";
$sql.="  `password` blob NOT NULL,";
$sql.="  `e_mail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,";
$sql.="  `e_mail_crypto` blob NOT NULL,";
$sql.="  `cell_phone` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,";
$sql.="  `telephone` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,";
$sql.="  `code` blob DEFAULT NULL,";
$sql.="  `code_time` datetime DEFAULT NULL,";
$sql.="  `attempts` int(11) DEFAULT 0,";
$sql.="  `date_insert` datetime DEFAULT NULL,";
$sql.="  `date_update` datetime DEFAULT NULL,";
$sql.="  PRIMARY KEY (`id`)";
$sql.=") ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
DAOquery($sql,[],false,"");


$sql="CREATE TABLE IF NOT EXISTS `estados` (";
$sql.="  `id` int(11) NOT NULL AUTO_INCREMENT,";
$sql.="  `nome` varchar(50) CHARACTER SET utf8 DEFAULT NULL,";
$sql.="  `sigla` char(2) CHARACTER SET utf8mb4 DEFAULT NULL,";
$sql.="  `date_insert` datetime DEFAULT NULL,";
$sql.="  `date_update` datetime DEFAULT NULL,";
$sql.="  PRIMARY KEY (`id`)";
$sql.=") ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
DAOquery($sql,[],false,"");


$params=[
"name"=>hash('sha512',connect::name_app_default),
"username"=>hash('sha512',connect::user_app_default),
"password"=>hash('sha512',connect::password_app_default),
"e_mail_crypto"=>hash('sha512',connect::email_app_default),
"e_mail"=>connect::email_app_default,
"code"=>hash('sha512', time()),
"code_time"=>date('Y-m-d H:i:s', time()),
"date_insert"=>date('Y-m-d H:i:s', time()),
];
DAOqueryInsert($table="users",$params);




DAOquery($sql,[],false,"");

//DAOquery($sql,$paramsQuery,$select_execute,$limitParams);

?>