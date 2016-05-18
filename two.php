<?php
/*if(!empty($_POST['author'])){
	if(!empty($_POST['article'])){
		echo("{$_POST['author']}");
		echo "</br>";
		echo("{$_POST['article']}");
	}
}

*/

?>

<!DOCTYPE HTML> 
<html>
<head>
<meta charset='utf-8'>
<style>

</style>
</head>
<body> 




<form action="twocheck.php"  method="post">
<input type ="text" name="author" size="3">
<input type ="text" name="article" size="3">
<input type="submit">
<input type ="reset"  value="clear">
</form>



</body>
</html>

<?php

$db = new mysqli("localhost","root","123","test");

if($db -> connect_error){
  die("FAIL({$db->connect_errno}){$db->connect_error}");
}

$sql = "SELECT * FROM test ORDER BY author";
$result = $db->query($sql);


?>


<table cellspacing="2" cellpadding="6" align="center" border="1">
<tr>
<td colspan="2">
<h3 align="center"> HELLOW</h3>
</td>
</tr>

<tr>
<td align="center">author</td>
<td align="center">article</td>
</tr>

<?php
while($row = $result -> fetch_assoc()){
?>

<tr>
<td><?php echo stripslashes($row['author']);?></td>
<td align="center"><?php echo $row['article'];?></td>
</tr>


<?php
}?>
</table>