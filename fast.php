<!DOCTYPE HTML> 
<html>
<head>
<meta charset='utf-8'>
<style>

</style>
</head>
<body> 

<p><a href="##"> index</a>|<a href="##"> news</a></p>
<p><a href="##"> index|news</a></p>

<details>
<summary> index </summary>
<ul>
<P> 123456789</P>
</ul>
</details>

<details open>
<summary> hellow </summary>
<ul>
<li> one</li>
<li> two</li>
</ul>
</details>


<div>
<a href="##" accesskey="A"> news </a>
</div>

<form>
<label>index:<input type=text required></label>
<input type="submit">

</form>
<input type="color"></br>





<?php

$person = $arrayName = array('name' =>"Andy" , 'age' => "18" );
$key = array_keys($person);
print_r(array_keys($person));

?>


<?php

if(!empty($_POST['name'])){
  echo"hellow,{$_POST['name']}";
}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
enter:<input tpye="text" name= "name"/>
<input type="submit">
</form>


<?php

$db = new mysqli("localhost","root","123","member");

if($db -> connect_error){
  die("FAIL({$db->connect_errno}){$db->connect_error}");
}

$sql = "SELECT * FROM member ORDER BY member_id";
$result = $db->query($sql);


?>

<table cellspacing="2" cellpadding="6" align="center" border="1">
<tr>
<td colspan="5">
<h3 align="center"> HELLOW</h3>
</td>
</tr>

<tr>
<td align="center">member_id</td>
<td align="center">member_Account</td>
<td align="center">member_Gender</td>
<td align="center">member_Birthday</td>
<td align="center">member_Email</td>
</tr>

<?php
while($row = $result -> fetch_assoc()){
?>

<tr>
<td><?php echo stripslashes($row['member_id']);?></td>
<td align="center"><?php echo $row['member_account'];?></td>
<td align="center"><?php echo $row['member_gender'];?></td>
<td align="center"><?php echo $row['member_birthday'];?></td>
<td align="center"><?php echo $row['member_email'];?></td>
</tr>


<?php
}?>
</table>




<?php
$link = array(
  "#"=>"index",
  "##"=>"PHOTO",
  "##"=>"MAP",
  );

function getlink($link = array()){
  $main = "<ul>";
  foreach ($link as $key => $value) {
    if(basename($_SERVER["PHP_SELF"])==$key){
       $main.="<li><a style='color:red;' href= '{$key}'>{$value}</a></li>";
    }else{
      $main.="<li><a href= '{$key}'>{$value}</a></li>";
    }

    
  }

  $main.="</ul>";
  return $main;
}
echo getlink($link);
?>


</body>
</html>