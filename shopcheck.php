

<?PHP

$Account  = $_POST['Account'];
$Password = $_POST['Password'];
$sum = $_POST['sum'];
$item = $_POST['item'];

$servername = "localhost";
$username = "root";
$password = "123";
$dbname = "member";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$sql = "SELECT * FROM test Where Account = '$Account' AND Password = '$Password'";
$result = $conn->query($sql);

if (isset($sql)) {
    // output data of each row
   $sql1 = "INSERT INTO test (sum,item) VALUES ('$sum','$item')";
    
} else {
    header("location:register.php");
}



$conn -> close();


?>