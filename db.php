<?php
$serverName = "localhost";
$userName = "root";
$password = ""; // Set your database password here
$dbname = "memetrackerdb";
$conn = "";

//create connection

try{
   $conn = mysqli_connect($serverName ,$userName ,$password ,$dbname);
}
catch(mysqli_sql_exception){
    echo"fail to connect";
}

if($conn){
    echo"You are connected";
}
?>