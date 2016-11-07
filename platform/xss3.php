<?php
/**
 * @Author: v4if
 * @Date:   2016-11-06 11:57:15
 * @Last Modified by:   v4if
 * @Last Modified time: 2016-11-07 09:48:07
 */
// 开启报错信息
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

// 关闭浏览器XSS过滤功能
header('X-XSS-Protection:0');

require('../utils/DB.php');

$db = new DB();
$comment = $db->all();
print_r($comment);

if (isset($_POST['action']) && $_POST['action'] == 'submitted') {
    print '<pre>';

    print_r($_POST);
    print '<a href="'. $_SERVER['PHP_SELF'] .'">Please try again</a>';

    print '</pre>';

    // 将留言区内容写入数据库
    $db->add($_POST['title'], $_POST['area']);
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
          hr {
              border: 1px dashed #aaa; 
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
          .vertical-top {
          	vertical-align: top;
          }
        </style>
    </head>
    <body>
      <div id="main-content">
        <div id="title">存储型XSS漏洞示例</div>
        
       	<strong>留言区</strong>
       	<br><hr>

       	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onsubmit="return verify()">
       		<span class="vertical-top">标题：</span><textarea rows="1" cols="50" name="title" id="sub_title"></textarea><br>
       		<span class="vertical-top">内容：</span><textarea rows="3" cols="50" name="area" id="sub_area"></textarea><br>
       		<input type="hidden" name="action" value="submitted">
       		<input type="submit" name="submit">
       	</form>

      </div>             

      <script type="text/javascript">
        function verify() {
			var sub_title = document.getElementById("sub_title").value;
			var sub_area = document.getElementById('sub_area').value;
			if ((sub_title.trim() == "") || (sub_area.trim() == ""))
			{
				alert("请输入留言的标题的内容");
				return false;
			}
			return true;
        }
      </script>                                            
    </body>
</html>


