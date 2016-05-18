
<?php

$db = new mysqli("localhost","root","123","member");

if($db -> connect_error){
  die("FAIL({$db->connect_errno}){$db->connect_error}");
}

$sql = "SELECT * FROM test ORDER BY Account";
$result = $db->query($sql);


?>


<table cellspacing="2" cellpadding="6" align="center" border="1">
<tr>
<td colspan="2">
<h3 align="center"> HELLOW</h3>
</td>
</tr>

<tr>
<td align="center">Account</td>
<td align="center">Email</td>
</tr>

<?php
while($row = $result -> fetch_assoc()){
?>

<tr>
<td><?php echo stripslashes($row['Account']);?></td>
<td align="center"><?php echo $row['Email'];?></td>
</tr>


<?php
}?>
</table>