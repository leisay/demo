<!DOCTYPE html>
<html>
<body>

<?php

$servername = "localhost";
$username = "root";
$password = "123";
$dbname = "member";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

else{
	echo "Success";
}


$sql = "SELECT member_account FROM member  " ;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br> member_account:".$row["member_account"]."";
    }
} else {
    echo "0 results";
}




$conn -> close();



$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

else{
	echo "Success";
}


$sql = "SELECT name , content FROM message  " ;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br> name:".$row["name"]."";
        echo "<br> content:".$row["content"]."";
       
    }
} else {
    echo "0 results";
}




$conn -> close();












?>

</body>
</html>