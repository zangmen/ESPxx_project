<?php

/*資料庫設定*/
$host = "localhost";		    // 伺服器位置(default:localhost)
$dbname = "esp8266_data";       // 資料庫名稱               
$username = "master";		    // 帳戶              
$password = "AA10bb17";	        // 密碼             

if ($_SERVER["REQUE_METHOD"]== "POST"){
   /*建立資料庫連結(MySQLi)*/
   $conn = new mysqli($host, $username, $password, $dbname);
   /*檢查是否有連線成功*/
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }else{
	  echo "Connected to mysql database. <br>"; 
   }
   $conn->close();
}else{
	echo "No Data in http POST";
}
?>