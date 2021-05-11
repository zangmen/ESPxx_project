<!doctype html>
<html>
<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.inc.php");
echo "目前使用者:".$_SESSION['username'];
echo '<br><a href="logout.php">登出</a>  <br><br>';
?>

<head>
<meta charset="utf-8">
<title>監控溫室專案檔bata3.2</title>
<style type="text/css">
.main {
	background-color: #FFF;
}
.maintext a {
	color: #000;
	text-decoration: none;
	display: block;
}
.maintext a:hover {
	color: #F00;
	background-color: #FF0;
	text-decoration: none;
}
.maintext {
	background-color: #eee;
	text-align: center;
	text-decoration: none;
	overflow: hidden;
	font-size: 24px;
	font-style: normal;
	font-family: "標楷體";
}
.main td {
	font-size: 72px;
	font-family: "標楷體";
	color: #000;
	font-style: italic;
	line-height: normal;
}
.maintext1 {	background-color: #eee;
	text-align: center;
	text-decoration: none;
	overflow: hidden;
	font-size: 24px;
	font-style: normal;
	font-family: "標楷體";
}
</style></head>

<body bgcolor="#999999">
<table width="1024" border="0" align="center" cellpadding="0">
  <tr align="center" valign="middle" class="main">
    <td height="200" colspan="2">監視網頁</td>
  </tr>
  <tr>
    <td width="200" height="683" align="center" valign="middle"><iframe src="Menu.html" name="menu" width="200" height="663" scrolling="auto"></iframe>&nbsp;</td>
    <td width="824" height="683" align="center" valign="middle"><table width="824" border="0" cellpadding="0">
      <tr>
        <td width="824" height="654"><table width="824" border="0" cellpadding="0">
          <tr>
            <td width="824" height="654"><span class="maintext1">
              <iframe src="dbread.php" name="main" width="824" height="654" scrolling="auto"></iframe>
            </span></td>
          </tr>
        </table>      </td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>