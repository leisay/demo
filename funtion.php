<?php

$link = array( "D" => "AA",
			   "E" => "BB",
			   "F" => "CC");

function getlink($link = array()){
	$main ="<ul>";
	foreach ($link as $key => $value) {
		$main .= "<a href = '{$key}' > {$value}</a>";
	}

	$main .= "</ul>" ;
	return $main;
}

	echo getlink($link);
?>


<?php
$a = $_POST['one'];
$b = $_POST['two'];
$c = $a*5 + $b*5;
$_POST['sum'] = $c  ;
$d = $a + $b;
$_POST['item'] = $d ;

echo $c ;
echo $d ;


?>

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
	<title> shop</title>
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
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<div id="booklist">
            <ul>
                <li>
                    <div>
                        <img src="image/A.JPG" /><br />
                        A</div>
                    <div>
                        price：$5</div>
                    <div>
                    	<input type ="number"  name="one" min = 0 max = 99 step = 1 >
                        <span name="one" class="scbutton">加入購物車<input type="hidden" value="A" />
                        </span>
                    </div>
                </li>
                <li>
                     <div>
                        <img src="image/B.JPG" /><br />
                        B</div>
                    <div>
                        price：$5</div>
                    <div>
                    	<input type ="number" name="two" min = 0 max = 99 step = 1 >
                        <span name="two" class="scbutton">加入購物車<input type="hidden" value="B" />
                        </span>
                    </div>
                </li>
                <li>
                     <div>
                        <img src="image/C.JPG" /><br />
                        C</div>
                    <div>
                        price：$5</div>
                    <div>
                        <span id="thr" class="scbutton">加入購物車<input type="hidden" value="C" />
                        </span>
                    </div>
                </li>
                <li>
                     <div>
                        <img src="image/D.JPG" /><br />
                        D</div>
                    <div>
                        price：$5</div>
                    <div>
                        <span id="four" class="scbutton">加入購物車<input type="hidden" value="D" />
                        </span>
                    </div>
                </li>
            </ul>
        </div>
		<div>
             <ul>
                <li>
                    <div>
                        <img src="image/A.JPG" /><br />
                        A</div>
                    <div>
                        price：$5</div>
                    <div>
                        <span id="one" class="scbutton">加入購物車<input type="hidden" value="A" />
                        </span>
                    </div>
                </li>
                <li>
                     <div>
                        <img src="image/B.JPG" /><br />
                        B</div>
                    <div>
                        price：$5</div>
                    <div>
                        <span id="two" class="scbutton">加入購物車<input type="hidden" value="B" />
                        </span>
                    </div>
                </li>
                <li>
                     <div>
                        <img src="image/C.JPG" /><br />
                        C</div>
                    <div>
                        price：$5</div>
                    <div>
                        <span id="thr" class="scbutton">加入購物車<input type="hidden" value="C" />
                        </span>
                    </div>
                </li>
                <li>
                     <div>
                        <img src="image/D.JPG" /><br />
                        D</div>
                    <div>
                        price：$5</div>
                    <div>
                        <span id="four" class="scbutton">加入購物車<input type="hidden" value="D" />
                        </span>
                    </div>
                </li>
            </ul>
        </div>
        </div>

<div id="sclast">
            <div id="itemAddMsg">
                <span id='cartmsg'>購物車中無任何項目</span>
            </div>
            <div style="float: left; width: 360px; height: 120px; margin-left: 20px; margin-right: 20px">
                <div id="newItem" style="float: left;">
                </div>
                <div style="clear: both">
                </div>
            </div>
            <div style="float: left; width: 600px">
                <div style="float: left">
                    <div style="width: 180px; height: 22px">
                        訂購金額小計：<span name="sum" style="padding-left: 6px;">0</span>元</div>
                    <div style="width: 180px; height: 22px">
                        選購品項樣數：<span name="item" style="padding-left: 6px;">0</span>項</div>
                </div>
                <div style="float: left">
                    <span class="cartprocess"><a href="shop2.php" target="_blank">編輯購物車內容</a></span></div>
                <div style="float: left">
                    <span class="cartprocess" onclick='checkout()'>結帳</span></div>
            </div>
            <div style="clear: both">
            </div>
        </div>
        </form>
</body>
</html>
