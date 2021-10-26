<?php
/* 
*  功能 :亮度值接收&伝送
*  Author: Zangmen Hsu
*/

/*資料庫設定*/
$host = "localhost";		  // 伺服器位置(default:localhost)
$dbname = "esp8266_data";     // 資料庫名稱
$username = "master";		  // 帳戶
$password = "AA10bb17";	      // 密碼


/*建立資料庫連結(MySQLi)*/
$conn = new mysqli($host, $username, $password, $dbname);

/*檢查是否有連線成功(同時傳給Arduino)*/
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    //向資料庫獲得新的資料(由'date'&'time'來判定)
    $get_sql = "SELECT * FROM `sensor_light` ORDER BY `date` AND `time` DESC LIMIT 1 ";
	$get_sql2 = "SELECT * FROM `default_sensor`";
    $get_sql3 = "SELECT * FROM `device_switch`";
	
    $result = $conn->query($get_sql);
	$result2 = $conn->query($get_sql2);
    $result3 = $conn->query($get_sql3);
	
    $row = $result->fetch_assoc();
	$row2 = $result2->fetch_assoc();
    $row3 = $result3->fetch_assoc();
	//回伝:light,default_light,time 
    echo "light=  ".$row["light"];
    echo ",default_light= ".$row2["default_light"];
    echo ",led_switch=". $row3["led_switch"];
	echo ",time= ".$row["time"];
	echo ",date= ".$row["date"];
	
	/* led on&off */
	$getLight_d = $row2["default_light"];
	$getLight_t = $row["light"];
	if($getLight_t >= $getLight_d){
		echo " LED_ON";
	}else if($getLight_t <= $getLight_d){
		echo " LED_OFF";
	}else{
		echo " ERROR";
	}
	
}
   
/*時間設定*/
date_default_timezone_set('Asia/Taipei');  //時區 
/*timezone refer: https://www.php.net/manual/en/timezones.asia.php*/
$d = date("Y-m-d"); //日期(格式:年-月-日)
$t = date("H:i:s"); //時間(格式:時-分-秒)
    
// If values send by NodeMCU are not empty then insert into MySQL database table
// 使用POST來送出資料
if(!empty($_POST['light'])){
		$light = $_POST['light'];
        
        /*把資料上傳到資料庫的表格上*/
	    $post_sql = "INSERT INTO sensor_light (light, date, time) VALUES ('".$light."', '".$d."', '".$t."')"; 
		
		
		/*檢查是否有成功上傳*/
		if ($conn->query($post_sql) == TRUE) {
		    //echo "Values inserted in MySQL database table.";
		}else{
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
}

/*関閉資料庫連線(MySQLi)*/
$conn->close();

?>
