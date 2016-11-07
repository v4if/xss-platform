<?php
/**
 * @Author: v4if
 * @Date:   2016-11-06 11:57:15
 * @Last Modified by:   v4if
 * @Last Modified time: 2016-11-07 11:20:42
 */
// 开启报错信息
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

// 关闭浏览器XSS过滤功能
header('X-XSS-Protection:0');

require('../utils/DB_Sql.php');

$db = new DB_Sql();

$action = "";
if (isset($_GET['action'])) {
	$action = $_GET['action'];
};
switch ($action) {
	case 'query':
		if (isset($_POST['action']) && $_POST['action'] == 'submitted') {
			$action = 'default';
			$id = $_POST['sqlinject'];
			$query  = "SELECT first_name, last_name FROM users WHERE user_id = '$id';";
			$users = $db->exec($query);
		} else {
			echo "请用正确的姿势提交！";
		}
		break;
	default:
		$action = 'default';
		$users = "";
		break;
}
?>
<?php if ($action == 'default') { ?>
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
	        <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	    </head>
	    <body>
	      <div id="main-content">
	        <div id="title">Sql注入漏洞示例</div>
	        
	        <form action="<?php echo $_SERVER['PHP_SELF'];?>?action=query" method="post" onsubmit="return verify()">
	       		Sql injection：
	       		<input type="text" name="sqlinject" id="sqlinject">
	       		<input type="hidden" name="action" value="submitted">
	       		<input type="submit" name="submit">
	       	</form>

	       	<table class="table">
			    <caption>查询信息</caption>
			    <thead>
			    <tr>
			        <th>#</th>
			        <th>first_name</th>
			        <th>last_name</th>
			    </tr>
			    </thead>
			    <tbody>
			    <?php foreach ($users as $index => $user) {
			        ?>
			        <tr>
			            <th scope="row"> <?php echo $index + 1 ?></th>
			            <td><?php echo $user['first_name'] ?></td>
			            <td><?php echo $user['last_name'] ?></td>
			        </tr>
			    <?php
			    } ?>
			    </tbody>
			</table>
	      </div>             

	      <script type="text/javascript">
	        function verify() {
				var sqlinject = document.getElementById("sqlinject").value;
				if (sqlinject.trim() == "")
				{
					alert("请输入Sql injection");
					return false;
				}
				return true;
	        }
	      </script>                                            
	    </body>
	</html>
<?php } ?>
