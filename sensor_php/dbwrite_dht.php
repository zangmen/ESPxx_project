<?php
/* 
*  功能 :溫溼度接收&伝送
*  Author: Zangmen Hsu
*/

/*資料庫設定*/
$host = "localhost";		  // 伺服器位置(default:localhost)
$dbname = "esp8266_data";     // 資料庫名稱
$username = "master";		  // 帳戶
$password = "AA10bb17";	      // 密碼

/*建立資料庫連結(MySQLi)*/
$conn = new mysqli($host, $username, $password, $dbname);
  
/*時間設定*/
date_default_timezone_set('Asia/Taipei');  //時區 
//*timezone refer: https://www.php.net/manual/en/timezones.asia.php
$d = date("Y-m-d"); //日期(格式:年-月-日)
$t = date("H:i:s"); //時間(格式:時-分-秒)
    
// If values send by NodeMCU are not empty then insert into MySQL database table
// 使用POST來送出資料
if(!empty($_POST['temp']) && !empty($_POST['hum']) ){
		$temp = $_POST['temp'];
        $hum = $_POST['hum'];
        
        /*把資料上傳到資料庫的表格上*/
	    $post_sql = "INSERT INTO sensor_dht (temp, hum, date, time) VALUES ('".$temp."','".$hum."', '".$d."', '".$t."')"; 
		
		/*檢查是否有成功上傳*/
		if ($conn->query($sql) == TRUE) {
		    echo "Values inserted in MySQL database table.";
		}else{
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
}


/*檢查是否有連線成功(同時傳給Arduino)*/
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    //向資料庫獲得新的資料(由'date'&'time'來判定)
    $get_sql = "SELECT * FROM `sensor_dht` ORDER BY `date` AND `time` DESC LIMIT 1 ";
    $get_sql1 = "SELECT * FROM `default_sensor`";
	$get_sql2 = "SELECT * FROM `default_switch`";
	$result = $conn->query($get_sql);
	$result1 = $conn->query($get_sql1);
	$result2 = $conn->query($get_sql2);
    $row = $result->fetch_assoc();
	$row1 = $result1->fetch_assoc();
	$row2 = $result2->fetch_assoc();
	//回伝:temp,default_temp,hum,default_hum,fan_switch,time 
    echo "temp= ".$row["temp"];
	echo ",default_temp=".$row1["default_temp"];
    echo ",hum= ".$row["hum"]; 
    echo ",default_hum= ".$row1["default_hum"];	
	echo ",fan_switch= ".$row2["fan_switch"];
    echo ",time= ".$row["time"];  
}

/*関閉資料庫連線(MySQLi)*/
$conn->close();

?>
