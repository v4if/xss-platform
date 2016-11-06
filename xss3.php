<?php
/**
 * @Author: v4if
 * @Date:   2016-11-06 11:57:15
 * @Last Modified by:   root
 * @Last Modified time: 2016-11-06 15:19:35
 */
// 开启报错信息
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

require('./docker_db.php');

$db = new DB();
$contacts = $db->all();
?>
