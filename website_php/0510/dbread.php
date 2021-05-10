<?php

/*資料庫設定*/
$host = "120.102.34.39";		 // 伺服器位置(default:localhost)
$dbname = "esp8266_data";        // 資料庫名稱               
$username = "master";		     // 帳戶              
$password = "AA10bb17";	         // 密碼             

/*建立資料庫連結(MySQLi)*/
$conn = new mysqli($host, $username, $password, $dbname);

/*檢查是否有連線成功*/
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
	echo "Connected to mysql database. <br>"; 
}

/*時間設定*/
date_default_timezone_set('Asia/Taipei');  //時區 
$d = date("Y-m-d"); //日期(格式:年-月-日)
$t = date("H:i:s"); //時間(格式:時-分-秒)
 
/*
 * 登入畫面 
*/

/*查詢資料庫資料*/
$login_user = $_POST['login_user'];
$login_password = $_POST['login_password'];
$login_sql = "SELECT * FROM `login_table` WHERE `user` = '$login_user' AND `password` = '$login_password'";
$login_result = mysqli_query($conn,$login_sql);
$login_row = mysqli_fetch_assoc($login_result);

/*判斷帳號與密碼是否為空白或存在資料庫*/
if($login_user != NULL && $login_password != NULL && $login_row['user'] == $login_user && $login_row['password'] == $login_password ) {
    //將帳號寫入session，方便驗證使用者身份
    $_SESSION['username'] = $login_user;
    echo '登入成功! ';
}else{
    echo '登入失敗! ';
}
 
/*
 * sensor控制
*/

//接收確認碼
if(!empty($_POST['confirm'])){
  echo "接收到確認碼".$_POST['confirm'];
  $confirm=(int)$_POST['confirm'];


if($confirm==2){
    
	// 使用POST來送出資料temp
    if(!empty($_POST['default_temp'])){
        /*把資料修改到資料庫的表格上*/
		$default_temp=$_POST['default_temp'];
	 	$post_sql = "update `default_sensor` set `default_temp`= ".$default_temp."";
		/*檢查是否有成功上傳*/
		if ($conn->query($post_sql) == TRUE) {    
		}else{
		    echo "Error: ". $sql ."<br>" . $conn->error;
		}
    }
	
    //soil
    if(!empty($_POST['default_soil'])){
     	$default_soil = $_POST['default_soil'];		  
	    $post_sql = "update `default_sensor` set `default_soil`= ".$default_soil." ";
		/*檢查是否有成功上傳*/
		if ($conn->query($post_sql) == TRUE) {    
		}else{
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
    }
	
    //tds
    if(!empty($_POST['default_tds'])){
		$default_tds = $_POST['default_tds'];
        /*把資料上傳到資料庫的表格上*/
		$post_sql = "update `default_sensor` set `default_tds`= ".$default_tds."";	
		/*檢查是否有成功上傳*/
		if ($conn->query($post_sql) == TRUE) {  
		}else{
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
    }
	
    //uv
    if(!empty($_POST['default_uv'])){
	
		$default_uv = $_POST['default_uv'];
        /*把資料上傳到資料庫的表格上*/
		$post_sql = "update `default_sensor` set `default_uv`= ".$default_uv."";				
		/*檢查是否有成功上傳*/
		if ($conn->query($post_sql) == TRUE) {   
		}else{
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
    }

    //light
    if(!empty($_POST['default_light'])){
	
		$default_light = $_POST['default_light'];		
        /*把資料上傳到資料庫的表格上*/
	    $post_sql = "update `default_sensor` set `default_light`= ".$default_light."";			
		/*檢查是否有成功上傳*/
		if ($conn->query($post_sql) == TRUE) {    
		}else{
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
    }

    /*輸出目前預設值*/
    echo "<br>New Data :";
    echo "<br>defalt_temp= ".$default_temp;
    echo "<br>defalt_light= ".$default_light;
    echo "<br>defalt_uv= ".$default_uv;
    echo "<br>defalt_tds= ".$default_tds;
    echo "<br>defalt_soil= ".$default_soil; 
    echo "<br>date= ".$d;
    echo ",time= ".$t;

}else if($confirm==3){
		
	/*把資料上傳到資料庫的表格上*/		
	if(!empty($_POST['fan_switch'])){
		  $fan_switch= $_POST['fan_switch'];
	}else{
		  $fan_switch= 0;
	}
			
	if(!empty($_POST['led_switch'])){
		  $led_switch= $_POST['led_switch'];
		  echo "確定有收到2";
	}else{ 
		  $led_switch= 0;
	}
			
	if(!empty($_POST['motor_switch'])){
		  $motor_switch= $_POST['motor_switch'];
	}else{ 
		  $motor_switch= 0;
	}
			
	$post_sql = "update `device_switch` set `fan_switch`=  ".$fan_switch.",`led_switch`=".$led_switch.",`motor_switch`=".$motor_switch."";
	echo "<br>風扇:".$fan_switch."<br>燈條:".$led_switch."<br>馬達:".$motor_switch;
	if ($conn->query($post_sql) == TRUE) {
		    echo "Values inserted in MySQL database table.";
	}else{
		    echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
}
}
else{
	echo "未讀取到分類值";
}
	
echo "</center>";



/*関閉資料庫連線(MySQLi)*/
$conn->close();

?>
