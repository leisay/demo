

<?PHP

$Account  = $_POST['Account'];
$Password = $_POST['Password'];
$RePassword = $_POST['RePassword'];
$Email =$_POST['Email'];

$servername = "localhost";
$username = "root";
$password = "123";
$dbname = "member";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 






$sql = "INSERT INTO test (Account,Password,Email) VALUES ('$Account','$Password','$Email')";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br> Account:".$row["Account"]."";
        echo "<br> Password:".$row["Password"]."";
        echo "<br> Email:".$row["Email"]."";
       
    }
} else {
    echo "Account or Password Fail";
    header("location:register.php");
}

$conn -> close();


?>