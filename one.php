
<?php



	$a = $_POST['one'];
	$b = $_POST['two'];
	$c = $_POST['thr'];
	$temp = $b*$b -4*$a*$c ;
	$temp1 = (-$c)/$b;
	$temp2 = ((-$b)/(2*$a));

	if($a==0){
		if($b==0){
			if($c==0)
				echo'X sloution';
			else
				echo 'no sloution';
		}else 
		echo"$temp2" ;
	}else if($temp>0){
		echo "{$_POST['one']} X^2+ {$_POST['two']}Y +{$_POST['thr']}= ";
		echo (-$b)+sqrt(($temp)/2*$a);
		echo "</br>";
		echo "{$_POST['one']} X^2+ {$_POST['two']}Y +{$_POST['thr']}=  ";
		echo (-$b)-sqrt(($temp)/2*$a);
	}else if($temp == 0)
	echo "$temp2";
	else
		echo 'NO sloution';

?>



<!DOCTYPE HTML> 
<html>
<head>
<meta charset='utf-8'>
<style>

</style>
</head>
<body> 


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type ="text" name="one" size="3">
<input type ="text" name="two" size="3">
<input type ="text" name="thr" size="3">
<input type="submit">
<input type ="reset"  value="clear">
</form>


</body>
</html>