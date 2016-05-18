<!DOCTYPE>
<html>
<head>
<meta charset="utf-8">
<title>  Login </title>
<style type="text/css">
	
.table{

	margin: 20px;
	border-width:5px;	
    border-style:groove ;
	text-align: center;
	background: #F0F0F0;
}

h6 {
	font: italic bold 12px/30px Georgia, serif;
	color:blue;

}

p{
	font: italic bold 12px/30px Georgia, serif;
	color: blue;
}

button {

	background: #ffffff;
	font: italic bold 12px/30px Georgia, serif;
	color:	#BE77FF ;

}

footer{
	text-align: center;
}

input{

	border-radius: 5px; 
	padding-left: 10px;
	width: 200px;
	height: 30px;
}


a{
	margin: 20px;
	text-decoration: none ;
	color:	#000000 ;
}a:hover {  color:red ;   }

</style>

<body>

	<div class="table">
	<p>LOGIN</p>
	<form action="check.php" method="POST">
	<h6> Account: <input type ="text" name="Account" placeholder="Account"  required> </h6>
	<h6> Password: <input type ="password" name="Password" placeholder="Password" > </h6>
	<button type="submit">login</button> 
	<button type="reset">reset</button></br></br>

	<a href="register.php">Creative Account</a>
	<a href="#">Forget Account</a>
	<a href="html.php">Home</a>

		
	</div>
</body>

<footer>
	 &copy; 2010-<?php echo date("Y")?>
</footer>
</head>
</html>



