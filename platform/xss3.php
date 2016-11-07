<?php
/**
 * @Author: v4if
 * @Date:   2016-11-06 11:57:15
 * @Last Modified by:   v4if
 * @Last Modified time: 2016-11-07 11:56:28
 */
// 开启报错信息
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

// 关闭浏览器XSS过滤功能
header('X-XSS-Protection:0');

require('../utils/DB.php');

$db = new DB();

$action = "";
if (isset($_GET['action'])) {
	$action = $_GET['action'];
};
switch ($action) {
	case 'submitted':
		if (isset($_POST['action']) && $_POST['action'] == 'submitted') {
		    // print '<pre>';

		    // print_r($_POST);
		    // print '<a href="'. $_SERVER['PHP_SELF'] .'">Please try again</a>';

		    // print '</pre>';

		    // 将留言区内容写入数据库
		    $db->add($_POST['title'], $_POST['area']);
		    echo "留言区数据插入成功！";
		    echo '<a href="'. $_SERVER['PHP_SELF'] .'">Please back and try again</a>';
		} else {
			echo "请用正确的姿势提交留言！";
		}
		break;
	case 'delete':
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$db->remove($id);
			echo "留言区数据删除成功！";
			echo '<a href="'. $_SERVER['PHP_SELF'] .'">Please back and try again</a>';
		};
		break;
	case 'drop':
		$db->drop();
		echo "数据库删除成功！";
		break;
	default:
		$action = 'default';
		$comment = $db->all();
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
	        <div id="title">存储型XSS漏洞示例</div>
	        
	       	<table class="table">
			    <caption>留言区</caption>
			    <thead>
			    <tr>
			        <th>#</th>
			        <th>标题</th>
			        <th>内容</th>
			        <th>删除</th>
			    </tr>
			    </thead>
			    <tbody>
			    <?php foreach ($comment as $index => $comm) {
			        ?>
			        <tr>
			            <th scope="row"> <?php echo $index + 1 ?></th>
			            <td><?php echo $comm['title'] ?></td>
			            <td><?php echo $comm['area'] ?></td>
			            <td>
			                <a href="<?php echo $_SERVER['PHP_SELF'];?>?action=delete&id=<?php echo $comm['id'] ?>">删除</a>
			            </td>
			        </tr>
			    <?php
			    } ?>
			    </tbody>
			</table>
	       	<br><hr>

	       	<form action="<?php echo $_SERVER['PHP_SELF'];?>?action=submitted" method="post" onsubmit="return verify()">
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
<?php } ?>
