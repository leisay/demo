<!DOCTYPE html>
<html>
<body>

<?php

$servername = "localhost";
$username = "root";
$password = "123";
$dbname = "member";

/*
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

else{
	echo "Success";
}*/
$link=@mysql_connect("localhost",$username,$password) or die_content("資料庫無法連線");
if(!mysql_select_db($dbname)) die_content("無法選擇資料庫");


mysql_query("SET NAMES 'utf8'");