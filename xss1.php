<?php
/**
 * @Author: v4if
 * @Date:   2016-11-06 11:57:15
 * @Last Modified by:   root
 * @Last Modified time: 2016-11-06 13:37:30
 */
// 开启报错信息
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

// 关闭浏览器XSS过滤功能
header('X-XSS-Protection:0');

$out = "您输入的内容是：";
if (isset($_GET['param'])) {
	$var = $_GET['param'];
	$out = $out.$var;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <style type="text/css">
          body {
            background-color: #eee;
            font: 14px/1.5 'Helvetica Neue', 'STHeiti', 'Microsoft YaHei', Helvetica,Arial,sans-serif;
          }
          #main-content {
            width: 70%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 150px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fdfdfd;
            box-shadow: 0px 0px 8px #aaa;
          }
          #title {
            text-align: center;
          }
        </style>
    </head>
    <body>
      <div id="main-content">
        <div id="title">反射型XSS漏洞示例：GET方式提交</div>
        
        <?php echo $out; ?>

      </div>                                                     
    </body>
</html>

