<?php
$author  = $_POST['author'];
$article = $_POST['article'];

$servername = "localhost";
$username = "root";
$password = "123";
$dbname = "test";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 






$sql = "INSERT INTO test (author,article) VALUES ('$author','$article')";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br> author:".$row["author"]."";
        echo "<br> article:".$row["article"]."";
       
    }
} else {
    echo "author or article Fail";
    header("location:two.php");
}

$conn -> close();


?>

?>