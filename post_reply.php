<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$author = $_POST["author"];
$content = $_POST["content"];
$current_time = date("Y-m-d H:i:s");
$reply_id = $_POST["reply_id"];
        
$link = mysqli_connect("localhost", "user", "pass", "user");
if(!$link)
    {
    die("Creative Date Fail");
    
    }
    
$sql = "INSERT INTO reply_message(author,content,date,reply_id)
         VALUES ('$author,'$content','$current_time','$reply_id') ";

//mysql_query("SET NAMES'utf8'");

$result = mysqli_query($link, $sql);

if(!$result)
    {
    die("SQL Fail");
    
    }
    mysqli_close($link);
    header("location:show_news.php? id = ".$reply_id);
    exit();