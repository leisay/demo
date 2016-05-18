<?PHP

$Account  = $_POST['Account'];
$Password = $_POST['Password'];

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

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br> Account:".$row["Account"]."";
        echo "<br> Password:".$row["Password"]."";
       
    }
} else {
    echo "Account or Password Fail";
}




$conn -> close();




?>