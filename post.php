<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$author =@ $_POST["author"];
//$author = filter_input(INPUT_POST,['author']);
$content =@ $_POST["content"];
//$content = filter_input(INPUT_POST,['content']);
$current_time = date("Y-m-d H:i:s");

$link = mysqli_connect("localhost", "user", "pass", "user");
if(!$link)
    {
    die("Creative Date Fail");
    
    }
    $db_selected = mysqli_select_db($link, "user");
$sql = "INSERT INTO message(author,content,date) VALUES
        ('$author,'$content','$current_time') ";

//mysql_query("SET NAMES'utf8'");

$result = mysqli_query($link, $sql);

if(!$result)
    {
    die("SQL Fail");
    
    }
    mysqli_close($link);
    header("location:index.php");
    exit();
          