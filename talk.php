<html lang="zh_TW">
<head>
<meta charset="utf-8">
<title>talking</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Bootstrap">
<meta name="author" content="test">

<link href="css/bootstrap.css" rel="stylesheet">
<link href='css/bootstrap-responsive.css' rel='stylesheet'>
<link href="css/jquery-ui-1.8.23.custom.css" rel="stylesheet">
<link href="css/finaltest.css" rel="stylesheet">


<!-- 引入js檔案開始 -->
<script src="js/jquery1.8.js"></script>
<script src="js/jquery-ui-1.8.23.custom.min.js"></script>
<script src="js/bootstrap.js"></script>
<!-- 引入js檔案結束 -->



</head>
<body>






<?php

$servername = "localhost";
$username = "root";
$password = "123";
$dbname = "member";



$db = new mysqli("localhost","root","123","member");

if($db -> connect_error){
  die("FAIL({$db->connect_errno}){$db->connect_error}");
}

$sql = "SELECT * FROM member ORDER BY member_id";   //改成date
$result = $db->query($sql);


$records_per_page = 5;

if(isset($_GET["page"]))
		$page = $_GET["page"];
	else
		$page = 1;

$total_records = mysql_num_rows($result);
$total_pages = ceil($total_records/$records_per_page);
$started_record = $records_per_page *($page-1);
mysql_data_seek($result, $started_record);


?>

<table cellspacing="2" cellpadding="6" align="center" border="1">
<tr>
<td colspan="5">
<h3 align="center"> HELLOW</h3>
</td>
</tr>

<tr>
<td align="center">name</td>
<td align="center">message</td>
<td align="center">date</td>
</tr>

<?php
while($row = $result -> fetch_assoc()){
?>

<tr>
<td><?php echo stripslashes($row['name']);?></td>
<td align="center"><?php echo $row['message'];?></td>
<td align="center"><?php echo $row['date'];?></td>
</tr>


<?php
}?>







 <footer>
    <p align="center">&copy; Company 2015</p>
  </footer>
</body>
</html>