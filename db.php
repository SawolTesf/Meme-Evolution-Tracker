<?php
$serverName = "localhost";
$userName = "root";
$password = "";
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