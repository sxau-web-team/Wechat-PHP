<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns=”http://www.w3.org/1999/xhtml”>
<head>
<meta http-equiv=”Content-Type” content=”text/html; charset=utf-8″ />
<title>无标题文档</title>
</head>

<body>
<?php
$username=$_POST['username'];
$password=$_POST['password'];

//连接数据库

$mydb = mysql_connect(“localhost”, “root”, “”);

if (!$mydb) {
die(‘Could not connect:’.mysql_error());
}

//include ‘conn.php’; //用来调用conn.php文件中的数据库连接文件

mysql_select_db(“tushu”,$mydb);

$sql =”select uiname,uipwd from adminadmin where uiname=’$username’ and uipwd=’$password’”;

$result =mysql_query ($sql,$mydb);

$row = mysql_fetch_assoc($result);

if ($row)
{
echo ‘<script>window.location.href=”main.php”</script>’;
}else
{
echo ‘<script>alert(“请输入正确账户密码！”);history.go(-1);</script>’;
}

/*   sql语句没有加条件只能查询验证第一条数据

$sql =”select username,password from admin”;

$row=mysql_fetch_array($sql);

$db_name=$row['username'];

$db_pass=$row['password'];

if ( $username == $db_name && $password ==$db_pass)
{
echo ‘<script>window.location.href=”main.php”</script>’;

}else{
echo ‘<script>alert(“请输入正确账户密码！”);history.go(-1);</script>’;
}

*/

mysql_close($mydb);

?>
</body>
</html>