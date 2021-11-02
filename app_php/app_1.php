<?php

/*資料庫設定*/
$host = "localhost";		  // 伺服器位置(default:localhost)
$dbname = "esp8266_data";     // 資料庫名稱
$username = "master";		  // 帳戶
$password = "AA10bb17";	      // 密碼

/*建立資料庫連結(MySQLi)*/
$conn = new mysqli($host, $username, $password, $dbname);

/*dht*/
$get_sql  = "SELECT * FROM `sensor_dht` ORDER BY `date` AND `time` DESC LIMIT 1 ";
$result = $conn->query($get_sql);
$row = $result->fetch_assoc();

/*預設值*/
$get_sql2 = "SELECT * FROM `default_sensor`";
$result2 = $conn->query($get_sql2);
$row2 = $result2->fetch_assoc();

/*變數*/
$client_1 = $_POST['client_1'];
$client_2 = $_POST['!'];
$mode_1 = "!";

/*主程式*/
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    if($client_1 == $mode_1){
	  //回伝:temp,default_temp,hum,default_hum,time
      echo "temp=".$row["temp"];
      echo ",default_temp=".$row2["default_temp"];
      echo ",hum=".$row["hum"];
      echo ",time=".$row["time"];
	  echo ",date=".$row["date"];
    }else{
	  echo "ERROR";
    }
	
	if($client_2 == $mode_1){
		echo "!";
	}else{
		echo "ERROR";
	}
}

$conn->close();

?>