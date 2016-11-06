<?php
/**
 * @Author: v4if
 * @Date:   2016-11-06 11:57:15
 * @Last Modified by:   v4if
 * @Last Modified time: 2016-11-06 16:11:48
 */
// 开启报错信息
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

/**
 * 获取环境变量
 * @param $key
 * @param null $default
 * @return null|string
 */
function env($key, $default = null)
{
    $value = getenv($key);
    if ($value === false) {
        return $default;
    }
    return $value;
} 

$serverName = env("MYSQL_PORT_3306_TCP_ADDR", "localhost");
$port = env("MYSQL_PORT_3306_TCP_PORT", "3306");
$databaseName = env("MYSQL_INSTANCE_NAME", "homestead");
$username = env("MYSQL_USERNAME", "homestead");
$password = env("MYSQL_PASSWORD", "secret");


# 连接到数据库
$conn = mysql_connect($serverName.':'.$port, $username, $password) or die('Cannot connect to MySQL');
mysql_select_db($databaseName, $conn) or die('Cannot connect to the database');
mysql_query('SET NAMES utf8');

echo "done";
?>
