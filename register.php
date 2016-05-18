<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title> register </title>
	<style type="text/css">
	.error {color: #FF0000;}
	</style>

	<script type="text/javascript">

	</script>
<body>
		
<div class="table">
	<p>REGITER</p>
	<p><span class="error">* Required field.</span></p>
	<form action="check2.php" method="POST" name="form">
	<H6>Account:<input type="text" name="Account" id="Account" placeholder = "Account" required>
	<span class="error">*</span></H6>
	
	<H6>Password:<input type="text" name="Password" placeholder = "Password" required>
	<span class="error">*</span></H6>
	
	<H6>RePassword:<input type="text" name="RePassword" placeholder = "RePassword" required>
	<span class="error">*</span></H6>

	<H6>Email:<input type="text" name="Email"  id="Email" placeholder = "Email" required>
	<span class="error">*</span></H6>


	<button type="submit">Register</button>
	<button type="reset">Reset</button>

</form>

</div>


</body>
<footer>
	
</footer>
</head>
</html>

<?PHP

?>