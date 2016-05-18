<?php

$a = $_POST['one'];
$b = $_POST['two'];
$c = $_POST['thr'];
$d = $_POST['fou'];
//$c = $a + $b ;
$sun = $a*5 + $b*5 +$c*5 +$d*5 ;
$_POST['sum'] = $sun  ;
$item = $a + $b +$c +$d;
$_POST['item'] = $item ;

echo "金額為".$sun."元" ;
echo "項目為".$item."項" ;

//echo $c;
?>


<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
	<title> test</title>
</head>
<style type="text/css">
ul
        {
            overflow: hidden;
        }
ul li
        {
            list-style-type: none;
            float: left;
            width: 150px;
            font-size: 11px;
            line-height: 1.8em;
            padding: 5px 10px;
        }
	
</style>
<body>



<form action="shopcheck.php" method="post">

<div class="fastline">
<ul>

<li>
<div>
<img src="image/A.JPG" /><br />
</div>
<div>price：$5</div>
<div>
<input type="number" name="one" min = 1 max =10 step=1 >
<input type="number" name="two" min = 1 max =10 step=1 >
</div>
</li>


<li>
<div>
<img src="image/A.JPG" /><br />
</div>
<div>price：$5</div>
<div>
<input type="number" name="thr" min = 1 max =10 step=1 >
<input type="number" name="fou" min = 1 max =10 step=1 >
</div>
</li>

</ul>
</div>


<input type="submit" >
<input type ="reset"  value="clear">

</form>



</body>
</html>