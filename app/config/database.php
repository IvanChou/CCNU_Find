<?php defined('INDEX_PAGE') or die('no entrance');
/**
 * 数据库配置文件
 * 目前仅支持 mysql 数据库
 * 支持数据库主从分离，支持多数据库连接
 * 支持一主多从，从库加 Slave 区分，可在此动态确定具体的从库
 * 
 * filename:	database.php
 * charset:		UTF-8
 * create date: 2012-5-25
 * 
 * @author Zhao Binyan <itbudaoweng@gmail.com>
 * @copyright 2011-2012 Zhao Binyan
 * @link http://yungbo.com
 * @link http://weibo.com/itbudaoweng
 */

//改善机制，支持多数据库
$db_conf = array();

//是否启用数据库
define('IS_DB_ACTIVE', TRUE);

/*---------------- default 数据库 -----------------*/
$db_conf['default'] = array(
	'db_username' => 'root',
	'db_passwd' => 'root',
	'db_database' => 'ccnu_find',
	'db_host' => 'localhost',	//默认 localhost
	'db_port' => '3306',		//默认 3306
);

// 从数据库
// $db_conf['default_slave'] = array(
// 	'db_username' => 'root',
// 	'db_passwd' => '123456',
// 	'db_database' => 'testdata',
// 	'db_host' => 'localhost',
// 	'db_port' => '3306',
// );

//如果是 Appfog 环境
if (getenv('VCAP_SERVICES')) {
    $services_json = json_decode(getenv("VCAP_SERVICES"),true);
    $mysql_config = $services_json["mysql-5.1"][0]["credentials"];

	/*---------------- Appfog 数据库 -----------------*/
	$db_conf['default'] = array(
		'db_username' => $mysql_config["username"],
		'db_passwd' => $mysql_config["password"],
		'db_database' => $mysql_config["name"],
		'db_host' => $mysql_config["hostname"],
		'db_port' => $mysql_config["port"]
	);

}
